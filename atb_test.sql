-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 18, 2019 at 09:27 AM
-- Server version: 5.7.24
-- PHP Version: 7.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `atb_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `email` varchar(50) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`email`, `token`, `expire`) VALUES
('dungna@kayac.vn', 'e7199a86b42e7fd0674f666b59fb9af72e71ac2b574dca9711626bcebdb48f4c', 1550567595);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `email` varchar(50) NOT NULL,
  `password` varchar(512) NOT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `password`, `full_name`, `tel`, `address`, `created`, `modified`) VALUES
('abc@abc.com', '$2y$10$cd6qe2J5AJw9l1mOus/5Sebf0e.Pua.DGwYbuq23xdjnvZwyDiZ9.', 'test', 'character 123  text ', '', '2019-02-17 12:40:36', '2019-02-17 05:40:36'),
('david113@test.com', '$2y$10$bZ2YNtagYt88lQMTu8mCN.rXC0XeyrhBD4VHdP/lYqoCK0ljM7L4O', 'David Nguyen', '+849123456789', 'Hanoi, Vietnam', '2019-02-18 15:58:17', '2019-02-18 08:58:17'),
('david11@test.com', '$2y$10$6G5x/HRyyrk7OOd564k6qODA.pWiee2QFumNLnWolbSP59NJj9sbS', 'David Nguyen', '+849123456789', 'Hanoi, Vietnam', '2019-02-18 15:31:08', '2019-02-18 08:31:08'),
('david1@test.com', '$2y$10$sR/OIirOOeKpdzV.lo6nsOebSuQd4zp3d2Q.CRxgK16dBS76zxFDC', '', '+849123456789', 'Hanoi, Vietnam', '2019-02-18 11:02:07', '2019-02-18 04:02:07'),
('david@test.com', '$2y$10$U9d1mt/vQyjLJqQcyKhCHuBO8/VQuMr8B88pUkoa0OBDE.JZgi7Pq', 'David Nguyen', '+849123456789', 'Hanoi, Vietnam', '2019-02-18 11:02:21', '2019-02-18 04:02:21'),
('dung.na@kayac.vn', '$2y$10$QBefHCcKOIyAoogZigKl4.1CnTqoy2h9yCL/vbREZPHkvt8UT2Bl6', '', '', '', '2019-02-17 16:46:43', '2019-02-17 09:46:43'),
('dungna1@kayac.vn', '$2y$10$s1UCQrRuj/qiA9sa0FB7M./sIbMFPQsURdM4keom4YgbMo0FTfOq.', '', '', '', '2019-02-18 10:28:48', '2019-02-18 03:28:48'),
('dungna@kayac.vn', '$2y$10$gZLCaZPs8Ta1W09it4DWiueyoimtCPpCFGDiRsK1EsuJ51W1c4BM.', 'DungNA2', '+840935200288', 'Hanoi, Vietnam', '2019-02-17 16:47:36', '2019-02-18 09:07:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `token` (`token`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
