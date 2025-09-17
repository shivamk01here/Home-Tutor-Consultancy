-- roles table
CREATE TABLE `roles` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert roles
INSERT INTO `roles` (`name`) VALUES
('admin'),
('tutor'),
('student');

-- users table
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `email_verified_at` TIMESTAMP NULL,
  `password` VARCHAR(255) NOT NULL,
  `role_id` BIGINT UNSIGNED NOT NULL,
  `is_verified` TINYINT(1) NOT NULL DEFAULT 0,
  `profile_photo_path` VARCHAR(2048) DEFAULT NULL,
  `remember_token` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Optional: Create a dummy admin user
INSERT INTO `users` (`name`, `email`, `password`, `role_id`, `is_verified`) VALUES
('Admin User', 'admin@tutor.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa', 1, 1);


-- tutor_profiles table
CREATE TABLE `tutor_profiles` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL UNIQUE,
  `bio` TEXT DEFAULT NULL,
  `qualification` VARCHAR(255) DEFAULT NULL,
  `experience_years` INT DEFAULT 0,
  `police_verification_status` ENUM('pending', 'verified', 'rejected') NOT NULL DEFAULT 'pending',
  `rating` DECIMAL(3, 2) DEFAULT 0.00,
  `location` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- subjects table
CREATE TABLE `subjects` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- tutor_subjects table (many-to-many relationship)
CREATE TABLE `tutor_subjects` (
  `tutor_id` BIGINT UNSIGNED NOT NULL,
  `subject_id` BIGINT UNSIGNED NOT NULL,
  `hourly_rate` DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (`tutor_id`, `subject_id`),
  FOREIGN KEY (`tutor_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`subject_id`) REFERENCES `subjects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- sessions table
CREATE TABLE `sessions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` BIGINT UNSIGNED NOT NULL,
  `tutor_id` BIGINT UNSIGNED NOT NULL,
  `subject_id` BIGINT UNSIGNED NOT NULL,
  `session_date` DATE NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `status` ENUM('scheduled', 'completed', 'canceled') NOT NULL DEFAULT 'scheduled',
  `tutor_notes` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`student_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`tutor_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`subject_id`) REFERENCES `subjects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- payments table
CREATE TABLE `payments` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `session_id` BIGINT UNSIGNED NOT NULL UNIQUE,
  `student_id` BIGINT UNSIGNED NOT NULL,
  `tutor_id` BIGINT UNSIGNED NOT NULL,
  `amount` DECIMAL(10, 2) NOT NULL,
  `status` ENUM('pending', 'paid', 'refunded') NOT NULL DEFAULT 'pending',
  `payment_method` VARCHAR(50) DEFAULT NULL,
  `transaction_id` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`session_id`) REFERENCES `sessions`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`student_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`tutor_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- reviews table
CREATE TABLE `reviews` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `session_id` BIGINT UNSIGNED NOT NULL UNIQUE,
  `student_id` BIGINT UNSIGNED NOT NULL,
  `tutor_id` BIGINT UNSIGNED NOT NULL,
  `rating` INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
  `comment` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`session_id`) REFERENCES `sessions`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`student_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`tutor_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- learning_resources table
CREATE TABLE `learning_resources` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tutor_id` BIGINT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`tutor_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `subjects` (`id`, `name`) VALUES
(1, 'Physics'),
(2, 'Chemistry'),
(3, 'Mathematics'),
(4, 'Biology'),
(5, 'Zoology'),
(6, 'Botany'),
(7, 'Organic Chemistry'),
(8, 'Inorganic Chemistry'),
(9, 'Physical Chemistry'),
(10, 'Thermodynamics'),
(11, 'Electromagnetism'),
(12, 'Mechanics'),
(13, 'Modern Physics'),
(14, 'Genetics'),
(15, 'Human Physiology');

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `password`, `is_verified`) VALUES
(2, 2, 'Rohan Sharma', 'rohan.sharma@tutor.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uhe.Pq2f4uW', 1),
(3, 2, 'Priya Singh', 'priya.singh@tutor.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uhe.Pq2f4uW', 1),
(4, 2, 'Akshay Kumar', 'akshay.kumar@tutor.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uhe.Pq2f4uW', 1),
(5, 2, 'Anjali Gupta', 'anjali.gupta@tutor.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uhe.Pq2f4uW', 1),
(6, 2, 'Sandeep Varma', 'sandeep.varma@tutor.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uhe.Pq2f4uW', 1),
(7, 2, 'Kavita Reddy', 'kavita.reddy@tutor.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uhe.Pq2f4uW', 0),
(8, 2, 'Nikhil Das', 'nikhil.das@tutor.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uhe.Pq2f4uW', 1),
(9, 2, 'Shweta Joshi', 'shweta.joshi@tutor.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uhe.Pq2f4uW', 1),
(10, 2, 'Vivek Mehra', 'vivek.mehra@tutor.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uhe.Pq2f4uW', 1),
(11, 2, 'Deepika Jain', 'deepika.jain@tutor.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uhe.Pq2f4uW', 0),
(12, 2, 'Arjun Pal', 'arjun.pal@tutor.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uhe.Pq2f4uW', 1),
(13, 2, 'Sana Khan', 'sana.khan@tutor.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uhe.Pq2f4uW', 1),
(14, 2, 'Manish Tiwari', 'manish.tiwari@tutor.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uhe.Pq2f4uW', 1),
(15, 2, 'Kirti Patel', 'kirti.patel@tutor.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uhe.Pq2f4uW', 1),
(16, 2, 'Vikram Seth', 'vikram.seth@tutor.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uhe.Pq2f4uW', 0);


INSERT INTO `tutor_profiles` (`user_id`, `qualification`, `experience_years`, `bio`, `rating`, `location`) VALUES
(2, 'M.Sc. Physics, IIT Delhi', 8, 'Expert in Classical and Modern Physics for JEE/NEET. Focus on conceptual clarity.', 4.8, 'New Delhi'),
(3, 'M.Sc. Organic Chemistry, University of Hyderabad', 6, 'Specializing in Organic Chemistry. Simplifying complex reactions and mechanisms.', 4.5, 'Hyderabad'),
(4, 'B.Tech Mechanical Engineering, IIT Bombay', 10, 'A passionate educator with a strong background in Mathematics and Mechanics.', 4.9, 'Mumbai'),
(5, 'M.Sc. Botany, JNU', 7, 'Specialized in Botany and plant biology. Making complex topics easy to understand.', 4.6, 'Bengaluru'),
(6, 'Ph.D. Chemistry, IISc Bangalore', 12, 'Highly experienced in all three branches of Chemistry. Known for building strong foundational skills.', 5.0, 'Bengaluru'),
(7, 'M.Sc. Physics, Delhi University', 3, 'Young and dynamic tutor. Passionate about teaching Electromagnetism.', 3.9, 'New Delhi'),
(8, 'M.Sc. Zoology, Mumbai University', 5, 'Dedicated to teaching Zoology and Human Physiology with clear diagrams and examples.', 4.7, 'Mumbai'),
(9, 'B.E. Computer Science, Anna University', 9, 'Expert in problem-solving techniques for JEE Mathematics.', 4.4, 'Chennai'),
(10, 'Ph.D. in Chemistry, IIT Kanpur', 15, 'A veteran tutor with a deep understanding of Physical Chemistry.', 4.9, 'Kanpur'),
(11, 'M.Sc. Biology, Amity University', 2, 'Beginner tutor, eager to help students with high school Biology concepts.', 4.0, 'Noida'),
(12, 'M.Sc. Mathematics, University of Delhi', 7, 'Focuses on building a strong logical foundation for JEE aspirants.', 4.5, 'New Delhi'),
(13, 'B.Tech Chemical Engineering, IIT Kharagpur', 6, 'Known for her engaging teaching style in Chemistry and Thermodynamics.', 4.8, 'Kolkata'),
(14, 'M.Sc. Physics, BITS Pilani', 10, 'Highly rated tutor for advanced Physics topics.', 4.9, 'Jaipur'),
(15, 'M.Sc. Botany, Pune University', 8, 'Experienced in teaching NEET Biology subjects.', 4.7, 'Pune'),
(16, 'M.Sc. Zoology, Panjab University', 4, 'New tutor specializing in Zoology and Genetics.', 4.2, 'Chandigarh');

INSERT INTO `subject_user` (`user_id`, `subject_id`, `hourly_rate`) VALUES
(2, 1, 800), (2, 11, 850), (2, 12, 800),
(3, 2, 750), (3, 7, 900), (3, 8, 800),
(4, 3, 900), (4, 12, 850),
(5, 4, 600), (5, 6, 650), (5, 14, 700),
(6, 2, 950), (6, 7, 950), (6, 8, 950), (6, 9, 950),
(7, 1, 500), (7, 11, 550), (7, 13, 600),
(8, 4, 650), (8, 5, 700), (8, 15, 700),
(9, 3, 800),
(10, 2, 850), (10, 9, 900),
(11, 4, 450), (11, 5, 450),
(12, 3, 750),
(13, 2, 700), (13, 10, 750),
(14, 1, 850), (14, 11, 900), (14, 13, 900),
(15, 4, 700), (15, 6, 750), (15, 14, 800),
(16, 5, 600), (16, 15, 650);


-- locations table
CREATE TABLE `locations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert 10 locations
INSERT INTO `locations` (`name`) VALUES
('Delhi'), ('Lucknow'), ('Noida'), ('Bangalore'), ('Agra'), ('Gurgaon'), ('Kanpur'), ('Roorkee'), ('Dehradun'), ('Pune');

-- student_profiles table
CREATE TABLE `student_profiles` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `parent_name` VARCHAR(255) NOT NULL,
  `parent_contact` VARCHAR(255) NOT NULL,
  `profile_photo_path` VARCHAR(255) NULL,
  `location_id` BIGINT UNSIGNED NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`location_id`) REFERENCES `locations`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- Add new fields to tutor_profiles table
