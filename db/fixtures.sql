/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE IF NOT EXISTS `db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci */;
USE `db`;

CREATE TABLE IF NOT EXISTS `disputes`
(
    `id`           int(10) unsigned NOT NULL AUTO_INCREMENT,
    `case_number`  varchar(50)      NOT NULL,
    `locked_until` timestamp        NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `u_case_number` (`case_number`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `dispute_responses`
(
    `id`         int(10) unsigned NOT NULL AUTO_INCREMENT,
    `dispute_id` int(10) unsigned NOT NULL,
    `message`    varchar(50)      NOT NULL DEFAULT '',
    PRIMARY KEY (`id`),
    KEY `ix_dispute_id` (`dispute_id`),
    CONSTRAINT `fk_dispute_responses_dispute_id` FOREIGN KEY (`dispute_id`) REFERENCES `disputes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

/*!40101 SET SQL_MODE = IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS = IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
