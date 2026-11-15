-- OPTIONAL: the site creates this table automatically the first time admin/book.php or the home page opens.
-- Run it in phpMyAdmin (database athen_database) only if you prefer to create it by hand.
CREATE TABLE IF NOT EXISTS `booklet_pages` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL,
  `sort_no` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `image_back` varchar(255) DEFAULT NULL,
  `heading` varchar(200) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
