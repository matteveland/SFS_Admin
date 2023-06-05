-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 04, 2023 at 08:29 PM
-- Server version: 5.7.32
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo_sfsAdmin`
--

-- --------------------------------------------------------

--
-- Table structure for table `alarmData`
--

CREATE TABLE `alarmData` (
  `id` int(25) NOT NULL,
  `alarmTypeSubmit` varchar(10) NOT NULL,
  `reportedTime` datetime NOT NULL,
  `accountName` varchar(25) NOT NULL,
  `sensorKind` varchar(50) NOT NULL,
  `fossZone` varchar(25) NOT NULL,
  `findings` varchar(15) NOT NULL,
  `weather` varchar(250) NOT NULL,
  `alarmDescription` varchar(1000) NOT NULL,
  `buildingNumber` varchar(10) NOT NULL,
  `roomNumber` varchar(50) NOT NULL,
  `alarmLocationType` varchar(10) NOT NULL,
  `submittedBy` varchar(75) NOT NULL,
  `dutySection` varchar(10) DEFAULT NULL,
  `status` varchar(25) NOT NULL,
  `correctedBy` varchar(50) NOT NULL,
  `dateCorrected` varchar(50) NOT NULL,
  `inspectedBy` varchar(50) NOT NULL,
  `notes` varchar(750) NOT NULL,
  `accountedFor` varchar(1) NOT NULL,
  `iv` varbinary(256) DEFAULT NULL,
  `accessPoint` int(15) DEFAULT NULL,
  `unitName` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `installation` varchar(50) NOT NULL,
  `sectionAffected` varchar(45) NOT NULL,
  `building` varchar(200) NOT NULL,
  `startTime` varchar(10) NOT NULL,
  `startDate` date NOT NULL,
  `notes` varchar(1000) NOT NULL,
  `addedBy` varchar(50) NOT NULL,
  `unitName` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `appointmentRoster`
--

CREATE TABLE `appointmentRoster` (
  `id` int(11) NOT NULL,
  `dodId` varchar(15) DEFAULT '',
  `rank` varchar(6) DEFAULT '',
  `email` varchar(100) DEFAULT '',
  `firstName` varchar(30) NOT NULL,
  `middleName` varchar(30) DEFAULT NULL,
  `lastName` varchar(30) NOT NULL,
  `title` varchar(30) NOT NULL COMMENT 'what type of appointment',
  `installation` varchar(30) NOT NULL,
  `location` varchar(25) DEFAULT '' COMMENT 'building number or location',
  `startdate` varchar(48) NOT NULL,
  `appointmentTime` varchar(10) NOT NULL,
  `selfMade` varchar(3) DEFAULT '',
  `dutySection` varchar(5) DEFAULT '',
  `allDay` varchar(5) DEFAULT '',
  `enddate` varchar(45) DEFAULT '',
  `addedBy` varchar(100) NOT NULL,
  `dateAdded` datetime NOT NULL,
  `notes` varchar(100) NOT NULL,
  `endTime` varchar(10) DEFAULT '',
  `unitName` varchar(30) NOT NULL,
  `overRide` varchar(3) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `armingRoster`
--

CREATE TABLE `armingRoster` (
  `id` int(11) NOT NULL,
  `rank` varchar(6) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `middleName` varchar(30) NOT NULL,
  `lastFour` int(4) NOT NULL,
  `dodId` bigint(25) NOT NULL,
  `baton` varchar(10) NOT NULL,
  `useOfForce` varchar(10) NOT NULL,
  `lat` varchar(10) NOT NULL,
  `taser` varchar(10) NOT NULL,
  `m4Qual` varchar(10) NOT NULL,
  `m9Qual` varchar(10) NOT NULL,
  `m4Exp` varchar(10) NOT NULL,
  `m9Exp` varchar(10) NOT NULL,
  `smcFired` varchar(25) NOT NULL,
  `smcDue` varchar(10) NOT NULL,
  `m203Exp` varchar(10) NOT NULL,
  `m249Exp` varchar(10) NOT NULL,
  `m240Exp` varchar(10) NOT NULL,
  `m870Exp` varchar(10) NOT NULL,
  `unitName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cbtList`
--

CREATE TABLE `cbtList` (
  `id` int(11) NOT NULL,
  `lastName` varchar(30) DEFAULT NULL,
  `firstName` varchar(30) DEFAULT NULL,
  `grade` varchar(9) NOT NULL,
  `trngType` varchar(100) DEFAULT NULL,
  `trngLast` varchar(15) DEFAULT NULL,
  `trngDue` varchar(15) DEFAULT NULL,
  `dodID` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cbtList799`
