# NetVera İnşaat Firması Web Sitesi Pro

SEO/GEO/AIO temelli, mobil öncelikli, statik kurumsal inşaat firması web sitesi başlangıç projesi.

## Demo teknoloji
- HTML5
- CSS3
- Vanilla JavaScript
- GitHub Pages + GitHub Actions

## Sayfalar
- Ana Sayfa
- Hakkımızda
- Hizmetler
- Projeler
- Blog
- İletişim
- 404

## SEO / GEO / AIO temeli
- Her sayfada title + meta description
- Canonical URL
- Open Graph / Twitter Card
- JSON-LD `GeneralContractor`
- `robots.txt`
- `sitemap.xml`
- `llms.txt`
- Semantik HTML
- Yerel hizmet alanı sinyalleri
- Responsive ve hafif frontend

## GitHub Pages
Repo oluşturulduktan sonra bir kez:

`Settings → Pages → Build and deployment → Source → GitHub Actions`

seçilmelidir. Sonraki `main` push'larında `.github/workflows/pages.yml` otomatik deploy eder.

## Not
Bu sürüm GitHub Pages üzerinde önizleme/test içindir ve statiktir. Ürünleştirme aşamasında istenirse aynı frontend PHP 8.2+ tabanlı cPanel paketine taşınabilir.
