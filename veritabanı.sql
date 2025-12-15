CREATE DATABASE IF NOT EXISTS esfit_db CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci;
USE esfit_db;

CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    birth_date DATE NOT NULL,
    gender ENUM('erkek', 'kadin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

CREATE TABLE user_measurements (
    measurement_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    weight_kg DECIMAL(5,2) NOT NULL,
    height_cm DECIMAL(5,2) NOT NULL,
    bmi DECIMAL(4,2) GENERATED ALWAYS AS (weight_kg / POWER(height_cm/100, 2)) STORED,
    measurement_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

CREATE TABLE muscle_groups (
    group_id INT PRIMARY KEY AUTO_INCREMENT,
    group_name VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

CREATE TABLE exercises (
    exercise_id INT PRIMARY KEY AUTO_INCREMENT,
    exercise_name VARCHAR(100) NOT NULL,
    group_id INT NOT NULL,
    difficulty ENUM('baslangic', 'orta', 'ileri') NOT NULL,
    description TEXT NOT NULL,
    FOREIGN KEY (group_id) REFERENCES muscle_groups(group_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

CREATE TABLE user_workouts (
    workout_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    exercise_id INT NOT NULL,
    workout_date DATE NOT NULL,
    sets INT NOT NULL,
    reps INT NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (exercise_id) REFERENCES exercises(exercise_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO muscle_groups (group_name) VALUES
('Göğüs'),
('Sırt'),
('Omuz'),
('Biceps'),
('Triceps'),
('Karın'),
('Bacak'),
('Kalça');

INSERT INTO exercises (exercise_name, group_id, difficulty, description) VALUES
('Şınav', 1, 'baslangic', 'Temel göğüs egzersizi, vücut ağırlığı ile yapılır.'),
('Bench Press', 1, 'orta', 'Barbell ile göğüs çalışması.'),
('Dumbbell Press', 1, 'orta', 'Dumbbell ile göğüs geliştirme.'),
('Dips', 1, 'ileri', 'Göğüs ve triceps için ileri seviye egzersiz.');

INSERT INTO exercises (exercise_name, group_id, difficulty, description) VALUES
('Barfix', 2, 'ileri', 'Sırt genişletmek için en iyi egzersiz.'),
('Lat Pulldown', 2, 'baslangic', 'Barfixa alternatif makine egzersizi.'),
('Bent Over Row', 2, 'orta', 'Barbell ile sırt kalınlığı çalışması.'),
('Dead Lift', 2, 'ileri', 'Tüm vücut egzersizi, özellikle sırt ve bacak.');

INSERT INTO exercises (exercise_name, group_id, difficulty, description) VALUES
('Shoulder Press', 3, 'orta', 'Dumbbell veya barbell ile omuz presi.'),
('Lateral Raise', 3, 'baslangic', 'Yan omuz geliştirme egzersizi.'),
('Front Raise', 3, 'baslangic', 'Ön omuz çalışması.');

INSERT INTO exercises (exercise_name, group_id, difficulty, description) VALUES
('Barbell Curl', 4, 'baslangic', 'Temel biceps egzersizi.'),
('Dumbbell Curl', 4, 'baslangic', 'Dumbbell ile biceps çalışması.'),
('Hammer Curl', 4, 'orta', 'Ön kol ve biceps egzersizi.');

INSERT INTO exercises (exercise_name, group_id, difficulty, description) VALUES
('Triceps Dips', 5, 'orta', 'Triceps için temel egzersiz.'),
('Triceps Pushdown', 5, 'baslangic', 'Kablo makinesi ile triceps çalışması.'),
('Close Grip Press', 5, 'orta', 'Dar tutuşla bench press.');

INSERT INTO exercises (exercise_name, group_id, difficulty, description) VALUES
('Mekik', 6, 'baslangic', 'Temel karın egzersizi.'),
('Plank', 6, 'baslangic', 'Core stabilizasyonu için plank.'),
('Leg Raise', 6, 'orta', 'Alt karın egzersizi.'),
('Russian Twist', 6, 'orta', 'Yan karın çalışması.');

INSERT INTO exercises (exercise_name, group_id, difficulty, description) VALUES
('Squat', 7, 'orta', 'Bacak kütlesi için en iyi egzersiz.'),
('Leg Press', 7, 'baslangic', 'Makine ile bacak çalışması.'),
('Lunge', 7, 'baslangic', 'Tek bacak egzersizi.'),
('Leg Curl', 7, 'baslangic', 'Arka bacak kasları.');

INSERT INTO exercises (exercise_name, group_id, difficulty, description) VALUES
('Hip Thrust', 8, 'orta', 'Kalça kütlesi geliştirme.'),
('Glute Bridge', 8, 'baslangic', 'Basit kalça egzersizi.');

CREATE INDEX idx_user_email ON users(email);
CREATE INDEX idx_measurement_date ON user_measurements(user_id, measurement_date);
CREATE INDEX idx_workout_date ON user_workouts(user_id, workout_date);
CREATE INDEX idx_exercise_group ON exercises(group_id);
