-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.27 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table todolist.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `project_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `description` text,
  `started_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table todolist.projects: ~8 rows (approximately)
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` (`project_id`, `title`, `company`, `description`, `started_date`, `due_date`, `created_at`, `updated_at`) VALUES
	(6, 'Web development', 'turbo boost team', 'ecommerce web app development and boosting', '2024-07-17', '2024-07-25', '2024-07-18 15:30:25', '2024-07-18 15:30:25'),
	(7, 'mobile app development', 'Zoom.us', 'new version update for existing app', '2024-07-18', '2024-08-10', '2024-07-18 15:31:45', '2024-07-18 15:31:45'),
	(8, 'Web Development', 'microsoft ', 'Blog for newly releasing events', '2024-07-20', '2024-07-21', '2024-07-18 16:11:33', '2024-07-18 16:11:33'),
	(9, 'Game Boosting', 'Dunia', 'Boost new game on TikTok', '2024-07-24', '2024-07-25', '2024-07-18 16:13:01', '2024-07-18 16:13:21'),
	(10, 'Game Development', 'Unity', 'Responsive Web 2D game ', '2024-08-12', '2024-08-29', '2024-07-18 16:16:46', '2024-07-18 16:16:46'),
	(11, 'Android App Development', 'Unity', 'Game selling ecommerce app', '2024-09-09', '2024-10-24', '2024-07-18 16:17:47', '2024-07-18 16:17:47'),
	(12, 'Video Editing', 'unity', 'Game video edit for web site', '2024-07-16', '2024-07-30', '2024-07-18 16:19:35', '2024-07-18 16:19:35'),
	(13, 'Mobile app development', 'Teasla', 'ecommerce app for sell cars and Soller panel ', '2024-07-27', '2024-08-31', '2024-07-19 04:47:52', '2024-07-19 04:49:34');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;

-- Dumping structure for table todolist.tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `task_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `estimated_time` varchar(45) DEFAULT NULL,
  `importance_status` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT 'pending',
  `due_date` date DEFAULT NULL,
  `users_user_id` int NOT NULL,
  `projects_project_id` int NOT NULL,
  PRIMARY KEY (`task_id`),
  KEY `fk_tasks_users1_idx` (`users_user_id`),
  KEY `fk_tasks_projects1_idx` (`projects_project_id`),
  CONSTRAINT `fk_tasks_projects1` FOREIGN KEY (`projects_project_id`) REFERENCES `projects` (`project_id`),
  CONSTRAINT `fk_tasks_users1` FOREIGN KEY (`users_user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table todolist.tasks: ~7 rows (approximately)
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` (`task_id`, `title`, `description`, `estimated_time`, `importance_status`, `status`, `due_date`, `users_user_id`, `projects_project_id`) VALUES
	(11, 'Ui/ Ux Design', 'make responsive design', '5h', 'High', 'finished', '2024-07-19', 3, 6),
	(12, 'front end development', 'using bootstrap 5 make design', '4h', 'High', 'finished', '2024-07-20', 1, 6),
	(13, 'back end Development', 'use Laravel as framework\r\nuse jquery', '8h', 'Medium', 'finished', '2024-07-24', 1, 6),
	(14, 'Hosting', 'use Hostinger shared Hosting ', '2h', 'Low', 'finished', '2024-07-30', 1, 6),
	(15, 'Project documentation', 'mobile app, company - Tesla, for sell cars and Soller panel', '4h', 'High', 'finished', '2024-07-27', 1, 13),
	(16, 'Ui/ Ux Design', 'responsive user friendly, e commerce', '5h', 'Medium', 'finished', '2024-07-28', 3, 13),
	(17, 'App Development', 'develop add ui according to ui design', '8h', 'Medium', 'finished', '2024-07-29', 4, 13);
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;

-- Dumping structure for table todolist.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `username` varchar(225) DEFAULT NULL,
  `role` varchar(45) DEFAULT 'User',
  `workload` varchar(45) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table todolist.users: ~5 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `email`, `password`, `username`, `role`, `workload`, `created_at`, `updated_at`) VALUES
	(1, 'suraweeraadikari@gmail.com', '123456', 'chama', 'User', '2', '2024-07-18 02:53:42', '2024-07-18 10:15:50'),
	(3, 'chamarawishwanath@gmail.com', '123456', 'ChamaraAdikari', 'User', '0', '2024-07-18 05:00:40', '2024-07-18 10:16:06'),
	(4, 'admin@gmail.com', 'chamara111', 'adhikar-ac20035', 'User', '0', '2024-07-18 09:36:49', '2024-07-18 16:20:05'),
	(6, 'mkx@turboboostteam.com', 'chamara111', '990500673V', 'Admin', '0', '2024-07-18 10:06:08', '2024-07-18 10:06:08'),
	(8, 'turboboostteam@gmail.com', 'chamara111', 'arunaAdikari', 'User', '0', '2024-07-19 04:58:04', '2024-07-19 04:58:15');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
