<?php
declare(strict_types=1);

final class NetveraLicenseService {
    private array $config;
    private string $cacheFile;

    public function __construct(array $config, ?string $cacheFile = null) {
        $this->config = $config;
        $root = dirname(__DIR__);
        $this->cacheFile = $cacheFile ?: $root . '/storage/license-cache.json';
    }

    public function status(bool $force = false): array {
        if (!(bool)($this->config['enabled'] ?? true)) {
            return ['success'=>true,'status'=>'disabled','message'=>'Lisans kontrolü açıkça devre dışı.','source'=>'config'];
        }
        $key = trim((string)($this->config['key'] ?? ''));
        $product = trim((string)($this->config['product_slug'] ?? ''));
        if ($key === '' || $product === '') {
            return ['success'=>false,'status'=>'not_configured','message'=>'Lisans anahtarı veya ürün slug bilgisi eksik.','source'=>'local'];
        }

        $cache = $this->readCache();
        $fingerprint = $this->fingerprint($key, $product);
        $verifyHours = max(1, (int)($this->config['verify_interval_hours'] ?? 24));
        if (!$force && $this->cacheMatches($cache, $fingerprint) && ($cache['status'] ?? '') === 'active') {
            $last = (int)($cache['last_success_at'] ?? 0);
            if ($last > 0 && time() - $last < $verifyHours * 3600) {
                $cache['source'] = 'cache';
                $cache['success'] = true;
                return $cache;
            }
        }

        $remote = $this->request('verify', $this->payload($key, $product));
        if ($this->isActive($remote)) {
            return $this->rememberSuccess($remote, $fingerprint);
        }
        if ($this->isTransportFailure($remote)) {
            return $this->graceOrFail($cache, $fingerprint, $remote);
        }
        return $this->rememberFailure($remote, $fingerprint);
    }

    public function activate(string $key, string $productSlug, ?string $siteUrl = null, ?string $installId = null): array {
        $key = trim($key);
        $productSlug = trim($productSlug);
        if ($key === '' || $productSlug === '') {
            return ['success'=>false,'status'=>'not_configured','message'=>'Lisans anahtarı ve ürün slug zorunludur.'];
        }
        $payload = $this->payload($key, $productSlug, $siteUrl, $installId);
        $remote = $this->request('activate', $payload);
        if ($this->isActive($remote)) {
            return $this->rememberSuccess($remote, $this->fingerprint($key, $productSlug), $payload);
        }
        return $remote;
    }

    public function deactivate(?string $key = null, ?string $productSlug = null): array {
        $key = trim((string)($key ?? $this->config['key'] ?? ''));
        $productSlug = trim((string)($productSlug ?? $this->config['product_slug'] ?? ''));
        if ($key === '' || $productSlug === '') {
            return ['success'=>false,'status'=>'not_configured','message'=>'Lisans bilgisi eksik.'];
        }
        $remote = $this->request('deactivate', $this->payload($key, $productSlug));
        if (($remote['success'] ?? false) === true) @unlink($this->cacheFile);
        return $remote;
    }

    public function getCache(): array {
        return $this->readCache();
    }

    private function payload(string $key, string $productSlug, ?string $siteUrl = null, ?string $installId = null): array {
        $url = rtrim((string)($siteUrl ?? $this->config['site_url'] ?? ''), '/');
        $host = (string)(parse_url($url, PHP_URL_HOST) ?? '');
        if ($host === '') {
            $host = preg_replace('/:\d+$/', '', (string)($_SERVER['HTTP_HOST'] ?? '')) ?: '';
        }
        return [
            'license_key' => $key,
            'product_slug' => $productSlug,
            'domain' => strtolower($host),
            'site_url' => $url,
            'install_id' => (string)($installId ?? $this->config['install_id'] ?? ''),
            'app_version' => (string)($this->config['app_version'] ?? '1.0.0'),
            'server_ip' => (string)($_SERVER['SERVER_ADDR'] ?? ''),
            'php_version' => PHP_VERSION,
        ];
    }

