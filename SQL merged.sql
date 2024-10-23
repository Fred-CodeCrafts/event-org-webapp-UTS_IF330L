--@block
CREATE TABLE `event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_akhir` time NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `status_toogle` tinyint(4) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--@block
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--@block
CREATE TABLE `event_participants` (
  `participant_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`participant_id`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `event_participants_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `event_participants_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`)
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
