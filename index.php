<?php session_start()?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ES-FIT - Sağlıklı Yaşam Platformu</title>
    <meta name="description" content="Ücretsiz kilo takibi, egzersiz önerileri ve hakkında bilgiler">
    <meta name="keywords" content="fit,sağlık,sağlıklı yaşam, egzersiz, vücut kitle ölçme,kilo vermek">
    <meta name="author" content="Ezginur Ünver & Serena Üzümcü">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💪</text></svg>">
    <!--ikon emoji şimdilik ileride???-->
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
    <header id="header">
      <nav class=navbar>
        <div class="logo">ES-FIT</div>
        <ul class="nav-links">
          <li><a href="#">Ana Sayfa</a></li>
          <li><a href="kesfet.php">Keşfet</a></li>
          <li><a href="#footer">İletişim</a></li>
          <!-- Oturum açıldığında gözüksün -->
          <li><a href="profil.php">Profil</a></li>
          <!--Oturum açılmadıysa profil yerine gözüksün-->
          <li><a href="login.php">Giriş Yap</a></li>
          <li><a href="signin.php">Kayıt Ol</a></li>
        </ul>
      </nav>
    </header>
    <!--user select ile renk seç sonra (kırmızı arkaplan beyaz font)-->
    <main id="main" class="main">
      <div class="hero">  <!--hero box-->
        <div class="hero-content">
          <h1>"Sağlık lüks değil, hayat tarzıdır."</h1>
          <p>
            Burada amaç yazıyor sitenin işte falan filan. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aspernatur modi est ab error fugiat! Ducimus, culpa alias! Nam quisquam explicabo iusto numquam similique officia hic exercitationem, placeat quos doloremque aut?
          </p>
        </div>
        <div class="hero-image"></div>
      </div>

      <div class="features">
        <div class="features-grid">
          <div class="feature-card">
            <div class="feature-image gradient-pink-green"></div>
            <div class="feature-content">
              <h3>İlerlemeni Gör!</h3>
              <p>
                Hesap kurarak nasıl ilerlemeler katlettiğini görebilirsin! Aşağıdaki yazıya tıklayarak profiline göz at!
              </p>
              <a href="#" class="feature-link">Git</a>
            </div>
          </div>

          <div class="feature-card">
            <div class="feature-image texture-green"></div>
            <div class="feature-content">
              <h3>BMI Hesaplama</h3>
              <p>İdeal kilo ve sağlık durumunuzla ilgili detaylı bilgi edinin.</p>
              <a href="#" class="feature-link">Git</a>
            </div>
          </div>

          <div class="feature-card">
            <div class="feature-image gradient-teal"></div>
            <div class="feature-content">
              <h3>Eğitim Alanı</h3>
              <p>
                Sağlık ve fitness alanında bilgi seviyenizi artırın ve
                hedeflerinize rahatla ulaşın.
              </p>
              <a href="#" class="feature-link">Git</a>
            </div>
          </div>
        </div>
      </div>

      <section class="cta-section">
        <div class="cta-content">
          <h2>Bugün suyunu içtin mi?</h2>
          <p>Vücudunuz Yenile; su içmeyi unutma!</p>
          <a href="http://acibadem.com.tr/hayat/suyun-faydalari-onemi/" target="_blank" class="cta-button">Bilgi Edin </a>
        </div>
        <div class="cta-image"></div>
      </section>
    </main>
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