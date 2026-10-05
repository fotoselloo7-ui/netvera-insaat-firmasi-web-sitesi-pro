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

1. Hosting panelinden boş MySQL veritabanı ve kullanıcı oluşturun.
2. Dosyaları sunucuya yükleyin.
3. Tarayıcıdan `/install.php` açın.
4. DB bilgileri, site URL'si ve admin hesabını girin.
5. Kurulum tamamlanınca `install.php` dosyasını silin veya yeniden adlandırın.

Installer otomatik olarak:
- `database.sql` şemasını kurar.
- `.env.php` bağlantı dosyasını oluşturur.
- Admin hesabını günceller.

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

İlk SQL seed hesabı yalnız geliştirme içindir:

- E-posta: `admin@netvera.local`
- Şifre: `ChangeMe123!`

Installer kullanırken kendi admin e-posta ve şifrenizi belirlersiniz.

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

Canlı PHP paketi NetVera lisans merkezine bağlıdır. Kurulumda lisans anahtarı ve lisans merkezindeki ürün slug değeri istenir; aktivasyon `https://lisans.netvera.tr/api/v1/activate`, periyodik kontrol `/api/v1/verify` üzerinden yapılır. Başarılı kontrol 24 saat cache edilir. Yalnız ağ/sunucu erişim hatalarında son başarılı kontrolden itibaren 168 saat tolerans vardır; invalid, expired, suspended, revoked, domain veya ürün uyuşmazlığı tolerans almaz.

Lisans anahtarı `APP_KEY` ile şifrelenerek `.env.php` içinde tutulur. Public PHP sayfaları lisans korumasındadır; lisans düzeltme işlemi yapılabilsin diye `/admin/` erişilebilir kalır. Admin panelindeki **NetVera Lisansı** ekranından durum görülebilir, zorla doğrulama yapılabilir veya anahtar yeniden bağlanabilir.

Varsayılan ürün slug değeri `netvera-insaat-pro` olarak hazırlanmıştır. Canlı kurulumda bu değer lisans merkezindeki ürün kaydıyla birebir eşleşmelidir.

## Sosyal Medya İkonları

Instagram, Facebook, LinkedIn, X / Twitter ve YouTube bağlantıları Admin > Genel Ayarlar > Marka & İletişim bölümünden yönetilir. Ana sayfa, iletişim sayfası ve mobil menü harici ikon kütüphanesine bağlı olmadan gerçek platform SVG ikonlarını kullanır.