ALTER TABLE `tutor_profiles`
ADD COLUMN `current_designation` VARCHAR(255) NULL AFTER `experience_years`,
ADD COLUMN `identity_proof_path` VARCHAR(255) NULL AFTER `current_designation`,
ADD COLUMN `packages` JSON NULL AFTER `identity_proof_path`;



-- student_subject pivot table
CREATE TABLE `student_subject` (
  `student_id` BIGINT UNSIGNED NOT NULL,
  `subject_id` BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (`student_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`subject_id`) REFERENCES `subjects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




-- topics table
CREATE TABLE `topics` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `subject_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`subject_id`) REFERENCES `subjects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- mock_tests table
CREATE TABLE `mock_tests` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `subject_id` BIGINT UNSIGNED NOT NULL,
  `topic_id` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`subject_id`) REFERENCES `subjects`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`topic_id`) REFERENCES `topics`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- questions table
CREATE TABLE `questions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `mock_test_id` BIGINT UNSIGNED NOT NULL,
  `question_text` TEXT NOT NULL,
  `option_a` TEXT NOT NULL,
  `option_b` TEXT NOT NULL,
  `option_c` TEXT NOT NULL,
  `option_d` TEXT NOT NULL,
  `option_e` TEXT NULL,
  `correct_answer` CHAR(1) NOT NULL, -- A, B, C, D, or E
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`mock_test_id`) REFERENCES `mock_tests`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Update tutor_profiles table
ALTER TABLE `tutor_profiles`
MODIFY COLUMN `packages` JSON NULL;


alter table topics add column updated_at timestamp;
alter table topics add column created_at timestamp;