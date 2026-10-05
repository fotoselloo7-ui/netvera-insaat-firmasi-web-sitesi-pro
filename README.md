# NetVera İnşaat Firması Web Sitesi Pro

Kurumsal inşaat firmaları için SEO/GEO/AIO temelli, responsive ve yönetilebilir web sitesi ürünü.

## İki çalışma modu

### 1. GitHub Pages demo
`index.html` ve statik `.html` sayfaları GitHub Pages üzerinde tasarım önizlemesi içindir.

Canlı demo:
`https://fotoselloo7-ui.github.io/netvera-insaat-firmasi-web-sitesi-pro/`

### 2. PHP + MySQL ürün sürümü
Gerçek ürün sürümü `index.php`, PHP sayfaları ve admin panelini kullanır.

PHP 8.2+ / 8.3+ ve MySQL 8 önerilir.

## Kurulum

Bu projede web installer kullanılmaz. Canlı cPanel kurulumu manuel yapılır:

1. cPanel'de MySQL veritabanı ve kullanıcı oluşturulur.
2. `database.sql` phpMyAdmin üzerinden tek seferde içe aktarılır.
3. `env.example.php`, sunucuda `.env.php` olarak kopyalanır.
4. `APP_URL`, `APP_KEY` ve veritabanı bağlantı bilgileri doldurulur.
5. Dosyalar document root'a yüklenir.
6. `/admin/` paneline giriş yapılır.
7. **NetVera Lisansı** ekranında gerçek `DIGI-...` lisans anahtarı girilip **Lisansı Doğrula ve Etkinleştir** seçilir.

Gerçek lisans anahtarı env dosyasına yazılmaz. Başarılı aktivasyonda anahtar `APP_KEY` ile şifrelenip veritabanındaki `license_settings` tablosunda saklanır.

## Admin Panel

`/admin/`

Yönetilebilir modüller:
- Genel firma / iletişim / SEO ayarları
- Ana sayfa bölüm başlıkları ve görünürlükleri
- Slider görselleri, metinleri ve butonları
- İstatistikler
- Hizmetler ve hizmet detay sayfaları
- Projeler, proje detayları ve galeri alanı
- Neden Biz / Süreç / Güven içerikleri
- Müşteri yorumları
- Hizmet bölgeleri
- SSS
- Blog
- Kurumsal sayfalar
- Admin şifresi
- Görsel URL veya doğrudan dosya yükleme

İlk SQL seed hesabı yalnız geliştirme / ilk erişim içindir:

- E-posta: `admin@netvera.local`
- Şifre: `ChangeMe123!`

Canlı kurulumdan sonra Admin > Hesap & Şifre bölümünden yönetici şifresini mutlaka değiştirin.

## SEO / GEO / AIO

- Sayfa bazlı meta başlık ve açıklama
- SEO uyumlu slug yapısı
- Hizmet detay URL'leri: `/hizmet/{slug}`
- Proje detay URL'leri: `/proje/{slug}`
- Blog URL'leri: `/blog/{slug}`
- Yerel hizmet bölgeleri
- `robots.txt`
- `sitemap.xml`
- `llms.txt`
- Semantik HTML ve responsive tasarım

## Codespaces

Repo içinde `.devcontainer/devcontainer.json` ve `docker-compose.yml` bulunur.

Codespace açıldığında:
- PHP 8.3
- MySQL 8.4
- 8080 web preview
- 3306 MySQL

ortamı hazırlanır.

## Otomatik test

`.github/workflows/php-lint.yml` her `main` push'unda tüm PHP dosyalarını `php -l` ile kontrol eder.

GitHub Pages deploy workflow'u da her `main` güncellemesinde statik demoyu yeniden yayınlar.

## NetVera Lisans Sistemi

Canlı PHP paketi `https://lisans.netvera.tr` merkezine bağlıdır. Lisans sunucusu, ürün slug, kontrol aralığı ve tolerans ayarları `.env.php` üzerinden gelir; gerçek lisans anahtarı ise yalnız Admin > **NetVera Lisansı** ekranından girilir.

Akış:
- Aktivasyon: `POST /api/v1/activate`
- Doğrulama: `POST /api/v1/verify`
- Yenileme / heartbeat: `POST /api/v1/heartbeat`
- Deaktivasyon altyapısı: `POST /api/v1/deactivate`
- Başarılı doğrulama: 24 saat cache
- Yalnız ağ/sunucu hatası: 168 saat / 7 gün tolerans
- Invalid, expired, suspended, revoked, domain veya product mismatch: tolerans yok

Başarılı aktivasyonda `DIGI-...` anahtarı `APP_KEY` ile şifrelenerek `license_settings` tablosunda saklanır ve admin ekranında yalnız maskeli gösterilir. Public PHP sayfaları lisans korumasındadır; lisansı düzeltmek için `/admin/` erişilebilir kalır.

Varsayılan ürün slug değeri `netvera-insaat-pro` olarak hazırlanmıştır ve lisans merkezindeki ürün kaydıyla birebir aynı olmalıdır.

## Sosyal Medya İkonları

Instagram, Facebook, LinkedIn, X / Twitter ve YouTube bağlantıları Admin > Genel Ayarlar > Marka & İletişim bölümünden yönetilir. Ana sayfa, iletişim sayfası ve mobil menü harici ikon kütüphanesine bağlı olmadan gerçek platform SVG ikonlarını kullanır.