    private function request(string $action, array $payload): array {
        $base = rtrim((string)($this->config['server_url'] ?? 'https://lisans.netvera.tr'), '/');
        $url = $base . '/api/v1/' . $action;
        $body = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $timeout = max(3, (int)($this->config['timeout_seconds'] ?? 8));
        $httpCode = 0;
        $raw = '';
        $networkError = '';

        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json','Accept: application/json'],
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_CONNECTTIMEOUT => min(5, $timeout),
                CURLOPT_TIMEOUT => $timeout,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_USERAGENT => 'NetVera-Insaat-Pro/' . (string)($this->config['app_version'] ?? '1.0.0'),
            ]);
            $result = curl_exec($ch);
            if ($result === false) $networkError = (string)curl_error($ch);
            $raw = is_string($result) ? $result : '';
            $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        } else {
            $ctx = stream_context_create(['http'=>[
                'method'=>'POST',
                'header'=>"Content-Type: application/json\r\nAccept: application/json\r\nUser-Agent: NetVera-Insaat-Pro\r\n",
                'content'=>$body,
                'timeout'=>$timeout,
                'ignore_errors'=>true,
            ]]);
            $result = @file_get_contents($url, false, $ctx);
            $raw = is_string($result) ? $result : '';
            if ($result === false) $networkError = 'Lisans sunucusuna bağlanılamadı.';
            foreach (($http_response_header ?? []) as $line) {
                if (preg_match('#^HTTP/\S+\s+(\d{3})#', $line, $m)) $httpCode = (int)$m[1];
            }
        }

        if ($networkError !== '') {
            return ['success'=>false,'status'=>'server_unreachable','message'=>$networkError,'http_code'=>$httpCode,'transport_error'=>true];
        }

        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) {
            return [
                'success'=>false,
                'status'=>$httpCode >= 500 || $httpCode === 0 ? 'server_error' : 'invalid_response',
                'message'=>'Lisans sunucusundan geçerli JSON yanıtı alınamadı.',
                'http_code'=>$httpCode,
                'transport_error'=>$httpCode >= 500 || $httpCode === 0,
            ];
        }

        if (isset($decoded['data']) && is_array($decoded['data'])) {
            $decoded = array_merge($decoded, $decoded['data']);
            unset($decoded['data']);
        }
        $status = strtolower(trim((string)($decoded['license_status'] ?? $decoded['status'] ?? '')));
        if ($status === '' && ($decoded['success'] ?? false) === true) $status = 'active';
        $decoded['status'] = $status ?: 'unknown';
        $decoded['success'] = (bool)($decoded['success'] ?? in_array($status, ['active','trial'], true));
        $decoded['http_code'] = $httpCode;
        $decoded['transport_error'] = $httpCode >= 500 || $httpCode === 0;
        if (empty($decoded['message']) && !empty($decoded['reason'])) $decoded['message'] = (string)$decoded['reason'];
        return $decoded;
    }

    private function isActive(array $result): bool {
        return ($result['success'] ?? false) === true && in_array((string)($result['status'] ?? ''), ['active','trial'], true);
    }

    private function isTransportFailure(array $result): bool {
        return ($result['transport_error'] ?? false) === true || in_array((string)($result['status'] ?? ''), ['server_error','server_unreachable','timeout'], true);
    }

    private function graceOrFail(array $cache, string $fingerprint, array $remote): array {
        $graceHours = max(0, (int)($this->config['grace_hours'] ?? 168));
        if ($graceHours > 0 && $this->cacheMatches($cache, $fingerprint)) {
            $last = (int)($cache['last_success_at'] ?? 0);
            if ($last > 0 && time() - $last <= $graceHours * 3600) {
                $cache['success'] = true;
                $cache['status'] = 'grace';
                $cache['source'] = 'grace';
                $cache['message'] = 'Lisans sunucusuna ulaşılamadı; son başarılı doğrulama geçici olarak kullanılıyor.';
                $cache['grace_until'] = $last + ($graceHours * 3600);
                $cache['last_error'] = (string)($remote['message'] ?? 'Sunucu hatası');
                $this->writeCache($cache);
                return $cache;
            }
        }
        $remote['success'] = false;
        return $remote;
    }

    private function rememberSuccess(array $result, string $fingerprint, ?array $payload = null): array {
        $now = time();
        $cache = $result + [];
        $cache['success'] = true;
        $cache['status'] = 'active';
        $cache['source'] = 'remote';
        $cache['fingerprint'] = $fingerprint;
        $cache['domain'] = $payload['domain'] ?? ($result['domain'] ?? $this->currentDomain());
        $cache['product_slug'] = $payload['product_slug'] ?? ($result['product_slug'] ?? $this->config['product_slug'] ?? '');
        $cache['last_checked_at'] = $now;
        $cache['last_success_at'] = $now;
        unset($cache['transport_error']);
        $this->writeCache($cache);
        return $cache;
    }

    private function rememberFailure(array $result, string $fingerprint): array {
        $cache = $result + [];
        $cache['success'] = false;
        $cache['fingerprint'] = $fingerprint;
        $cache['last_checked_at'] = time();
        $cache['source'] = 'remote';
        $this->writeCache($cache);
        return $cache;
    }

    private function fingerprint(string $key, string $product): string {
        return hash('sha256', $product . '|' . $this->currentDomain() . '|' . $key);
    }

    private function currentDomain(): string {
        $url = (string)($this->config['site_url'] ?? '');
        $host = (string)(parse_url($url, PHP_URL_HOST) ?? '');
        if ($host === '') $host = (string)($_SERVER['HTTP_HOST'] ?? '');
        return strtolower((string)preg_replace('/:\d+$/', '', $host));
    }

    private function cacheMatches(array $cache, string $fingerprint): bool {
        return isset($cache['fingerprint']) && hash_equals((string)$cache['fingerprint'], $fingerprint);
    }

    private function readCache(): array {
        if (!is_file($this->cacheFile)) return [];
        $raw = @file_get_contents($this->cacheFile);
        $decoded = is_string($raw) ? json_decode($raw, true) : null;
        return is_array($decoded) ? $decoded : [];
    }

    private function writeCache(array $data): void {
        $dir = dirname($this->cacheFile);
        if (!is_dir($dir)) @mkdir($dir, 0775, true);
        @file_put_contents($this->cacheFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), LOCK_EX);
    }
}

