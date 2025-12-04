<?php session_start()?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ES-FIT - Keşfet</title>
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
          <li><a href="index.php">Ana Sayfa</a></li>
          <li><a href="#">Keşfet</a></li>
          <li><a href="#footer">İletişim</a></li>
          <!-- Oturum açıldığında gözüksün -->
          <li><a href="profil.php">Profil</a></li>
          <!--Oturum açılmadıysa profil yerine gözüksün-->
          <li><a href="login.php">Giriş Yap</a></li>
          <li><a href="signin.php">Kayıt Ol</a></li>
        </ul>
      </nav>
    </header>
    <main>

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