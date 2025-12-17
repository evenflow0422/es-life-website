<?php session_start(); ?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Eğitim Alanı - ES-FIT</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💪</text></svg>">
    <meta name="description" content="Sağlık ve fitness eğitim materyalleri">
    <meta name="keywords" content="eğitim,sağlık,fitness,spor,beslenme">
    <meta name="author" content="Ezginur Ünver & Serena Üzümcü">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Work+Sans:wght@300;400;500;600&display=swap"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <!-- Header -->
    <header id="header">
      <nav class="navbar">
        <div class="logo">ES-FIT</div>
        <ul class="nav-links">
          <li><a href="index.php">Ana Sayfa</a></li>
          <li><a href="kesfet.php">Keşfet</a></li>
          <li><a href="#footer">İletişim</a></li>
          <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="profil.php">Profilim</a></li>
            <li><a href="logout.php">Çıkış</a></li>
          <?php else: ?>
            <li><a href="login.php">Giriş Yap</a></li>
            <li><a href="signin.php">Kayıt Ol</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </header>

    <!-- Main Content -->
    <main>
      <section class="education-section">
        <div class="education-header">
          <h1>Eğitim Alanı</h1>
          <p>Sağlık ve fitness bilgi seviyenizi artırın, hedeflerinize daha kolay ulaşın</p>
        </div>

        <div class="education-grid">
          <!-- Kart 1: Beslenme -->
          <div class="education-card">
            <div class="education-image nutrition-image">
              <div class="education-overlay">
                <i class="fas fa-apple-alt"></i>
              </div>
            </div>
            <div class="education-content">
              <h3>Sağlıklı Beslenme</h3>
              <p>
                Dengeli beslenme, sağlıklı yaşamın temelidir. Vücudunuzun ihtiyaç duyduğu 
                tüm besin öğelerini doğru oranlarda alarak enerji seviyenizi yüksek tutabilir, 
                hastalıklardan korunabilir ve ideal kilonuzu koruyabilirsiniz.
              </p>
              <div class="education-topics">
                <span class="topic-tag"><i class="fas fa-check-circle"></i> Makro Besinler</span>
                <span class="topic-tag"><i class="fas fa-check-circle"></i> Vitamin & Mineraller</span>
                <span class="topic-tag"><i class="fas fa-check-circle"></i> Öğün Planlaması</span>
                <span class="topic-tag"><i class="fas fa-check-circle"></i> Su Tüketimi</span>
              </div>
              <div class="education-tips">
                <h4><i class="fas fa-lightbulb"></i> İpuçları:</h4>
                <ul>
                  <li>Her öğünde protein, karbonhidrat ve sağlıklı yağ bulundurun</li>
                  <li>Günde en az 2 litre su için</li>
                  <li>Renkli sebze ve meyveleri tercih edin</li>
                  <li>İşlenmiş gıdalardan uzak durun</li>
                  <li>Düzenli ve küçük öğünler tüketin</li>
                </ul>
              </div>
              <a href="https://www.nefisyemektarifleri.com/liste/her-pazartesi-degil-bugun-basliyoruz-diyet-tarifleri/" target="_blank" class="education-link">
                <i class="fas fa-external-link-alt"></i> Sağlıklı tarifler için
              </a>
            </div>
          </div>

          <!-- Kart 2: Egzersiz -->
          <div class="education-card">
            <div class="education-image exercise-image">
              <div class="education-overlay">
                <i class="fas fa-dumbbell"></i>
              </div>
            </div>
            <div class="education-content">
              <h3>Egzersiz ve Fitness</h3>
              <p>
                Düzenli egzersiz yapmak sadece kilo kontrolü için değil, kardiyovasküler sağlık, 
                kas gücü, esneklik ve mental sağlık için de son derece önemlidir. Haftada 
                en az 150 dakika orta yoğunlukta aktivite hedefleyin.
              </p>
              <div class="education-topics">
                <span class="topic-tag"><i class="fas fa-check-circle"></i> Kardiyo Egzersizler</span>
                <span class="topic-tag"><i class="fas fa-check-circle"></i> Güç Antrenmanı</span>
                <span class="topic-tag"><i class="fas fa-check-circle"></i> Esneklik & Denge</span>
                <span class="topic-tag"><i class="fas fa-check-circle"></i> HIIT Antrenmanları</span>
              </div>
              <div class="education-tips">
                <h4><i class="fas fa-lightbulb"></i> İpuçları:</h4>
                <ul>
                  <li>Egzersize ısınma ile başlayın, soğuma ile bitirin</li>
                  <li>Kas gruplarını dengeli çalıştırın</li>
                  <li>Dinlenme günlerine önem verin</li>
                  <li>Doğru form ve teknik kullanın</li>
                  <li>İlerlemeli olarak yoğunluğu artırın</li>
                </ul>
              </div>
              <a href="https://www.spookynooksports.com/blog/manheim/proper-form-for-weightlifting-and-exercising" target="_blank" class="education-link">
                <i class="fas fa-external-link-alt"></i> Doğru egzersiz formlarını öğrenmek için
              </a>
            </div>
          </div>

          <!-- Kart 3: Yaşam Tarzı -->
          <div class="education-card">
            <div class="education-image lifestyle-image">
              <div class="education-overlay">
                <i class="fas fa-heart"></i>
              </div>
            </div>
            <div class="education-content">
              <h3>Sağlıklı Yaşam Tarzı</h3>
              <p>
                Sağlıklı yaşam sadece beslenme ve egzersizden ibaret değildir. Kaliteli uyku, 
                stres yönetimi, sosyal bağlantılar ve zihinsel sağlık da genel refahınız için 
                kritik öneme sahiptir. Bütünsel bir yaklaşım benimseyin.
              </p>
              <div class="education-topics">
                <span class="topic-tag"><i class="fas fa-check-circle"></i> Uyku Hijyeni</span>
                <span class="topic-tag"><i class="fas fa-check-circle"></i> Stres Yönetimi</span>
                <span class="topic-tag"><i class="fas fa-check-circle"></i> Mental Sağlık</span>
                <span class="topic-tag"><i class="fas fa-check-circle"></i> Sosyal Bağlantılar</span>
              </div>
              <div class="education-tips">
                <h4><i class="fas fa-lightbulb"></i> İpuçları:</h4>
                <ul>
                  <li>Düzenli uyku saatlerine uyun (7-9 saat)</li>
                  <li>Meditasyon veya nefes egzersizleri yapın</li>
                  <li>Hobiler edinin ve zaman ayırın</li>
                  <li>Sevdiklerinizle kaliteli zaman geçirin</li>
                  <li>Ekran sürenizi sınırlandırın</li>
                </ul>
              </div>
              <a href="https://www.youtube.com/results?search_query=meditasyon+egzersizleri+türkçe" target="_blank" class="education-link">
                <i class="fas fa-external-link-alt"></i> Meditasyon egzersizleri için
              </a>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- Footer -->
    <footer class="footer" id="footer">
      <div class="footer-content">
        <div class="footer-section">
          <div class="footer-brand">ES-FIT</div>
          <p>sağlıklı bir yaşam için.</p>
          <div class="social-links">
            <a href="https://github.com/Ezgnur35" target="_blank">
              <i class="fab fa-github"></i>
              <span>Ezginur Ünver</span>
            </a>
            <a href="https://github.com/evenflow0422" target="_blank">
              <i class="fab fa-github"></i>
              <span>Serena Üzümcü</span>
            </a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 ES-FIT. Tüm hakları saklıdır.</p>
        <p style="margin-top: 0.5rem; font-size: 0.8rem; opacity: 0.7;">Design: Figma</p>
      </div>
    </footer>
  </body>
</html>