-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2021 at 04:11 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(4) UNSIGNED NOT NULL,
  `table_no` int(2) UNSIGNED NOT NULL,
  `booking_dt` varchar(20) NOT NULL,
  `duration` time NOT NULL,
  `booking_charge` float UNSIGNED NOT NULL,
  `waiter_id` int(2) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `customer_id`, `table_no`, `booking_dt`, `duration`, `booking_charge`, `waiter_id`, `payment_id`) VALUES
(36, 46, 1, '1617003120', '00:30:00', 150, 1, 202103261317170046),
(37, 46, 1, '1617176160', '00:30:00', 150, 1, 202103261321100046),
(38, 46, 1, '1617176280', '00:30:00', 150, 1, 202103261323140046),
(39, 46, 1, '1617182700', '00:30:00', 150, 1, 202103261510090046),
(40, 48, 1, '1617157620', '00:30:00', 150, 1, 202103270812360048),
(41, 48, 1, '1617157800', '00:31:00', 155, 1, 202103270816510048),
(42, 46, 1, '1617168180', '00:30:00', 150, 1, 202103271108190046),
(43, 46, 1, '1617081840', '00:30:00', 150, 1, 202103271110250046),
(44, 48, 2, '1617168300', '00:30:00', 150, 2, 202103271110480048),
(45, 48, 1, '1617168480', '00:44:00', 220, 1, 202103271115150048),
(46, 47, 2, '1617082140', '00:30:00', 150, 2, 202103271117090047),
(47, 49, 1, '1617946200', '00:30:00', 150, 1, 202103271117260049),
(48, 46, 1, '1617118680', '00:30:00', 150, 1, 202103291139080046),
(49, 46, 1, '1617175260', '00:30:00', 150, 1, 202103301309070046),
(50, 46, 1, '1617434640', '00:30:00', 150, 1, 202103301309270046),
(51, 46, 1, '1617261840', '00:30:00', 150, 1, 202103301404300046),
(202103301506320046, 46, 1, '1617182460', '00:30:00', 150, 1, 202103301508230046),
(202103301558510046, 46, 1, '1617358380', '00:30:00', 150, 1, 202103301559190046),
(202103301600130046, 46, 1, '1617358500', '00:30:00', 150, 1, 202103301600140046),
(202103301604010046, 46, 1, '1617358680', '00:30:00', 150, 1, 202103301604040046),
(202103301605360046, 46, 1, '1617272400', '00:30:00', 150, 1, 202103301605370046),
(202103301605480046, 46, 1, '1617445200', '00:30:00', 150, 2, 202103301605500046),
(202104030832140046, 46, 1, '1619750820', '00:30:00', 150, 1, 202104030832200046),
(202104030833500046, 46, 1, '1617763680', '00:30:00', 150, 2, 202104030833520046),
(202104030833580046, 46, 1, '1619750880', '00:30:00', 150, 2, 202104030834000046),
(202104031750110046, 46, 1, '1619006700', '00:31:00', 155, 1, 202104031750190046),
(202104031751190046, 46, 1, '1618574760', '00:31:00', 155, 1, 202104031751210046),
(202104031801530046, 46, 1, '1618661760', '00:30:00', 150, 1, 202104031802270046),
(202104031805280046, 46, 1, '1617884400', '00:30:00', 150, 1, 202104031806420046),
(202104031830300046, 46, 1, '1619095500', '00:33:00', 165, 1, 202104031830420046),
(202104031908030046, 46, 1, '1618060980', '00:30:00', 150, 1, 202104031911000046),
(202104051158550046, 46, 1, '1618899180', '00:30:00', 150, 1, 202104051159130046);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(4) UNSIGNED NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(20) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(75) NOT NULL,
  `mobile_no` bigint(10) UNSIGNED NOT NULL,
  `house_no` int(5) UNSIGNED NOT NULL,
  `street` varchar(25) NOT NULL,
  `district` smallint(1) UNSIGNED NOT NULL,
  `ward_no` int(2) UNSIGNED NOT NULL,
  `email` varchar(60) NOT NULL,
  `card_no` varchar(75) NOT NULL,
  `cvv_no` varchar(75) NOT NULL,
  `bank` smallint(1) UNSIGNED NOT NULL,
  `exp_year` int(4) UNSIGNED NOT NULL,
  `exp_month` int(2) UNSIGNED NOT NULL,
  `card_type` int(1) UNSIGNED NOT NULL,
  `booking_status` int(1) UNSIGNED NOT NULL,
  `order_status` int(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `middle_name`, `last_name`, `username`, `password`, `mobile_no`, `house_no`, `street`, `district`, `ward_no`, `email`, `card_no`, `cvv_no`, `bank`, `exp_year`, `exp_month`, `card_type`, `booking_status`, `order_status`) VALUES
