-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2023 at 05:36 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phone_case_business`
--
CREATE DATABASE IF NOT EXISTS `phone_case_business` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `phone_case_business`;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands` (
  `id` varchar(15) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`) VALUES
('ap', 'Apple'),
('mc', 'Minecraft');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `total`, `status`) VALUES
(3, 83, '2023-05-03 16:37:45', 199.80, 0),
(4, 62, '2023-05-03 17:23:50', 274.55, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ordersline`
--

DROP TABLE IF EXISTS `ordersline`;
CREATE TABLE `ordersline` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordersline`
--

INSERT INTO `ordersline` (`order_id`, `product_id`, `quantity`) VALUES
(3, 3, 20),
(4, 3, 10),
(4, 4, 35);

--
-- Triggers `ordersline`
--
DROP TRIGGER IF EXISTS `update_order_total`;
DELIMITER $$
CREATE TRIGGER `update_order_total` AFTER INSERT ON `ordersline` FOR EACH ROW UPDATE orders
SET total = (SELECT SUM(price * quantity) FROM ordersline INNER JOIN products ON products.id = ordersline.product_id WHERE order_id = NEW.order_id)
WHERE id = NEW.order_id
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update_order_total_on_delete`;
DELIMITER $$
CREATE TRIGGER `update_order_total_on_delete` AFTER DELETE ON `ordersline` FOR EACH ROW UPDATE orders
SET total = (SELECT SUM(price * quantity) FROM ordersline INNER JOIN products ON products.id = ordersline.product_id WHERE order_id = OLD.order_id)
WHERE id = OLD.order_id
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update_order_total_on_update`;
DELIMITER $$
CREATE TRIGGER `update_order_total_on_update` AFTER UPDATE ON `ordersline` FOR EACH ROW UPDATE orders
SET total = (SELECT SUM(price * quantity) FROM ordersline INNER JOIN products ON products.id = ordersline.product_id WHERE order_id = NEW.order_id)
WHERE id = NEW.order_id
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update_total_stock`;
DELIMITER $$
CREATE TRIGGER `update_total_stock` AFTER INSERT ON `ordersline` FOR EACH ROW UPDATE products
SET stoke = stoke - NEW.quantity
WHERE NEW.product_id = id
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update_total_stock_on_delete`;
DELIMITER $$
CREATE TRIGGER `update_total_stock_on_delete` AFTER DELETE ON `ordersline` FOR EACH ROW UPDATE products
SET stoke = stoke + OLD.quantity
WHERE OLD.product_id = id
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update_total_stock_on_update`;
DELIMITER $$
CREATE TRIGGER `update_total_stock_on_update` AFTER UPDATE ON `ordersline` FOR EACH ROW UPDATE products
SET stoke = stoke + OLD.quantity - NEW.quantity
WHERE OLD.product_id = id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stoke` int(11) NOT NULL DEFAULT 0,
  `description` varchar(5000) DEFAULT NULL,
  `image_url` text NOT NULL,
  `brand_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stoke`, `description`, `image_url`, `brand_id`) VALUES
(3, 'Oak log', 9.99, 100, 'It\'s just an oak log', 'img/products/Oak_Log.png', 'mc'),
(4, 'Oak plank', 4.99, 75, 'It\'s just a plank', 'img/products/Oak_Plank.png', 'mc'),
(5, 'APPLE IPHONE 13 PRO SMOKED OAK WOOD CASE', 24.99, 100, 'Smoked oak – is a special variation of wood made from trees or rarely high bushes of the Fagaceae family (Fagaceae Dumort). This family consists of 200 species occurring mainly in temperate zones in the Northern Hemisphere (among others in Poland) and in high terrains in the tropical zone. Oaks are famous for large sizes, they are the thickest Polish trees and their diameter may exceed 3 metres for the height up to 25-35 metres. Oak wood is relatively heavy and tough, therefore it is commonly used in woodwork and furniture industry. Moreover, it is highly resistant to abrasion. Oak wood is usually yellowish brown and has clearly defined structure with knots characteristic of oak. Smoked oak colour becomes dark as a result of long-lasting and remarkably precise process of heat treatment – smoking. The diversity of rings, revealed as a result of ‘smoking’, reacts on the light in an unusual manner changing the complexion depending on the angle of incidence of the light. The above mentioned features will make our case change in front of our eyes depending on what angle we look at it from.', 'img\\products\\oak_wood_case.jpg', 'ap'),
(6, 'APPLE IPHONE 13 PRO ', 24.99, 100, 'Smoked oak – is a special variation of wood made from trees or rarely high bushes of the Fagaceae family (Fagaceae Dumort). This family consists of 200 species occurring mainly in temperate zones in the Northern Hemisphere (among others in Poland) and in high terrains in the tropical zone. Oaks are famous for large sizes, they are the thickest Polish trees and their diameter may exceed 3 metres for the height up to 25-35 metres. Oak wood is relatively heavy and tough, therefore it is commonly used in woodwork and furniture industry. Moreover, it is highly resistant to abrasion. Oak wood is usually yellowish brown and has clearly defined structure with knots characteristic of oak. Smoked oak colour becomes dark as a result of long-lasting and remarkably precise process of heat treatment – smoking. The diversity of rings, revealed as a result of ‘smoking’, reacts on the light in an unusual manner changing the complexion depending on the angle of incidence of the light. The above mentioned features will make our case change in front of our eyes depending on what angle we look at it from.', 'img\\products\\oak_wood_case.jpg', 'ap');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` char(255) NOT NULL,
  `phonenumber` varchar(12) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(512) DEFAULT NULL,
  `address2` varchar(512) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `phonenumber`, `email`, `address`, `address2`, `reg_date`) VALUES