--

CREATE TABLE `cbtList799` (
  `id` int(10) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `dodCombatTrafficking` varchar(10) NOT NULL,
  `cyberAwareness` varchar(10) NOT NULL,
  `fp` varchar(10) NOT NULL,
  `greenDotCurrent` varchar(10) NOT NULL,
  `airfieldDriving` varchar(10) NOT NULL,
  `cbrnCBT` varchar(10) NOT NULL,
  `cbrnCBTPretest` varchar(10) NOT NULL,
  `noFEAR` varchar(10) NOT NULL,
  `religiousFreedom` varchar(10) NOT NULL,
  `afCIED` varchar(10) NOT NULL,
  `sabc` varchar(10) NOT NULL,
  `sabcHandsOn` varchar(10) NOT NULL,
  `loac` varchar(10) NOT NULL,
  `ems` varchar(10) NOT NULL,
  `riskManagement` varchar(10) NOT NULL,
  `blendedRetirement` varchar(10) NOT NULL,
  `profRelationship` varchar(10) NOT NULL,
  `unitName` varchar(10) NOT NULL,
  `afCIED_Old` varchar(10) NOT NULL,
  `greenDotNext` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cctkList`
--

CREATE TABLE `cctkList` (
  `id` int(11) NOT NULL,
  `office` varchar(6) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `grade` varchar(9) NOT NULL,
  `status` varchar(30) NOT NULL,
  `imm` varchar(5) NOT NULL,
  `den` varchar(10) NOT NULL,
  `lab` varchar(10) NOT NULL,
  `dlc` varchar(10) DEFAULT NULL,
  `pha` varchar(5) NOT NULL,
  `eqp` varchar(5) NOT NULL,
  `imr` varchar(5) NOT NULL,
  `metrics` varchar(50) NOT NULL,
  `actionList` varchar(100) NOT NULL,
  `goRed` varchar(10) NOT NULL,
  `site` varchar(10) NOT NULL,
  `unitName` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `family`
--

CREATE TABLE `family` (
  `id` int(11) NOT NULL,
  `dodId` int(11) NOT NULL,
  `fname` varchar(45) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `birthdate` date NOT NULL,
  `relationship` varchar(10) NOT NULL,
  `unitName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fitness`
--

CREATE TABLE `fitness` (
  `id` int(11) NOT NULL,
  `rank` varchar(9) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `middleName` varchar(30) NOT NULL,
  `pushUps` varchar(10) NOT NULL,
  `sitUps` varchar(10) NOT NULL,
  `run` varchar(15) NOT NULL,
  `waist` varchar(10) NOT NULL,
  `dodId` int(15) DEFAULT NULL,
  `dueDate` varchar(15) NOT NULL,
  `fitness_mockType` varchar(30) NOT NULL,
  `unitName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `importAppointment`
--

CREATE TABLE `importAppointment` (
  `id` int(11) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `middleName` varchar(30) NOT NULL,
  `dutySection` varchar(5) NOT NULL,
  `title` varchar(30) NOT NULL,
  `location` varchar(25) NOT NULL,
  `startDate` varchar(48) NOT NULL,
  `endDate` varchar(10) DEFAULT '',
  `appointmentTime` varchar(10) NOT NULL,
  `notes` varchar(100) NOT NULL,
  `unitName` varchar(30) NOT NULL,
  `addedBy` varchar(75) NOT NULL,
  `dateAdded` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `importArming`
--

CREATE TABLE `importArming` (
  `id` int(11) NOT NULL DEFAULT '0',
  `rank` varchar(6) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `middleName` varchar(30) NOT NULL,
  `lastFour` int(4) NOT NULL,
  `dodId` int(25) NOT NULL,
  `baton` varchar(10) NOT NULL,
  `useOfForce` varchar(10) NOT NULL,
  `lat` varchar(10) NOT NULL,
  `taser` varchar(10) NOT NULL,
  `m4Qual` varchar(10) NOT NULL,
  `m9Qual` varchar(10) NOT NULL,
  `m4Exp` varchar(10) NOT NULL,
  `m9Exp` varchar(10) NOT NULL,
  `smcFired` varchar(10) NOT NULL,
  `smcDue` varchar(10) NOT NULL,
  `m203Exp` varchar(10) NOT NULL,
  `m249Exp` varchar(10) NOT NULL,
  `m240Exp` varchar(10) NOT NULL,
  `m870Exp` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `importSFMQ`
--

CREATE TABLE `importSFMQ` (
  `id` int(11) NOT NULL,
  `rank` varchar(6) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `middleName` varchar(30) NOT NULL,
  `dutyQualPos` varchar(15) NOT NULL,
  `primCertDate` varchar(15) NOT NULL,
  `reCertDate` varchar(15) NOT NULL,
  `phase2Start` varchar(30) NOT NULL,
  `newDutyQual` varchar(15) NOT NULL,
  `phase2End` varchar(30) NOT NULL,
  `qcNLT` varchar(15) NOT NULL,
  `nintyDayStart` varchar(15) NOT NULL,
  `deros` varchar(15) NOT NULL,
  `dodId` int(25) NOT NULL,
  `unitName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `import_decStatus`
--

CREATE TABLE `import_decStatus` (
  `id` int(15) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `decType` varchar(10) NOT NULL,
  `reason` varchar(20) NOT NULL,
  `startDate` varchar(15) NOT NULL,
  `endDate` varchar(15) NOT NULL,
  `submitDate` varchar(45) NOT NULL,
  `currentAssigned` varchar(100) NOT NULL,
  `pendingCoordDate` varchar(45) NOT NULL,
  `unitName` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `import_eprStatus`
--

CREATE TABLE `import_eprStatus` (
  `id` int(15) NOT NULL,
  `closeoutDate` varchar(15) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `rateeLastName` varchar(30) NOT NULL,
  `rateeFirstName` varchar(30) NOT NULL,
  `pendingCoord` varchar(50) NOT NULL,
  `pendingCoordDate` varchar(15) NOT NULL,
  `daysPending` varchar(15) NOT NULL,
  `milpdsUpdateDate` varchar(15) NOT NULL,
  `unitName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `import_gtc`
--

CREATE TABLE `import_gtc` (
  `id` int(15) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `middleName` varchar(30) NOT NULL,
  `s1Status` varchar(250) NOT NULL,
  `currentStatus` varchar(250) NOT NULL,
  `instructions` varchar(250) NOT NULL,
  `unitName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `import_ioaDocs`
--

CREATE TABLE `import_ioaDocs` (
  `id` int(15) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `middleName` varchar(30) NOT NULL,
  `docsRequired` varchar(250) NOT NULL,
  `unitName` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `import_leaveAudit`
--

CREATE TABLE `import_leaveAudit` (
  `id` int(15) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `audit` varchar(250) NOT NULL,
  `unitName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `import_sponsorProgram`
--

CREATE TABLE `import_sponsorProgram` (
  `id` int(15) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `middleName` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `maritalStatus` varchar(15) NOT NULL,
  `children` varchar(15) NOT NULL,
  `afsc` varchar(10) NOT NULL,
  `rnltd` varchar(15) NOT NULL,
  `promoting` varchar(15) NOT NULL,
  `eta` varchar(15) NOT NULL,
  `sponsorRank` varchar(10) NOT NULL,
  `sponsorLastName` varchar(30) NOT NULL,
  `sponsorFirstName` varchar(30) NOT NULL,
  `sponsorMiddleName` varchar(30) NOT NULL,
  `firstContactDate` varchar(15) NOT NULL,
  `milpdsUpdate` varchar(15) NOT NULL,
  `sponsorContactDate` varchar(15) NOT NULL,
  `status` varchar(250) NOT NULL,
  `unitName` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `import_useOrLose`
--

CREATE TABLE `import_useOrLose` (
  `id` int(15) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `middleName` varchar(30) NOT NULL,
  `daysOfLeave` int(5) NOT NULL,
  `notes` varchar(250) NOT NULL,
  `unitName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(16) NOT NULL,
  `unitName` varchar(255) NOT NULL,
  `section` varchar(255) DEFAULT NULL,
  `inventory` varchar(5000) NOT NULL,
  `post_patrol` varchar(255) NOT NULL,
  `submittedBy` varchar(255) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `admin` text NOT NULL,
  `specialAccess` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `middleName` varchar(30) NOT NULL,
  `enterDate` varchar(9) NOT NULL,
  `dodId` varchar(15) NOT NULL,
  `unitName` varchar(30) NOT NULL,
  `secret` varchar(100) NOT NULL,
  `iv` varbinary(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `user_name`, `admin`, `specialAccess`, `password`, `emailAddress`, `lastName`, `firstName`, `middleName`, `enterDate`, `dodId`, `unitName`, `secret`, `iv`) VALUES
(2, 'steve', 'Yes', 'ESS, GTC, GPC', '$2y$10$/RxdQWC98YG6KDZ6aq4Piu.h.RCnXPnEL3cM2dxKRng8Pof80eX0e', '', 'Jobs', 'steve', 'Paul', '25-Jun-02', '5171533293', '412 SFS', '1,Blue', 0x14c145676f2effb5ffc9a5f7efdaecf4),
(3, 'steve_NONADMIN', 'Yes', 'VCO', '$2y$10$mNi6xNnj5eq8oEkb8.OHy.JX6HmM9ddtg1ngkjpVGKSq3f9UzACZG', '', 'Jobs_NONADMIN', 'Steve_NONADMIN', 'Paul', '25-Jun-02', '3', '432 SFS', '1,Blue', 0x14c145676f2effb5ffc9a5f7efdaecf4);

-- --------------------------------------------------------

--
-- Table structure for table `markers`
--

CREATE TABLE `markers` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `address` varchar(80) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `dodId` bigint(15) DEFAULT NULL,
  `lastName` varchar(30) DEFAULT NULL,
  `firstName` varchar(30) DEFAULT NULL,
  `middleName` varchar(30) DEFAULT NULL,
  `rank` varchar(6) DEFAULT NULL,
  `dutySection` varchar(5) DEFAULT NULL,
  `afsc` varchar(8) DEFAULT NULL,
  `address` text,
  `homePhone` varchar(50) DEFAULT NULL,
  `cellPhone` varchar(50) DEFAULT NULL,
  `family` text,
  `birthdate` varchar(20) DEFAULT NULL,
  `admin` varchar(3) DEFAULT NULL,
  `govEmail` varchar(50) DEFAULT NULL,
  `PrsnlEmail` varchar(50) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  `imageDetail` varchar(1) DEFAULT NULL,
  `unitName` varchar(30) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `emailOpt_In` int(1) DEFAULT NULL COMMENT '0 - No; 1- Yes',
  `specialAccess` varchar(255) DEFAULT NULL,
  `deletedBy` varchar(300) DEFAULT NULL,
  `iv` varbinary(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `dodId`, `lastName`, `firstName`, `middleName`, `rank`, `dutySection`, `afsc`, `address`, `homePhone`, `cellPhone`, `family`, `birthdate`, `admin`, `govEmail`, `PrsnlEmail`, `image`, `imageDetail`, `unitName`, `gender`, `emailOpt_In`, `specialAccess`, `deletedBy`, `iv`) VALUES
(2, 5171533293, 'Jobs', 'Steve', 'Paul', 'SMSgt', 'S3OA', '3P091', '', '', '', NULL, NULL, ' No', '', '', NULL, 't', '412 SFS', 'Male', 0, 'ESS, Fitness, GPC, GTC, Supply, VCO, Zeus', NULL, 0x36de1c15dbb48ffb3322c293849d6bce),
(3, 5540235678, 'Morissette', 'Andy', 'autem', 'AB', 'S1', NULL, '', '', '', NULL, '', ' No', '', '', NULL, 't', '412 SFS', 'Male', 0, NULL, NULL, 0xa57d317c2a7efa4d0178fe5e148868e9),
(4, 9899744202, 'Thiel', 'Jamar', 'in', ' SSgt', ' S3OC', NULL, '1393 Audrey Greens Suite 130\nEast Keshawn, MO 81426', NULL, NULL, NULL, NULL, ' No', NULL, NULL, NULL, 't', '412 SFS', 'Female', 1, ' No', NULL, NULL),
(5, 4317540042, 'Will', 'Lea', 'accusamus', 'AB', 'S1', NULL, '', '', '', NULL, '', 'Yes', '', '', NULL, 't', '412 SFS', 'Male', 0, NULL, NULL, 0x48e903cc86ba8e7ce49da526e2adf130),
(6, 9172638452, 'Luettgen', 'Nestor', 'deserunt', ' 2nd L', ' S3OF', NULL, '62316 D\'Amore Way\nKrystalburgh, MT 76802-6003', NULL, NULL, NULL, NULL, 'Yes', NULL, NULL, NULL, 't', '412 SFS', 'Male', 0, ' No', NULL, NULL),
(7, 4252963849, 'Cole', 'Cesar', 'aspernatur', 'AB', 'S1', NULL, '', '', '', NULL, '', 'Yes', '', '', NULL, 't', '412 SFS', '', 0, NULL, NULL, 0xe4b549b2e461a6a72810e936547ee316),
(8, 2124229512, 'Rowe', 'Macy', 'occaecati', 'AB', 'S3', NULL, '', '', '', NULL, '', 'Yes', '', '', NULL, 't', '412 SFS', 'Male', 0, NULL, NULL, 0x3a943419ee1a19f3338ff19b6c6667a5),
(9, 2972420334, 'Waters', 'Esperanza', 'quam', 'AB', 'S1', NULL, '', '', '', NULL, '', ' No', '', '', NULL, 't', '412 SFS', 'Male', 1, NULL, NULL, 0x43d372953a9a31634293dcbc4defdada),
(10, 5092845081, 'Waelchi', 'Corine', 'quos', 'AB', 'S1', NULL, '', '', '', NULL, '', 'Yes', '', '', NULL, 't', '412 SFS', '', 1, NULL, NULL, 0xafce6dbf119a6e9a2c0deea8591c36bb),
(11, 9130800787, 'Konopelski', 'Emanuel', 'aut', ' AMN', ' S3OF', NULL, '6057 Kihn Valley\nBergeport, WA 73346-4888', NULL, NULL, NULL, NULL, ' No', NULL, NULL, NULL, 't', '412 SFS', 'Female', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `miscCerts`
--

CREATE TABLE `miscCerts` (
  `id` int(11) NOT NULL,
  `dodId` int(25) NOT NULL,
  `5ton` varchar(25) NOT NULL,
  `ranger` varchar(25) NOT NULL,
  `raven` varchar(25) NOT NULL,
  `dagr` varchar(25) NOT NULL,
  `leaderLed` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(16) NOT NULL,
  `unitName` varchar(255) NOT NULL,
  `post/patrol` varchar(1000) NOT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `itemName` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `itemDescription` varchar(1000) COLLATE latin1_general_ci NOT NULL,
  `itemJustification` varchar(1000) COLLATE latin1_general_ci NOT NULL,
  `quoteOne` varchar(500) COLLATE latin1_general_ci NOT NULL,
  `quoteTwo` varchar(500) COLLATE latin1_general_ci NOT NULL,
  `quoteThree` varchar(500) COLLATE latin1_general_ci NOT NULL,
  `unitName` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `dutySection` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `submitter` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `dateAdded` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `status` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `notes` varchar(1000) COLLATE latin1_general_ci NOT NULL,
  `dateDeleted` varchar(10) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sfmq`
--

CREATE TABLE `sfmq` (
  `id` int(11) NOT NULL,
  `rank` varchar(6) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `middleName` varchar(30) NOT NULL,
  `dutyQualPos` varchar(15) NOT NULL,
  `primCertDate` varchar(15) NOT NULL,
  `practical` varchar(3) DEFAULT NULL,
  `written` varchar(3) DEFAULT NULL,
  `verbal` varchar(3) DEFAULT NULL,
  `reCertDate` varchar(15) NOT NULL,
  `phase2Start` varchar(30) NOT NULL,
  `newDutyQual` varchar(15) DEFAULT NULL,
  `phase2End` varchar(30) NOT NULL,
  `qcNLT` varchar(15) NOT NULL,
  `nintyDayStart` varchar(15) NOT NULL,
  `deros` varchar(15) NOT NULL,
  `dodId` int(25) NOT NULL,
  `unitName` varchar(30) NOT NULL,
  `phase2_cert` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sfmq_positions`
--

CREATE TABLE `sfmq_positions` (
  `id` int(16) NOT NULL,
  `unitName` varchar(155) NOT NULL,
  `positions` varchar(1000) NOT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `specialAccess`
--

CREATE TABLE `specialAccess` (
  `id` int(16) NOT NULL,
  `unitName` varchar(30) NOT NULL,
  `accessValues` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `specialAccess`
--

INSERT INTO `specialAccess` (`id`, `unitName`, `accessValues`) VALUES
(1, 'Master Listing', 'ESS,GTC,GPC,Fitness,Supply,VCO,Zeus'),
(2, '412 SFS', 'ESS,GTC,GPC,Fitness,Supply,VCO,Zeus'),
(4, '432 SFS', 'ESS,GTC,GPC,Fitness,Supply,VCO,Zeus');

-- --------------------------------------------------------

--
-- Table structure for table `supList`
--

CREATE TABLE `supList` (
  `id` int(11) NOT NULL,
  `dodId` bigint(15) DEFAULT NULL,
  `rank` varchar(9) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `middleName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `superRank` varchar(10) NOT NULL,
  `supFirstName` varchar(30) NOT NULL,
  `supLastName` varchar(30) NOT NULL,
  `supDateBegin` varchar(15) NOT NULL,
  `feedbackCompleted` varchar(15) NOT NULL,
  `unitName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `supply_issue`
--

CREATE TABLE `supply_issue` (
  `id` int(16) NOT NULL,
  `dodID` int(16) DEFAULT NULL,
  `itemStockNumber` varchar(25) DEFAULT NULL,
  `itemIssued` varchar(3) DEFAULT NULL,
  `quantityIssued` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `supply_receiving`
--

CREATE TABLE `supply_receiving` (
  `id` int(16) NOT NULL,
  `unitName` varchar(30) NOT NULL,
  `itemName` varchar(200) NOT NULL,
  `itemDescription` varchar(1000) NOT NULL,
  `itemCost` varchar(25) NOT NULL,
  `itemQuantity` int(9) NOT NULL,
  `quantityType` varchar(11) NOT NULL,
  `modelName` varchar(200) NOT NULL,
  `stockNumber` varchar(15) NOT NULL,
  `manufacturerName` varchar(250) NOT NULL,
  `dateReceived` date NOT NULL,
  `issueType` varchar(25) NOT NULL,
  `initialIssue` varchar(3) NOT NULL,
  `defaultQuantity` int(5) DEFAULT NULL,
  `item_img` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `taskers`
--

CREATE TABLE `taskers` (
  `id` int(10) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `ownerSection` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `suspense` varchar(10) NOT NULL,
  `notes` varchar(1000) NOT NULL,
  `sectionAffected` varchar(30) NOT NULL,
  `unitName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `testDB`
--

CREATE TABLE `testDB` (
  `id` int(11) NOT NULL,
  `dutyPosition` varchar(15) NOT NULL,
  `dutySection` varchar(15) NOT NULL,
  `questionID` int(11) NOT NULL,
  `questionNumber` varchar(250) NOT NULL,
  `testNumber` int(1) NOT NULL,
  `dateAdded` varchar(30) NOT NULL,
  `addedBy` varchar(100) NOT NULL,
  `unitName` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

CREATE TABLE `tracking` (
  `id` int(15) NOT NULL,
  `dateLastLogin` datetime NOT NULL,
  `membersName` varchar(150) NOT NULL,
  `username` varchar(50) NOT NULL,
  `address` varchar(64) NOT NULL,
  `unitName` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `UnitSections`
--

CREATE TABLE `UnitSections` (
  `id` int(25) NOT NULL,
  `unitName` varchar(250) NOT NULL,
  `sectionName` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `UnitSections`
--

INSERT INTO `UnitSections` (`id`, `unitName`, `sectionName`) VALUES
(1, '412 SFS', 'S1, S2, S3, S3OA, S3OB, S3OC, S3OD, S3OE, S4, S5');

-- --------------------------------------------------------

--
-- Table structure for table `vacation`
--

CREATE TABLE `vacation` (
  `id` int(11) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `middleName` varchar(30) NOT NULL,
  `beginDate` date NOT NULL,
  `endDate` date NOT NULL,
  `locationCity` varchar(50) NOT NULL,
  `locationState` varchar(50) NOT NULL,
  `locationCountry` varchar(50) NOT NULL,
  `rank` varchar(8) NOT NULL,
  `dutySection` varchar(6) NOT NULL,
  `dodId` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vehicleEquipment`
--

CREATE TABLE `vehicleEquipment` (
  `id` int(16) NOT NULL,
  `unitName` varchar(30) NOT NULL,
  `equipmentType` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `registration` varchar(25) NOT NULL,
  `modelYear` int(4) NOT NULL,
  `model` varchar(30) NOT NULL,
  `make` varchar(30) NOT NULL,
  `driveType` int(1) NOT NULL,
  `DoorType` int(1) NOT NULL,
  `stickers` int(1) NOT NULL,
  `status` varchar(25) DEFAULT NULL,
  `equipment` varchar(500) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `post` varchar(25) DEFAULT NULL,
  `unitName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles_daily`
--

CREATE TABLE `vehicles_daily` (
  `id` int(11) NOT NULL,
  `registration` varchar(25) NOT NULL,
  `modelYear` int(4) NOT NULL,
  `model` varchar(30) NOT NULL,
  `make` varchar(30) NOT NULL,
  `driveType` int(1) NOT NULL,
  `DoorType` int(1) NOT NULL,
  `stickers` int(1) NOT NULL,
  `status` varchar(25) DEFAULT NULL,
  `equipment` varchar(500) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `post` varchar(25) DEFAULT NULL,
  `mileage` int(15) DEFAULT NULL,
  `lastUpdate` datetime DEFAULT NULL,
  `updatedBy` varchar(250) DEFAULT NULL,
  `unitName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles_img`
--

CREATE TABLE `vehicles_img` (
  `id` int(11) NOT NULL,
  `registration` varchar(250) DEFAULT NULL,
  `img` varchar(250) DEFAULT NULL,
  `imgDetail` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles_mileage`
--

CREATE TABLE `vehicles_mileage` (
  `id` int(11) NOT NULL,
  `registration` varchar(30) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `mileage` int(9) NOT NULL,
  `dutySection` varchar(50) DEFAULT NULL,
  `AF1800` varchar(25) DEFAULT NULL,
  `1800Notes` varchar(1000) DEFAULT NULL,
  `waiverCard` varchar(250) DEFAULT NULL,
  `waiverNotes` varchar(1000) DEFAULT NULL,
  `AF91` varchar(25) DEFAULT NULL,
  `AF518` varchar(25) DEFAULT NULL,
  `post` varchar(50) DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `deadlineReason` varchar(1000) DEFAULT NULL,
  `driverName` varchar(250) DEFAULT NULL,
  `lastUpdate` datetime DEFAULT NULL,
  `updatedBy` varchar(250) DEFAULT NULL,
  `unitName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `workorders`
--

CREATE TABLE `workorders` (
  `id` int(11) NOT NULL,
  `projectName` varchar(200) NOT NULL,
  `projectDescription` varchar(1000) NOT NULL,
  `projectLocation` varchar(100) NOT NULL,
  `projectJustification` varchar(1000) NOT NULL,
  `submitter` varchar(100) NOT NULL,
  `dateAdded` varchar(15) NOT NULL,
  `dutySection` varchar(10) NOT NULL,
  `status` varchar(50) NOT NULL,
  `notes` varchar(1000) NOT NULL,
  `unitName` varchar(25) NOT NULL,
  `dateDeleted` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alarmData`
--
ALTER TABLE `alarmData`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointmentRoster`
--
ALTER TABLE `appointmentRoster`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `armingRoster`
--
ALTER TABLE `armingRoster`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cbtList`
--
ALTER TABLE `cbtList`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cbtList799`
--
ALTER TABLE `cbtList799`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cctkList`
--
ALTER TABLE `cctkList`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `family`
--
ALTER TABLE `family`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fitness`
--
ALTER TABLE `fitness`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `importAppointment`
--
ALTER TABLE `importAppointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `importSFMQ`
--
ALTER TABLE `importSFMQ`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `import_decStatus`
--
ALTER TABLE `import_decStatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `import_eprStatus`
--
ALTER TABLE `import_eprStatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `import_gtc`
--
ALTER TABLE `import_gtc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `import_ioaDocs`
--
ALTER TABLE `import_ioaDocs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `import_leaveAudit`
--
ALTER TABLE `import_leaveAudit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `import_sponsorProgram`
--
ALTER TABLE `import_sponsorProgram`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `import_useOrLose`
--
ALTER TABLE `import_useOrLose`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `markers`
--
ALTER TABLE `markers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `miscCerts`
--
ALTER TABLE `miscCerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sfmq`
--
ALTER TABLE `sfmq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sfmq_positions`
--
ALTER TABLE `sfmq_positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specialAccess`
--
ALTER TABLE `specialAccess`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supList`
--
ALTER TABLE `supList`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supply_issue`
--
ALTER TABLE `supply_issue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supply_receiving`
--
ALTER TABLE `supply_receiving`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taskers`
--
ALTER TABLE `taskers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testDB`
--
ALTER TABLE `testDB`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracking`
--
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `UnitSections`
--
ALTER TABLE `UnitSections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vacation`
--
ALTER TABLE `vacation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicleEquipment`
--
ALTER TABLE `vehicleEquipment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles_daily`
--
ALTER TABLE `vehicles_daily`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles_img`
--
ALTER TABLE `vehicles_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles_mileage`
--
ALTER TABLE `vehicles_mileage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workorders`
--
ALTER TABLE `workorders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alarmData`
--
ALTER TABLE `alarmData`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointmentRoster`
--
ALTER TABLE `appointmentRoster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `armingRoster`
--
ALTER TABLE `armingRoster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cbtList`
--
ALTER TABLE `cbtList`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cbtList799`
--
ALTER TABLE `cbtList799`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cctkList`
--
ALTER TABLE `cctkList`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `family`
--
ALTER TABLE `family`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fitness`
--
ALTER TABLE `fitness`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `importAppointment`
--
ALTER TABLE `importAppointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `importSFMQ`
--
ALTER TABLE `importSFMQ`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `import_decStatus`
--
ALTER TABLE `import_decStatus`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `import_eprStatus`
--
ALTER TABLE `import_eprStatus`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `import_gtc`
--
ALTER TABLE `import_gtc`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `import_ioaDocs`
--
ALTER TABLE `import_ioaDocs`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `import_leaveAudit`
--
ALTER TABLE `import_leaveAudit`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `import_sponsorProgram`
--
ALTER TABLE `import_sponsorProgram`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `import_useOrLose`
--
ALTER TABLE `import_useOrLose`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `markers`
--
ALTER TABLE `markers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `miscCerts`
--
ALTER TABLE `miscCerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sfmq`
--
ALTER TABLE `sfmq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sfmq_positions`
--
ALTER TABLE `sfmq_positions`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `specialAccess`
--
ALTER TABLE `specialAccess`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `supList`
--
ALTER TABLE `supList`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supply_issue`
--
ALTER TABLE `supply_issue`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supply_receiving`
--
ALTER TABLE `supply_receiving`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taskers`
--
ALTER TABLE `taskers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testDB`
--
ALTER TABLE `testDB`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tracking`
--
ALTER TABLE `tracking`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `UnitSections`
--
ALTER TABLE `UnitSections`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vacation`
--
ALTER TABLE `vacation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicleEquipment`
--
ALTER TABLE `vehicleEquipment`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicles_daily`
--
ALTER TABLE `vehicles_daily`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicles_img`
--
ALTER TABLE `vehicles_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicles_mileage`
--
ALTER TABLE `vehicles_mileage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workorders`
--
ALTER TABLE `workorders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
