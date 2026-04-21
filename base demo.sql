-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 21 avr. 2026 à 14:28
-- Version du serveur : 11.4.10-MariaDB
-- Version de PHP : 8.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tima6358_zadig-Mouquet-projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `beaches`
--

CREATE TABLE `beaches` (
  `id_station` int(11) NOT NULL,
  `latitude` decimal(9,6) NOT NULL,
  `longitude` decimal(9,6) NOT NULL,
  `label` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `id_region` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `beaches`
--

INSERT INTO `beaches` (`id_station`, `latitude`, `longitude`, `label`, `description`, `id_region`) VALUES
(1, 47.627820, -2.777826, 'Plage de Conleau', 'Située sur la presqu’île de Conleau à Vannes, la plage de Conleau est une petite plage familiale appréciée pour ses eaux calmes et peu profondes. Protégée des vagues du Golfe du Morbihan, elle est idéale pour la baignade, notamment avec des enfants. Facile d’accès et entourée de sentiers et de restaurants, elle offre un cadre agréable pour une sortie détente au bord de l’eau.', 1),
(12, 48.656747, -2.008688, 'Plage du Sillon', 'Grande plage emblématique de Saint-Malo', 1),
(13, 49.707738, 0.200731, 'Plage d\'Etretat', 'Falaises spectaculaires et galets', 2),
(14, 49.356606, 0.059009, 'Plage de Deauville', 'Plage chic avec ses célèbres parasols', 2),
(15, 43.474898, -1.568821, 'Plage de la Côte des Basques', 'Spot de surf réputé à Biarritz', 3),
(16, 44.662412, -1.157718, 'Plage d\'Arcachon', 'Plage calme avec vue sur la dune du Pilat', 3),
(17, 43.541209, 3.968288, 'Plage de Palavas-les-Flots', 'Plage méditerranéenne populaire', 4),
(18, 42.673606, 3.031923, 'Plage de Collioure', 'Plage pittoresque avec eau claire', 4),
(19, 42.552469, 3.048502, 'Plage de Nice', 'Plage urbaine célèbre de la Côte d’Azur', 5),
(20, 43.228178, 6.662299, 'Plage de Pampelonne', 'Plage mythique près de Saint-Tropez', 5);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id_comment` int(11) NOT NULL,
  `content` text NOT NULL,
  `date_` date NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `id_station` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id_comment`, `content`, `date_`, `is_deleted`, `id_station`, `id_user`) VALUES
(1, 'Super plage, très agréable !', '2024-04-01', 0, 1, 5),
(2, 'Beaucoup de monde mais belle vue', '2024-04-02', 0, 12, 10),
(3, 'Parfait pour surfer', '2024-04-03', 0, 15, 5),
(4, 'Un peu trop de galets', '2024-04-04', 0, 13, 4),
(5, 'Très touristique mais sympa', '2024-04-05', 1, 19, 9),
(36, 'Très belle plage, eau propre et sable fin. Je recommande 👍', '2026-04-01', 0, 1, 7),
(37, 'Endroit agréable mais un peu trop de monde en été.', '2026-04-02', 0, 1, 6),
(38, 'Super pour une sortie en famille, les enfants ont adoré.', '2026-04-03', 0, 1, 9),
(39, 'Plage bien entretenue, mais les parkings sont vite pleins.', '2026-04-03', 0, 12, 7),
(40, 'Magnifique au coucher du soleil, vraiment paisible.', '2026-04-04', 0, 12, 4),
(41, 'Correct dans l’ensemble, mais les restaurants autour sont un peu chers.', '2026-04-04', 0, 13, 6),
(42, 'Très bon spot pour se détendre, peu de vagues.', '2026-04-05', 0, 13, 8),
(43, 'J’ai trouvé l’eau un peu froide même en avril.', '2026-04-05', 0, 14, 9),
(44, 'Plage propre et facile d’accès, parfait pour une journée tranquille.', '2026-04-06', 0, 15, 10),
(45, 'Beaucoup de vent ce jour-là, mais ça reste un bel endroit.', '2026-04-06', 0, 15, 10),
(46, 'Ambiance sympa, mais manque un peu d’ombre.', '2026-04-07', 0, 16, 5),
(47, 'Super balade le long de la plage, très agréable.', '2026-04-07', 0, 17, 8),
(48, 'Pas mal du tout, mais attention aux algues selon les jours.', '2026-04-08', 0, 18, 7),
(49, 'Parfait pour faire du paddle ou se relaxer.', '2026-04-08', 0, 19, 4),
(50, 'Je reviendrai sûrement, très bonne expérience globale.', '2026-04-09', 0, 20, 6),
(54, 'J&#039;adore cette plage !', '2026-04-16', 0, 1, 13),
(56, 'test', '2026-04-16', 1, 1, 13);

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