function netvera_encrypt_secret(string $plain, string $appKey): string {
    if ($plain === '') return '';
    if (!function_exists('openssl_encrypt')) return $plain;
    $key = hash('sha256', $appKey, true);
    $iv = random_bytes(12);
    $tag = '';
    $cipher = openssl_encrypt($plain, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);
    if ($cipher === false) return $plain;
    return 'enc:v1:' . base64_encode($iv . $tag . $cipher);
}

function netvera_decrypt_secret(string $value, string $appKey): string {
    if (!str_starts_with($value, 'enc:v1:')) return $value;
    if (!function_exists('openssl_decrypt')) return '';
    $raw = base64_decode(substr($value, 7), true);
    if ($raw === false || strlen($raw) < 29) return '';
    $iv = substr($raw, 0, 12);
    $tag = substr($raw, 12, 16);
    $cipher = substr($raw, 28);
    $plain = openssl_decrypt($cipher, 'aes-256-gcm', hash('sha256', $appKey, true), OPENSSL_RAW_DATA, $iv, $tag);
    return is_string($plain) ? $plain : '';
}

function netvera_license_service(): NetveraLicenseService {
    return new NetveraLicenseService($GLOBALS['app_config']['license'] ?? []);
}

function netvera_license_status(bool $force = false): array {
    return netvera_license_service()->status($force);
}

function netvera_public_license_guard(): void {
    if (PHP_SAPI === 'cli') return;
    $uri = (string)($_SERVER['REQUEST_URI'] ?? '/');
    $path = '/' . ltrim((string)(parse_url($uri, PHP_URL_PATH) ?? ''), '/');
    if (str_contains($path, '/admin/') || str_ends_with($path, '/admin') || str_ends_with($path, '/install.php')) return;

    $status = netvera_license_status(false);
    if (($status['success'] ?? false) === true && in_array((string)($status['status'] ?? ''), ['active','trial','grace','disabled'], true)) return;

    $code = in_array((string)($status['status'] ?? ''), ['server_error','server_unreachable','timeout'], true) ? 503 : 403;
    http_response_code($code);
    header('Content-Type: text/html; charset=utf-8');
    $message = htmlspecialchars((string)($status['message'] ?? 'Bu kurulum için geçerli bir NetVera lisansı bulunamadı.'), ENT_QUOTES, 'UTF-8');
    $state = htmlspecialchars((string)($status['status'] ?? 'invalid'), ENT_QUOTES, 'UTF-8');
    echo '<!doctype html><html lang="tr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>NetVera Lisans Kontrolü</title><style>body{margin:0;background:#f4f6f7;color:#102c40;font-family:Arial,sans-serif}.nv{width:min(620px,calc(100% - 32px));margin:10vh auto;background:#fff;border:1px solid #dce4e8;border-radius:14px;padding:30px;box-shadow:0 20px 60px rgba(16,44,64,.08)}.nv b{display:inline-block;padding:6px 9px;border-radius:6px;background:#fff0ed;color:#9b432f;font-size:11px;text-transform:uppercase}.nv h1{font-size:26px;margin:18px 0 10px}.nv p{color:#60717c;line-height:1.7}.nv a{color:#b76732;font-weight:700}</style></head><body><main class="nv"><b>'.$state.'</b><h1>NetVera lisans doğrulaması gerekli.</h1><p>'.$message.'</p><p>Site yöneticisi lisans durumunu <a href="' . htmlspecialchars(app_url('admin/'), ENT_QUOTES, 'UTF-8') . '">yönetim panelinden</a> kontrol edebilir.</p></main></body></html>';
    exit;
}

function netvera_update_local_env(array $updates): void {
    $root = dirname(__DIR__);
    $file = $root . '/.env.php';
    $current = is_file($file) ? require $file : [];
    if (!is_array($current)) $current = [];
    $next = array_merge($current, $updates);
    $php = "<?php\nreturn " . var_export($next, true) . ";\n";
    if (@file_put_contents($file, $php, LOCK_EX) === false) {
        throw new RuntimeException('.env.php güncellenemedi. Kök klasör yazma iznini kontrol edin.');
    }
}

function netvera_mask_license_key(string $key): string {
    $key = trim($key);
    if ($key === '') return '—';
    $len = strlen($key);
    if ($len <= 8) return str_repeat('•', max(4, $len));
    return substr($key, 0, 5) . str_repeat('•', max(4, $len - 9)) . substr($key, -4);
}

