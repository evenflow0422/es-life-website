<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'config.php';
require_once 'user.php';
require_once 'saglikHesapla.php';
require_once 'egzersiz.php';

$user = new User();
$calculator = new HealthCalculator();
$exercise = new Exercise();

$userInfo = $user->getUserInfo($_SESSION['user_id']);
$latestBMI = $calculator->getLatestBMI($_SESSION['user_id']);
$bmiHistory = $calculator->getUserBMIHistory($_SESSION['user_id'], 5);
$recentWorkouts = $exercise->getUserWorkouts($_SESSION['user_id'], 5);

$birthDate = new DateTime($userInfo['birth_date']);
$today = new DateTime();
$age = $today->diff($birthDate)->y;
?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profilim - ES-FIT</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💪</text></svg>">
    <meta name="description" content="ES-FIT kullanıcı profili">
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

    <main>
      <section class="profile-section">
        <div class="profile-header">
          <h1>Hoş Geldin, <?php echo htmlspecialchars($userInfo['first_name']); ?>!</h1>
          <p>Profilin ve ilerleme kaydın</p>
        </div>

        <div class="profile-container">
          <div class="profile-info-card">
            <div class="profile-avatar">
              <i class="fas fa-user-circle"></i>
            </div>
            
            <h2><?php echo htmlspecialchars($userInfo['first_name'] . ' ' . $userInfo['last_name']); ?></h2>
            
            <div class="info-list">
              <div class="info-item">
                <i class="fas fa-envelope"></i>
                <div>
                  <span class="info-label">E-posta</span>
                  <span class="info-value"><?php echo htmlspecialchars($userInfo['email']); ?></span>
                </div>
              </div>

              <div class="info-item">
                <i class="fas fa-birthday-cake"></i>
                <div>
                  <span class="info-label">Yaş</span>
                  <span class="info-value"><?php echo $age; ?> yaşında</span>
                </div>
              </div>

              <div class="info-item">
                <i class="fas fa-venus-mars"></i>
                <div>
                  <span class="info-label">Cinsiyet</span>
                  <span class="info-value"><?php echo $userInfo['gender'] === 'erkek' ? 'Erkek' : 'Kadın'; ?></span>
                </div>
              </div>
            </div>
          </div>
          <div class="profile-content">
            <?php if ($latestBMI): ?>
            <div class="stat-card bmi-card">
              <h3><i class="fas fa-heartbeat"></i> Son BMI Ölçümün</h3>
              <div class="stat-grid">
                <div class="stat-item">
                  <span class="stat-label">BMI</span>
                  <span class="stat-value"><?php echo $latestBMI['bmi']; ?></span>
                </div>
                <div class="stat-item">
                  <span class="stat-label">Kilo</span>
                  <span class="stat-value"><?php echo $latestBMI['weight_kg']; ?> kg</span>
                </div>
                <div class="stat-item">
                  <span class="stat-label">Boy</span>
                  <span class="stat-value"><?php echo $latestBMI['height_cm']; ?> cm</span>
                </div>
                <div class="stat-item">
                  <span class="stat-label">Tarih</span>
                  <span class="stat-value"><?php echo date('d.m.Y', strtotime($latestBMI['measurement_date'])); ?></span>
                </div>
              </div>
              <a href="kesfet.php" class="card-link">Yeni Ölçüm Yap <i class="fas fa-arrow-right"></i></a>
            </div>
            <?php else: ?>
            <div class="stat-card empty-card">
              <i class="fas fa-chart-line"></i>
              <h3>Henüz BMI Ölçümü Yok</h3>
              <p>BMI'ni hesapla ve ilerlemeyi takip et!</p>
              <a href="kesfet.php" class="card-button">İlk Ölçümü Yap</a>
            </div>
            <?php endif; ?>
            <?php if (!empty($bmiHistory)): ?>
            <div class="stat-card">
              <h3><i class="fas fa-history"></i> BMI Geçmişi</h3>
              <div class="history-list">
                <?php foreach ($bmiHistory as $record): ?>
                <div class="history-item">
                  <div class="history-date">
                    <i class="fas fa-calendar"></i>
                    <?php echo date('d.m.Y', strtotime($record['measurement_date'])); ?>
                  </div>
                  <div class="history-stats">
                    <span><strong>BMI:</strong> <?php echo $record['bmi']; ?></span>
                    <span><strong>Kilo:</strong> <?php echo $record['weight_kg']; ?> kg</span>
                    <span><strong>Boy:</strong> <?php echo $record['height_cm']; ?> cm</span>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
            <?php endif; ?>
            <?php if (!empty($recentWorkouts)): ?>
            <div class="stat-card">
              <h3><i class="fas fa-dumbbell"></i> Son Antrenmanlar</h3>
              <div class="workout-list">
                <?php foreach ($recentWorkouts as $workout): ?>
                <div class="workout-item">
                  <div class="workout-header">
                    <span class="workout-name"><?php echo htmlspecialchars($workout['exercise_name']); ?></span>
                    <span class="workout-date"><?php echo date('d.m.Y', strtotime($workout['workout_date'])); ?></span>
                  </div>
                  <div class="workout-details">
                    <span class="workout-badge"><?php echo $workout['group_name']; ?></span>
                    <span><?php echo $workout['sets']; ?> set × <?php echo $workout['reps']; ?> tekrar</span>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
            <?php else: ?>
            <div class="stat-card empty-card">
              <i class="fas fa-dumbbell"></i>
              <h3>Henüz Antrenman Kaydı Yok</h3>
              <p>Antrenmanlarını kaydet ve gelişimini gör!</p>
            </div>
            <?php endif; ?>
          </div>
        </div>
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