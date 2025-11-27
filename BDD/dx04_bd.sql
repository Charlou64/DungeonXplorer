-- Cleaned / corrected SQL dump for dx04_bd
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- DROP existing (useful for re-import during dev)
DROP TABLE IF EXISTS `Hero_XP_History`;
DROP TABLE IF EXISTS `Hero_Spells`;
DROP TABLE IF EXISTS `Quests`;
DROP TABLE IF EXISTS `Monster_Loot`;
DROP TABLE IF EXISTS `Monster`;
DROP TABLE IF EXISTS `Links`;
DROP TABLE IF EXISTS `Inventory`;
DROP TABLE IF EXISTS `Hero_Progress`;
DROP TABLE IF EXISTS `Hero`;
DROP TABLE IF EXISTS `Spells`;
DROP TABLE IF EXISTS `Level`;
DROP TABLE IF EXISTS `Items`;
DROP TABLE IF EXISTS `Chapter_Monster_Encounter`;
DROP TABLE IF EXISTS `Encounter`;
DROP TABLE IF EXISTS `Chapter_Treasure`;
DROP TABLE IF EXISTS `Chapter`;
DROP TABLE IF EXISTS `Class`;
DROP TABLE IF EXISTS `Chapter_Treasure`;
DROP TABLE IF EXISTS `Users`;

-- Users (accounts)
CREATE TABLE `Users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Items
CREATE TABLE `Items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `item_type` varchar(50) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Chapter
CREATE TABLE `Chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Class
CREATE TABLE `Class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `base_pv` int(11) NOT NULL DEFAULT 0,
  `base_mana` int(11) NOT NULL DEFAULT 0,
  `strength` int(11) NOT NULL DEFAULT 0,
  `initiative` int(11) NOT NULL DEFAULT 0,
  `max_items` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Monster
CREATE TABLE `Monster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `pv` int(11) NOT NULL,
  `mana` int(11) DEFAULT NULL,
  `initiative` int(11) NOT NULL,
  `strength` int(11) NOT NULL,
  `attack` text DEFAULT NULL,
  `xp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Spells
CREATE TABLE `Spells` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `mana_cost` int(11) NOT NULL,
  `damage` int(11) DEFAULT NULL,
  `heal` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Hero
