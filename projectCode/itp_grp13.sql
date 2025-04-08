-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 07:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itp_grp13`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
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
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`artikelID`, `name`, `createdAt`, `markeFK`, `ml`, `artikelBildSrc`, `beschreibung`) VALUES
(3, 'Luna Rossa', '2025-04-08 17:43:49', 5, '50', './assets/images/articles/prada_luna_rossa.jpg', 'Ein frisches, sportliches Parfum von Prada, das mit zitrischen und holzigen Noten eine maskuline und energetische Ausstrahlung vermittelt. Die Komposition aus Lavendel, Minze und Ambra sorgt für ein belebendes und gleichzeitig elegantes Dufterlebnis.'),
(4, 'Eros', '2025-04-08 17:43:49', 4, '50', './assets/images/articles/versace_eros.jpg', 'Eros von Versace ist ein kraftvolles und leidenschaftliches Parfum, das mit einer sinnlichen Mischung aus Minze, Apfel, Zitronenverbene und Vanille die perfekte Balance zwischen Frische und Wärme schafft. Ein Duft, der Stärke, Selbstbewusstsein und Verführung verkörpert.'),
(5, 'Homme', '2025-04-08 17:43:49', 1, '50', './assets/images/articles/dior_homme.jpg', 'Yves Saint Laurents Homme ist ein charmanter, holziger Duft mit floralen Akzenten. Die erfrischenden Noten von Bergamot und Zitrusfrüchten harmonieren perfekt mit Leder, Amber und Gewürzen, was zu einem eleganten und maskulinen Duftprofil führt.'),
(6, 'Bleu De Chanel', '2025-04-08 17:43:49', 2, '50', './assets/images/articles/chanel_bleu_de_chanel.jpg', 'Bleu de Chanel ist ein klassisches Parfum, das mit einer modernen, maskulinen Note beeindruckt. Es kombiniert zitrische Frische mit Holz- und Ambernoten, was einen klaren, sauberen und dennoch tiefgründigen Duft erzeugt – perfekt für den anspruchsvollen Mann.');

-- --------------------------------------------------------

--
-- Table structure for table `artikelduftnoten`
--

CREATE TABLE `artikelduftnoten` (
  `artikelID` int(11) NOT NULL,
  `duftnoteID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artikelduftnoten`
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
-- Table structure for table `artikelinhaltsstoffe`
--

CREATE TABLE `artikelinhaltsstoffe` (
  `artikelID` int(11) NOT NULL,
  `inhaltID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artikelinhaltsstoffe`
--

INSERT INTO `artikelinhaltsstoffe` (`artikelID`, `inhaltID`) VALUES
(3, 17),
(4, 19),
(5, 20),
(6, 18);

-- --------------------------------------------------------

--
-- Table structure for table `duftnote`
--

CREATE TABLE `duftnote` (
  `duftnoteID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `typ` enum('Kopfnote','Herznote','Basisnote') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `duftnote`
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
-- Table structure for table `inhaltsstoffe`
--

