<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'config.php';
require_once 'egzersiz.php';

$exercise = new Exercise();
$muscleGroups = $exercise->getAllMuscleGroups();
$allExercises = $exercise->getAllExercises(); // Tüm egzersizleri çek

$success = '';
$error = '';

// Antrenman kaydetme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_workout'])) {
    $workoutData = json_decode($_POST['workout_data'], true);
    
    if (!empty($workoutData)) {
        try {
            $db = getDB();
            $db->beginTransaction();
            
            foreach ($workoutData as $workout) {
                $result = $exercise->addWorkout(
                    $_SESSION['user_id'],
                    $workout['exercise_id'],
                    $workout['sets'],
                    $workout['reps'],
                    $workout['notes'] ?? null
                );
            }
            
            $db->commit();
            $success = 'Antrenman başarıyla kaydedildi!';
            
            // 2 saniye sonra profile yönlendir
            header("refresh:2;url=profil.php");
            
        } catch (Exception $e) {
            $db->rollBack();
            $error = 'Antrenman kaydedilirken bir hata oluştu.';
        }
    } else {
        $error = 'Lütfen en az bir egzersiz ekleyin.';
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Antrenman Oluştur - ES-FIT</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💪</text></svg>">
    <meta name="description" content="Antrenman programı oluştur">
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
      <section class="workout-creator-section">
        <div class="workout-header">
          <h1>Antrenman Oluştur</h1>
          <p>Egzersizlerini seç ve antrenmanını planla</p>
        </div>

        <?php if ($success): ?>
          <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo $success; ?>
          </div>
        <?php endif; ?>

        <?php if ($error): ?>
          <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <?php echo $error; ?>
          </div>
        <?php endif; ?>

        <div class="workout-container">
          <!-- Sol Panel: Kas Grupları ve Egzersizler -->
          <div class="exercise-selector">
            <h2><i class="fas fa-dumbbell"></i> Egzersiz Seç</h2>
            
            <!-- Kas Grubu Butonları -->
            <div class="muscle-group-tabs">
              <?php foreach ($muscleGroups as $index => $group): ?>
                <button class="muscle-tab <?php echo $index === 0 ? 'active' : ''; ?>" 
                        data-group-id="<?php echo $group['group_id']; ?>"
                        onclick="filterExercises(<?php echo $group['group_id']; ?>, this)">
                  <?php echo htmlspecialchars($group['group_name']); ?>
                </button>
              <?php endforeach; ?>
            </div>

            <!-- Egzersiz Butonları -->
            <div class="exercise-buttons-container">
              <?php foreach ($allExercises as $exercise): ?>
                <button class="exercise-button" 
                        data-group-id="<?php echo $exercise['group_id']; ?>"
                        data-exercise-id="<?php echo $exercise['exercise_id']; ?>"
                        data-exercise-name="<?php echo htmlspecialchars($exercise['exercise_name']); ?>"
                        data-group-name="<?php echo htmlspecialchars($exercise['group_name']); ?>"
                        data-difficulty="<?php echo $exercise['difficulty']; ?>"
                        onclick="openAddModal(<?php echo $exercise['exercise_id']; ?>, '<?php echo htmlspecialchars($exercise['exercise_name']); ?>', '<?php echo htmlspecialchars($exercise['group_name']); ?>')">
                  <?php echo htmlspecialchars($exercise['exercise_name']); ?>
                </button>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Sağ Panel: Antrenman Programı -->
          <div class="workout-list-panel">
            <h2><i class="fas fa-clipboard-list"></i> Antrenman Programım</h2>
            
            <div id="workout-program" class="workout-program">
              <div class="empty-program">
                <i class="fas fa-dumbbell"></i>
                <p>Henüz egzersiz eklemediniz</p>
                <small>Soldan egzersiz butonlarına tıklayarak ekleyin</small>
              </div>
            </div>

            <form method="POST" id="save-workout-form" style="display: none;">
              <input type="hidden" name="workout_data" id="workout_data">
              <button type="submit" name="save_workout" class="save-workout-btn">
                <i class="fas fa-save"></i> Programı Kaydet
              </button>
            </form>
          </div>
        </div>
      </section>

      <!-- Tüm egzersizleri JavaScript'e aktar -->
      <script>
        const allExercisesData = <?php echo json_encode($allExercises); ?>;
      </script>
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

    <script>
      // Workout data
      let workoutData = [];
      let workoutIdCounter = 1;

      // Sayfa yüklendiğinde ilk kas grubunu göster
      window.addEventListener('DOMContentLoaded', function() {
        const firstTab = document.querySelector('.muscle-tab');
        if (firstTab) {
          const groupId = firstTab.getAttribute('data-group-id');
          filterExercises(groupId, firstTab);
        }
      });

      // Egzersizleri filtrele
      function filterExercises(groupId, tabElement) {
        // Aktif tab'ı güncelle
        document.querySelectorAll('.muscle-tab').forEach(tab => {
          tab.classList.remove('active');
        });
        tabElement.classList.add('active');

        // Egzersiz butonlarını göster/gizle
        const exerciseButtons = document.querySelectorAll('.exercise-button');
        exerciseButtons.forEach(button => {
          if (button.getAttribute('data-group-id') == groupId) {
            button.style.display = 'inline-block';
          } else {
            button.style.display = 'none';
          }
        });
      }

      // Egzersiz ekleme modalını aç
      function openAddModal(exerciseId, exerciseName, groupName) {
        const modal = document.createElement('div');
        modal.className = 'modal-overlay';
        modal.innerHTML = `
          <div class="modal-content">
            <div class="modal-header">
              <h3><i class="fas fa-plus-circle"></i> Egzersiz Ekle</h3>
              <button onclick="closeModal()" class="close-modal">
                <i class="fas fa-times"></i>
              </button>
            </div>
            <div class="modal-body">
              <h4>${exerciseName}</h4>
              <p class="modal-group-name">${groupName}</p>
              
              <div class="modal-form">
                <div class="form-row">
                  <div class="form-group">
                    <label><i class="fas fa-layer-group"></i> Set Sayısı</label>
                    <input type="number" id="modal-sets" class="modal-input" min="1" max="10" value="3">
                  </div>
                  <div class="form-group">
                    <label><i class="fas fa-redo"></i> Tekrar Sayısı</label>
                    <input type="number" id="modal-reps" class="modal-input" min="1" max="100" value="10">
                  </div>
                </div>
                <div class="form-group">
                  <label><i class="fas fa-sticky-note"></i> Not (Opsiyonel)</label>
                  <input type="text" id="modal-notes" class="modal-input" placeholder="Örn: Ağırlık 20kg">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button onclick="closeModal()" class="modal-btn modal-btn-cancel">İptal</button>
              <button onclick="addToWorkout(${exerciseId}, '${exerciseName}', '${groupName}')" class="modal-btn modal-btn-add">
                <i class="fas fa-check"></i> Ekle
              </button>
            </div>
          </div>
        `;
        
        document.body.appendChild(modal);
        
        // Modal dışına tıklandığında kapat
        modal.addEventListener('click', function(e) {
          if (e.target === modal) {
            closeModal();
          }
        });
      }

      // Modalı kapat
      function closeModal() {
        const modal = document.querySelector('.modal-overlay');
        if (modal) {
          modal.remove();
        }
      }

      // Egzersizi programa ekle
      function addToWorkout(exerciseId, exerciseName, groupName) {
        const sets = document.getElementById('modal-sets').value;
        const reps = document.getElementById('modal-reps').value;
        const notes = document.getElementById('modal-notes').value;

        const workoutItem = {
          id: workoutIdCounter++,
          exercise_id: exerciseId,
          exercise_name: exerciseName,
          group_name: groupName,
          sets: sets,
          reps: reps,
          notes: notes,
          completed: false
        };

        workoutData.push(workoutItem);
        renderWorkoutProgram();
        closeModal();
        
        // Kaydet formunu göster
        document.getElementById('save-workout-form').style.display = 'block';
      }

      // Antrenman programını render et
      function renderWorkoutProgram() {
        const programDiv = document.getElementById('workout-program');
        
        if (workoutData.length === 0) {
          programDiv.innerHTML = `
            <div class="empty-program">
              <i class="fas fa-dumbbell"></i>
              <p>Henüz egzersiz eklemediniz</p>
              <small>Soldan egzersiz butonlarına tıklayarak ekleyin</small>
            </div>
          `;
          document.getElementById('save-workout-form').style.display = 'none';
          return;
        }

        let html = '<div class="program-table">';
        html += '<table class="workout-table">';
        html += '<thead><tr>';
        html += '<th style="width: 50px;"><i class="fas fa-check"></i></th>';
        html += '<th>Egzersiz</th>';
        html += '<th>Kas Grubu</th>';
        html += '<th style="width: 80px;">Set</th>';
        html += '<th style="width: 80px;">Tekrar</th>';
        html += '<th style="width: 50px;"><i class="fas fa-trash"></i></th>';
        html += '</tr></thead>';
        html += '<tbody>';
        
        workoutData.forEach(item => {
          html += `
            <tr class="${item.completed ? 'completed-row' : ''}">
              <td class="checkbox-cell">
                <input type="checkbox" id="check-${item.id}" ${item.completed ? 'checked' : ''} 
                       onchange="toggleComplete(${item.id})" class="workout-checkbox">
                <label for="check-${item.id}"></label>
              </td>
              <td class="exercise-name-cell">
                <strong>${item.exercise_name}</strong>
                ${item.notes ? `<br><small class="note-text"><i class="fas fa-sticky-note"></i> ${item.notes}</small>` : ''}
              </td>
              <td><span class="group-badge">${item.group_name}</span></td>
              <td class="text-center"><strong>${item.sets}</strong></td>
              <td class="text-center"><strong>${item.reps}</strong></td>
              <td class="text-center">
                <button class="delete-btn" onclick="removeFromProgram(${item.id})" title="Sil">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          `;
        });
        
        html += '</tbody>';
        html += '</table>';
        html += '</div>';
        programDiv.innerHTML = html;

        // Workout data'yı hidden input'a kaydet
        document.getElementById('workout_data').value = JSON.stringify(workoutData);
      }

      // Tamamlandı durumunu değiştir
      function toggleComplete(id) {
        const item = workoutData.find(w => w.id === id);
        if (item) {
          item.completed = !item.completed;
          renderWorkoutProgram();
        }
      }

      // Egzersizi programdan çıkar
      function removeFromProgram(id) {
        if (confirm('Bu egzersizi programdan çıkarmak istediğinize emin misiniz?')) {
          workoutData = workoutData.filter(w => w.id !== id);
          renderWorkoutProgram();
        }
      }
    </script>
  </body>
</html>