-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Gegenereerd op: 22 mrt 2024 om 17:40
-- Serverversie: 11.3.2-MariaDB-1:11.3.2+maria~ubu2204
-- PHP-versie: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_development_1`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Admin`
--

CREATE TABLE `Admin` (
  `AdminID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `FullName` varchar(100) NOT NULL,
  `AdminRole` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Appointments`
--

CREATE TABLE `Appointments` (
  `AppointmentID` int(11) NOT NULL,
  `ClientID` int(11) DEFAULT NULL,
  `TrainerID` int(11) DEFAULT NULL,
  `AppointmentDateTime` datetime DEFAULT NULL,
  `Duration` int(11) DEFAULT NULL,
  `Status` enum('confirmed','pending','cancelled') DEFAULT NULL,
  `Notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `Appointments`
--

INSERT INTO `Appointments` (`AppointmentID`, `ClientID`, `TrainerID`, `AppointmentDateTime`, `Duration`, `Status`, `Notes`) VALUES
(5, 1, 2, '2024-03-24 10:30:00', 60, 'pending', 'Test Note'),
(6, 1, 1, '2024-04-01 08:30:00', 60, 'pending', 'Test Note'),
(13, 2, 1, '2024-04-16 12:30:00', 60, 'pending', 'Test Note');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Availability`
--

CREATE TABLE `Availability` (
  `AvailabilityID` int(11) NOT NULL,
  `TrainerID` int(11) DEFAULT NULL,
  `Weekday` enum('monday','tuesday','wednesday','thursday','friday','saturday','sunday') DEFAULT NULL,
  `StartTime` time DEFAULT NULL,
  `EndTime` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `BookingHistory`
--

CREATE TABLE `BookingHistory` (
  `BookingID` int(11) NOT NULL,
  `ClientID` int(11) DEFAULT NULL,
  `AppointmentID` int(11) DEFAULT NULL,
  `BookingDateTime` timestamp NULL DEFAULT current_timestamp(),
  `BookingStatus` enum('confirmed','cancelled') DEFAULT NULL,
  `ReasonForCancellation` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ClientDetails`
--

CREATE TABLE `ClientDetails` (
  `ClientID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `FullName` varchar(100) NOT NULL,
  `Age` int(11) DEFAULT NULL,
  `Gender` enum('male','female','other') DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ClientDetails`
--

INSERT INTO `ClientDetails` (`ClientID`, `UserID`, `FullName`, `Age`, `Gender`, `Address`, `PhoneNumber`) VALUES
(1, 8, 'Joel Embiid', 27, 'male', '1154 Cardinal Lane', '217-246-1371'),
(2, 4, 'Edgar Davies', 22, 'male', '1127 Tyler Avenue', '13052847701'),
(3, 9, 'Josh Giddy', 25, 'male', '69 Parrill Court', '12603128885'),
(4, 7, 'Karl-Anthony Towns', 26, 'male', '3828 Kennedy Court', '16172514379'),
(5, 3, 'Marley Johnson', 32, 'male', '3330 Heavens Way', '13102007005');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `TrainerDetails`
--

CREATE TABLE `TrainerDetails` (
  `TrainerID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `FullName` varchar(100) NOT NULL,
  `Age` int(11) DEFAULT NULL,
  `Gender` enum('male','female','other') DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `Specialization` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `TrainerDetails`
--

INSERT INTO `TrainerDetails` (`TrainerID`, `UserID`, `FullName`, `Age`, `Gender`, `Address`, `PhoneNumber`, `Specialization`) VALUES
(1, 1, 'Mohamed Dinle', 24, 'male', '4647 Everette Alley', '407-221-8186', 'Power Lifting'),
(2, 2, 'Samantha Smith', 28, 'female', '3781 Bolman Court', '12179408924', NULL),
(3, 5, 'Joe Hart', 43, 'male', '2242 Newton Street', '17632273507', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Users`
--

CREATE TABLE `Users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `UserType` enum('client','trainer') NOT NULL,
  `RegistrationDate` timestamp NULL DEFAULT current_timestamp(),
  `LastLoginDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `Users`
--

INSERT INTO `Users` (`UserID`, `Username`, `Password`, `Email`, `UserType`, `RegistrationDate`, `LastLoginDate`) VALUES
(1, 'mdinle', '$2y$10$sAzY2e5NxGn1s7U0tDmmceFuUIN4pvsMBbXMbBwjdPAbOAXuHCVZ6', 'mdinle9@gmail.com', 'trainer', '2024-03-19 21:10:46', NULL),
(2, 'ssmith', '$2y$10$lzEmUV4X13ZLXdWHRU.2g.WCnljrp5sDM8g6bEpK.ypb7Msyvn4c.', 's.smith@example.com', 'trainer', '2024-03-20 20:09:30', NULL),
(3, 'mjohnson', '$2y$10$jZ5ZzHF6y/Yjd5G/kSkYwOGRKtnScylUvRno.IyQpC5GuXgcBuwzS', 'm.johnson@example.com', 'client', '2024-03-20 20:09:56', NULL),
(4, 'edavis', '$2y$10$gzSqepAOjla5adJQd36cNeBqoFSk8utw.ajppAWYzW5o5v.B.ugdi', 'e.davis@example.com', 'client', '2024-03-20 20:10:20', NULL),
(5, 'jhart', '$2y$10$yyP4U8Rbxph9j61ZuVqpYezBfCT7TMpBLoOwWCAQ43GHzojUcX6hu', 'j.hart@example.com', 'trainer', '2024-03-21 00:26:14', NULL),
(7, 'katowns', '$2y$10$1qvbIZb0ty/Y5.PGXuzMbuVMWvKI/UW9FXylldJocs65WnrSjwfvO', 'k.a.towns@example.com', 'client', '2024-03-21 01:38:18', NULL),
(8, 'jembiid', '$2y$10$twKGtJeERZhN2crMBA7Jme95fcfCuaGODWOG.HE0//3lEkLnVTnf.', 'j.embiid@example.com', 'client', '2024-03-21 01:38:56', NULL),
(9, 'jgiddy', '$2y$10$5HjNFyhra4Z3dMt4.eEol.zjcYIdDVubD/tfQRhUl7aTHDJS.hug6', 'j.giddy@example.com', 'client', '2024-03-21 01:39:28', NULL);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `UserID` (`UserID`);

--
-- Indexen voor tabel `Appointments`
--
ALTER TABLE `Appointments`
  ADD PRIMARY KEY (`AppointmentID`),
  ADD KEY `ClientID` (`ClientID`),
  ADD KEY `TrainerID` (`TrainerID`);

--
-- Indexen voor tabel `Availability`
--
ALTER TABLE `Availability`
  ADD PRIMARY KEY (`AvailabilityID`),
  ADD KEY `TrainerID` (`TrainerID`);

--
-- Indexen voor tabel `BookingHistory`
--
ALTER TABLE `BookingHistory`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `ClientID` (`ClientID`),
  ADD KEY `AppointmentID` (`AppointmentID`);

--
-- Indexen voor tabel `ClientDetails`
--
ALTER TABLE `ClientDetails`
  ADD PRIMARY KEY (`ClientID`),
  ADD UNIQUE KEY `UserID` (`UserID`);

--
-- Indexen voor tabel `TrainerDetails`
--
ALTER TABLE `TrainerDetails`
  ADD PRIMARY KEY (`TrainerID`),
  ADD UNIQUE KEY `UserID` (`UserID`);

--
-- Indexen voor tabel `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `Admin`
--
ALTER TABLE `Admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `Appointments`
--
ALTER TABLE `Appointments`
  MODIFY `AppointmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT voor een tabel `Availability`
--
ALTER TABLE `Availability`
  MODIFY `AvailabilityID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `BookingHistory`
--
ALTER TABLE `BookingHistory`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `ClientDetails`
--
ALTER TABLE `ClientDetails`
  MODIFY `ClientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `TrainerDetails`
--
ALTER TABLE `TrainerDetails`
  MODIFY `TrainerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `Users`
--
ALTER TABLE `Users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `Admin`
--
ALTER TABLE `Admin`
  ADD CONSTRAINT `Admin_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`);

--
-- Beperkingen voor tabel `Appointments`
--
ALTER TABLE `Appointments`
  ADD CONSTRAINT `Appointments_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `ClientDetails` (`ClientID`),
  ADD CONSTRAINT `Appointments_ibfk_2` FOREIGN KEY (`TrainerID`) REFERENCES `TrainerDetails` (`TrainerID`);

--
-- Beperkingen voor tabel `Availability`
--
ALTER TABLE `Availability`
  ADD CONSTRAINT `Availability_ibfk_1` FOREIGN KEY (`TrainerID`) REFERENCES `TrainerDetails` (`TrainerID`);

--
-- Beperkingen voor tabel `BookingHistory`
--
ALTER TABLE `BookingHistory`
  ADD CONSTRAINT `BookingHistory_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `ClientDetails` (`ClientID`),
  ADD CONSTRAINT `BookingHistory_ibfk_2` FOREIGN KEY (`AppointmentID`) REFERENCES `Appointments` (`AppointmentID`);

--
-- Beperkingen voor tabel `ClientDetails`
--
ALTER TABLE `ClientDetails`
  ADD CONSTRAINT `ClientDetails_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`);

--
-- Beperkingen voor tabel `TrainerDetails`
--
ALTER TABLE `TrainerDetails`
  ADD CONSTRAINT `TrainerDetails_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
