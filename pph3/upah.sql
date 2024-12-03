-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 29, 2024 at 02:11 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `avengers`
--

-- --------------------------------------------------------

--
-- Table structure for table `upah`
--

CREATE TABLE `upah` (
  `id` int UNSIGNED NOT NULL,
  `nik` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gaji` int UNSIGNED NOT NULL DEFAULT '0',
  `hadir_pusat` int UNSIGNED NOT NULL DEFAULT '0',
  `hadir_proyek` int UNSIGNED NOT NULL DEFAULT '0',
  `konsumsi` int UNSIGNED NOT NULL DEFAULT '0',
  `lembur` int UNSIGNED NOT NULL DEFAULT '0',
  `tunjang_lain` int UNSIGNED NOT NULL DEFAULT '0',
  `jkk` int UNSIGNED NOT NULL DEFAULT '0',
  `jkm` int UNSIGNED NOT NULL DEFAULT '0',
  `sehat` int UNSIGNED NOT NULL DEFAULT '0',
  `ptkp` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `upah`
--

INSERT INTO `upah` (`id`, `nik`, `name`, `gaji`, `hadir_pusat`, `hadir_proyek`, `konsumsi`, `lembur`, `tunjang_lain`, `jkk`, `jkm`, `sehat`, `ptkp`) VALUES
(1, '7001', 'Son Goku', 1000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(2, '7002', 'Okarun', 1001, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(3, '7003', 'Momo Ayase', 1002, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(4, '7004', 'Aira Shiratori', 1003, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(5, '7005', 'Rudeus Greyrat', 1004, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(6, '7006', 'Roxy Migurdia', 1005, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(7, '7007', 'Eris Boreas Greyrat', 1006, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(8, '7008', 'Banagher Links', 1007, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(9, '7009', 'Mineva Lao Zabi', 1008, 0, 0, 0, 0, 0, 0, 0, 0, 'K1'),
(10, '7010', 'Full Frontal', 1009, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(11, '7011', 'Marida Cruz', 1010, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(12, '7012', 'Takuya Irei', 1011, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(13, '7013', 'Micott Bartsch', 1012, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(14, '7014', 'Alberto Vist', 1013, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(15, '7015', 'Cardeas Vist', 1014, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(16, '7016', 'Angelo Sauper', 1015, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(17, '7017', 'Suberoa Zinnerman', 1016, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(18, '7018', 'Gael Chan', 1017, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(19, '7019', 'Heero Yuy', 1018, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(20, '7020', 'Duo Maxwell', 1019, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(21, '7021', 'Trowa Barton', 1020, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(22, '7022', 'Quatre Raberba Winner', 1021, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(23, '7023', 'Chang Wufei', 1022, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(24, '7024', 'Relena Peacecraft', 1023, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(25, '7025', 'Zack Marqueze', 1024, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(26, '7026', 'Lady Une', 1025, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(27, '7027', 'Treize Khushrenada', 1026, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(28, '7028', 'Sally Po', 1027, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(29, '7029', 'Catherine Bloom', 1028, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(30, '7030', 'Howard', 1029, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(31, '7031', 'Dekim Barton', 1030, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(32, '7032', 'Taichi \"Tai\" Kamiya', 1031, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(33, '7033', 'Yamato \"Matt\" Ishida', 1032, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(34, '7034', 'Sora Takenouchi', 1033, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(35, '7035', 'Koushiro \"Izzy\" Izumi', 1034, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(36, '7036', 'Mimi Tachikawa', 1035, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(37, '7037', 'Joe Kido', 1036, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(38, '7038', 'Takeru \"T.K.\" Takaishi', 1037, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(39, '7039', 'Hikari \"Kari\" Kamiya', 1038, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(40, '7040', 'Seiya', 1039, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(41, '7041', 'Shiryu', 1040, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(42, '7042', 'Hyoga', 1041, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(43, '7043', 'Shun', 1042, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(44, '7044', 'Ikki', 1043, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(45, '7045', 'Saori Kido (Athena)', 1044, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(46, '7046', 'Aiolia (Leo Gold Saint)', 1045, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(47, '7047', 'Saga (Gemini Gold Saint)', 1046, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(48, '7048', 'Kanon (Gemini Gold Saint)', 1047, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(49, '7049', 'Mu (Aries Gold Saint)', 1048, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(50, '7050', 'Shaka (Virgo Gold Saint)', 1049, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(51, '7051', 'Milo (Scorpio Gold Saint)', 1050, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(52, '7052', 'Camus (Aquarius Gold Saint)', 1051, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(53, '7053', 'Aphrodite (Pisces Gold Saint)', 1052, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(54, '7054', 'Aldebaran (Taurus Gold Saint)', 1053, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(55, '7055', 'Aiolos (Sagittarius Gold Saint)', 1054, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(56, '7056', 'Deathmask (Cancer Gold Saint)', 1055, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(57, '7057', 'Shura (Capricorn Gold Saint)', 1056, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(58, '7058', 'Dohko (Libra Gold Saint)', 1057, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(59, '7059', 'Ranma Saotome', 1058, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(60, '7060', 'Akane Tendo', 1059, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(61, '7061', 'Soun Tendo', 1060, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(62, '7062', 'Genma Saotome', 1061, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(63, '7063', 'Nodoka Saotome', 1062, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(64, '7064', 'Nabiki Tendo', 1063, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(65, '7065', 'Kasumi Tendo', 1064, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(66, '7066', 'Shampoo', 1065, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(67, '7067', 'Cologne (Obaba)', 1066, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(68, '7068', 'Ryoga Hibiki', 1067, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(69, '7069', 'Tatewaki Kuno', 1068, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(70, '7070', 'Kodachi Kuno', 1069, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(71, '7071', 'Ukyo Kuonji', 1070, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(72, '7072', 'Hikaru Gosunkugi', 1071, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(73, '7073', 'Mousse', 1072, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(74, '7074', 'Happosai', 1073, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(75, '7075', 'Principal Kuno', 1074, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(76, '7076', 'Iron Cat', 1075, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(77, '7077', 'Ichigo Kurosaki', 1076, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(78, '7078', 'Rukia Kuchiki', 1077, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(79, '7079', 'Orihime Inoue', 1078, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(80, '7080', 'Uryu Ishida', 1079, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(81, '7081', 'Yasutora \"Chad\" Sado', 1080, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(82, '7082', 'Kisuke Urahara', 1081, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(83, '7083', 'Yoruichi Shihouin', 1082, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(84, '7084', 'Renji Abarai', 1083, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(85, '7085', 'Byakuya Kuchiki', 1084, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(86, '7086', 'Toshiro Hitsugaya', 1085, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(87, '7087', 'Kenpachi Zaraki', 1086, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(88, '7088', 'Mayuri Kurotsuchi', 1087, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(89, '7089', 'Jushiro Ukitake', 1088, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(90, '7090', 'Shunsui Kyoraku', 1089, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(91, '7091', 'Retsu Unohana', 1090, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(92, '7092', 'Grimmjow Jaegerjaquez', 1091, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(93, '7093', 'Ulquiorra Cifer', 1092, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(94, '7094', 'Sosuke Aizen', 1093, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(95, '7095', 'Gin Ichimaru', 1094, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(96, '7096', 'Kaname Tosen', 1095, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `upah`
--
ALTER TABLE `upah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD KEY `idx_name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `upah`
--
ALTER TABLE `upah`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