CREATE TABLE `inhaltsstoffe` (
  `inhaltID` int(11) NOT NULL,
  `inhaltsstoff` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inhaltsstoffe`
--

INSERT INTO `inhaltsstoffe` (`inhaltID`, `inhaltsstoff`) VALUES
(1, 'Wasser'),
(17, 'Linalool'),
(18, 'Citronellol'),
(19, 'Geraniol'),
(20, 'Limonene');

-- --------------------------------------------------------

--
-- Table structure for table `marke`
--

CREATE TABLE `marke` (
  `markeID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `firma` varchar(100) DEFAULT NULL,
  `herkunftsland` varchar(50) DEFAULT NULL,
  `beschreibung` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marke`
--

INSERT INTO `marke` (`markeID`, `name`, `firma`, `herkunftsland`, `beschreibung`) VALUES
(1, 'Dior', 'LVMH', 'Frankreich', 'Französische Luxusmarke für Parfüm, Mode und Kosmetik.'),
(2, 'Chanel', 'Chanel S.A.', 'Frankreich', 'Berühmte Marke, bekannt für Chanel No. 5 und elegante Mode.'),
(3, 'Gucci', 'Kering', 'Italien', 'Italienische Luxusmarke mit auffälligem Design und Düften.'),
(4, 'Versace', 'Capri Holdings', 'Italien', 'Modemarke mit glamourösen Styles und markanten Parfüms.'),
(5, 'Prada', 'Prada S.p.A.', 'Italien', 'Modemarke mit eleganten Designs und luxuriösen Parfums.');

-- --------------------------------------------------------

--
-- Table structure for table `preisliste`
--

CREATE TABLE `preisliste` (
  `preisID` int(11) NOT NULL,
  `artikelID` int(11) NOT NULL,
  `preisNetto` decimal(10,0) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `steuersatzId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `preisliste`
--

INSERT INTO `preisliste` (`preisID`, `artikelID`, `preisNetto`, `created_at`, `steuersatzId`) VALUES
(3, 6, 80, '2025-04-08 16:16:56', 2),
(4, 4, 60, '2025-04-08 16:17:03', 2),
(5, 5, 90, '2025-04-08 16:17:09', 2),
(6, 3, 70, '2025-04-08 16:17:17', 2);

-- --------------------------------------------------------

--
-- Table structure for table `steuersatz`
--

CREATE TABLE `steuersatz` (
  `steuersatzID` int(11) NOT NULL,
  `steuersatz` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `steuersatz`
--

INSERT INTO `steuersatz` (`steuersatzID`, `steuersatz`) VALUES
(1, 0.1),
(2, 0.2),
(3, 0.13);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`artikelID`),
  ADD KEY `fk_artikel_marke` (`markeFK`);

--
-- Indexes for table `artikelduftnoten`
--
ALTER TABLE `artikelduftnoten`
  ADD PRIMARY KEY (`artikelID`,`duftnoteID`),
  ADD KEY `duftnoteID` (`duftnoteID`);

--
-- Indexes for table `artikelinhaltsstoffe`
--
ALTER TABLE `artikelinhaltsstoffe`
  ADD PRIMARY KEY (`artikelID`,`inhaltID`),
  ADD KEY `inhaltID` (`inhaltID`);

--
-- Indexes for table `duftnote`
--
ALTER TABLE `duftnote`
  ADD PRIMARY KEY (`duftnoteID`);

--
-- Indexes for table `inhaltsstoffe`
--
ALTER TABLE `inhaltsstoffe`
  ADD PRIMARY KEY (`inhaltID`);

--
-- Indexes for table `marke`
--
ALTER TABLE `marke`
  ADD PRIMARY KEY (`markeID`);

--
-- Indexes for table `preisliste`
--
ALTER TABLE `preisliste`
  ADD PRIMARY KEY (`preisID`),
  ADD KEY `fkTax` (`steuersatzId`),
  ADD KEY `FKartID` (`artikelID`);

--
-- Indexes for table `steuersatz`
--
ALTER TABLE `steuersatz`
  ADD PRIMARY KEY (`steuersatzID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `artikelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `duftnote`
--
ALTER TABLE `duftnote`
  MODIFY `duftnoteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `inhaltsstoffe`
--
ALTER TABLE `inhaltsstoffe`
  MODIFY `inhaltID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `marke`
--
ALTER TABLE `marke`
  MODIFY `markeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `preisliste`
--
ALTER TABLE `preisliste`
  MODIFY `preisID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `steuersatz`
--
ALTER TABLE `steuersatz`
  MODIFY `steuersatzID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `fk_artikel_marke` FOREIGN KEY (`markeFK`) REFERENCES `marke` (`markeID`) ON UPDATE CASCADE;

--
-- Constraints for table `artikelduftnoten`
--
ALTER TABLE `artikelduftnoten`
  ADD CONSTRAINT `artikelduftnoten_ibfk_1` FOREIGN KEY (`artikelID`) REFERENCES `artikel` (`artikelID`) ON DELETE CASCADE,
  ADD CONSTRAINT `artikelduftnoten_ibfk_2` FOREIGN KEY (`duftnoteID`) REFERENCES `duftnote` (`duftnoteID`) ON DELETE CASCADE;

--
-- Constraints for table `artikelinhaltsstoffe`
--
ALTER TABLE `artikelinhaltsstoffe`
  ADD CONSTRAINT `artikelinhaltsstoffe_ibfk_1` FOREIGN KEY (`artikelID`) REFERENCES `artikel` (`artikelID`),
  ADD CONSTRAINT `artikelinhaltsstoffe_ibfk_2` FOREIGN KEY (`inhaltID`) REFERENCES `inhaltsstoffe` (`inhaltID`);

--
-- Constraints for table `preisliste`
--
ALTER TABLE `preisliste`
  ADD CONSTRAINT `FKartID` FOREIGN KEY (`artikelID`) REFERENCES `artikel` (`artikelID`),
  ADD CONSTRAINT `fkTax` FOREIGN KEY (`steuersatzId`) REFERENCES `steuersatz` (`steuersatzID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
