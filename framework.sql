-- -------------------------------------------------------------
-- TablePlus 6.2.1(578)
--
-- https://tableplus.com/
--
-- Database: framework
-- Generation Time: 2025-02-05 16:14:42.8570
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `public_id` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_id` bigint NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `content` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `thumbnail_url` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `thumbnail_path` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `featured_image_url` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `featured_image_path` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `public_id` varchar(12) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT '0',
  `refresh_token` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_public_id` (`public_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `notes` (`id`, `public_id`, `title`, `user_id`, `description`, `content`, `thumbnail_url`, `thumbnail_path`, `featured_image_url`, `featured_image_path`, `created_at`, `updated_at`) VALUES
(1, 'lxx7aql955oh', 'Identity: The Root of all Conflict', 13, 'Identity is one mysterious subject of mind that is root of all forms of conflicts in the world.', 'Identity is one mysterious subject of mind that is root of all forms of conflicts in the world. \r\n\r\nThe mind is split into 4 major parts as per Hinduism\'s school of Yoga:\r\n\r\n1. Manas: This is memory vault.\r\n\r\n2. Buddhi: This is intellect.\r\n\r\n3. Ahamkar/Ahankar: This is Ego \'I\' (Identity) formed through Manas and defended by Buddhi.\r\n\r\n4. Chitta: Unsullied consciousness.', NULL, NULL, NULL, NULL, '2025-01-21 04:11:45', '2025-01-21 04:14:47'),
(4, 'x8tp8eheo9k3', 'asdasd', 13, 'asdasd', 'asdasd', NULL, NULL, NULL, NULL, '2025-01-24 15:38:35', '2025-01-24 15:38:35');

INSERT INTO `users` (`id`, `public_id`, `name`, `username`, `email`, `password`, `email_verified`, `refresh_token`, `created_at`, `updated_at`) VALUES
(13, 'lxx7aql955oh', 'Saurabh Srivastava', 'saurabhsrivastava', 'saurabhsri@geekyants.com', '$2y$12$1ENdym49gGiu038bBh4D2ums3PhbwCS.G166tte7ds9x4ZATg9zfi', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6InNhdXJhYmhzcml2YXN0YXZhIiwiZW1haWwiOiJzYXVyYWJoc3JpQGdlZWt5YW50cy5jb20iLCJuYW1lIjoiU2F1cmFiaCBTcml2YXN0YXZhIiwiaWF0IjoxNzM3NDEyMTM4LCJleHAiOjE3NDAwMDQxMzh9.JEGx0emPsDsdGv_xSOV-yEYTm2O3MNQhtS26uNjz67Q', '2025-01-21 03:58:58', '2025-01-21 03:58:58');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;