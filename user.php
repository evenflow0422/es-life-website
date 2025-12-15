<?php
require_once 'config.php';
class User {
    private $db;
    public function __construct() {
        $this->db = getDB();
    }
    public function register($data) {
        if (empty($data['first_name']) || empty($data['last_name'])) {
            return ['success' => false, 'message' => 'Ad ve soyad gerekli.'];
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Geçerli bir e-posta girin.'];
        }
        if (empty($data['password']) || strlen($data['password']) < 6) {
            return ['success' => false, 'message' => 'Şifre en az 6 karakter olmalı.'];
        }
        if ($data['password'] !== $data['confirm_password']) {
            return ['success' => false, 'message' => 'Şifreler eşleşmiyor.'];
        }
        $checkSql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->execute([':email' => $data['email']]);
        if ($checkStmt->fetchColumn() > 0) {
            return ['success' => false, 'message' => 'Bu e-posta zaten kullanılıyor.'];
        }
        try {
            $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (first_name, last_name, email, password_hash, birth_date, gender) 
                    VALUES (:first_name, :last_name, :email, :password_hash, :birth_date, :gender)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':first_name' => $data['first_name'],
                ':last_name' => $data['last_name'],
                ':email' => $data['email'],
                ':password_hash' => $passwordHash,
                ':birth_date' => $data['birth_date'],
                ':gender' => $data['gender']
            ]);
            return [
                'success' => true,
                'message' => 'Kayıt başarılı!',
                'user_id' => $this->db->lastInsertId()
            ];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Bir hata oluştu: ' . $e->getMessage()];
        }
    }
    public function login($email, $password) {
        try {
            $sql = "SELECT user_id, first_name, last_name, email, password_hash 
                    FROM users 
                    WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();
            if (!$user) {
                return ['success' => false, 'message' => 'E-posta veya şifre hatalı.'];
            }
            if (!password_verify($password, $user['password_hash'])) {
                return ['success' => false, 'message' => 'E-posta veya şifre hatalı.'];
            }
            unset($user['password_hash']);
            return [
                'success' => true,
                'message' => 'Giriş başarılı!',
                'user' => $user
            ];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Bir hata oluştu.'];
        }
    }
    public function getUserInfo($userId) {
        $sql = "SELECT user_id, first_name, last_name, email, birth_date, gender 
                FROM users 
                WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetch();
    }
    public static function logout() {
        session_start();
        session_destroy();
        header('Location: login.php?logout=1');
        exit();
    }
}
?>