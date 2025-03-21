-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 08, 2025 at 10:40 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotelprojekt`
--

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `thumbnail_path` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Entwurf','Veröffentlicht') DEFAULT 'Entwurf',
  `published_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `image_path`, `thumbnail_path`, `content`, `created_at`, `status`, `published_at`) VALUES
(6, 'Gutes Essen macht gute Laune', 'uploads/news_images/news_676f5dc862a684.17586379.jpg', 'uploads/news_thumbnails/thumb_676f5dc862a703.47446295.jpg', 'Das Hotel Blick und Glück liegt ideal gelegen, um sowohl Erholungssuchende als auch Abenteuerlustige gleichermaßen zu begeistern. Die malerische Umgebung bietet eine Vielzahl von Aktivitäten, die Ihren Aufenthalt unvergesslich machen.\r\n\r\nFür Naturliebhaber gibt es zahlreiche Wander- und Radwege, die durch atemberaubende Landschaften führen. Erkunden Sie die umliegenden Wälder, Seen und Berge und genießen Sie die frische Luft und die beeindruckende Natur. Im Winter verwandelt sich die Region in ein Paradies für Skifahrer und Snowboarder mit bestens präparierten Pisten und gemütlichen Berghütten.', '2024-12-28 02:09:12', 'Veröffentlicht', NULL),
(7, 'Gutes Essen macht gute Laune', 'uploads/news_images/news_676f61166a6ff8.14992795.jpg', 'uploads/news_thumbnails/thumb_676f61166a70e6.38805804.jpg', 'Gutes Essen ist ein wichtiger Bestandteil eines gelungenen Aufenthalts, und im Hotel Blick und Glück legen wir besonderen Wert auf kulinarische Exzellenz. Unser Küchenteam zaubert täglich frische und abwechslungsreiche Gerichte, die keine Wünsche offenlassen.\r\n\r\nBeginnen Sie Ihren Tag mit einem reichhaltigen Frühstücksbuffet, das von regionalen Spezialitäten bis hin zu internationalen Köstlichkeiten alles bietet. Für das Mittag- und Abendessen bieten wir wechselnde Menüs, die saisonal angepasst werden und die besten Zutaten der Region hervorheben.\r\n\r\nBesonders stolz sind wir auf unsere Themenabende, bei denen Sie besondere kulinarische Erlebnisse genießen können. Ob mediterrane Nächte, asiatische Fusionsküche oder traditionelle deutsche Hausmannskost – lassen Sie sich von unseren kreativen Gerichten überraschen.', '2024-12-28 02:23:18', 'Entwurf', NULL),
(8, 'Entspannung pur – Ihr Wellness-Erlebnis im Hotel Blick und Glück', 'uploads/news_images/news_676f61496be365.25389508.jpg', 'uploads/news_thumbnails/thumb_676f61496be404.91383901.jpg', 'Im hektischen Alltag ist es wichtiger denn je, sich Momente der Ruhe und Entspannung zu gönnen. Im Hotel Blick und Glück haben wir genau das Richtige für Sie vorbereitet. Unser hauseigenes Wellnesscenter bietet eine Vielzahl von Anwendungen, die Körper und Geist in Einklang bringen.\r\n\r\nBeginnen Sie Ihren Tag mit einer belebenden Yoga-Session in unserem lichtdurchfluteten Studio oder lassen Sie den Stress bei einer wohltuenden Massage hinter sich. Unsere erfahrenen Therapeuten stehen Ihnen mit individuellen Behandlungen zur Verfügung, die auf Ihre Bedürfnisse abgestimmt sind. Nach einer entspannenden Sitzung können Sie im Whirlpool relaxen oder einen Spaziergang durch unsere gepflegten Gartenanlagen genießen.\r\n\r\nFür das leibliche Wohl sorgen unsere gesunden und köstlichen Speisen im hoteleigenen Restaurant. Frische, regionale Zutaten und kreative Rezepte machen jedes Gericht zu einem Genuss. Lassen Sie sich von unserem Wellness-Angebot verwöhnen und tanken Sie neue Energie im Hotel Blick und Glück – Ihrem Rückzugsort für Körper und Seele.', '2024-12-28 02:24:09', 'Entwurf', NULL),
(9, 'Für Naturliebhaber', 'uploads/news_images/news_676f62b9c9c392.63638533.jpg', 'uploads/news_thumbnails/thumb_676f62b9c9c412.46786137.jpg', 'Das Hotel Blick und Glück liegt ideal gelegen, um sowohl Erholungssuchende als auch Abenteuerlustige gleichermaßen zu begeistern. Die malerische Umgebung bietet eine Vielzahl von Aktivitäten, die Ihren Aufenthalt unvergesslich machen.\r\n\r\nFür Naturliebhaber gibt es zahlreiche Wander- und Radwege, die durch atemberaubende Landschaften führen. Erkunden Sie die umliegenden Wälder, Seen und Berge und genießen Sie die frische Luft und die beeindruckende Natur. Im Winter verwandelt sich die Region in ein Paradies für Skifahrer und Snowboarder mit bestens präparierten Pisten und gemütlichen Berghütten.', '2024-12-28 02:30:17', 'Entwurf', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `guests` int(11) NOT NULL,
  `breakfast` enum('mit','ohne') NOT NULL,
  `children` enum('kein','Kleinkinder','Kinder') NOT NULL,
  `pets` enum('keine','hund','katze','sonstige') NOT NULL,
  `parking` enum('ja','nein') NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('neu','bestätigt','storniert') DEFAULT 'neu',
  `bearbeitet_von` enum('admin','manager') NOT NULL DEFAULT 'admin',
  `bearbeitet_am` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `room_id`, `username`, `check_in_date`, `check_out_date`, `guests`, `breakfast`, `children`, `pets`, `parking`, `notes`, `created_at`, `status`, `bearbeitet_von`, `bearbeitet_am`) VALUES