CREATE TABLE `Hero` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `compte_id` int(11) DEFAULT NULL,         -- liaison vers Users (compte)
  `class_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `biography` text DEFAULT NULL,
  `pv` int(11) NOT NULL DEFAULT 0,
  `mana` int(11) NOT NULL DEFAULT 0,
  `strength` int(11) NOT NULL DEFAULT 0,
  `initiative` int(11) NOT NULL DEFAULT 0,
  `armor_item_id` int(11) DEFAULT NULL,
  `primary_weapon_item_id` int(11) DEFAULT NULL,
  `secondary_weapon_item_id` int(11) DEFAULT NULL,
  `shield_item_id` int(11) DEFAULT NULL,
  `spell_list` text DEFAULT NULL,
  `xp` int(11) NOT NULL DEFAULT 0,
  `current_level` int(11) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`),
  KEY `armor_item_id` (`armor_item_id`),
  KEY `primary_weapon_item_id` (`primary_weapon_item_id`),
  KEY `secondary_weapon_item_id` (`secondary_weapon_item_id`),
  KEY `shield_item_id` (`shield_item_id`),
  KEY `compte_id` (`compte_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Level
CREATE TABLE `Level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `required_xp` int(11) NOT NULL,
  `pv_bonus` int(11) NOT NULL,
  `mana_bonus` int(11) NOT NULL,
  `strength_bonus` int(11) NOT NULL,
  `initiative_bonus` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Chapter_Treasure
CREATE TABLE `Chapter_Treasure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chapter_item_unique` (`chapter_id`,`item_id`),
  KEY `item_id` (`item_id`),
  KEY `chapter_id` (`chapter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Chapter_Monster_Encounter
CREATE TABLE `Chapter_Monster_Encounter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_id` int(11) NOT NULL,
  `monster_id` int(11) NOT NULL,
  `encounter_rate` decimal(5,2) DEFAULT 1.00,
  PRIMARY KEY (`id`),
  KEY `chapter_id` (`chapter_id`),
  KEY `monster_id` (`monster_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Encounter
CREATE TABLE `Encounter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_id` int(11) DEFAULT NULL,
  `monster_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chapter_id` (`chapter_id`),
  KEY `monster_id` (`monster_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inventory
CREATE TABLE `Inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hero_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hero_item_unique` (`hero_id`,`item_id`),
  KEY `item_id` (`item_id`),
  KEY `hero_id` (`hero_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Links (chapter graph)
CREATE TABLE `Links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_id` int(11) DEFAULT NULL,
  `next_chapter_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chapter_id` (`chapter_id`),
  KEY `next_chapter_id` (`next_chapter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Monster_Loot
CREATE TABLE `Monster_Loot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monster_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `drop_rate` decimal(5,2) DEFAULT 1.00,
  PRIMARY KEY (`id`),
  UNIQUE KEY `monster_item_unique` (`monster_id`,`item_id`),
  KEY `item_id` (`item_id`),
  KEY `monster_id` (`monster_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Hero_Progress
CREATE TABLE `Hero_Progress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hero_id` int(11) NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'Completed',
  `completion_date` datetime DEFAULT NULL,
  `objective` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hero_id` (`hero_id`),
  KEY `chapter_id` (`chapter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Quests
CREATE TABLE `Quests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(50) DEFAULT 'in_progress',
  `hero_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hero_id` (`hero_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Hero_Spells
CREATE TABLE `Hero_Spells` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hero_id` int(11) NOT NULL,
  `spell_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hero_id` (`hero_id`),
  KEY `spell_id` (`spell_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Hero_XP_History
CREATE TABLE `Hero_XP_History` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hero_id` int(11) NOT NULL,
  `xp_gained` int(11) NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hero_id` (`hero_id`),
  KEY `chapter_id` (`chapter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add foreign keys (after tables created to ensure order)
ALTER TABLE `Hero`
  ADD CONSTRAINT `Hero_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `Class` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Hero_ibfk_2` FOREIGN KEY (`armor_item_id`) REFERENCES `Items` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Hero_ibfk_3` FOREIGN KEY (`primary_weapon_item_id`) REFERENCES `Items` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Hero_ibfk_4` FOREIGN KEY (`secondary_weapon_item_id`) REFERENCES `Items` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Hero_ibfk_5` FOREIGN KEY (`shield_item_id`) REFERENCES `Items` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Hero_fk_compte` FOREIGN KEY (`compte_id`) REFERENCES `Users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `Level`
  ADD CONSTRAINT `Level_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `Class` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `Chapter_Treasure`
  ADD CONSTRAINT `Chapter_Treasure_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `Chapter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Chapter_Treasure_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `Items` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `Chapter_Monster_Encounter`
  ADD CONSTRAINT `Chapter_Monster_Encounter_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `Chapter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Chapter_Monster_Encounter_ibfk_2` FOREIGN KEY (`monster_id`) REFERENCES `Monster` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Encounter`
  ADD CONSTRAINT `Encounter_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `Chapter` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Encounter_ibfk_2` FOREIGN KEY (`monster_id`) REFERENCES `Monster` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `Inventory`
  ADD CONSTRAINT `Inventory_ibfk_1` FOREIGN KEY (`hero_id`) REFERENCES `Hero` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Inventory_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `Items` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `Links`
  ADD CONSTRAINT `Links_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `Chapter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Links_ibfk_2` FOREIGN KEY (`next_chapter_id`) REFERENCES `Chapter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Monster_Loot`
  ADD CONSTRAINT `Monster_Loot_ibfk_1` FOREIGN KEY (`monster_id`) REFERENCES `Monster` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Monster_Loot_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `Items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Hero_Progress`
  ADD CONSTRAINT `Hero_Progress_ibfk_1` FOREIGN KEY (`hero_id`) REFERENCES `Hero` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Hero_Progress_ibfk_2` FOREIGN KEY (`chapter_id`) REFERENCES `Chapter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Quests`
  ADD CONSTRAINT `Quests_ibfk_1` FOREIGN KEY (`hero_id`) REFERENCES `Hero` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Hero_Spells`
  ADD CONSTRAINT `Hero_Spells_ibfk_1` FOREIGN KEY (`hero_id`) REFERENCES `Hero` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Hero_Spells_ibfk_2` FOREIGN KEY (`spell_id`) REFERENCES `Spells` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Hero_XP_History`
  ADD CONSTRAINT `Hero_XP_History_ibfk_1` FOREIGN KEY (`hero_id`) REFERENCES `Hero` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Hero_XP_History_ibfk_2` FOREIGN KEY (`chapter_id`) REFERENCES `Chapter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


-- Example inserts for chapters
INSERT INTO Chapter (id, content, image) VALUES
(1, 'La Forêt Enchantée

Vous vous trouvez dans une forêt sombre et enchantée. Deux chemins se présentent à vous.', 'images/forêt.jpg'),
(2, 'Le Lac Mystérieux

Vous arrivez à un lac aux eaux limpides. Une créature vous observe.', 'images/lac.jpg');

COMMIT;
