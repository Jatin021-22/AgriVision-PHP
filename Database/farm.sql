-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2024 at 09:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `farm`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogdata`
--

CREATE TABLE `blogdata` (
  `blogId` int(10) NOT NULL,
  `bloguser` varchar(256) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `blogTitle` varchar(256) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `blogContent` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `blogTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `likes` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogdata`
--

INSERT INTO `blogdata` (`blogId`, `bloguser`, `blogTitle`, `blogContent`, `blogTime`, `likes`) VALUES
(1, 'Jatin', 'Farming', 'Farming is the future.', '2024-09-30 09:00:42', 7),
(4, 'Jatin', 'Hydroponics and Vertical Farming', ' As traditional farming faces challenges from climate change and resource scarcity, innovative methods like hydroponics and vertical farming are gaining traction. Hydroponics allows for soil-less cultivation, which can enhance yields and reduce water usage. Vertical farming utilizes stacked layers to maximize space, enabling food production in urban areas and reducing transportation costs?', '2024-10-08 11:47:01', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentId` int(11) NOT NULL,
  `blogId` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `commentTime` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`commentId`, `blogId`, `username`, `comment`, `commentTime`) VALUES
(1, 1, '_tank_jatin_', 'hellow this is best blog\r\n', '2024-10-05 11:46:24'),
(2, 4, 'Jatin Prajapati', 'This is very useful blog', '2024-10-08 17:19:49');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `document` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `time`, `date`, `document`, `created_at`) VALUES
(6, 'krushi prabhat', 'krushi prabhat', '14:05:00', '2024-10-12', '../uploads/ખેડૂતોનું એકમાત્ર દૈનિક અખબાર કૃષિ પ્રભાત 01-10-24.pdf', '2024-10-05 08:30:52'),
(8, 'Krushi Prabhat', 'Krushi Prabhat', '08:35:00', '2024-10-14', '../uploads/ખેડૂતોનું એકમાત્ર દૈનિક અખબાર કૃષિ પ્રભાત 02-10-24.pdf', '2024-10-14 03:05:38');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `product_id`, `user_id`, `quantity`, `created_at`) VALUES
(10, 13, 1, 1, '2024-10-09 11:46:03'),
(11, 13, 1, 1, '2024-10-10 02:51:54'),
(12, 12, 1, 1, '2024-10-10 15:52:02'),
(13, 12, 1, 1, '2024-10-10 16:22:36'),
(14, 13, 1, 1, '2024-10-11 06:31:36');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productid` int(11) NOT NULL,
  `productname` varchar(255) NOT NULL,
  `productprice` decimal(10,2) NOT NULL,
  `productdescription` text DEFAULT NULL,
  `productphoto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productid`, `productname`, `productprice`, `productdescription`, `productphoto`) VALUES
(12, 'cherry', 45.00, 'fress cherry', 'uploads/img2/cherries-6308871_1920.jpg'),
(13, 'Orange', 23.00, 'Fress Orange ', 'uploads/img2/oranges-8193789_1920.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pincode` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `confirm_password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `name`, `username`, `password`, `address`, `pincode`, `email`, `phone`, `gender`, `confirm_password`) VALUES
(5, 'prajaptijatin', 'tank_jatin', '$2y$10$a8XS85zTbzNmD3Pkw5HzJuvYsa.g5rsBiGCZCf15aCbHDttVJceSm', 'sapakda', '363330', 'tank@gmail.com', '6953719345', 'Male', NULL),
(6, 'admin', 'admin', '$2y$10$frnmxVRJXQLYrrA9ieG7duSV6nnfaw2xrRSwvgwT8gPWaw78ypzMG', 'admin houces', '363330', 'admin@gmail.com', '6561495786', 'Male', NULL),
(7, 'jppp', 'jpp', '$2y$10$hHn3jQiu4qCmZ3rrNFwVPeDcOK8nUbUsLFKDENu9g.i6SDpfi2Lne', 'sapakda', '363330', 'jpp@gmail.com', '6353719654', 'Male', NULL),
(10, 'jatinp', 'jatin_p', '$2y$10$NlPEbAEfCdoRKkrIqpPOpOIpamy9DWV2PMNE8s7YUFRPTXN743wWO', 'sapakda', '363330', 'jatinprajapati@gmail.com', '6353719654', 'Male', NULL),
(12, 'jatin', 'jatinP', '$2y$10$yN4SK/rSimBVmfE.LqhElu0PjJYJpyXtsZBXQSgdaltQvQwbhRVhO', 'sapakda halvad ', '363330', 'jatinprajapati021@gmail.com', '6353719645', 'Male', NULL),
(14, 'Jatin', 'jatin_tank_', '$2y$10$C/cBc29LpS0cMJMBNSMd8.VpBziyFLLosS.oyNK29sBwag.nHDW8e', 'sapakda halvad', '363330', 'Jatin_prajapati_@gmail.com', '6353719645', 'Male', NULL),
(15, 'jatin', 'PrajapatiJatin', '$2y$10$bbb8jveFbGmLsEamIbDkruCaguHrpW9m2Ns/y9c0aXtO5Uk2XhWMK', 'sapakda halvad', '363330', 'jatinprajapati028@gmail.com', '6353719645', 'Male', NULL),
(20, 'Jatin', 'Jatin Prajapati', '$2y$10$XTOhpAF6FiT/PBZdFT7PyegVsHNoXnsZFs39i57ioLb3k/019Xhuu', 'sapakda halvad', '363330', 'tnjtin@gmail.com', '6353749545', 'Male', NULL),
(21, 'jignesh nayakpara', 'jignesh', '$2y$10$FfQ9hIg6Cyf.L0gSe3VKDeBjPMp68kLKQP1F15ML/CVy4cKnvevdK', 'at halvad', '363330', 'jignesh@gmail.com', '9724788876', 'Male', NULL),
(22, 'murli', 'murli prasad', '$2y$10$aoZCwoVGVYhPSUTbUzAX.OSRzxo1tIkmTcl3ueKoZr.AvpYDTmFBO', 'sapakda', '363330', 'murli_prasad@gmail.com', '9665655659', 'Male', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userid`, `username`, `password`, `created_at`) VALUES
(3, 6, 'admin', '$2y$10$frnmxVRJXQLYrrA9ieG7duSV6nnfaw2xrRSwvgwT8gPWaw78ypzMG', '2024-10-03 09:30:55'),
(10, 18, '', '$2y$10$pCq4Oe.8IRiOoKN.izqF.ebbrk4vMf7EYwtd.1e.vsWgbwMbOe8ty', '2024-10-06 03:59:58'),
(12, 20, 'Jatin Prajapati', '$2y$10$XTOhpAF6FiT/PBZdFT7PyegVsHNoXnsZFs39i57ioLb3k/019Xhuu', '2024-10-09 11:06:12'),
(13, 21, 'jignesh', '$2y$10$FfQ9hIg6Cyf.L0gSe3VKDeBjPMp68kLKQP1F15ML/CVy4cKnvevdK', '2024-10-10 02:49:24'),
(14, 22, 'murli prasad', '$2y$10$aoZCwoVGVYhPSUTbUzAX.OSRzxo1tIkmTcl3ueKoZr.AvpYDTmFBO', '2024-10-11 05:39:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogdata`
--
ALTER TABLE `blogdata`
  ADD PRIMARY KEY (`blogId`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentId`),
  ADD KEY `blogId` (`blogId`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productid`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogdata`
--
ALTER TABLE `blogdata`
  MODIFY `blogId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`blogId`) REFERENCES `blogdata` (`blogId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
