-- --------------------------------------------------------
-- Хост:                         mysql-8.4.local
-- Версия сервера:               8.4.4 - MySQL Community Server - GPL
-- Операционная система:         Win64
-- HeidiSQL Версия:              12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Дамп данных таблицы testdb.post: ~0 rows (приблизительно)
INSERT INTO `post` (`id`, `text`, `autor_id`) VALUES
	(1, 'Первая запись на сайте1', 3),
	(2, 'Первая запись на сайте2', 3),
	(3, 'Первая запись на сайте3', 2),
	(4, 'Первая запись на сайте4', 4),
	(5, 'Первая запись на сайте5', 4),
	(6, 'Первая запись на сайте6', 4),
	(7, 'Первая запись на сайте7', 4),
	(8, 'Первая запись на сайте8', 1),
	(9, 'Первая запись на сайте9', 1),
	(10, 'Первая запись на сайте10', 4),
	(11, 'Первая запись на сайте11', 3),
	(12, 'Очередная запись', 1);

-- Дамп данных таблицы testdb.user: ~4 rows (приблизительно)
INSERT INTO `user` (`id`, `login`, `password`) VALUES
	(1, 'VJmecEhSWXj2IJ/qBzaXlA==', 'VJmecEhSWXj2IJ/qBzaXlA=='),
	(2, 'GW0LyppvPQGOaoCYhLbWzA==', 'GW0LyppvPQGOaoCYhLbWzA=='),
	(3, '81XXb5mO4o8VCkpUYDSMUQ==', '81XXb5mO4o8VCkpUYDSMUQ=='),
	(4, 'gYJ2zzWOectTZbVn8SQ69Q==', 'gYJ2zzWOectTZbVn8SQ69Q=='),
	(5, 'y2+euTzQOXo7SnbYMp5Y3Q==', '2mpxK6rtBsxNdEUqNG1SgA==');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