CREATE TABLE `media` (
  `id_media` int(11) NOT NULL,
  `path` varchar(50) NOT NULL,
  `MIME_type` varchar(50) NOT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `legend` varchar(255) DEFAULT NULL,
  `id_region` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`id_media`, `path`, `MIME_type`, `alt`, `legend`, `id_region`) VALUES
(2, 'beach1.webp', 'image/webp', 'plage de conleau', 'La plage de Conleau', 1),
(3, 'conleau2.webp', 'image/webp', 'Plage de conleau', 'Plage de conleau', 1),
(4, 'bretagne1.webp', 'image/webp', 'Plage Bretagne', 'Vue côtière bretonne', 1),
(5, 'normandie1.webp', 'image/webp', 'Falaises Normandie', 'Falaises d\'Etretat', 2),
(6, 'aquitaine1.webp', 'image/webp', 'Surf Biarritz', 'Vagues parfaites', 3),
(7, 'occitanie1.webp', 'image/webp', 'Plage Occitanie', 'Mer Méditerranée calme', 4),
(8, 'paca1.webp', 'image/webp', 'Nice plage', 'Promenade des Anglais', 5),
(9, 'sunset', 'video/', 'Coucher de soleil', 'Coucher de soleil', 1),
(18, '69e24426dd175.jpg', 'image/jpeg', NULL, NULL, 2),
(19, '69e24475090e7.jpg', 'image/jpeg', NULL, NULL, 4),
(20, '69e2449aae432.jpg', 'image/jpeg', NULL, NULL, 1),
(21, '69e244bd0993e.jpg', 'image/jpeg', NULL, NULL, 3),
(22, '69e244f0781fa.jpg', 'image/jpeg', NULL, NULL, 3),
(23, '69e68f2eac172.jpg', 'image/jpeg', NULL, NULL, 1),
(24, '69e6907965668.jpg', 'image/jpeg', NULL, NULL, 5);

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE `news` (
  `id_news` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date_` date NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) NOT NULL,
  `id_thumbnail` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `news`
--

INSERT INTO `news` (`id_news`, `title`, `content`, `date_`, `id_user`, `id_thumbnail`) VALUES
(1, 'Ouverture de la saison estivale', 'Les plages sont prêtes pour accueillir les visiteurs.', '2024-05-01', 4, 2),
(2, 'Article 1', 'blabla', '2026-04-07', 1, 2),
(3, 'Article 2', 'blabla bla', '2026-04-07', 1, 3),
(4, 'Conditions idéales pour le surf', 'Les vagues sont exceptionnelles cette semaine.', '2024-05-02', 4, 3),
(5, 'Nouveau château de sable', 'Nouvelle technique découverte pour la construction de château de sable.', '2026-04-10', 4, 2),
(10, 'Normandie : les falaises et plages sous surveillance constante', '<h2>Un littoral fragile</h2>\r\n<p>Les plages de Normandie, bordées de falaises de craie, sont soumises à une érosion naturelle constante. Ce phénomène façonne le paysage mais représente également un risque pour les visiteurs.</p>\r\n\r\n<h2>Des mesures de sécurité renforcées</h2>\r\n<p>Des zones sont régulièrement interdites d’accès afin de prévenir les accidents liés aux chutes de blocs rocheux. Les autorités rappellent l’importance de respecter les consignes de sécurité.</p>\r\n\r\n<h2>Un attrait touristique intact</h2>\r\n<p>Malgré ces contraintes, la région continue de séduire grâce à ses panoramas spectaculaires et à la richesse de son patrimoine naturel.</p>', '2026-04-17', 12, 18),
(11, 'Méditerranée : des plages toujours plus prisées en période estivale', '<h2>Une destination incontournable</h2>\r\n<p>Les plages du sud de la France restent parmi les destinations les plus populaires en été. Le climat ensoleillé et la mer calme attirent chaque année des millions de touristes.</p>\r\n\r\n<h2>Des défis environnementaux</h2>\r\n<p>L’augmentation de la fréquentation pose des défis en matière de gestion des déchets et de protection de la biodiversité. Certaines communes mettent en place des mesures pour limiter l’impact humain.</p>\r\n\r\n<h2>Vers un tourisme plus responsable</h2>\r\n<p>De plus en plus d’initiatives encouragent les visiteurs à adopter des comportements respectueux de l’environnement, afin de préserver ces espaces naturels.</p>', '2026-04-17', 12, 19),
(12, 'Bretagne : entre marées et paysages sauvages', '<h2>Des plages au rythme des marées</h2>\r\n<p>En Bretagne, les plages se transforment au fil des marées, offrant des paysages variés tout au long de la journée. Ce phénomène attire les amateurs de nature et de photographie.</p>\r\n\r\n<h2>Un littoral préservé</h2>\r\n<p>De nombreuses zones sont protégées afin de conserver la biodiversité locale. Les visiteurs sont invités à respecter les espaces naturels et à limiter leur impact.</p>\r\n\r\n<h2>Une destination authentique</h2>\r\n<p>La Bretagne séduit par son caractère sauvage et ses plages moins urbanisées, offrant une alternative aux destinations plus fréquentées.</p>', '2026-04-17', 12, 20),
(13, 'Atlantique : la montée des eaux au cœur des préoccupations', '<h2>Un phénomène en progression</h2>\r\n<p>Les côtes atlantiques sont de plus en plus concernées par la montée du niveau de la mer. Certaines plages voient leur surface diminuer au fil des années.</p>\r\n\r\n<h2>Des adaptations nécessaires</h2>\r\n<p>Les collectivités locales mettent en place des stratégies pour faire face à ce phénomène, comme la protection des dunes ou le déplacement de certaines infrastructures.</p>\r\n\r\n<h2>Un enjeu pour l’avenir</h2>\r\n<p>La préservation du littoral devient un enjeu majeur pour les générations futures, nécessitant une mobilisation à long terme.</p>', '2026-04-17', 12, 21),
(14, 'Les plages de la côte basque face à l affluence estivale', '<h2>Une fréquentation en forte hausse</h2>\r\n<p>Chaque été, les plages de la côte basque attirent de nombreux visiteurs venus profiter de l’océan Atlantique et de paysages uniques. Des villes comme Biarritz ou Saint-Jean-de-Luz voient leur population fortement augmenter durant la saison touristique.</p>\r\n\r\n<h2>Des infrastructures mises à l’épreuve</h2>\r\n<p>Cette affluence entraîne une pression importante sur les infrastructures locales : parkings saturés, accès difficiles et gestion des déchets plus complexe. Les collectivités adaptent leurs dispositifs pour maintenir la qualité d’accueil.</p>\r\n\r\n<h2>Entre attractivité et préservation</h2>\r\n<p>La protection du littoral reste un enjeu majeur. Des actions sont mises en place pour sensibiliser les visiteurs à la préservation des plages et des écosystèmes marins.</p>', '2026-04-17', 12, 22);

-- --------------------------------------------------------

--
-- Structure de la table `news_images`
--

CREATE TABLE `news_images` (
  `id_news` int(11) NOT NULL,
  `id_media` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `news_images`
--

INSERT INTO `news_images` (`id_news`, `id_media`) VALUES
(1, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `news_station`
--

CREATE TABLE `news_station` (
  `id_station` int(11) NOT NULL,
  `id_news` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `news_station`
--

INSERT INTO `news_station` (`id_station`, `id_news`) VALUES
(12, 1),
(1, 2),
(1, 3),
(12, 3),
(1, 4),
(12, 4),
(15, 4),
(1, 5),
(12, 5),
(13, 10),
(14, 10),
(17, 11),
(18, 11),
(1, 12),
(12, 12),
(15, 13),
(16, 13),
(15, 14),
(16, 14);

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE `notes` (
  `id_note` int(11) NOT NULL,
  `value_` int(11) NOT NULL,
  `id_station` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `notes`
--

INSERT INTO `notes` (`id_note`, `value_`, `id_station`, `id_user`) VALUES
(1, 5, 1, 5),
(2, 4, 12, 7),
(3, 5, 15, 6),
(4, 3, 13, 5),
(5, 4, 19, 7),
(6, 4, 1, 7),
(7, 2, 1, 13);

-- --------------------------------------------------------

--
-- Structure de la table `regions`
--

CREATE TABLE `regions` (
  `id_region` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `regions`
--

INSERT INTO `regions` (`id_region`, `name`) VALUES
(1, 'Bretagne'),
(2, 'Normandie'),
(3, 'Nouvelle-Aquitaine'),
(4, 'Occitanie'),
(5, 'Provence-Alpes-Côte d\'Azur'),
(6, 'Hauts-de-France'),
(7, 'Pays-de-la-Loire');

-- --------------------------------------------------------

--
-- Structure de la table `reports`
--

CREATE TABLE `reports` (
  `id_report` int(11) NOT NULL,
  `date_` date NOT NULL DEFAULT current_timestamp(),
  `id_comment` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reports`
--

INSERT INTO `reports` (`id_report`, `date_`, `id_comment`, `id_user`) VALUES
(1, '2024-04-06', 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `station_images`
--

CREATE TABLE `station_images` (
  `id_station` int(11) NOT NULL,
  `id_media` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `station_images`
--

INSERT INTO `station_images` (`id_station`, `id_media`) VALUES
(1, 2),
(13, 2),
(1, 3),
(15, 3),
(17, 4),
(19, 5),
(1, 6),
(1, 9);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `email` varchar(254) NOT NULL,
  `username` varchar(50) NOT NULL,
  `date_` date NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL,
  `avatar` char(50) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `email`, `username`, `date_`, `password`, `avatar`, `is_admin`) VALUES
(1, 'user@user.net', 'FirstUser', '2026-04-02', '$2y$10$VeV06jzi17.QHYxRtcuM0uMktUzoe5Qv2KDzQMhjzCweJEsGLYqVy', NULL, 0),
(3, 'estt@est.net', 'test', '2026-04-03', '$2y$10$KdYXQu4.lgcUnL./.vj3nOVlL5MY.xgTBRTlhvuX4SZCCKZCG4DWW', NULL, 0),
(4, 'admin@site.com', 'bob', '2024-01-01', '$2y$10$hashadmin', 'avatar1.png', 1),
(5, 'user1@mail.com', 'surfLover', '2024-02-10', '$2y$10$hash1', 'avatar2.png', 0),
(6, 'user2@mail.com', 'beachFan', '2024-03-05', '$2y$10$hash2', 'avatar_69e73638aac914.82995093.jpg', 0),
(7, 'user3@mail.com', 'sunSeeker', '2024-03-20', '$2y$10$hash3', 'avatar4.png', 0),
(8, 'lucas.martin@gmail.com', 'lucas_m', '2025-11-12', '$2y$10$examplehash1', 'avatar_69e7368508adf2.83802806.png', 0),
(9, 'emma.bernard@yahoo.fr', 'emma_b', '2025-12-01', '$2y$10$examplehash2', 'avatar_69e735b42686f7.44654348.jpg', 0),
(10, 'thomas.robert@outlook.com', 'thomas_r', '2025-12-15', '$2y$10$examplehash3', 'thomas.jpg', 0),
(11, 'chloe.richard@gmail.com', 'chloe_r', '2026-01-03', '$2y$10$examplehash4', 'chloe.png', 0),
(12, 'zadig.mouquet@gmail.com', 'Zadig', '2026-04-10', '$2y$10$f7oA/ueMQq9PxlxjGR1Eluhx/jyTlDDdygvkqbahQYZILTHIFTwxC', 'avatar_69e736d63d11b8.39477220.jpg', 1),
(13, 'surflover45@gmail.com', 'surfLover45', '2026-04-16', '$2y$10$7ax//Z1Rl9NJO7yLkK5rD.dGpPYzyTnI9bjET.hbofSP.LFDV5sSe', NULL, 0),
(14, 'testuser@gmail.com', 'testuser', '2026-04-20', '$2y$10$wp5c7Qdk9EwPXaIJuusXUeMTxAfljVin4/sQ3UgWPl1Z2xUCIf.0u', NULL, 0),
(15, 'admin@gmail.com', 'admin', '2026-04-20', '$2y$12$NQq7wtQ1KEkEeMChkpYxIOi3j0vsi7fkqogvjOBMqvX1kiV4ZC2l6', NULL, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `beaches`
--
ALTER TABLE `beaches`
  ADD PRIMARY KEY (`id_station`),
  ADD UNIQUE KEY `label` (`label`),
  ADD KEY `id_region` (`id_region`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `id_station` (`id_station`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id_media`),
  ADD UNIQUE KEY `image` (`path`),
  ADD KEY `id_region` (`id_region`);

--
-- Index pour la table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id_news`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `news_thumbnail` (`id_thumbnail`);

--
-- Index pour la table `news_images`
--
ALTER TABLE `news_images`
  ADD PRIMARY KEY (`id_news`,`id_media`),
  ADD KEY `id_media` (`id_media`);

--
-- Index pour la table `news_station`
--
ALTER TABLE `news_station`
  ADD PRIMARY KEY (`id_station`,`id_news`),
  ADD KEY `id_news` (`id_news`);

--
-- Index pour la table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id_note`),
  ADD KEY `id_station` (`id_station`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id_region`);

--
-- Index pour la table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id_report`),
  ADD KEY `id_comment` (`id_comment`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `station_images`
--
ALTER TABLE `station_images`
  ADD PRIMARY KEY (`id_station`,`id_media`),
  ADD KEY `id_media` (`id_media`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `beaches`
--
ALTER TABLE `beaches`
  MODIFY `id_station` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pour la table `media`
--
ALTER TABLE `media`
  MODIFY `id_media` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `news`
--
ALTER TABLE `news`
  MODIFY `id_news` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `notes`
--
ALTER TABLE `notes`
  MODIFY `id_note` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `regions`
--
ALTER TABLE `regions`
  MODIFY `id_region` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `reports`
--
ALTER TABLE `reports`
  MODIFY `id_report` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `beaches`
--
ALTER TABLE `beaches`
  ADD CONSTRAINT `beaches_ibfk_1` FOREIGN KEY (`id_region`) REFERENCES `regions` (`id_region`);

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_station`) REFERENCES `beaches` (`id_station`),
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`id_region`) REFERENCES `regions` (`id_region`);

--
-- Contraintes pour la table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_thumbnail` FOREIGN KEY (`id_thumbnail`) REFERENCES `media` (`id_media`);

--
-- Contraintes pour la table `news_images`
--
ALTER TABLE `news_images`
  ADD CONSTRAINT `news_images_ibfk_1` FOREIGN KEY (`id_news`) REFERENCES `news` (`id_news`),
  ADD CONSTRAINT `news_images_ibfk_2` FOREIGN KEY (`id_media`) REFERENCES `media` (`id_media`);

--
-- Contraintes pour la table `news_station`
--
ALTER TABLE `news_station`
  ADD CONSTRAINT `news_station_ibfk_1` FOREIGN KEY (`id_station`) REFERENCES `beaches` (`id_station`),
  ADD CONSTRAINT `news_station_ibfk_2` FOREIGN KEY (`id_news`) REFERENCES `news` (`id_news`);

--
-- Contraintes pour la table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`id_station`) REFERENCES `beaches` (`id_station`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`id_comment`) REFERENCES `comments` (`id_comment`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `station_images`
--
ALTER TABLE `station_images`
  ADD CONSTRAINT `station_images_ibfk_1` FOREIGN KEY (`id_station`) REFERENCES `beaches` (`id_station`),
  ADD CONSTRAINT `station_images_ibfk_2` FOREIGN KEY (`id_media`) REFERENCES `media` (`id_media`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