(62, 'Huy', 'Nguyen', 'AHgaming', '$2y$10$Wx7ssg8cuDWrYGYItXTy3.0Y35Eri0n7sow8/9qbbWJixnEa2GIq.', '0123654789', 'ahgamingofficial03@gmail.com', '58 Nguyen Du St', '20 Cong Hoa St', '2023-04-27 21:19:01'),
(70, 'Jack', 'Connor', 'dooddeed', '$2y$10$wN3xEBjH517U7YYrp5VTmeznl0hLyYENzcHoUkmwgBT2alymNw8lW', '0375931900', 'tatuanthunohomo@gmail.com', '100 lmao', 'something', '2023-04-27 22:01:06'),
(83, 'Harry', 'Nguyen', 'AHgaming03', '$2y$10$IBK2OnC937k01Z4l.TA3TezeEkjxTS/CLUQL08EgY5sFqJbf8yBdS', '0398356653', 'ahgamingofficial03@gmail.com', '58 Nguyen Du St', '20 Cong Hoa St', '2023-04-27 22:23:22'),
(84, 'Jepp', 'Connor', 'jep03', '$2y$10$c.8tCUmUzPwZ6NDWH4GfVOMTR160QduZpcE4JqOmdYLj6gSibi5U.', '0908123789', '', 'New York', '', '2023-05-05 18:16:46'),
(106, 'John', 'Nathan', 'john12', '$2y$10$BI5Oyd9YbUV3PJHmFYg1Aez1WZyOef3wZk05ihVXMe/JxpuWVA9fq', '0123655269', '', 'London', '', '2023-05-05 19:26:42'),
(107, 'Long', 'Lee', 'Long99', '$2y$10$Ltxg3fXfj33LtyDcoZhpou2XFkLBFAuivvJnc8s9vkpE2Id9LpqdO', '0924635269', '', 'Hong Kong', '', '2023-05-05 19:32:08'),
(108, 'Jenifer', 'Connor', 'jenifer14', '$2y$10$orQVvvPSLwVLcMSIJ3qCXOHzZyWKKLJGK9sVvIua1BrsY79SbSrma', '0785426821', 'facemail@face.com', 'face address 1', '', '2023-05-05 22:32:37'),
(110, 'Bob', 'Roll', 'bobr78', '$2y$10$yhen.RPJkyH2VUWFkvOWIO2VaI0nJ7fsViS9CQwHI4jGlehBasf3m', '0908465481', 'facemail2@mail.com', 'face address 2', '', '2023-05-05 22:34:47'),
(112, 'Elephen', 'Pop', 'elephen4', '$2y$10$JPVS.7k1i3Q./64c0FnsoOwRSoAH67henWUyyUfkdviWkjUA59a6u', '0789153172', 'fakemail@fake.com', 'fake address 5', '', '2023-05-05 22:38:10'),
(117, 'jump', 'Roll', 'jump1', '$2y$10$nF7T1AFbcFiR8XzQL3v8BO6xhyicytZ/yvp2B.liMUuE3qgKAo9Qe', '0987564247', 'fakemail54@fake.com', 'fake address 67', '', '2023-05-05 23:06:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_user_id` (`user_id`);

--
-- Indexes for table `ordersline`
--
ALTER TABLE `ordersline`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `phonenumber` (`phonenumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `ordersline`
--
ALTER TABLE `ordersline`
  ADD CONSTRAINT `ordersline_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `ordersline_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_brands_products` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
