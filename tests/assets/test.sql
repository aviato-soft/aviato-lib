USE `avi-lib-test`;

CREATE TABLE IF NOT EXISTS `test` (
  `id` int NOT NULL AUTO_INCREMENT,
  `col_string` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `col_float` float DEFAULT NULL,
  `col_decimal` decimal(10,0) DEFAULT NULL,
  `col_bit` bit(1) DEFAULT NULL,
  `col_json` json DEFAULT NULL,
  `col_datetime` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=639 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;