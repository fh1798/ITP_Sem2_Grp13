-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 23. Jun 2025 um 11:48
-- Server-Version: 10.4.28-MariaDB
-- PHP-Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `itp_grp13`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `artikel`
--

CREATE TABLE `artikel` (
  `artikelID` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `markeFK` int(11) NOT NULL,
  `ml` enum('50','100') NOT NULL,
  `artikelBildSrc` varchar(255) NOT NULL,
  `beschreibung` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `artikel`
--

INSERT INTO `artikel` (`artikelID`, `name`, `createdAt`, `markeFK`, `ml`, `artikelBildSrc`, `beschreibung`) VALUES
(3, 'Luna Rossa', '2025-04-08 17:43:49', 5, '50', './assets/images/articles/prada_luna_rossa.jpg', 'Ein frisches, sportliches Parfum von Prada, das mit zitrischen und holzigen Noten eine maskuline und energetische Ausstrahlung vermittelt. Die Komposition aus Lavendel, Minze und Ambra sorgt für ein belebendes und gleichzeitig elegantes Dufterlebnis.'),
(4, 'Eros', '2025-04-08 17:43:49', 4, '50', './assets/images/articles/versace_eros.jpg', 'Eros von Versace ist ein kraftvolles und leidenschaftliches Parfum, das mit einer sinnlichen Mischung aus Minze, Apfel, Zitronenverbene und Vanille die perfekte Balance zwischen Frische und Wärme schafft. Ein Duft, der Stärke, Selbstbewusstsein und Verführung verkörpert.'),
(5, 'Homme', '2025-04-08 17:43:49', 1, '50', './assets/images/articles/dior_homme.jpg', 'Yves Saint Laurents Homme ist ein charmanter, holziger Duft mit floralen Akzenten. Die erfrischenden Noten von Bergamot und Zitrusfrüchten harmonieren perfekt mit Leder, Amber und Gewürzen, was zu einem eleganten und maskulinen Duftprofil führt.'),
(6, 'Bleu De Chanel', '2025-04-08 17:43:49', 2, '50', './assets/images/articles/chanel_bleu_de_chanel.jpg', 'Bleu de Chanel ist ein klassisches Parfum, das mit einer modernen, maskulinen Note beeindruckt. Es kombiniert zitrische Frische mit Holz- und Ambernoten, was einen klaren, sauberen und dennoch tiefgründigen Duft erzeugt – perfekt für den anspruchsvollen Mann.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `artikelduftnoten`
--

CREATE TABLE `artikelduftnoten` (
  `artikelID` int(11) NOT NULL,
  `duftnoteID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `artikelduftnoten`
--

INSERT INTO `artikelduftnoten` (`artikelID`, `duftnoteID`) VALUES
(3, 5),
(3, 7),
(4, 1),
(4, 6),
(5, 4),
(5, 8),
(6, 2),
(6, 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `artikelinhaltsstoffe`
--

CREATE TABLE `artikelinhaltsstoffe` (
  `artikelID` int(11) NOT NULL,
  `inhaltID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `artikelinhaltsstoffe`
--

INSERT INTO `artikelinhaltsstoffe` (`artikelID`, `inhaltID`) VALUES
(3, 17),
(4, 19),
(5, 20),
(6, 18);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

CREATE TABLE `benutzer` (
  `benutzerID` int(11) NOT NULL,
  `vorname` varchar(50) NOT NULL,
  `nachname` varchar(50) NOT NULL,
  `geschlecht` enum('Mann','Frau','Divers') NOT NULL,
  `geburtsdatum` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwort` varchar(255) NOT NULL,
  `role` enum('Benutzer','Admin') NOT NULL DEFAULT 'Benutzer',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `benutzer`
--

INSERT INTO `benutzer` (`benutzerID`, `vorname`, `nachname`, `geschlecht`, `geburtsdatum`, `email`, `passwort`, `role`, `createdAt`) VALUES
(1, 'franzi', 'h', 'Frau', '2000-01-01', 'tt@tt.com', '$2y$10$TGNcWVUIo5CO0lH2HlZ2yeHujz/99UC8SylI6sbMDA49AlAU4xcC.', 'Benutzer', '2025-04-29 15:30:30'),
(2, 'Franziska', 'Harich', 'Frau', '1998-11-17', 'kjrychie@gmail.com', '$2y$10$M1kPI9iONnnxh2rncw4vDudh.JKXJW0myAnjBfzcmBH1CEvY/GM0O', 'Benutzer', '2025-04-29 16:06:12');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestellposition`
--

CREATE TABLE `bestellposition` (
  `positionID` int(11) NOT NULL,
  `bestellungID` int(11) NOT NULL,
  `artikelID` int(11) NOT NULL,
  `menge` int(11) NOT NULL,
  `einzelpreis` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `bestellposition`
--

INSERT INTO `bestellposition` (`positionID`, `bestellungID`, `artikelID`, `menge`, `einzelpreis`) VALUES
(1, 1, 4, 2, 72.00),
(2, 1, 5, 1, 108.00),
(3, 2, 6, 1, 96.00),
(4, 3, 3, 8, 84.00),
(5, 4, 5, 1, 108.00);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestellung`
--

CREATE TABLE `bestellung` (
  `bestellungID` int(11) NOT NULL,
  `benutzerID` int(11) NOT NULL,
  `gesamtpreis` decimal(10,2) DEFAULT NULL,
  `zahlungsart` varchar(50) DEFAULT NULL,
  `bestellt_am` datetime DEFAULT NULL,
  `lieferadresse` text DEFAULT NULL,
  `rechnungsadresse` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `bestellung`
--

INSERT INTO `bestellung` (`bestellungID`, `benutzerID`, `gesamtpreis`, `zahlungsart`, `bestellt_am`, `lieferadresse`, `rechnungsadresse`) VALUES
(1, 1, 252.00, 'Rechnung', '2025-06-23 11:30:48', 'Grazerstraße 59', 'Grazerstraße 59'),
(2, 1, 96.00, 'Rechnung', '2025-06-23 11:32:20', '8680', '8680'),
(3, 1, 672.00, 'Rechnung', '2025-06-23 11:42:41', 'Grazerstraße 59, 8680 Mürzzuschlag', 'Grazerstraße 59, 8680 Mürzzuschlag'),
(4, 1, 108.00, 'Rechnung', '2025-06-23 11:43:25', 'Grazerstraße 59, 8680 Mürzzuschlag (Tel: 06649970166)', 'Staura 11, 1050 wien');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `chatnachrichten`
--

CREATE TABLE `chatnachrichten` (
  `id` int(11) NOT NULL,
  `benutzer_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `chatnachrichten`
--

INSERT INTO `chatnachrichten` (`id`, `benutzer_id`, `content`, `time`) VALUES
(2, 2, '123', '2025-05-11 09:45:10'),
(3, 1, 'Hello', '2025-05-11 09:53:15'),
(4, 1, 'wie gehts', '2025-05-11 09:53:38'),
(5, 2, 'gut', '2025-05-11 09:57:53'),
(11, 3, 'Hallo', '2025-05-12 12:41:49'),
(12, 3, 'wie gehts', '2025-05-12 12:41:59'),
(13, 3, 'hallo', '2025-05-12 12:43:15'),
(14, 3, 'hey', '2025-05-12 12:58:37'),
(15, 1, 'testnachricht', '2025-05-13 14:37:42'),
(16, 1, 'test test test', '2025-06-10 19:40:41');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `duftnote`
--

CREATE TABLE `duftnote` (
  `duftnoteID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `typ` enum('Kopfnote','Herznote','Basisnote') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `duftnote`
--

INSERT INTO `duftnote` (`duftnoteID`, `name`, `typ`) VALUES
(1, 'Zitrone', 'Kopfnote'),
(2, 'Bergamotte', 'Kopfnote'),
(3, 'Lavendel', 'Herznote'),
(4, 'Rose', 'Herznote'),
(5, 'Jasmin', 'Herznote'),
(6, 'Vanille', 'Basisnote'),
(7, 'Sandelholz', 'Basisnote'),
(8, 'Moschus', 'Basisnote');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `forum`
--

CREATE TABLE `forum` (
  `forumID` int(11) NOT NULL,
  `benutzerID` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `forum`
--

INSERT INTO `forum` (`forumID`, `benutzerID`, `content`, `created_at`) VALUES
(1, 1, 'test', '2025-06-18 16:06:58');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `inhaltsstoffe`
--

CREATE TABLE `inhaltsstoffe` (
  `inhaltID` int(11) NOT NULL,
  `inhaltsstoff` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `inhaltsstoffe`
--

INSERT INTO `inhaltsstoffe` (`inhaltID`, `inhaltsstoff`) VALUES
(1, 'Wasser'),
(17, 'Linalool'),
(18, 'Citronellol'),
(19, 'Geraniol'),
(20, 'Limonene');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kommentare`
--

CREATE TABLE `kommentare` (
  `kommentarID` int(11) NOT NULL,
  `benutzerID` int(11) NOT NULL,
  `artikelID` int(11) NOT NULL,
  `kommentar` text NOT NULL,
  `erstellt_am` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `kommentare`
--

INSERT INTO `kommentare` (`kommentarID`, `benutzerID`, `artikelID`, `kommentar`, `erstellt_am`) VALUES
(1, 2, 3, 'super Duft!', '2025-06-18 16:19:08'),
(2, 2, 3, 'another comment..', '2025-06-18 16:19:22');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `likes`
--

CREATE TABLE `likes` (
  `likeID` int(11) NOT NULL,
  `benutzerID` int(11) NOT NULL,
  `artikelID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `likes`
--

INSERT INTO `likes` (`likeID`, `benutzerID`, `artikelID`) VALUES
(6, 2, 3),
(1, 2, 4),
(2, 2, 5),
(0, 1, 6),
(0, 1, 3),
(0, 1, 3),
(0, 1, 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `marke`
--

CREATE TABLE `marke` (
  `markeID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `firma` varchar(100) DEFAULT NULL,
  `herkunftsland` varchar(50) DEFAULT NULL,
  `beschreibung` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `marke`
--

INSERT INTO `marke` (`markeID`, `name`, `firma`, `herkunftsland`, `beschreibung`) VALUES
(1, 'Dior', 'LVMH', 'Frankreich', 'Französische Luxusmarke für Parfüm, Mode und Kosmetik.'),
(2, 'Chanel', 'Chanel S.A.', 'Frankreich', 'Berühmte Marke, bekannt für Chanel No. 5 und elegante Mode.'),
(3, 'Gucci', 'Kering', 'Italien', 'Italienische Luxusmarke mit auffälligem Design und Düften.'),
(4, 'Versace', 'Capri Holdings', 'Italien', 'Modemarke mit glamourösen Styles und markanten Parfüms.'),
(5, 'Prada', 'Prada S.p.A.', 'Italien', 'Modemarke mit eleganten Designs und luxuriösen Parfums.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `preisliste`
--

CREATE TABLE `preisliste` (
  `preisID` int(11) NOT NULL,
  `artikelID` int(11) NOT NULL,
  `preisNetto` decimal(10,0) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `steuersatzId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `preisliste`
--

INSERT INTO `preisliste` (`preisID`, `artikelID`, `preisNetto`, `created_at`, `steuersatzId`) VALUES
(3, 6, 80, '2025-04-08 16:16:56', 2),
(4, 4, 60, '2025-04-08 16:17:03', 2),
(5, 5, 90, '2025-04-08 16:17:09', 2),
(6, 3, 70, '2025-04-08 16:17:17', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `steuersatz`
--

CREATE TABLE `steuersatz` (
  `steuersatzID` int(11) NOT NULL,
  `steuersatz` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `steuersatz`
--

INSERT INTO `steuersatz` (`steuersatzID`, `steuersatz`) VALUES
(1, 0.1),
(2, 0.2),
(3, 0.13);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `warenkorb`
--

CREATE TABLE `warenkorb` (
  `warenkorbID` int(11) NOT NULL,
  `benutzerID` int(11) NOT NULL,
  `artikelID` int(11) NOT NULL,
  `menge` int(11) NOT NULL DEFAULT 1,
  `hinzugefuegt_am` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`artikelID`),
  ADD KEY `fk_artikel_marke` (`markeFK`);

--
-- Indizes für die Tabelle `artikelduftnoten`
--
ALTER TABLE `artikelduftnoten`
  ADD PRIMARY KEY (`artikelID`,`duftnoteID`),
  ADD KEY `duftnoteID` (`duftnoteID`);

--
-- Indizes für die Tabelle `artikelinhaltsstoffe`
--
ALTER TABLE `artikelinhaltsstoffe`
  ADD PRIMARY KEY (`artikelID`,`inhaltID`),
  ADD KEY `inhaltID` (`inhaltID`);

--
-- Indizes für die Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  ADD PRIMARY KEY (`benutzerID`);

--
-- Indizes für die Tabelle `bestellposition`
--
ALTER TABLE `bestellposition`
  ADD PRIMARY KEY (`positionID`),
  ADD KEY `bestellungID` (`bestellungID`);

--
-- Indizes für die Tabelle `bestellung`
--
ALTER TABLE `bestellung`
  ADD PRIMARY KEY (`bestellungID`);

--
-- Indizes für die Tabelle `chatnachrichten`
--
ALTER TABLE `chatnachrichten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `benutzer_id` (`benutzer_id`);

--
-- Indizes für die Tabelle `duftnote`
--
ALTER TABLE `duftnote`
  ADD PRIMARY KEY (`duftnoteID`);

--
-- Indizes für die Tabelle `inhaltsstoffe`
--
ALTER TABLE `inhaltsstoffe`
  ADD PRIMARY KEY (`inhaltID`);

--
-- Indizes für die Tabelle `marke`
--
ALTER TABLE `marke`
  ADD PRIMARY KEY (`markeID`);

--
-- Indizes für die Tabelle `preisliste`
--
ALTER TABLE `preisliste`
  ADD PRIMARY KEY (`preisID`),
  ADD KEY `fkTax` (`steuersatzId`),
  ADD KEY `FKartID` (`artikelID`);

--
-- Indizes für die Tabelle `steuersatz`
--
ALTER TABLE `steuersatz`
  ADD PRIMARY KEY (`steuersatzID`);

--
-- Indizes für die Tabelle `warenkorb`
--
ALTER TABLE `warenkorb`
  ADD PRIMARY KEY (`warenkorbID`),
  ADD KEY `benutzerID` (`benutzerID`),
  ADD KEY `artikelID` (`artikelID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `artikel`
--
ALTER TABLE `artikel`
  MODIFY `artikelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `benutzerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `bestellposition`
--
ALTER TABLE `bestellposition`
  MODIFY `positionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `bestellung`
--
ALTER TABLE `bestellung`
  MODIFY `bestellungID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `chatnachrichten`
--
ALTER TABLE `chatnachrichten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT für Tabelle `duftnote`
--
ALTER TABLE `duftnote`
  MODIFY `duftnoteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `inhaltsstoffe`
--
ALTER TABLE `inhaltsstoffe`
  MODIFY `inhaltID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT für Tabelle `marke`
--
ALTER TABLE `marke`
  MODIFY `markeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `preisliste`
--
ALTER TABLE `preisliste`
  MODIFY `preisID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `steuersatz`
--
ALTER TABLE `steuersatz`
  MODIFY `steuersatzID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `warenkorb`
--
ALTER TABLE `warenkorb`
  MODIFY `warenkorbID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `fk_artikel_marke` FOREIGN KEY (`markeFK`) REFERENCES `marke` (`markeID`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `artikelduftnoten`
--
ALTER TABLE `artikelduftnoten`
  ADD CONSTRAINT `artikelduftnoten_ibfk_1` FOREIGN KEY (`artikelID`) REFERENCES `artikel` (`artikelID`) ON DELETE CASCADE,
  ADD CONSTRAINT `artikelduftnoten_ibfk_2` FOREIGN KEY (`duftnoteID`) REFERENCES `duftnote` (`duftnoteID`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `artikelinhaltsstoffe`
--
ALTER TABLE `artikelinhaltsstoffe`
  ADD CONSTRAINT `artikelinhaltsstoffe_ibfk_1` FOREIGN KEY (`artikelID`) REFERENCES `artikel` (`artikelID`),
  ADD CONSTRAINT `artikelinhaltsstoffe_ibfk_2` FOREIGN KEY (`inhaltID`) REFERENCES `inhaltsstoffe` (`inhaltID`);

--
-- Constraints der Tabelle `bestellposition`
--
ALTER TABLE `bestellposition`
  ADD CONSTRAINT `bestellposition_ibfk_1` FOREIGN KEY (`bestellungID`) REFERENCES `bestellung` (`bestellungID`);

--
-- Constraints der Tabelle `preisliste`
--
ALTER TABLE `preisliste`
  ADD CONSTRAINT `FKartID` FOREIGN KEY (`artikelID`) REFERENCES `artikel` (`artikelID`),
  ADD CONSTRAINT `fkTax` FOREIGN KEY (`steuersatzId`) REFERENCES `steuersatz` (`steuersatzID`);

--
-- Constraints der Tabelle `warenkorb`
--
ALTER TABLE `warenkorb`
  ADD CONSTRAINT `warenkorb_ibfk_1` FOREIGN KEY (`benutzerID`) REFERENCES `benutzer` (`benutzerID`) ON DELETE CASCADE,
  ADD CONSTRAINT `warenkorb_ibfk_2` FOREIGN KEY (`artikelID`) REFERENCES `artikel` (`artikelID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
