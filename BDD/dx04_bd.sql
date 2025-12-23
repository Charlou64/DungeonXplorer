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
  `email` VARCHAR(100) NOT NULL,
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
  `titre` text NOT NULL,
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
INSERT INTO Chapter (id, titre, content, image) VALUES
(1, "Introduction",

"Le ciel est lourd ce soir sur le village du Val Perdu, dissimulé entre les montagnes. La
petite taverne, dernier refuge avant l'immense forêt, est étrangement calme quand le
bourgmestre s’approche de vous. Homme d’apparence usée par les années et les soucis,
il vous adresse un regard désespéré.
« Ma fille… elle a disparu dans la forêt. Personne n’a osé la chercher… sauf vous, peut-
être ? On raconte qu’un sorcier vit dans un château en ruines, caché au cœur des bois.
Depuis des mois, des jeunes filles disparaissent… J'ai besoin de vous pour la retrouver. »
Vous sentez le poids de la mission qui s’annonce, et un frisson parcourt votre échine.
Bientôt, la forêt s'ouvre devant vous, sombre et menaçante. La quête commence.", '../images/chapter/scene-fantastique-en-3d.jpg'),
(2, "L'orée de la forêt","

Vous franchissez la lisière des arbres, la pénombre de la forêt avalant le sentier devant
vous. Un vent froid glisse entre les troncs, et le bruissement des feuilles ressemble à un
murmure menaçant. Deux chemins s’offrent à vous : l’un sinueux, bordé de vieux arbres
noueux ; l’autre droit mais envahi par des ronces épaisses.", '../images/chapter/ronce_foret.png'),
(3, "L'arbre aux corbeaux","

Votre choix vous mène devant un vieux chêne aux branches tordues, grouillant de
corbeaux noirs qui vous observent en silence. À vos pieds, des traces de pas légers,
probablement récents, mènent plus loin dans les bois. Soudain, un bruit de pas feutrés
se fait entendre. Vous ressentez la présence d’un prédateur.", '../images/chapter/arbre_corbeaux.png'),
(4, "Le sanglier enragé","

En progressant, le calme de la forêt est soudain brisé par un grognement. Surgissant des
buissons, un énorme sanglier, au pelage épais et aux yeux injectés de sang, se dirige vers
vous. Sa rage est palpable, et il semble prêt à en découdre. Le voici qui décide
brutalement de vous charger !", '../images/chapter/sanglier_combat.png'),
(5, "Rencontre avec le paysan","

Tandis que vous progressez, une voix humaine s’élève, interrompant le silence de la forêt.
Vous tombez sur un vieux paysan, accroupi près de champignons aux couleurs vives. Il
sursaute en vous voyant, puis se détend, vous souriant tristement.
« Vous devriez faire attention, étranger, murmure-t-il. La nuit, des cris terrifiants
retentissent depuis le cœur de la forêt… Des créatures rôdent. »", '../images/chapter/rencontre_paysan.png'),
(6, "Le loup noir","

À mesure que vous avancez, un bruissement attire votre attention. Une silhouette sombre
s’élance soudainement devant vous : un loup noir aux yeux perçants. Son poil est hérissé
et sa gueule laisse entrevoir des crocs acérés. Vous sentez son regard fixé sur vous, prêt
à bondir.
Le combat est inévitable »", '../images/chapter/loup_noir_combat.png'),
(7, "La clairière aux pierres anciennes","

Après votre rencontre, vous atteignez une clairière étrange, entourée de pierres dressées,
comme un ancien autel oublié par le temps. Une légère brume rampe au sol, et les
ombres des pierres semblent danser sous la lueur de la lune.", '../images/chapter/clairiere_pierre_ancienne.png'),
(8, "Les murmures du ruisseau","

Essoufflé mais déterminé, vous arrivez près d’un petit ruisseau qui serpente au milieu des
arbres. Le chant de l’eau vous apaise quelque peu, mais des murmures étranges
semblent émaner de la rive. Vous apercevez des inscriptions anciennes gravées dans une
pierre moussue.", '../images/chapter/ruisseau.png'),
(9, "Au pied du château","

La forêt se disperse enfin, et devant vous se dresse une colline escarpée. Au sommet, le
château en ruines projette une ombre menaçante sous le clair de lune. Les murs effrités
et les tours en partie effondrées ajoutent à la sinistre réputation du lieu.
Vous sentez que la véritable aventure commence ici, et que l’influence du sorcier n’est
peut-être pas qu’une légende…", '../images/chapter/pied_chateau.png'),
(10, "La lumière au bout du néant","

Le monde se dérobe sous vos pieds, et une obscurité profonde vous enveloppe, glaciale
et insondable. Vous ne sentez plus le poids de votre équipement, ni la morsure de la
douleur. Juste un vide infini, vous aspirant lentement dans les ténèbres.
Alors que vous perdez toute notion du temps, une lueur douce apparaît au loin, vacillante
comme une flamme fragile dans l’obscurité. Au fur et à mesure que vous approchez, vous
entendez une voix, faible mais bienveillante, qui murmure des mots oubliés, anciens.
« Brave âme, ton chemin n'est pas achevé... À ceux qui échouent, une seconde chance
est accordée. Mais les caprices du destin exigent un sacrifice. »
La lumière s'intensifie, et vous sentez vos forces revenir, mais vos poches sont vides, votre
sac allégé de tout trésor. Votre équipement, vos armes, tout a disparu, laissant place à
une sensation de vulnérabilité.
Lorsque la lumière vous enveloppe, vous ouvrez de nouveau les yeux, retrouvant la terre
ferme sous vos pieds. Vous êtes de retour, sans autre possession que votre volonté de
reprendre cette quête. Mais cette fois-ci, peut-être, saurez-vous éviter les pièges fatals
qui vous ont mené à votre perte.", '../images/chapter/lumiere_bout_neant.png'),
(11, "La curiosité tua le chat","

Qu’avez-vous fait, Malheureux !", '../images/chapter/game_over.png'),
(12, "Le Hall des Ombres",
"Vous poussez les lourdes portes en chêne qui gémissent sinistrement. Une odeur de poussière et de cire fondue vous prend à la gorge. Le hall d'entrée est immense, éclairé par des torches aux flammes bleues. Deux voies s'offrent à vous : un grand escalier montant vers les étages supérieurs, ou une porte dérobée descendant vers les sous-sols humides.",
'../images/chapter/castle_hall.jpg'),

(13, "Les Geôles Oubliées",
"Vous descendez dans les entrailles du château. L'air est glacial. Des cellules vides bordent le couloir, mais au fond, une ombre se dresse. C'est une armure animée, gardienne des lieux, qui rouille dans l'attente d'un intrus. Elle lève sa lourde épée en vous voyant !",
'../images/chapter/dungeon_armor.jpg'),

(14, "La Galerie des Glaces",
"En haut de l'escalier, vous traversez une galerie remplie de miroirs anciens. Votre reflet semble bouger avec un léger décalage. Soudain, les miroirs explosent et une créature spectrale en sort. C'est une illusion gardienne !",
'../images/chapter/mirror_hall.jpg'),

(15, "Le Laboratoire d'Alchimie",
"Après avoir survécu à la garde, vous arrivez dans une pièce remplie de fioles bouillonnantes et de livres interdits. Sur une table, une potion rougeoyante semble intacte au milieu du chaos. Au fond, une porte mène vers la plus haute tour.",
'../images/chapter/alchemy_lab.jpg'),

(16, "La Tour du Sorcier",
"Vous grimpez les dernières marches en colimaçon. Le vent hurle à l'extérieur. Vous débouchez au sommet, sous le ciel étoilé. Le Sorcier est là, dos à vous, incantant devant un autel où la jeune fille est endormie. Il se retourne, ses yeux brillant de malice. Le combat final commence !",
'../images/chapter/wizard_tower.jpg'),

(17, "Le Triomphe du Héros",
"Le sorcier s'effondre dans un nuage de fumée noire. Le charme est rompu. La jeune fille s'éveille, désorientée mais vivante. Le soleil commence à se lever sur le Val Perdu. Vous avez réussi là où tant d'autres ont échoué. Le retour au village sera glorieux.",
'../images/chapter/victory_sunrise.jpg'),

(18, "Un Piège Mortel",
"Vous tentez de manipuler les fioles sans connaissances alchimiques. Une vapeur verte s'échappe soudainement d'un mélange instable. Vos poumons brûlent, votre vision se trouble... C'était une erreur fatale.",
'../images/chapter/poison_trap.jpg'),

(19, "Le Passage Secret",
"En inspectant les murs humides des geôles, vous remarquez une pierre descellée. En appuyant dessus, un pan de mur pivote dans un grincement millénaire. Un courant d'air vicié, chargé d'odeurs de terre et d'encens, vous saute au visage. C'est un escalier en colimaçon qui s'enfonce bien plus bas que les fondations du château.",
'../images/chapter/secret_passage.jpg'),

(20, "L'Ossuaire",
"Vous débouchez dans une vaste salle circulaire dont les murs sont tapissés de milliers de crânes humains. Le sol est jonché d'ossements qui craquent sous vos bottes. Au centre, une lueur verdâtre émane d'un puits sans fond. Soudain, les os s'assemblent ! Une horde de squelettes se dresse pour protéger le repos des morts.",
'../images/chapter/ossuary_skeletons.jpg'),

(21, "La Crypte du Roi Déchu",
"Après avoir fracassé les gardiens d'os, vous pénétrez dans la chambre funéraire royale. Un sarcophage en obsidienne trône au centre. Devant lui, une silhouette encapuchonnée incante dans une langue oubliée. C'est le Nécromancien, le bras droit du Sorcier, qui tente de relever l'ancien Roi !",
'../images/chapter/necromancer_crypt.jpg'),

(22, "Le Trésor de la Lignée",
"Le Nécromancien gît au sol, vaincu. Le sarcophage s'ouvre légèrement, non pas pour libérer un mort, mais pour révéler ce qu'il protégeait : l'Épée de l'Aube, une lame radiant d'une lumière sacrée, seule capable de percer les barrières magiques du Sorcier sans effort.",
'../images/chapter/holy_sword.jpg'),

(23, "L'Éboulement",
"Le combat a fragilisé la structure de la crypte. Le plafond commence à s'effondrer ! D'énormes blocs de pierre tombent autour de vous. Il faut fuir immédiatement vers la surface ou finir enterré vivant avec les rois d'antan.",
'../images/chapter/cave_in.jpg');

INSERT INTO Links (id, chapter_id, next_chapter_id, description) VALUES
(1,1,2,

"Commencer la quête !"
),
(2,2,3,

"Emprunter le chemin sinueux..."
),
(3,2,4,

"Choisir le sentier couvert de ronces !!"
),
(4,3,5,

"Rester prudent..."
),
(5,3,6,

"Ignorer les bruits et de poursuivre sa route..."
),
(6,4,8,

"Vaincre le sanglier !!"
),
(7,4,10,

"Perdre contre le sanglier..."
),
(8,5,7,

"Tendre l'oreille..."
),
(9,6,7,

"Survivre au loup."
),
(10,6,10,

"Le loup vous terrasse..."
),
(11,7,8,

"Suivre le sentier couvert de mousse"
),
(12,7,9,

"Suivre le chemin tortueux à travers les racines"
),
(13,8,11,

"Toucher la pierre gravée..."
),
(14,8,9,

"Ignorer et poursuivez votre route..."
),
(15,10,1,

"Reprendre l’aventure depuis le début..."
),
(16,11,10,

"Oh non !!"
);

INSERT INTO Links (chapter_id, next_chapter_id, description) VALUES

-- --- CONNEXION CHATEAU (Depuis Chapitre 9) ---
(9, 12, "Pousser les portes et entrer dans le château."),

-- --- NAVIGATION DU CHATEAU (Chapitres 12-18) ---
(12, 13, "Descendre vers les sous-sols obscurs."),
(12, 14, "Monter le grand escalier vers la galerie."),
(13, 10, "L'armure vous écrase sous son poids..."),
(13, 15, "L'armure est en pièces, continuer vers le laboratoire."),
(13, 19, "Inspecter le mur du fond (Perception requise)."),
(14, 15, "Le spectre est dissipé, avancer vers le laboratoire."),
(14, 10, "Les éclats de verre ont eu raison de vous..."),
(15, 16, "Ignorer les potions et monter vers la tour finale."),
(15, 18, "Boire la potion rouge pour gagner des forces..."),
(16, 17, "Porter le coup fatal au Sorcier !"),
(16, 10, "La magie du Sorcier est trop puissante..."),
(17, 1, "Retourner au village (Nouvelle partie)."),
(18, 10, "Sombrer..."),

-- Progression dans les catacombes
(19, 20, "Descendre dans les profondeurs."),
(20, 21, "Affronter la horde et avancer vers la Crypte."),
(20, 23, "Fuir avant d'être submergé !"),
(21, 22, "Le Nécromancien est mort, piller le sarcophage."),
(21, 10, "Le sort de mort du Nécromancien vous atteint..."),

-- Sorties des catacombes
(22, 16, "Utiliser le téléporteur pour rejoindre la Tour du Sorcier."),
(23, 10, "Trop lent ! Les pierres vous écrasent."),
(23, 12, "Courir vers la sortie et rejoindre le Hall (Sans trésor).");

/*MONSTER*/
insert into Monster (id, name, pv, mana, initiative, strength, attack, xp) values
(1, 'Sanglier enragé', 30, NULL, 15, 5, 'Charge furieuse', 20),
(2, 'Loup noir', 25, NULL, 20, 7, 'Morsure rapide', 25),
(3,'Armure Maudite', 50, 0, 5, 20, 'Coup de taille', 50),
(4,'Spectre du Miroir', 40, 50, 18, 10, 'Hurlement psychique', 60),
(5,'Le Sorcier Noir', 80, 100, 12, 15, 'Éclair de néant', 500),
(6,'Horde de Squelettes', 45, 0, 10, 8, "Pluie d\'os", 80),
(7,'Le Nécromancien', 60, 80, 14, 10, 'Drain de vie', 150);

INSERT INTO Encounter (chapter_id, monster_id) VALUES
(4, 1),
(6, 2),
(13, 3), 
(14, 4), 
(16, 5), 
(20, (SELECT id FROM Monster WHERE name = 'Horde de Squelettes')),
(21, (SELECT id FROM Monster WHERE name = 'Le Nécromancien'));

/*CLASS*/
INSERT INTO `Class` (name,description,base_pv,base_mana,strength,initiative,max_items) VALUES
('Guerrier','Combat rapproché, très résistant',150,0,18,6,12),
('Voleur','Agile et rapide, forte initiative',100,10,12,14,10),
('Magicien','Spécialiste de la magie offensive',80,30,8,10,8);

-- Ajout de l'objet légendaire
INSERT INTO Items (name, description, item_type, category) VALUES
('Épée de l''Aube', 'Une lame sacrée qui brille dans les ténèbres. Efficace contre les sorciers.', 'Arme', 'Légendaire');

-- On lie l'objet au trésor (Chapitre 22 donne l'item ID correspondant)
-- Note : Il faudra vérifier l'ID de l'item généré, supposons ici que c'est le dernier ID créé.
INSERT INTO Chapter_Treasure (chapter_id, item_id, quantity) 
VALUES (22, (SELECT MAX(id) FROM Items), 1);

COMMIT;
