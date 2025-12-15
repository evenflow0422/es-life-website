<?php
session_start();
require_once 'config.php';
require_once 'saglikHesapla.php';
$isLoggedIn = isset($_SESSION['user_id']);
$error = '';
$bmiResult = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $weightKg = floatval($_POST['weight'] ?? 0);
    $heightCm = floatval($_POST['height'] ?? 0);
    if ($weightKg <= 0 || $weightKg > 300) {
        $error = 'Lütfen geçerli bir kilo değeri girin (1-300 kg arası).';
    } elseif ($heightCm <= 0 || $heightCm > 250) {
        $error = 'Lütfen geçerli bir boy değeri girin (50-250 cm arası).';
    } else {
        if ($isLoggedIn) {
            $calculator = new HealthCalculator();
            $result = $calculator->calculateAndSaveUserBMI($_SESSION['user_id'], $weightKg, $heightCm);
            if ($result['success']) {
                $bmiResult = $result['bmi_data'];
                $bmiResult['saved'] = true;
            } else {
                $error = $result['message'];
            }
        } else {
            $age = intval($_POST['age'] ?? 0);
            $gender = $_POST['gender'] ?? '';
            if ($age <= 0 || $age > 120) {
                $error = 'Lütfen geçerli bir yaş girin (1-120 arası).';
            } elseif (!in_array($gender, ['erkek', 'kadin'])) {
                $error = 'Lütfen cinsiyet seçin.';
            } else {
                $bmiResult = HealthCalculator::calculateBMI($weightKg, $heightCm, $gender, $age);
                $bmiResult['age'] = $age;
                $bmiResult['saved'] = false;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ES-FIT - Keşfet</title>
    <meta name="description" content="Ücretsiz BMI hesaplama, kilo takibi, egzersiz önerileri">
    <meta name="keywords" content="bmi,vücut kitle indeksi,sağlık,kilo hesaplama">
    <meta name="author" content="Ezginur Ünver & Serena Üzümcü">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💪</text></svg>">
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
          <?php if ($isLoggedIn): ?>
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
      <section class="bmi-section">
        <div class="bmi-header">
          <h1>Vücut Kitle İndeksi (BMI) Hesaplama</h1>
          <p>Sağlığınız hakkında bilgi edinin ve ideal kilonuzu öğrenin</p>
        </div>
        <div class="bmi-container">
          <div class="bmi-form-card">
            <h2>
              <i class="fas fa-calculator"></i> 
              <?php echo $isLoggedIn ? 'BMI Hesapla & Kaydet' : 'BMI Hesapla'; ?>
            </h2>
            <?php if (!$isLoggedIn): ?>
              <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <strong>Hesap oluşturun!</strong> Giriş yaparak BMI geçmişinizi takip edebilir ve ilerlemenizi görebilirsiniz.
              </div>
            <?php endif; ?>
            <?php if ($error): ?>
              <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <?php echo $error; ?>
              </div>
            <?php endif; ?>
            <form method="POST" action="">
              <div class="form-group">
                <label for="weight">
                  <i class="fas fa-weight"></i> Kilo (kg)
                </label>
                <input type="number" 
                       id="weight" 
                       name="weight" 
                       step="0.1" 
                       min="1" 
                       max="300"
                       placeholder="Örn: 75.5"
                       value="<?php echo htmlspecialchars($_POST['weight'] ?? ''); ?>"
                       required>
              </div>
              <div class="form-group">
                <label for="height">
                  <i class="fas fa-ruler-vertical"></i> Boy (cm)
                </label>
                <input type="number" 
                       id="height" 
                       name="height" 
                       step="0.1" 
                       min="50" 
                       max="250"
                       placeholder="Örn: 175"
                       value="<?php echo htmlspecialchars($_POST['height'] ?? ''); ?>"
                       required>
              </div>
              <?php if (!$isLoggedIn): ?>
                <div class="form-group">
                  <label for="age">
                    <i class="fas fa-calendar"></i> Yaş
                  </label>
                  <input type="number" 
                         id="age" 
                         name="age" 
                         min="1" 
                         max="120"
                         placeholder="Örn: 25"
                         value="<?php echo htmlspecialchars($_POST['age'] ?? ''); ?>"
                         required>
                </div>
                <div class="form-group">
                  <label for="gender">
                    <i class="fas fa-venus-mars"></i> Cinsiyet
                  </label>
                  <select id="gender" name="gender" required>
                    <option value="">Seçiniz</option>
                    <option value="erkek" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'erkek') ? 'selected' : ''; ?>>Erkek</option>
                    <option value="kadin" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'kadin') ? 'selected' : ''; ?>>Kadın</option>
                  </select>
                </div>
              <?php endif; ?>
              <button type="submit" class="calculate-btn">
                <i class="fas fa-calculator"></i> BMI Hesapla
              </button>
            </form>
          </div>
          <?php if ($bmiResult): ?>
            <div class="bmi-result-card">
              <div class="bmi-value" style="background: linear-gradient(135deg, <?php echo $bmiResult['color']; ?>22 0%, <?php echo $bmiResult['color']; ?>11 100%);">
                <h3>Vücut Kitle İndeksiniz</h3>
                <div class="bmi-number" style="color: <?php echo $bmiResult['color']; ?>;"><?php echo $bmiResult['bmi']; ?></div>
                <div class="bmi-category" style="color: <?php echo $bmiResult['color']; ?>; background: <?php echo $bmiResult['color']; ?>22; padding: 0.5rem 1.5rem; border-radius: 50px; font-weight: 700;">
                  <?php echo $bmiResult['category']; ?>
                </div>
                <?php if ($bmiResult['saved']): ?>
                  <div class="saved-badge">
                    <i class="fas fa-check-circle"></i>
                    Kaydedildi
                  </div>
                <?php endif; ?>
              </div>
              <div class="bmi-details">
                <div class="bmi-detail-item">
                  <h4><i class="fas fa-weight"></i> Mevcut Kilonuz</h4>
                  <p><?php echo $_POST['weight']; ?> kg</p>
                </div>
                <div class="bmi-detail-item">
                  <h4><i class="fas fa-bullseye"></i> İdeal Kilo Aralığınız</h4>
                  <p><?php echo $bmiResult['ideal_weight_min']; ?> - <?php echo $bmiResult['ideal_weight_max']; ?> kg</p>
                </div>
                <div class="bmi-detail-item">
                  <h4><i class="fas fa-chart-line"></i> Kilo Farkı</h4>
                  <p><?php echo $bmiResult['weight_difference_text']; ?></p>
                </div>
                <?php if (isset($bmiResult['daily_calories']) && $bmiResult['daily_calories']): ?>
                  <div class="bmi-detail-item">
                    <h4><i class="fas fa-fire"></i> Günlük Kalori İhtiyacı (Tahmini)</h4>
                    <p><?php echo $bmiResult['daily_calories']; ?> kcal</p>
                  </div>
                <?php endif; ?>
              </div>
              <div class="bmi-recommendation" style="background: linear-gradient(135deg, <?php echo $bmiResult['color']; ?>15 0%, <?php echo $bmiResult['color']; ?>05 100%); border-left: 4px solid <?php echo $bmiResult['color']; ?>;">
                <h4><i class="fas fa-lightbulb"></i> Öneri</h4>
                <p><?php echo $bmiResult['recommendation']; ?></p>
              </div>
            </div>
          <?php else: ?>
            <div class="bmi-result-card empty">
              <i class="fas fa-chart-line"></i>
              <h3>Sonuç Burada Görünecek</h3>
              <p>Formu doldurup hesaplama yapın</p>
            </div>
          <?php endif; ?>
        </div>
      </section>
      <section class="info-section">
        <div class="bmi-header">
          <h2>BMI Hakkında</h2>
        </div>
        <div class="info-grid">
          <div class="info-card">
            <div class="info-icon">
              <i class="fas fa-question-circle"></i>
            </div>
            <h3>BMI Nedir?</h3>
            <p>
              Vücut Kitle İndeksi (BMI), kilo ve boy oranına göre kişinin ideal kiloda olup olmadığını gösteren bir ölçüttür. 
              Dünya Sağlık Örgütü tarafından standart olarak kabul edilmiştir.
            </p>
          </div>
          <div class="info-card">
            <div class="info-icon">
              <i class="fas fa-ruler-combined"></i>
            </div>
            <h3>Nasıl Hesaplanır?</h3>
            <p>
              <strong>BMI = Kilo (kg) / Boy² (m²)</strong><br><br>
              Örnek: 75 kg ve 1.75 m boyunda bir kişi için:<br>
              BMI = 75 / (1.75 × 1.75) = 24.5
            </p>
          </div>
          <div class="info-card">
            <div class="info-icon">
              <i class="fas fa-balance-scale"></i>
            </div>
            <h3>Kategoriler</h3>
            <p>
              • <strong>Zayıf:</strong> &lt; 18.5<br>
              • <strong>Normal:</strong> 18.5 - 24.9<br>
              • <strong>Fazla Kilolu:</strong> 25 - 29.9<br>
              • <strong>Obez:</strong> ≥ 30
            </p>
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