(46, 'Shyam', NULL, 'Singh', '4444444444', '$2y$10$X2On0TgHAAWM/VegrY8fo.JtwntVVgSk91tQl124QPwsHjlQNFYF6', 9844444444, 444, 'rrr marga', 0, 4, 'rrrr4444@rrrr.com', '44444444444444444', '444', 1, 2020, 1, 1, 0, 0),
(47, 'Geeta', 'Rani', 'Subedi', '3333333333', '$2y$10$V7iHWtmVlulmMpw6SWHb9u3obB5aoekUqdaAMpZOeiouGGgTgFTbO', 9833333333, 333, '333', 0, 3, '333@333', '3333333333333333', '333', 1, 2023, 3, 1, 0, 0),
(48, 'Swapnil', 'Raj', 'Tripathi', '5555555555', '$2y$10$2yEa/FpFSX69VXQYffA5JO3PEgYF3YzcZLfN9cqLNWV5lb5wfMiE.', 9855555555, 555, '555555', 0, 5, '555@555', '5555555555555555', '555', 1, 2022, 1, 1, 0, 0),
(49, '1123', '123', '123', '123123123123', '$2y$10$wjVG2VjuVLn7y3fKeqTIz.SBwWmtCtcYUDrdCu0zZt4CGbuuap2Ma', 9812312312, 123, '123123', 0, 12, '123@123', '$2y$10$a4tS9uzVTffqAX.1fmE9VO1fNF.gin3k0iSKGUtWyIaXGzV6t2vkO', '$2y$10$SIBeUKEHO1qFxA3AvrRh8.nFmKXXC3QjYKd9yxuuM2zBh9BOsn4km', 1, 2022, 1, 1, 0, 0),
(50, '234', '234', '234', '234234234234', '$2y$10$Y0L1/KLWQeVV0.VPDbRYVeoNLBQvxV79rnNFBq87eeikKB5pCXFOm', 9823444444, 234, '234', 0, 23, '234@234', '$2y$10$WK52J7UqdmdFBvpLK33aAuIrF0q6w.NIV35aLbecPSuxWEtDY1t9G', '$2y$10$RFFny1jhehyz/3UkHSE43eXDqPeFOtWI1/F3UFTBo18nuiWRa5OT.', 1, 2022, 1, 1, 0, 0),
(51, '3453453453', '354345', '345', '345345345345', '$2y$10$5SL6pgNzRaBrN7VIPjgdouorA9iFbE4InXmGnZofLJP88VIBmUhQ6', 9834534534, 345, '345', 0, 3, '345@345', '$2y$10$HpHpkF.ni9unVikimICMo.TLrOZ2bomaXrP7BWb2KgmvVhxgoWF1a', '$2y$10$8s3Fp8m9vqO.eZbFL/g8vegEk5D5xrfyfprfTU8IjPFP/5yMzlzpm', 1, 2022, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE `menu_item` (
  `menu_id` int(3) UNSIGNED NOT NULL,
  `item_name` varchar(20) NOT NULL,
  `production_cost` double(6,2) UNSIGNED NOT NULL,
  `selling_price` double(6,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu_item`
--

INSERT INTO `menu_item` (`menu_id`, `item_name`, `production_cost`, `selling_price`) VALUES
(1, 'Pizza', 200.00, 250.00),
(2, 'Burger', 150.00, 175.00),
(3, 'Mo:Mo', 100.00, 125.00),
(4, 'Chowmin', 100.00, 135.00),
(5, 'Sizzler', 300.00, 400.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customer_id` int(4) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `customer_id`, `payment_id`) VALUES
(136, '2021-03-30 08:19:30', 46, 202103301404300046),
(137, '2021-03-30 08:23:24', 47, 202103301408240047),
(138, '2021-03-30 08:26:48', 46, 202103301411470046),
(139, '2021-03-30 09:23:23', 46, 202103301508230046),
(202103301213550046, '2021-03-30 10:14:19', 46, 202103301559190046),
(202103301215560046, '2021-03-30 10:19:04', 46, 202103301604040046),
(202103301219170046, '2021-03-30 10:19:19', 46, 202103301604190046),
(202103301220240046, '2021-03-30 10:20:27', 46, 202103301605270046),
(202103301220430046, '2021-03-30 10:20:50', 46, 202103301605500046),
(202104031830400046, '2021-04-03 12:45:42', 46, 202104031830420046),
(202104031927330046, '2021-04-03 13:42:34', 46, 202104031927340046),
(202104051159020046, '2021-04-05 06:14:13', 46, 202104051159130046);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(15) UNSIGNED NOT NULL,
  `menu_id` int(3) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `amount_ordered` int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `menu_id`, `order_id`, `amount_ordered`) VALUES
(138, 3, 137, 1),
(152, 3, 136, 2),
(153, 4, 136, 2),
(154, 3, 138, 1),
(170, 1, 202103301213550046, 2),
(172, 5, 202103301213550046, 3),
(173, 1, 202103301215560046, 1),
(174, 1, 202103301219170046, 1),
(175, 1, 202103301220240046, 1),
(176, 1, 202103301220430046, 1),
(216, 3, 202104031830400046, 2),
(222, 1, 202104031927330046, 1),
(223, 1, 202104051159020046, 1),
(224, 3, 202104051159020046, 4),
(225, 4, 202104051159020046, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `amount` float UNSIGNED NOT NULL,
  `payment_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `amount`, `payment_timestamp`) VALUES
(0, 0, '2021-03-27 02:31:33'),
(202103261317170046, 33.33, '2021-03-26 07:36:00'),
(202103261321100046, 150, '2021-03-26 07:36:10'),
(202103261323140046, 150, '2021-03-26 07:38:14'),
(202103261510090046, 150, '2021-03-26 09:25:09'),
(202103270812360048, 150, '2021-03-27 02:27:36'),
(202103270816510048, 155, '2021-03-27 02:31:51'),
(202103271108190046, 150, '2021-03-27 05:23:19'),
(202103271110250046, 150, '2021-03-27 05:25:25'),
(202103271110480048, 150, '2021-03-27 05:25:48'),
(202103271115150048, 220, '2021-03-27 05:30:15'),
(202103271117090047, 150, '2021-03-27 05:32:09'),
(202103271117260049, 150, '2021-03-27 05:32:26'),
(202103291139080046, 150, '2021-03-29 05:54:08'),
(202103301309070046, 150, '2021-03-30 07:24:07'),
(202103301309270046, 150, '2021-03-30 07:24:27'),
(202103301404300046, 670, '2021-03-30 08:19:30'),
(202103301408240047, 125, '2021-03-30 08:23:24'),
(202103301411470046, 125, '2021-03-30 08:26:47'),
(202103301508230046, 150, '2021-03-30 09:23:23'),
(202103301559190046, 1850, '2021-03-30 10:14:19'),
(202103301600140046, 150, '2021-03-30 10:15:14'),
(202103301604040046, 400, '2021-03-30 10:19:04'),
(202103301604190046, 250, '2021-03-30 10:19:19'),
(202103301605270046, 250, '2021-03-30 10:20:27'),
(202103301605370046, 150, '2021-03-30 10:20:37'),
(202103301605500046, 400, '2021-03-30 10:20:50'),
(202104030832200046, 150, '2021-04-03 02:47:20'),
(202104030833520046, 150, '2021-04-03 02:48:52'),
(202104030834000046, 150, '2021-04-03 02:49:00'),
(202104031750190046, 155, '2021-04-03 12:05:19'),
(202104031751210046, 155, '2021-04-03 12:06:21'),
(202104031802270046, 150, '2021-04-03 12:17:27'),
(202104031806420046, 150, '2021-04-03 12:21:42'),
(202104031830420046, 415, '2021-04-03 12:45:42'),
(202104031911000046, 150, '2021-04-03 13:26:00'),
(202104031912340046, 0, '2021-04-03 13:27:34'),
(202104031927340046, 0, '2021-04-03 13:42:34'),
(202104051159130046, 150, '2021-04-05 06:14:13');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `table_no` int(2) UNSIGNED NOT NULL,
  `rate` double(6,2) UNSIGNED NOT NULL,
  `table_status` int(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`table_no`, `rate`, `table_status`) VALUES
(1, 5.00, 0),
(2, 5.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `waiters`
--

CREATE TABLE `waiters` (
  `waiter_id` int(2) UNSIGNED NOT NULL,
  `name` varchar(25) NOT NULL,
  `waiter_status` int(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `waiters`
--

INSERT INTO `waiters` (`waiter_id`, `name`, `waiter_status`) VALUES
(1, 'Ram Dhami', 0),
(2, 'Hari Sadu', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `customer_booking` (`customer_id`),
  ADD KEY `waiter_booking` (`waiter_id`),
  ADD KEY `table_booking` (`table_no`),
  ADD KEY `payment_booking` (`payment_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_order` (`customer_id`),
  ADD KEY `payment_order` (`payment_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `FOREIGN_1` (`menu_id`),
  ADD KEY `orders_oi` (`order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`table_no`);

--
-- Indexes for table `waiters`
--
ALTER TABLE `waiters`
  ADD PRIMARY KEY (`waiter_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `customer_booking` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_booking` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`payment_id`),
  ADD CONSTRAINT `table_booking` FOREIGN KEY (`table_no`) REFERENCES `tables` (`table_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `waiter_booking` FOREIGN KEY (`waiter_id`) REFERENCES `waiters` (`waiter_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `customer_order` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_order` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`payment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `FOREIGN_1` FOREIGN KEY (`menu_id`) REFERENCES `menu_item` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_oi` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
