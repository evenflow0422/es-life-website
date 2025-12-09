<?php session_start()?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kayıt Ol - ES-FIT</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💪</text></svg>">
    <meta name="description" content="ES-FIT'e katılın ve sağlıklı yaşam yolculuğunuza başlayın">
    <meta name="keywords" content="kayıt,register,es-fit">
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
    <header id="header">
      <nav class="navbar">
        <div class="logo">ES-FIT</div>
        <ul class="nav-links">
          <li><a href="index.php">Ana Sayfa</a></li>
          <li><a href="kesfet.php">Keşfet</a></li>
          <li><a href="#footer">İletişim</a></li>
          <li><a href="login.php">Giriş Yap</a></li>
          <li><a href="signin.php">Kayıt Ol</a></li>
        </ul>
      </nav>
    </header>

    <main id="main" class="main">
      <div class="register-container">
        <div class="register-header">
          <h1>Aramıza Katılın!</h1>
          <p>Sağlıklı yaşam yolculuğunuza başlayın</p>
        </div>

        <form action="" method="POST">
          <div class="form-row">
            <div class="form-group">
              <label for="first-name">Ad</label>
              <input type="text" id="first-name" name="first_name" placeholder="Adınız" required>
            </div>

            <div class="form-group">
              <label for="last-name">Soyad</label>
              <input type="text" id="last-name" name="last_name" placeholder="Soyadınız" required>
            </div>
          </div>

          <div class="form-group">
            <label for="email">E-posta</label>
            <input type="email" id="email" name="email" placeholder="ornek@email.com" required>
          </div>

          <div class="form-group">
            <label for="password">Şifre</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
          </div>

          <div class="form-group">
            <label for="confirm-password">Şifre Tekrar</label>
            <input type="password" id="confirm-password" name="confirm_password" placeholder="••••••••" required>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="birth-date">Doğum Tarihi</label>
              <input type="date" id="birth-date" name="birth_date" required>
            </div>

            <div class="form-group">
              <label for="gender">Doğum Cinsiyet</label>
              <select id="gender" name="gender" required>
                <option value="">Seçiniz</option>
                <option value="erkek">Erkek</option>
                <option value="kadin">Kadın</option>
              </select>
            </div>
          </div>

          <button type="submit" class="register-button">Kayıt Ol</button>

          <div class="form-footer">
            Zaten hesabınız var mı? <a href="login.php">Giriş yapın</a>
          </div>
        </form>
      </div>
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