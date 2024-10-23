-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 06:43 PM
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
-- Database: `utslec`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_akhir` time NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `status_toogle` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `nama`, `deskripsi`, `kapasitas`, `lokasi`, `tgl_mulai`, `tgl_akhir`, `waktu_mulai`, `waktu_akhir`, `gambar`, `status_toogle`) VALUES
(1, 'vsdvdv', 'dsdf', 123, '2dsd', '2024-10-23', '2024-10-30', '00:00:00', '01:00:00', 'user-profile-icon-free-vector.jpg', 1),
(2, 'saf', 'v', 234, 'vdv', '2024-10-29', '2024-10-30', '00:00:00', '00:00:00', 'bg.jpg', 1),
(3, 'dfanhsejfcaejnfdfanhsejfcaejnfdfanhsejfcaejnfdfanh', 'dfanhsejfcaejnfdfanhsejfcaejnfdfanhs ejfcaejnfdfanhsejfcaejnfdfanh sejfcaejnfdfanhsejfcaejnfdfanhsej', 123123, 'Jl. Husein Sastranegara No.109, RT.008/RW.008, Jurumudi, Kec. Benda, Kota Tangerang, Banten 15124', '2024-10-23', '2024-10-23', '00:00:00', '00:42:00', 'bg.jpg', 1),
(4, 'asdf', 'c', 123, 'cd', '2024-10-23', '2024-10-23', '00:00:00', '00:43:00', 'bg.jpg', 1),
(5, 'sadf', 'sadfasf', 213123, 'sdf', '2024-10-23', '2024-10-23', '00:00:00', '01:00:00', 'bg.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_participants`
--

CREATE TABLE `event_participants` (
  `participant_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_participants`
--

INSERT INTO `event_participants` (`participant_id`, `user_id`, `event_id`) VALUES
(6, 3, 2),
(7, 11, 4),
(8, 11, 3),
(9, 11, 4),
(10, 9, 3),
(11, 8, 2),
(12, 10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `email`, `nama`) VALUES
(3, '1123', '12', '321', '2'),
(8, '123ads', 'dasedas', 'adsedasd', 'cadea'),
(9, '1312eedasedae', 'asdad', 'casecdas', 'casd'),
(10, 'scdas', 'acsdfa', 'acsf', 'ace'),
(11, '2ecwasxdwa323', 'axedxa', 'xasefasxe', 'afefaefsfasef');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `event_participants`
--
ALTER TABLE `event_participants`
  ADD PRIMARY KEY (`participant_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event_participants`
--
ALTER TABLE `event_participants`
  MODIFY `participant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_participants`
--
ALTER TABLE `event_participants`
  ADD CONSTRAINT `event_participants_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `event_participants_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
