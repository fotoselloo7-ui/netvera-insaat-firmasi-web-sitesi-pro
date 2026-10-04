SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS admins (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  name VARCHAR(120) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS settings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(120) NOT NULL UNIQUE,
  setting_value TEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS home_sections (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  section_key VARCHAR(80) NOT NULL UNIQUE,
  eyebrow VARCHAR(190) NULL,
  title VARCHAR(255) NULL,
  body TEXT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS sliders (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  eyebrow VARCHAR(190) NULL,
  title VARCHAR(255) NOT NULL,
  body TEXT NULL,
  image VARCHAR(500) NOT NULL,
  primary_label VARCHAR(120) NULL,
  primary_url VARCHAR(255) NULL,
  secondary_label VARCHAR(120) NULL,
  secondary_url VARCHAR(255) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS home_stats (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  stat_value VARCHAR(40) NOT NULL,
  label VARCHAR(190) NOT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS services (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(190) NOT NULL,
  slug VARCHAR(190) NOT NULL UNIQUE,
  summary TEXT NULL,
  body LONGTEXT NULL,
  cover_image VARCHAR(500) NULL,
  meta_title VARCHAR(255) NULL,
  meta_description VARCHAR(320) NULL,
  is_featured TINYINT(1) NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS projects (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(190) NOT NULL,
  slug VARCHAR(190) NOT NULL UNIQUE,
  category VARCHAR(120) NULL,
  location VARCHAR(160) NULL,
  status VARCHAR(100) NULL,
  area VARCHAR(80) NULL,
  project_year VARCHAR(20) NULL,
  summary TEXT NULL,
  body LONGTEXT NULL,
  cover_image VARCHAR(500) NULL,
  gallery_json LONGTEXT NULL,
  meta_title VARCHAR(255) NULL,
  meta_description VARCHAR(320) NULL,
  is_featured TINYINT(1) NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS home_features (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  group_key VARCHAR(80) NOT NULL,
  title VARCHAR(190) NOT NULL,
  body TEXT NULL,
  icon VARCHAR(80) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS testimonials (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  role VARCHAR(190) NULL,
  quote_text TEXT NOT NULL,
  rating TINYINT UNSIGNED NOT NULL DEFAULT 5,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS service_areas (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(160) NOT NULL,
  services_text VARCHAR(255) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS faqs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  question VARCHAR(255) NOT NULL,
  answer TEXT NOT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS posts (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(190) NOT NULL,
  slug VARCHAR(190) NOT NULL UNIQUE,
  excerpt TEXT NULL,
  body LONGTEXT NULL,
  cover_image VARCHAR(500) NULL,
  meta_title VARCHAR(255) NULL,
  meta_description VARCHAR(320) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0,
  published_at DATETIME NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS pages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(120) NOT NULL UNIQUE,
  eyebrow VARCHAR(190) NULL,
  title VARCHAR(255) NOT NULL,
  intro TEXT NULL,
  body LONGTEXT NULL,
  hero_image VARCHAR(500) NULL,
  meta_title VARCHAR(255) NULL,
  meta_description VARCHAR(320) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO admins (email,password_hash,name) VALUES
('admin@netvera.local','$2y$12$atqlWseCnAFFDmpCfJgg2.CfPFxgHNu84fH9MctdlXtKheDSZjfgK','NetVera Admin');

INSERT IGNORE INTO settings (setting_key,setting_value) VALUES
('site_name','VERA YAPI'),('logo_mark','VY'),('tagline','İNŞAAT & TAAHHÜT'),
('phone','+90 500 000 00 00'),('whatsapp','905000000000'),('email','info@example.com'),
('address','Alanya / Antalya'),('working_hours','Pzt–Cmt 08:30–18:30'),
('home_testimonials_limit','8'),
('about_image','https://images.unsplash.com/photo-1759863468387-374e0362050a?auto=format&fit=crop&q=80&w=1400'),
('why_image','https://images.unsplash.com/photo-1780145769345-de98a1a6a982?auto=format&fit=crop&q=80&w=1400'),
('contact_title','Projenizi bize anlatın.'),
('contact_body','Kısa bilgileri paylaşın; form sizi doğrudan WhatsApp görüşmesine yönlendirsin.'),
('quick_cta_1_title','Hangi hizmetin projenize uygun olduğundan emin değil misiniz?'),
('quick_cta_1_body','Projenizi kısaca anlatın; kapsam, süreç ve doğru hizmet seçeneği hakkında hızlı bilgi verelim.'),
('quick_cta_1_primary_label','Detaylı Bilgi Al'),('quick_cta_1_primary_url','iletisim'),
('quick_cta_1_secondary_label','WhatsApp\'tan Sor'),
('quick_cta_1_whatsapp_text','Merhaba Vera Yapı, projem için hangi hizmetin uygun olduğu hakkında bilgi almak istiyorum.'),
('quick_cta_2_title','Arsanız veya hazır bir projeniz mi var?'),
('quick_cta_2_body','İlk değerlendirmeyi birlikte yapalım; yaklaşık kapsamı, uygulama modelini ve keşif sürecini netleştirelim.'),
('quick_cta_2_primary_label','Ücretsiz Keşif Planla'),('quick_cta_2_secondary_label','Hemen Ara'),
('meta_description','Alanya ve Antalya’da konut, villa, ticari yapı, renovasyon ve anahtar teslim taahhüt hizmetleri.'),
('footer_text','Konut, villa, ticari yapı, renovasyon ve anahtar teslim taahhüt projelerinde planlı ve güvenilir uygulama.');

INSERT IGNORE INTO home_sections (section_key,eyebrow,title,body,is_active,sort_order) VALUES
('proof','','Deneyimi projeye, güveni sürece dönüştürüyoruz.','Planlama, saha koordinasyonu ve teslim sürecini tek ekip altında yönetiyoruz.',1,10),
('about','Vera Yapı Hakkında','İyi bir yapı, doğru kararların toplamıdır.','Proje planlama, malzeme seçimi, saha uygulaması ve teslim süreçlerini tek sorumluluk altında yönetiyoruz.',1,20),
('services','Hizmetlerimiz','İhtiyacınıza göre kapsamı net, uygulanabilir çözümler.','Konut projelerinden ticari yapılara, anahtar teslim taahhütten renovasyona kadar temel inşaat hizmetleri.',1,30),
('projects','Öne Çıkan Projeler','Yaptığımız işi projelerimiz anlatsın.','Konut, villa ve ticari yapılardan seçili projeler.',1,40),
('why','Neden Vera Yapı?','İnşaat sürecinde sürprizleri değil, netliği tercih ediyoruz.','Kalite yalnızca malzemeyle değil; doğru plan, düzenli kontrol ve zamanında iletişimle oluşur.',1,50),
('process','Çalışma Sürecimiz','İlk görüşmeden anahtar teslimine dört net adım.','Sürecin neresinde olduğunuzu ve sıradaki adımı her zaman bilirsiniz.',1,60),
('testimonials','Müşteri Deneyimleri','Güven, teslim edilen projeden sonra da devam eder.','İletişim, bütçe disiplini ve teslim kalitesi müşterilerimizin en çok önem verdiği başlıklar.',1,70),
('trust','Kurumsal Güven','Kaliteyi süreç boyunca koruyoruz.','Planlama, iş güvenliği, saha kontrolü ve teknik ekip koordinasyonu aynı standardın parçasıdır.',1,75),
('areas','Hizmet Bölgelerimiz','Alanya ve çevresinde yerel saha deneyimi.','Bölgenin koşullarını dikkate alarak proje sürecini yerel şartlara göre planlıyoruz.',1,80),
('blog','Bilgi Merkezi','Projeniz başlamadan önce doğru soruları sorun.','',1,90),
('faq','Sık Sorulan Sorular','İlk görüşme öncesi merak edilenler.','',1,100);

INSERT IGNORE INTO sliders (id,eyebrow,title,body,image,primary_label,primary_url,secondary_label,secondary_url,is_active,sort_order) VALUES
(1,'Alanya’da inşaat ve taahhüt hizmetleri','Projenizi sağlam bir planla, doğru ekiple hayata geçirin.','Konut, villa, ticari yapı ve renovasyon projelerinde keşiften teslimata kadar şeffaf bütçe, düzenli saha takibi ve ölçülebilir kalite standardı.','https://images.unsplash.com/photo-1780145769345-de98a1a6a982?auto=format&fit=crop&q=82&w=2200','Projem İçin Teklif Al','#teklif','Projeleri İncele','projeler',1,10),
(2,'Konut ve villa projeleri','Yaşam alanlarını uzun vadeli değer için tasarlıyoruz.','Arsa değerlendirmesinden uygulama detayına kadar mimari kararları mühendislik disipliniyle birlikte ele alıyoruz.','https://images.unsplash.com/photo-1759863468387-374e0362050a?auto=format&fit=crop&q=82&w=2200','Konut Hizmetini İncele','hizmet/konut-projeleri','Örnek Projeyi Gör','proje/park-residence',1,20),
(3,'Anahtar teslim uygulama','Tek ekip, net sorumluluk, kontrollü teslim.','Keşif, bütçe, tedarik, uygulama ve son kontrolleri tek koordinasyon altında yürütüyoruz.','https://images.unsplash.com/photo-1773427457869-6fbded8b89b9?auto=format&fit=crop&q=82&w=2200','Hizmeti İncele','hizmet/anahtar-teslim-taahhut','Keşif Talebi','#teklif',1,30);

INSERT IGNORE INTO home_stats (id,stat_value,label,is_active,sort_order) VALUES
(1,'20+','Yıllık sektör deneyimi',1,10),(2,'48+','Tamamlanan proje',1,20),(3,'310K','m² toplam uygulama',1,30);

INSERT IGNORE INTO services (id,title,slug,summary,body,cover_image,meta_title,meta_description,is_featured,is_active,sort_order) VALUES
(1,'Konut Projeleri','konut-projeleri','Apartman, rezidans ve toplu konut projelerinde keşiften saha uygulamasına kadar planlı ve kontrollü süreç yönetimi.','Konut projelerinde ihtiyaç analizi, keşif, uygulama planlaması, saha koordinasyonu, kalite kontrolleri ve teslim süreçlerini tek ekip altında yönetiyoruz.','https://images.unsplash.com/photo-1759863468387-374e0362050a?auto=format&fit=crop&q=80&w=1400','Konut Projeleri | Vera Yapı','Alanya ve Antalya’da konut projeleri ve anahtar teslim uygulama hizmetleri.',1,1,10),
(2,'Villa Yapımı','villa-yapimi','Müstakil ve butik villa projelerinde tasarımdan malzeme seçimine, saha uygulamasından teslime kadar bütüncül yönetim.','Arsanın özelliklerinden yaşam senaryosuna kadar her detayı değerlendirerek villa projelerini planlıyor ve uyguluyoruz.','https://images.unsplash.com/photo-1771366260867-7e07094579d7?auto=format&fit=crop&q=80&w=1400','Villa Yapımı | Vera Yapı','Alanya villa yapımı ve anahtar teslim villa inşaat hizmetleri.',1,1,20),
(3,'Ticari Yapılar','ticari-yapilar','Ofis, mağaza, otel ve işletme yapılarında marka, işlev ve uygulama takvimini birlikte ele alan ticari çözümler.','Ticari yapı projelerinde marka deneyimi, işlev, dayanıklılık ve uygulama takvimini birlikte ele alıyoruz.','https://images.unsplash.com/photo-1487958449943-2429e8be8625?auto=format&fit=crop&q=80&w=1400','Ticari Yapılar | Vera Yapı','Ofis, mağaza, otel ve ticari yapı uygulama hizmetleri.',1,1,30),
(4,'Anahtar Teslim Taahhüt','anahtar-teslim-taahhut','Keşif, bütçe, tedarik, saha koordinasyonu, kalite kontrol ve teslim süreçlerini tek sorumluluk altında yönetiyoruz.','Anahtar teslim taahhüt modelinde bütçe, tedarik, uygulama, saha koordinasyonu ve son kontroller tek sorumluluk altında yürütülür.','https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&q=80&w=1400','Anahtar Teslim İnşaat | Vera Yapı','Anahtar teslim inşaat ve taahhüt hizmetleri.',1,1,40),
(5,'Renovasyon','renovasyon','Mevcut yapıların teknik ihtiyaçlarını, kullanım senaryosunu ve estetik beklentileri birlikte ele alan yenileme hizmeti.','Mevcut yapıların ihtiyaçlarını analiz ederek güçlendirme, yenileme ve kullanım dönüşümü çalışmalarını planlıyoruz.','https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&q=80&w=1400','Renovasyon | Vera Yapı','Renovasyon, tadilat ve yapı yenileme hizmetleri.',1,1,50),
(6,'Proje Uygulama','proje-uygulama','Hazır mimari ve mühendislik projelerini teknik detaylara sadık kalarak sahada planlıyor, koordine ediyor ve uyguluyoruz.','Onaylı mimari ve mühendislik projelerini uygulama detaylarına sadık kalarak sahada koordine ediyoruz.','https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&q=80&w=1400','Proje Uygulama | Vera Yapı','Mimari ve mühendislik proje uygulama hizmetleri.',1,1,60);

INSERT IGNORE INTO projects (id,title,slug,category,location,status,area,project_year,summary,body,cover_image,gallery_json,meta_title,meta_description,is_featured,is_active,sort_order) VALUES
(1,'Marina Villa','marina-villa','Villa','Alanya','Tamamlandı','640 m²','2026','Modern çizgiler ve yüksek malzeme standardı.','Marina Villa projesinde iç-dış yaşam ilişkisi, doğal ışık ve uzun ömürlü malzeme seçimleri öne çıkarıldı.','https://images.unsplash.com/photo-1771366260867-7e07094579d7?auto=format&fit=crop&q=80&w=1400','[]','Marina Villa | Vera Yapı','Alanya Marina Villa proje detayı.',1,1,10),
(2,'Park Residence','park-residence','Konut','Antalya','Devam Ediyor','8.900 m²','2026','Çağdaş cephe ve fonksiyonel konut planlaması.','Park Residence, ortak yaşam alanları ve çağdaş cephe karakteriyle çok katlı konut projesi olarak planlandı.','https://images.unsplash.com/photo-1759863468387-374e0362050a?auto=format&fit=crop&q=80&w=1400','[]','Park Residence | Vera Yapı','Antalya Park Residence konut projesi.',1,1,20),
(3,'Kestel House','kestel-house','Konut','Kestel','Tamamlandı','420 m²','2026','Doğal taş ile çağdaş cephe detaylarını birleştiren konut.','Kestel House projesinde doğal malzemeler, koyu cephe detayları ve sade peyzaj dili birlikte kullanıldı.','https://images.unsplash.com/photo-1773427457869-6fbded8b89b9?auto=format&fit=crop&q=80&w=1400','[]','Kestel House | Vera Yapı','Kestel House konut proje detayı.',1,1,30);

INSERT IGNORE INTO home_features (id,group_key,title,body,icon,is_active,sort_order) VALUES
(1,'why','Şeffaf Bütçe','İş kapsamı ve maliyet kalemleri başlangıçta mümkün olduğunca netleştirilir.','01',1,10),
(2,'why','Planlı Takvim','İmalat adımları ve kritik teslim noktaları takvim üzerinden takip edilir.','02',1,20),
(3,'why','Kalite Kontrol','Malzeme ve uygulamalar teknik standartlara göre değerlendirilir.','03',1,30),
(4,'why','Tek Muhatap','Proje iletişimi tek koordinasyon yapısı üzerinden yürütülür.','04',1,40),
(5,'process','Ön Görüşme & Keşif','İhtiyaç, arsa/yapı durumu ve hedef takvim değerlendirilir.','01',1,10),
(6,'process','Teklif & Planlama','İş kapsamı, yaklaşık bütçe ve uygulama takvimi netleştirilir.','02',1,20),
(7,'process','Uygulama & Kontrol','Saha işleri plan doğrultusunda ilerler ve kalite kontrolleri yapılır.','03',1,30),
(8,'process','Kontrol & Teslim','Son kontroller tamamlanır ve proje teslim edilir.','04',1,40),
(9,'trust','Kalite Kontrol','Malzeme ve imalat takibi','',1,10),
(10,'trust','İş Güvenliği','Saha güvenliği ve disiplin','',1,20),
(11,'trust','Teknik Ekip','Mühendislik ve uygulama koordinasyonu','',1,30);

INSERT IGNORE INTO testimonials (id,name,role,quote_text,rating,is_active,sort_order) VALUES
(1,'Mehmet K.','Villa Projesi • Alanya','Proje boyunca maliyet ve uygulama konusunda düzenli bilgi aldık. Sürecin ne durumda olduğunu hep biliyorduk.',5,1,10),
(2,'Selin A.','Renovasyon • Mahmutlar','İlk keşiften teslimata kadar tek ekip ile ilerlemek bizim için büyük kolaylık oldu. Detaylara gerçekten önem verildi.',5,1,20),
(3,'Ahmet Y.','Ticari Yapı • Antalya','Teklifte konuştuğumuz kapsamla sahadaki uygulamanın uyumlu olması güven verdi. İletişim tarafı da hızlıydı.',5,1,30),
(4,'Zeynep D.','Konut Projesi • Oba','Planlama baştan netti; saha ilerleyişini düzenli takip ettik ve teslim sürecinde sürpriz yaşamadık.',5,1,40);

INSERT IGNORE INTO service_areas (id,title,services_text,is_active,sort_order) VALUES
(1,'Alanya Merkez','Konut • Ticari • Renovasyon',1,10),(2,'Oba','Konut • Villa',1,20),(3,'Kestel','Villa • Konut',1,30),(4,'Mahmutlar','Konut • Renovasyon',1,40),(5,'Kargıcak','Villa • Özel proje',1,50),(6,'Antalya','Ticari • Taahhüt',1,60);

INSERT IGNORE INTO faqs (id,question,answer,is_active,sort_order) VALUES
(1,'Anahtar teslim inşaat hizmeti neleri kapsar?','Keşif, bütçeleme, uygulama planı, satın alma, saha koordinasyonu, kalite kontrolleri ve teslim süreçlerini kapsar.',1,10),
(2,'Alanya dışında proje yapıyor musunuz?','Alanya ve Antalya başta olmak üzere proje kapsamına göre çevre bölgelerde de hizmet veriyoruz.',1,20),
(3,'Teklif almadan önce hangi bilgiler gerekir?','Proje türü, konum, yaklaşık alan, mevcut çizim/proje durumu ve hedeflenen zaman bilgileri ilk değerlendirme için yeterlidir.',1,30),
(4,'Keşif ücretli mi?','İlk proje değerlendirmesi ücretsizdir; detaylı saha keşfi proje kapsamına göre planlanır.',1,40);

INSERT IGNORE INTO posts (id,title,slug,excerpt,body,meta_title,meta_description,is_active,sort_order,published_at) VALUES
(1,'İnşaat firması seçerken nelere dikkat edilmeli?','insaat-firmasi-secerken-nelere-dikkat-edilmeli','Sözleşme, teknik ekip, referans, bütçe şeffaflığı ve saha yönetimi için temel kontrol listesi.','İnşaat firması seçiminde yalnız fiyat değil; teknik yeterlilik, sözleşme kapsamı, referanslar, saha yönetimi ve iletişim düzeni birlikte değerlendirilmelidir.','İnşaat Firması Seçerken Nelere Dikkat Edilmeli?','İnşaat firması seçerken dikkat edilmesi gereken temel kriterler.',1,10,NOW()),
(2,'Alanya’da villa yaptırmadan önce 7 önemli kontrol','alanyada-villa-yaptirmadan-once-7-kontrol','Arsa, proje, bütçe, malzeme ve uygulama süreci için temel kontroller.','Villa projesi öncesinde arsa koşulları, ruhsat süreci, ihtiyaç programı, bütçe, malzeme standardı, uygulama takvimi ve sözleşme kapsamı netleştirilmelidir.','Alanya’da Villa Yaptırmadan Önce 7 Kontrol','Alanya’da villa yaptırmadan önce bilinmesi gerekenler.',1,20,NOW()),
(3,'Anahtar teslim inşaat sözleşmesinde hangi maddeler olmalı?','anahtar-teslim-insaat-sozlesmesi','Kapsam, süre, ödeme, malzeme standardı ve teslim kriterleri.','Anahtar teslim sözleşmede iş kapsamı, teknik şartname, ödeme takvimi, süre, değişiklik yönetimi, kalite kriterleri ve teslim koşulları açıkça tanımlanmalıdır.','Anahtar Teslim İnşaat Sözleşmesi','Anahtar teslim inşaat sözleşmesinde bulunması gereken maddeler.',1,30,NOW());

INSERT IGNORE INTO pages (id,slug,eyebrow,title,intro,body,meta_title,meta_description,is_active) VALUES
(1,'hakkimizda','Kurumsal','Güvenilir yapılar, şeffaf süreçler.','Vera Yapı; planlama, teknik uygulama ve teslim süreçlerini tek sorumluluk altında yürüten bir inşaat markasıdır.','Her projede uygulanabilir bütçe, doğru teknik çözüm, düzenli saha takibi ve açık iletişim yaklaşımını benimsiyoruz.','Hakkımızda | Vera Yapı','Vera Yapı kurumsal yaklaşımı, çalışma prensipleri ve inşaat deneyimi.',1),
(2,'iletisim','İletişim','Projenizi birlikte değerlendirelim.','Konut, villa, ticari yapı, taahhüt veya renovasyon ihtiyacınız için bize ulaşın.','İlk görüşmede proje türü, konum, yaklaşık alan ve hedef takvimi birlikte değerlendiririz.','İletişim | Vera Yapı','Vera Yapı iletişim, teklif ve keşif talebi.',1);

SET FOREIGN_KEY_CHECKS=1;
