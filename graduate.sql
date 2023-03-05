-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2020 at 09:29 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `graduate`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Cat_id` int(11) NOT NULL,
  `Cat_Name` varchar(255) NOT NULL,
  `Cat_Description` varchar(255) NOT NULL,
  `Cat_Crafting_number` int(11) DEFAULT NULL COMMENT 'numbercrafting in each castegory'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Cat_id`, `Cat_Name`, `Cat_Description`, `Cat_Crafting_number`) VALUES
(1, 'cars technicals', 'Mechanic - Technical Car electrician -  car tyres - .....', NULL),
(2, 'Electrician  Technicals', 'This Section contains all craftings to fix Electronic Tools', NULL),
(3, 'Furniture', 'This Section To Fix all Home  Furniture Or Tools That contains Wood   ', NULL),
(4, 'Paints', 'This Section Contain Paints Craftsmen That you Need ', NULL),
(6, 'Sanitary ware', 'Contains All Craftsmen that fix or pring the Sanitary ware', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chatroom`
--

CREATE TABLE `chatroom` (
  `message_id` int(11) NOT NULL,
  `message_content` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chatroom`
--

INSERT INTO `chatroom` (`message_id`, `message_content`, `user_name`) VALUES
(12, 'hello I\'m looking for mechanic', 'Mohamed'),
(13, 'Hello Craftsmen I\'m Looking for a Plumper', 'ibrahem'),
(14, 'hello l\'m need carpanter', 'mahmoud');

-- --------------------------------------------------------

--
-- Table structure for table `craftsmen`
--

CREATE TABLE `craftsmen` (
  `Craft_ID` int(11) NOT NULL,
  `Craft_age` int(11) NOT NULL,
  `Craft_Phone` int(11) NOT NULL,
  `Crafting_name` varchar(255) NOT NULL,
  `Craft_description` text NOT NULL,
  `Craft_locations` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `craftsmen`
--

INSERT INTO `craftsmen` (`Craft_ID`, `Craft_age`, `Craft_Phone`, `Crafting_name`, `Craft_description`, `Craft_locations`, `user_id`, `cat_id`) VALUES
(1, 25, 1236548950, 'Plumber', 'To fix all tools ', 'zagazig', 2, 6),
(2, 30, 1265486222, 'carpanter', 'To fix all too that made of wood and make and design tools with wood', 'zagazig', 3, 3),
(3, 39, 1233365881, 'artiest', 'to art all picture on wall', 'zagazig', 4, 4),
(4, 41, 1265486222, 'Plumber', 'To fix all tools ', 'zagazig', 5, 6),
(5, 28, 1236548950, 'technical', 'Models of cars', 'zagazig', 6, 6),
(6, 29, 1236548950, 'technical', 'Models of cars', 'zagazig', 8, 6),
(7, 33, 2147483647, 'carpanter', 'to make a good design with wood and made  char   and other tools', 'zagazig', 11, 3);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `rate_id` int(11) NOT NULL,
  `rate_num` int(11) NOT NULL,
  `craft_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`rate_id`, `rate_num`, `craft_id`) VALUES
(1, 1, 2),
(2, 1, 2),
(3, 1, 6),
(4, 2, 6),
(5, 4, 1),
(6, 2, 4),
(7, 5, 4),
(8, 5, 6),
(9, 5, 2),
(10, 5, 6),
(11, 3, 6),
(12, 1, 5),
(13, 5, 6),
(14, 3, 2),
(15, 3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_id` int(11) NOT NULL,
  `User_Name` varchar(255) NOT NULL,
  `Full_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_Address` text NOT NULL,
  `date` date NOT NULL,
  `conditions` int(11) NOT NULL DEFAULT 0,
  `verify` int(11) NOT NULL DEFAULT 0,
  `Reg_status` int(11) NOT NULL DEFAULT 0,
  `user_avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_id`, `User_Name`, `Full_name`, `user_email`, `user_password`, `user_Address`, `date`, `conditions`, `verify`, `Reg_status`, `user_avatar`) VALUES
(1, 'Abdallah', 'Abdalrahman', 'abdallahabdelrahman186@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '5.block.elgash.st.zag.egypt', '2020-02-26', 1, 0, 1, ''),
(2, 'Mohamed', 'Ahmed', 'mohamed_545@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '1.block.main.st.zag.egypt', '2020-02-27', 1, 0, 0, '1_avatar-16.png'),
(3, 'ElSayed', 'Ahmed', 'eksayed_54@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '15.block.mais.zag.cairo', '2020-02-28', 1, 0, 0, '3838'),
(4, 'Mohamed', 'Essam', 'mohamed_89@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '98.bloc.5Elsalame.st.zag.cairo', '2020-02-28', 1, 0, 0, '6061_salah.jpg'),
(5, 'Turki', 'Zaeen', 'turkizaeen25@yahoo.com', '601f1889667efaebb33b8c12572835da3f027f78', '32.block.98.elhoreya.elryaed.soudiarabia', '2020-02-28', 1, 0, 0, '1578_17201064_438170739862492_4429038526650425068_n.jpg'),
(6, 'Ahmed', 'mohamed', 'Ahmedmohamed98@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '98.block.elsalane.st.elmosque.city.cairo', '2020-02-28', 1, 0, 0, '6269_23435011_10155491530173127_3447823635734473338_n.jpg'),
(7, 'Khaled', 'Elsayed', 'khaled15@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '32.elzhooer.zag.', '2020-03-15', 1, 0, 0, '4823_avatar-16.png'),
(8, 'ibrahem', 'tresazq', 'ibra_tre198@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '98.block.4st.elhorya.zag.cairo', '2020-03-15', 1, 0, 0, '1163_10985870_757047221081905_1731789428520711165_n.jpg'),
(9, 'moaez', 'ahmed', 'moazhaset18@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '5.block.elgash.st.zag.egypt', '2020-03-15', 1, 0, 0, '8147_almastba.com_1385799035_799.jpg'),
(10, 'omar', 'mohamed', 'omarahme18@gmail.com', 'a70deade6cecb1b7b2e121a479ec00dee61c8018', '32.elzhooer.zag', '2020-03-15', 1, 0, 0, '537_7555.jpg'),
(11, 'mahmoud', 'Omar', 'mahmoudomar15@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '15.block.alhoreya.cairo.city', '2020-03-16', 1, 0, 0, '8372_10291696_647431715339542_5920998893091013606_n.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Cat_id`);

--
-- Indexes for table `chatroom`
--
ALTER TABLE `chatroom`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `craftsmen`
--
ALTER TABLE `craftsmen`
  ADD PRIMARY KEY (`Craft_ID`),
  ADD KEY `craft_user_id` (`user_id`),
  ADD KEY `craft_categories` (`cat_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`rate_id`),
  ADD KEY `ratng` (`craft_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chatroom`
--
ALTER TABLE `chatroom`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `craftsmen`
--
ALTER TABLE `craftsmen`
  MODIFY `Craft_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `craftsmen`
--
ALTER TABLE `craftsmen`
  ADD CONSTRAINT `craft_categories` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`Cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `craft_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`User_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `ratng` FOREIGN KEY (`craft_id`) REFERENCES `craftsmen` (`Craft_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
