--@block
CREATE TABLE `event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `capacity` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `image` varchar(100) NOT NULL,
  `status_toogle` tinyint(4) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--@block
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--@block
CREATE TABLE `event_participants` (
  `participant_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`participant_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--@block
CREATE USER 'event_user'@'localhost' IDENTIFIED BY 'password123';
-- Grant privileges to the user
GRANT SELECT, INSERT, UPDATE, DELETE ON event_management.* TO 'event_user'@'localhost';
-- To apply the changes
FLUSH PRIVILEGES;

--@block
ALTER TABLE `user`
ADD COLUMN `first_name` varchar(50) NOT NULL AFTER `email`,
ADD COLUMN `last_name` varchar(50) NOT NULL AFTER `first_name`,
ADD COLUMN `gender` varchar(10) DEFAULT NULL AFTER `last_name`,
ADD COLUMN `headline` varchar(100) DEFAULT NULL AFTER `gender`,
ADD COLUMN `bio` varchar(255) DEFAULT NULL AFTER `headline`;


--@block
ALTER TABLE `user`
ADD COLUMN `profile_image` varchar(255) DEFAULT NULL AFTER `bio`;
--@block
ALTER TABLE `user`
ADD COLUMN `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
--@block
ALTER TABLE `user`
ADD COLUMN `last_login_at` DATETIME DEFAULT NULL AFTER `email`;