(51, 1, 'student6', '2025-01-03', '2025-01-10', 3, 'mit', 'kein', 'hund', 'ja', '', '2024-12-31 04:12:43', 'bestätigt', 'admin', '2024-12-31 05:12:43'),
(52, 2, 'student5', '2025-01-04', '2025-01-07', 1, 'mit', 'kein', 'keine', 'nein', 'test', '2024-12-31 04:55:15', 'neu', 'admin', '2024-12-31 05:55:15'),
(53, 2, 'student6', '2024-12-31', '2025-01-03', 3, 'mit', 'kein', 'hund', 'ja', 'test', '2024-12-31 04:58:23', 'neu', 'admin', '2024-12-31 05:58:23'),
(54, 2, 'tina.m', '2025-01-09', '2025-01-11', 1, 'mit', 'kein', 'keine', 'ja', 'test', '2025-01-08 20:56:18', 'bestätigt', 'admin', '2025-01-08 21:56:18'),
(55, 3, 'tina.m', '2025-01-09', '2025-01-12', 3, 'mit', 'kein', 'keine', 'ja', '', '2025-01-08 21:16:34', 'neu', 'admin', '2025-01-08 22:16:34');

--
-- Triggers `reservations`
--
DELIMITER $$
CREATE TRIGGER `after_reservation_delete` AFTER DELETE ON `reservations` FOR EACH ROW BEGIN
    -- Prüfen, ob noch Reservierungen für das Zimmer existieren
    IF NOT EXISTS (
        SELECT 1
        FROM reservations
        WHERE room_id = OLD.room_id
    ) THEN
        -- Setze das Zimmer auf verfügbar
        UPDATE rooms
        SET available = 1
        WHERE room_id = OLD.room_id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_reservation_insert` AFTER INSERT ON `reservations` FOR EACH ROW BEGIN
    UPDATE rooms
    SET available = 0
    WHERE room_id = NEW.room_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price_per_night` decimal(10,2) NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT 1,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `category`, `price_per_night`, `available`, `image_path`) VALUES
