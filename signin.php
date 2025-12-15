<?php
session_start();
require_once 'config.php';
require_once 'user.php';
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $data = [
        'first_name' => trim($_POST['first_name'] ?? ''),
        'last_name' => trim($_POST['last_name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'confirm_password' => $_POST['confirm_password'] ?? '',
        'birth_date' => $_POST['birth_date'] ?? '',
        'gender' => $_POST['gender'] ?? ''
    ];
    $result = $user->register($data);
    if ($result['success']) {
        $success = $result['message'];
        header('Location: login.php?registered=1');
        exit();
    } else {
        $error = $result['message'];
    }
}
?>
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
    <main id="main" class="main">
      <div class="register-container">
        <div class="register-header">
          <h1>Aramıza Katılın!</h1>
          <p>Sağlıklı yaşam yolculuğunuza başlayın</p>
        </div>
        <?php if ($error): ?>
          <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <?php echo $error; ?>
          </div>
        <?php endif; ?>
        <?php if ($success): ?>
          <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo $success; ?>
          </div>
        <?php endif; ?>
        <form action="" method="POST">
          <div class="form-row">
            <div class="form-group">
              <label for="first-name">Ad</label>
              <input type="text" id="first-name" name="first_name" 
                     placeholder="Adınız" 
                     value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>"
                     required>
            </div>
            <div class="form-group">
              <label for="last-name">Soyad</label>
              <input type="text" id="last-name" name="last_name" 
                     placeholder="Soyadınız" 
                     value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>"
                     required>
            </div>
          </div>
          <div class="form-group">
            <label for="email">E-posta</label>
            <input type="email" id="email" name="email" 
                   placeholder="ornek@email.com" 
                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                   required>
          </div>
          <div class="form-group">
            <label for="password">Şifre (en az 6 karakter)</label>
            <input type="password" id="password" name="password" 
                   placeholder="••••••••" 
                   minlength="6"
                   required>
          </div>
          <div class="form-group">
            <label for="confirm-password">Şifre Tekrar</label>
            <input type="password" id="confirm-password" name="confirm_password" 
                   placeholder="••••••••" 
                   minlength="6"
                   required>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="birth-date">Doğum Tarihi</label>
              <input type="date" id="birth-date" name="birth_date" 
                     value="<?php echo htmlspecialchars($_POST['birth_date'] ?? ''); ?>"
                     max="<?php echo date('Y-m-d', strtotime('-13 years')); ?>"
                     required>
            </div>
            <div class="form-group">
              <label for="gender">Cinsiyet</label>
              <select id="gender" name="gender" required>
                <option value="">Seçiniz</option>
                <option value="erkek" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'erkek') ? 'selected' : ''; ?>>Erkek</option>
                <option value="kadin" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'kadin') ? 'selected' : ''; ?>>Kadın</option>
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