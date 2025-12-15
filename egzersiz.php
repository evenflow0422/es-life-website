<?php
require_once 'config.php';
class Exercise {
    private $db;
    public function __construct() {
        $this->db = getDB();
    }
    public function getAllMuscleGroups() {
        $sql = "SELECT * FROM muscle_groups ORDER BY group_name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getExercisesByGroup($groupId) {
        $sql = "SELECT e.*, mg.group_name 
                FROM exercises e
                JOIN muscle_groups mg ON e.group_id = mg.group_id
                WHERE e.group_id = :group_id
                ORDER BY e.difficulty, e.exercise_name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':group_id' => $groupId]);
        return $stmt->fetchAll();
    }
    public function getExercisesByDifficulty($difficulty) {
        $sql = "SELECT e.*, mg.group_name 
                FROM exercises e
                JOIN muscle_groups mg ON e.group_id = mg.group_id
                WHERE e.difficulty = :difficulty
                ORDER BY mg.group_name, e.exercise_name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':difficulty' => $difficulty]);
        return $stmt->fetchAll();
    }
    public function getAllExercises() {
        $sql = "SELECT e.*, mg.group_name 
                FROM exercises e
                JOIN muscle_groups mg ON e.group_id = mg.group_id
                ORDER BY mg.group_name, e.exercise_name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getExerciseDetails($exerciseId) {
        $sql = "SELECT e.*, mg.group_name 
                FROM exercises e
                JOIN muscle_groups mg ON e.group_id = mg.group_id
                WHERE e.exercise_id = :exercise_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':exercise_id' => $exerciseId]);
        return $stmt->fetch();
    }
    public function addWorkout($userId, $exerciseId, $sets, $reps, $notes = null) {
        try {
            $sql = "INSERT INTO user_workouts (user_id, exercise_id, workout_date, sets, reps, notes)
                    VALUES (:user_id, :exercise_id, :workout_date, :sets, :reps, :notes)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':user_id' => $userId,
                ':exercise_id' => $exerciseId,
                ':workout_date' => date('Y-m-d'),
                ':sets' => $sets,
                ':reps' => $reps,
                ':notes' => $notes
            ]);
            return ['success' => true, 'message' => 'Antrenman kaydedildi!'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Kayıt başarısız.'];
        }
    }
    public function getUserWorkouts($userId, $limit = 10) {
        $sql = "SELECT w.*, e.exercise_name, mg.group_name
                FROM user_workouts w
                JOIN exercises e ON w.exercise_id = e.exercise_id
                JOIN muscle_groups mg ON e.group_id = mg.group_id
                WHERE w.user_id = :user_id
                ORDER BY w.workout_date DESC, w.created_at DESC
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>