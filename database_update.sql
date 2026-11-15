-- ATHEN: database update for the new "View Book" feature  (run once in phpMyAdmin -> database athen_database -> SQL)
-- NOTE: the website also adds the new columns / table automatically the first time you save a card in the admin panel.
-- Running this file by hand is optional, EXCEPT the last line (DROP TABLE) which removes the old admin "Book" data.

-- 1) new optional text fields + extra photos for the View Book
ALTER TABLE `cards`
  ADD COLUMN `heading` varchar(200) DEFAULT NULL,
  ADD COLUMN `subtitle` varchar(255) DEFAULT NULL,
  ADD COLUMN `content` text DEFAULT NULL;

CREATE TABLE IF NOT EXISTS `card_images` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `card_id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_no` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `card_id` (`card_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2) REMOVE the old admin "Book" table (no longer used anywhere in the project)
DROP TABLE IF EXISTS `booklet_pages`;