(1, 'Einzelzimmer', 80.00, 0, NULL),
(2, 'Doppelzimmer', 120.00, 0, NULL),
(3, 'Suite', 200.00, 0, NULL),
(4, 'Einzelzimmer', 80.00, 1, NULL),
(5, 'Doppelzimmer', 120.00, 1, NULL),
(6, 'Einzelzimmer', 80.00, 1, NULL),
(7, 'Doppelzimmer', 120.00, 1, NULL),
(8, 'Suite', 200.00, 1, NULL),
(9, 'Einzelzimmer', 50.00, 1, NULL),
(10, 'Einzelzimmer', 50.00, 1, NULL),
(11, 'Einzelzimmer', 50.00, 1, NULL),
(12, 'Einzelzimmer', 50.00, 1, NULL),
(13, 'Doppelzimmer', 80.00, 1, NULL),
(14, 'Doppelzimmer', 80.00, 1, NULL),
(15, 'Doppelzimmer', 80.00, 1, NULL),
(16, 'Doppelzimmer', 80.00, 1, NULL),
(17, 'Suite', 120.00, 1, NULL),
(18, 'Suite', 120.00, 1, NULL),
(19, 'Suite', 120.00, 1, NULL),
(20, 'Suite', 120.00, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(260) NOT NULL,
  `useremail` varchar(100) NOT NULL,
  `role` enum('user','admin','anonym') NOT NULL DEFAULT 'anonym',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `anrede` enum('Herr','Frau') DEFAULT 'Herr',
  `vorname` varchar(50) NOT NULL,
  `nachname` varchar(50) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `useremail`, `role`, `created_at`, `anrede`, `vorname`, `nachname`, `status`, `updated_at`) VALUES
(8, 'admin', '$2y$10$rnR3Qd0.LZ342E.pt3AGpui0GaKrozayoz57jyZmSSNl/KqdS7Pj.', 'admin@blickglueck.at', 'admin', '2024-12-21 15:37:53', 'Frau', 'Alma', 'Hermann', 'active', '2024-12-31 02:06:16'),
(9, 'student5', '$2y$10$RyMKcygIigPgU9yE300qMOcdv1DKkPzHlMmk3zJbHr/fIru5EuHMO', 'student5@somedomain.at', 'user', '2024-12-22 14:34:52', 'Frau', 'Anja', 'Becker', 'active', '2025-01-08 21:36:09'),
(10, 'student6', '$2y$10$t5TgiJ/obLr5fhBHSUwT/eUn961RoLdZ4D1zUJ5rmpZXkI2NMtQ12', 'student6@somedomain.at', 'user', '2024-12-23 20:21:01', 'Herr', 'Benjamin', 'Bauer', 'active', '2025-01-08 21:36:52'),
(14, 'Andi_3', '$2y$10$1qQlSkYvz9HDeOqokoBufOYcbnQYQ9u.qZ7JzZCRk7R9EeO9BxV52', 'student_andi@somedomain.at', 'user', '2024-12-31 04:46:39', 'Herr', 'Andy', 'Schneider', 'inactive', '2025-01-08 21:37:21'),
(15, 'tina.m', '$2y$10$GSsqlv6k7z6Br9qu8YFeDOHsGFuY.iVwn7ZOIA7OPvSuvoy7WFCTa', 'christina.m@somedomain.com', 'user', '2025-01-08 20:55:11', 'Frau', 'Christina', 'Müller', 'active', '2025-01-08 20:55:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD UNIQUE KEY `unique_reservation` (`room_id`,`check_in_date`,`check_out_date`),
  ADD KEY `fk_username` (`username`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `useremail` (`useremail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_room_id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_username` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
