<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: profil.php');
    exit();
}
require_once 'config.php';
require_once 'User.php';
$error = '';
$success = '';
if (isset($_GET['registered']) && $_GET['registered'] == 1) {
    $success = 'Kayıt başarıyla tamamlandı! Giriş yapabilirsiniz.';
}
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    $success = 'Başarıyla çıkış yaptınız.';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (empty($email) || empty($password)) {
        $error = 'Lütfen tüm alanları doldurun.';
    } else {
        $result = $user->login($email, $password);
        if ($result['success']) {
            $_SESSION['user_id'] = $result['user']['user_id'];
            $_SESSION['first_name'] = $result['user']['first_name'];
            $_SESSION['last_name'] = $result['user']['last_name'];
            $_SESSION['email'] = $result['user']['email'];
            $_SESSION['login_time'] = time();
            header('Location: profil.php');
            exit();
        } else {
            $error = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Giriş Yap - ES-FIT</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💪</text></svg>">
    <meta name="description" content="ES-FIT hesabınıza giriş yapın">
    <meta name="keywords" content="giriş,login,es-fit">
    <meta name="author" content="Ezginur Ünver & Serena Üzümcü">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Work+Sans:wght@300;400;500;600&display=swap"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="style.css">
    <style>
      .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 10px;
        font-size: 0.95rem;
      }
      .alert-error {
        background-color: #fee;
        color: #c33;
        border: 1px solid #fcc;
      }
      .alert-success {
        background-color: #efe;
        color: #3c3;
        border: 1px solid #cfc;
      }
    </style>
  </head>
  <body>
    <header id="header">
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
      <div class="login-container">
        <div class="login-header">
          <h1>Hoş Geldiniz!</h1>
          <p>Hesabınıza giriş yapın</p>
        </div>
        <?php if ($error): ?>
          <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
          <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
          <div class="form-group">
            <label for="email">E-posta</label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   placeholder="ornek@email.com" 
                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                   required>
          </div>
          <div class="form-group">
            <label for="password">Şifre</label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   placeholder="••••••••" 
                   required>
            <div class="forgot-password">
              <a href="sifre-sifirlama.php">Şifreni mi unuttun?</a>
            </div>
          </div>
          <button type="submit" class="login-button">Giriş Yap</button>
          <div class="divider">veya</div>
          <div class="form-footer">
            Hesabınız yok mu? <a href="signin.php">Kayıt olun</a>
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