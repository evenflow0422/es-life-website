<?php

require_once 'config.php';

class HealthCalculator {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
    }

    public static function calculateBMI($weightKg, $heightCm, $gender = null, $age = null) {
        $heightM = $heightCm / 100;
        $bmi = round($weightKg / ($heightM * $heightM), 2);
        
        if ($bmi < 18.5) {
            $category = 'Zayıf';
            $color = '#fbc02d';
            $advice = 'Sağlıklı bir şekilde kilo almanız önerilir.';
        } elseif ($bmi >= 18.5 && $bmi < 25) {
            $category = 'Normal';
            $color = '#388e3c';
            $advice = 'İdeal kilo aralığındasınız. Böyle devam edin!';
        } elseif ($bmi >= 25 && $bmi < 30) {
            $category = 'Fazla Kilolu';
            $color = '#f57c00';
            $advice = 'Düzenli egzersiz ve sağlıklı beslenme ile ideal kiloya ulaşabilirsiniz.';
        } else {
            $category = 'Obez';
            $color = '#e64a19';
            $advice = 'Sağlığınız için kilo vermeniz önemlidir. Bir diyetisyen ile görüşün.';
        }
        
        $idealMin = round(18.5 * ($heightM * $heightM), 1);
        $idealMax = round(24.9 * ($heightM * $heightM), 1);
        
        $dailyCalories = null;
        if ($gender && $age) {
            if ($gender === 'erkek') {
                $bmr = 88.362 + (13.397 * $weightKg) + (4.799 * $heightCm) - (5.677 * $age);
            } else {
                $bmr = 447.593 + (9.247 * $weightKg) + (3.098 * $heightCm) - (4.330 * $age);
            }
            $dailyCalories = round($bmr * 1.55); 
        }
        
        return [
            'bmi' => $bmi,
            'category' => $category,
            'color' => $color,
            'advice' => $advice,
            'ideal_min' => $idealMin,
            'ideal_max' => $idealMax,
            'ideal_weight_min' => $idealMin,
            'ideal_weight_max' => $idealMax,
            'weight_difference' => round($weightKg - (($idealMin + $idealMax) / 2), 1),
            'weight_difference_text' => ($weightKg > (($idealMin + $idealMax) / 2)) 
                ? 'İdeal kilonuzun ' . round(abs($weightKg - (($idealMin + $idealMax) / 2)), 1) . ' kg üzerindesiniz.'
                : (($weightKg < (($idealMin + $idealMax) / 2)) 
                    ? 'İdeal kilonuzun ' . round(abs($weightKg - (($idealMin + $idealMax) / 2)), 1) . ' kg altındasınız.'
                    : 'İdeal kilonuzdasınız!'),
            'recommendation' => $advice,
            'daily_calories' => $dailyCalories
        ];
    }
    
    public function calculateAndSaveUserBMI($userId, $weightKg, $heightCm) {
        try {
            $sql = "SELECT birth_date FROM users WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            $user = $stmt->fetch();
            
            if (!$user) {
                return ['success' => false, 'message' => 'Kullanıcı bulunamadı.'];
            }
            
            $birthDate = new DateTime($user['birth_date']);
            $today = new DateTime();
            $age = $today->diff($birthDate)->y;
            
            $bmiData = self::calculateBMI($weightKg, $heightCm);
            
            $insertSql = "INSERT INTO user_measurements (user_id, weight_kg, height_cm, measurement_date)
                          VALUES (:user_id, :weight_kg, :height_cm, :measurement_date)";
            
            $insertStmt = $this->db->prepare($insertSql);
            $insertStmt->execute([
                ':user_id' => $userId,
                ':weight_kg' => $weightKg,
                ':height_cm' => $heightCm,
                ':measurement_date' => date('Y-m-d')
            ]);
            
            $bmiData['age'] = $age;
            $bmiData['saved'] = true;
            
            return [
                'success' => true,
                'message' => 'BMI kaydedildi!',
                'bmi_data' => $bmiData
            ];
            
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Kayıt başarısız.'];
        }
    }
    public function getUserBMIHistory($userId, $limit = 10) {
        $sql = "SELECT weight_kg, height_cm, bmi, measurement_date
                FROM user_measurements
                WHERE user_id = :user_id
                ORDER BY measurement_date DESC
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    public function getLatestBMI($userId) {
        $sql = "SELECT weight_kg, height_cm, bmi, measurement_date
                FROM user_measurements
                WHERE user_id = :user_id
                ORDER BY measurement_date DESC
                LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        
        return $stmt->fetch();
    }
}
?>