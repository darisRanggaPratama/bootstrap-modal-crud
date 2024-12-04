-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 04, 2024 at 07:11 AM
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
(1, '7001', 'Son Goku', 4000000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(2, '7002', 'Okarun', 4100000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(3, '7003', 'Momo Ayase', 4200000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(4, '7004', 'Aira Shiratori', 4300000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(5, '7005', 'Rudeus Greyrat', 4400000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(6, '7006', 'Roxy Migurdia', 4500000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(7, '7007', 'Eris Boreas Greyrat', 4600000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(8, '7008', 'Banagher Links', 4700000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(9, '7009', 'Mineva Lao Zabi', 4800000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(10, '7010', 'Full Frontal', 4900000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(11, '7011', 'Marida Cruz', 5000000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(12, '7012', 'Takuya Irei', 5100000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(13, '7013', 'Micott Bartsch', 5200000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(14, '7014', 'Alberto Vist', 5300000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(15, '7015', 'Cardeas Vist', 5400000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(16, '7016', 'Angelo Sauper', 5500000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(17, '7017', 'Suberoa Zinnerman', 5600000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(18, '7018', 'Gael Chan', 5700000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(19, '7019', 'Heero Yuy', 5800000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(20, '7020', 'Duo Maxwell', 5900000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(21, '7021', 'Trowa Barton', 6000000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(22, '7022', 'Quatre Raberba Winner', 6100000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(23, '7023', 'Chang Wufei', 6200000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(24, '7024', 'Relena Peacecraft', 6300000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(25, '7025', 'Zack Marqueze', 6400000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(26, '7026', 'Lady Une', 6500000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(27, '7027', 'Treize Khushrenada', 6600000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(28, '7028', 'Sally Po', 6700000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(29, '7029', 'Catherine Bloom', 6800000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(30, '7030', 'Howard', 6900000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(31, '7031', 'Dekim Barton', 7000000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(32, '7032', 'Taichi \"Tai\" Kamiya', 7100000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(33, '7033', 'Yamato \"Matt\" Ishida', 7200000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(34, '7034', 'Sora Takenouchi', 7300000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(35, '7035', 'Koushiro \"Izzy\" Izumi', 7400000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(36, '7036', 'Mimi Tachikawa', 7500000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(37, '7037', 'Joe Kido', 7600000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(38, '7038', 'Takeru \"T.K.\" Takaishi', 7700000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(39, '7039', 'Hikari \"Kari\" Kamiya', 7800000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(40, '7040', 'Seiya', 7900000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(41, '7041', 'Shiryu', 8000000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(42, '7042', 'Hyoga', 8100000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(43, '7043', 'Shun', 8200000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(44, '7044', 'Ikki', 8300000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(45, '7045', 'Saori Kido (Athena)', 8400000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(46, '7046', 'Aiolia (Leo Gold Saint)', 8500000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(47, '7047', 'Saga (Gemini Gold Saint)', 8600000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(48, '7048', 'Kanon (Gemini Gold Saint)', 8700000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(49, '7049', 'Mu (Aries Gold Saint)', 8800000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(50, '7050', 'Shaka (Virgo Gold Saint)', 8900000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(51, '7051', 'Milo (Scorpio Gold Saint)', 9000000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(52, '7052', 'Camus (Aquarius Gold Saint)', 9100000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(53, '7053', 'Aphrodite (Pisces Gold Saint)', 9200000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(54, '7054', 'Aldebaran (Taurus Gold Saint)', 9300000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(55, '7055', 'Aiolos (Sagittarius Gold Saint)', 9400000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(56, '7056', 'Deathmask (Cancer Gold Saint)', 9500000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(57, '7057', 'Shura (Capricorn Gold Saint)', 9600000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(58, '7058', 'Dohko (Libra Gold Saint)', 9700000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(59, '7059', 'Ranma Saotome', 9800000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(60, '7060', 'Akane Tendo', 9900000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(61, '7061', 'Soun Tendo', 10000000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(62, '7062', 'Genma Saotome', 10100000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(63, '7063', 'Nodoka Saotome', 10200000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(64, '7064', 'Nabiki Tendo', 10300000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(65, '7065', 'Kasumi Tendo', 10400000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(66, '7066', 'Shampoo', 10500000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(67, '7067', 'Cologne (Obaba)', 10600000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(68, '7068', 'Ryoga Hibiki', 10700000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(69, '7069', 'Tatewaki Kuno', 10800000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(70, '7070', 'Kodachi Kuno', 10900000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(71, '7071', 'Ukyo Kuonji', 11000000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(72, '7072', 'Hikaru Gosunkugi', 11100000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(73, '7073', 'Mousse', 11200000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(74, '7074', 'Happosai', 11300000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(75, '7075', 'Principal Kuno', 11400000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(76, '7076', 'Iron Cat', 11500000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(77, '7077', 'Ichigo Kurosaki', 11600000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(78, '7078', 'Rukia Kuchiki', 11700000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(79, '7079', 'Orihime Inoue', 11800000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(80, '7080', 'Uryu Ishida', 11900000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(81, '7081', 'Yasutora \"Chad\" Sado', 12000000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(82, '7082', 'Kisuke Urahara', 12100000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(83, '7083', 'Yoruichi Shihouin', 12200000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(84, '7084', 'Renji Abarai', 12300000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(85, '7085', 'Byakuya Kuchiki', 12400000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(86, '7086', 'Toshiro Hitsugaya', 12500000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(87, '7087', 'Kenpachi Zaraki', 12600000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(88, '7088', 'Mayuri Kurotsuchi', 12700000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(89, '7089', 'Jushiro Ukitake', 12800000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(90, '7090', 'Shunsui Kyoraku', 12900000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(91, '7091', 'Retsu Unohana', 13000000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(92, '7092', 'Grimmjow Jaegerjaquez', 13100000, 0, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(93, '7093', 'Ulquiorra Cifer', 13200000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(94, '7094', 'Sosuke Aizen', 13300000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(95, '7095', 'Gin Ichimaru', 13400000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(96, '7096', 'Kaname Tosen', 13500000, 0, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(97, '5111', 'Loid Forger', 13600000, 100000, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(98, '5112', 'Yor Forger', 13700000, 110000, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(99, '5113', 'Anya Forger', 13800000, 120000, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(100, '5114', 'Bond Forger', 13900000, 130000, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(101, '5115', 'Franky Franklin', 14000000, 140000, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(102, '5116', 'Sylvia Sherwood', 14100000, 150000, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(103, '5117', 'Damian Desmond', 14200000, 160000, 0, 0, 0, 0, 0, 0, 0, 'TK/1'),
(104, '5118', 'Becky Blackbell', 14300000, 170000, 0, 0, 0, 0, 0, 0, 0, 'TK/0'),
(105, '5119', 'Henry Henderson', 14400000, 180000, 0, 0, 0, 0, 0, 0, 0, 'K/3'),
(106, '5120', 'Donovan Desmond', 14500000, 190000, 0, 0, 0, 0, 0, 0, 0, 'K/2'),
(107, '5121', 'Yuri Briar', 14600000, 200000, 0, 0, 0, 0, 0, 0, 0, 'K/1'),
(108, '5122', 'Fiona Frost', 14700000, 210000, 0, 0, 0, 0, 0, 0, 0, 'K/0'),
(109, '5123', 'Millie', 14800000, 220000, 0, 0, 0, 0, 0, 0, 0, 'TK/3'),
(110, '5124', 'Dominic', 14900000, 230000, 0, 0, 0, 0, 0, 0, 0, 'TK/2'),
(111, '5125', 'Ewen Egeburg', 15000000, 240000, 0, 0, 0, 0, 0, 0, 0, 'TK/1');

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
