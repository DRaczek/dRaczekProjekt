-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2023 at 06:37 PM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `draczekprojektdb`
--
CREATE DATABASE IF NOT EXISTS `draczekprojektdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci;
USE `draczekprojektdb`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `user_id_created` bigint(20) NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `user_id_last_modified` bigint(20) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image_path`, `created_date`, `user_id_created`, `last_modified_date`, `user_id_last_modified`, `status`) VALUES
(19, 'kat1', 'img/uploads/categories/2023-04-06-23-47-52_img1.png', '2023-04-06 23:47:52', 49, '2023-04-10 19:40:57', 49, 1),
(20, 'kat2', 'img/uploads/categories/2023-04-06-23-47-57_img2.png', '2023-04-06 23:47:57', 49, '2023-04-06 23:47:57', 49, 1),
(21, 'kat3', 'img/uploads/categories/2023-04-06-23-48-02_img3.png', '2023-04-06 23:48:02', 49, '2023-04-06 23:48:02', 49, 1),
(23, 'kat5', 'img/uploads/categories/2023-04-06-23-48-12_img5.png', '2023-04-06 23:48:12', 49, '2023-04-06 23:48:12', 49, 1),
(24, 'test', 'img/uploads/categories/2023-04-15-23-25-30_frlif.png', '2023-04-06 23:48:17', 49, '2023-04-15 23:25:30', 49, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `delivery_methods`
--

CREATE TABLE `delivery_methods` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double(10,2) NOT NULL,
  `created_date` datetime NOT NULL,
  `user_id_created` bigint(20) NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `user_id_last_modified` bigint(20) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `delivery_methods`
--

INSERT INTO `delivery_methods` (`id`, `name`, `price`, `created_date`, `user_id_created`, `last_modified_date`, `user_id_last_modified`, `status`) VALUES
(1, 'Odbiór osobisty', 0.00, '2023-04-23 12:54:55', 1, '2023-04-23 12:54:55', 1, 1),
(2, 'Dostawa kurierska', 15.99, '2023-04-23 12:55:43', 1, '2023-04-23 12:55:43', 1, 1),
(3, 'Dostawa pocztowa', 9.99, '2023-04-23 12:56:27', 1, '2023-04-23 12:56:27', 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `is_company` tinyint(1) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `street` varchar(255) NOT NULL,
  `street_number` smallint(6) NOT NULL,
  `postal_code` varchar(50) NOT NULL,
  `postal_city` varchar(255) NOT NULL,
  `country` varchar(2) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `delivery_id` bigint(20) NOT NULL,
  `delivery_tracking` varchar(1000) NOT NULL,
  `payment_method_id` bigint(20) NOT NULL,
  `payment_status` tinyint(3) UNSIGNED NOT NULL,
  `order_status` tinyint(3) UNSIGNED NOT NULL,
  `created_date` datetime NOT NULL,
  `user_id_created` bigint(20) NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `user_id_last_modified` bigint(20) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `is_company`, `first_name`, `last_name`, `street`, `street_number`, `postal_code`, `postal_city`, `country`, `nip`, `company_name`, `delivery_id`, `delivery_tracking`, `payment_method_id`, `payment_status`, `order_status`, `created_date`, `user_id_created`, `last_modified_date`, `user_id_last_modified`, `status`) VALUES
(40, 49, 0, 'Damian', 'Raczek', 'Mordarka', 344, '34-600', 'Limanowa', 'PL', '5240257126', 'awdawd', 2, 'Brak danych', 1, 0, 0, '2023-04-23 17:53:48', 49, '2023-04-23 17:53:48', 49, 1),
(41, 49, 0, 'Damian', 'Raczek', 'Mordarka', 344, '34-600', 'Limanowa', 'PL', '5240257126', 'awdawd', 2, 'Brak danych', 1, 0, 0, '2023-04-23 17:56:03', 49, '2023-04-23 17:56:03', 49, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders_products`
--

CREATE TABLE `orders_products` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `user_id_created` bigint(20) NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `user_id_last_modified` bigint(20) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `orders_products`
--

INSERT INTO `orders_products` (`id`, `order_id`, `product_id`, `quantity`, `created_date`, `user_id_created`, `last_modified_date`, `user_id_last_modified`, `status`) VALUES
(14, 40, 15, 4, '2023-04-23 17:53:48', 49, '2023-04-23 17:53:48', 49, 1),
(15, 40, 13, 8, '2023-04-23 17:53:48', 49, '2023-04-23 17:53:48', 49, 1),
(16, 41, 15, 4, '2023-04-23 17:56:04', 49, '2023-04-23 17:56:04', 49, 1),
(17, 41, 13, 8, '2023-04-23 17:56:04', 49, '2023-04-23 17:56:04', 49, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `user_id_created` bigint(20) NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `user_id_last_modified` bigint(20) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `created_date`, `user_id_created`, `last_modified_date`, `user_id_last_modified`, `status`) VALUES
(1, 'Płatność Przelewem', '2023-04-23 12:52:45', 1, '2023-04-23 12:52:45', 1, 1),
(2, 'Płatność za pobraniem', '2023-04-23 12:52:45', 1, '2023-04-23 12:52:45', 1, 1),
(3, 'Płatność kartą', '2023-04-23 12:54:26', 1, '2023-04-23 12:54:26', 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE `products` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `image_path_1` varchar(255) NOT NULL,
  `image_path_2` varchar(255) DEFAULT NULL,
  `image_path_3` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` bigint(20) NOT NULL,
  `size` varchar(50) NOT NULL,
  `colour` varchar(50) NOT NULL,
  `view_count` bigint(20) NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `user_id_last_modified` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `user_id_created` bigint(20) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `image_path_1`, `image_path_2`, `image_path_3`, `description`, `price`, `quantity`, `size`, `colour`, `view_count`, `last_modified_date`, `user_id_last_modified`, `created_date`, `user_id_created`, `status`) VALUES
(13, 'produkt 3 super cena lux premiumawdawdawdawd', 24, 'img/uploads/products/2023-04-16-15-35-40_img1.png', 'img/uploads/products/2023-04-16-15-35-40_img5.png', NULL, 'opis', 0.22, 1, '2', '3', 0, '2023-04-16 15:35:40', 49, '2023-04-11 14:45:48', 49, 1),
(15, 'produkt1', 23, 'img/uploads/products/2023-04-16-15-39-06_img6.png', NULL, NULL, '123', 123.00, 123, '1', '1', 0, '2023-04-20 15:40:55', 49, '2023-04-16 15:39:06', 49, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `created_date` datetime NOT NULL,
  `user_id_created` bigint(20) NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `user_id_last_modified` bigint(20) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `date_of_birth`, `created_date`, `user_id_created`, `last_modified_date`, `user_id_last_modified`, `status`) VALUES
(1, 'SYSTEM', 'SYSTEM', 'SYSTEM', 'SYSTEM', '2013-03-01', '2023-03-29 21:19:32', 1, '2023-03-29 21:19:32', 1, 1),
(49, 'godzina.wychowawcza12@gmail.com', '$2y$10$e1gtlUufqOzZHxYDz2.ZvOO8jNkpMpcrwXMBPwZNY8lZUHE6HCuga', 'Damian', 'Raczek', '2022-12-30', '2023-04-01 22:02:34', 1, '2023-04-16 11:49:12', 49, 1),
(50, 'test1', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-04-02 15:14:47', 49, 1),
(51, 'test2', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-04-16 11:58:20', 49, 1),
(52, 'test3', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-04-16 12:08:34', 49, 2),
(53, 'test4', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-04-10 19:38:30', 49, 1),
(54, 'test5', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-04-10 19:38:31', 49, 1),
(59, 'draczekprojekt@gmail.com', '$2y$10$ZY/0Sefed9Rg7wAH6YSzbOVDnfLp10XDelIwnjTWOoR/4Dfvy28cW', 'Damian', 'Raczek', '2023-03-31', '2023-04-10 15:47:17', 1, '2023-04-16 11:58:24', 49, 1),
(60, 'damian.raczek4206695@gmail.com', '$2y$10$hUIhLo7gAGA7P93X3WiUuuTZ3i8CBZcj7LX8PPXfe7W9P/XvjhOde', 'DamianZmienione', 'RaczekZmienione', '2023-04-01', '2023-04-16 16:12:13', 1, '2023-04-16 16:22:18', 60, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users_admin`
--

CREATE TABLE `users_admin` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `users_admin`
--

INSERT INTO `users_admin` (`id`, `user_id`) VALUES
(7, 49);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users_token_action`
--

CREATE TABLE `users_token_action` (
  `id` bigint(20) NOT NULL,
  `token` varchar(255) NOT NULL,
  `action` tinyint(3) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `user_id_created` bigint(20) NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `user_id_last_modified` bigint(20) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `user_id_created` (`user_id_created`),
  ADD KEY `user_id_last_modified` (`user_id_last_modified`);

--
-- Indeksy dla tabeli `delivery_methods`
--
ALTER TABLE `delivery_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `delivery_methods_name_uidx` (`name`),
  ADD KEY `user_id_created` (`user_id_created`),
  ADD KEY `user_id_last_modified` (`user_id_last_modified`);

--
-- Indeksy dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_id` (`delivery_id`),
  ADD KEY `payment_method_id` (`payment_method_id`),
  ADD KEY `user_id_created` (`user_id_created`),
  ADD KEY `user_id_last_modified` (`user_id_last_modified`);

--
-- Indeksy dla tabeli `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id_created` (`user_id_created`),
  ADD KEY `user_id_last_modified` (`user_id_last_modified`);

--
-- Indeksy dla tabeli `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_methods_name_uidx` (`name`),
  ADD KEY `user_id_created` (`user_id_created`),
  ADD KEY `user_id_last_modified` (`user_id_last_modified`);

--
-- Indeksy dla tabeli `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_name_uidx` (`name`),
  ADD KEY `user_id_created` (`user_id_created`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id_last_modified` (`user_id_last_modified`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_uidx` (`email`),
  ADD KEY `user_id_created` (`user_id_created`),
  ADD KEY `user_id_modified` (`user_id_last_modified`);

--
-- Indeksy dla tabeli `users_admin`
--
ALTER TABLE `users_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `users_token_action`
--
ALTER TABLE `users_token_action`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_token_action_token_uidx` (`token`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_created` (`user_id_created`),
  ADD KEY `user_id_last_modified` (`user_id_last_modified`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `delivery_methods`
--
ALTER TABLE `delivery_methods`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `orders_products`
--
ALTER TABLE `orders_products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `users_admin`
--
ALTER TABLE `users_admin`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users_token_action`
--
ALTER TABLE `users_token_action`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`user_id_created`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `categories_ibfk_2` FOREIGN KEY (`user_id_created`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `categories_ibfk_3` FOREIGN KEY (`user_id_last_modified`) REFERENCES `users` (`id`);

--
-- Constraints for table `delivery_methods`
--
ALTER TABLE `delivery_methods`
  ADD CONSTRAINT `delivery_methods_ibfk_1` FOREIGN KEY (`user_id_created`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `delivery_methods_ibfk_2` FOREIGN KEY (`user_id_last_modified`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`delivery_id`) REFERENCES `delivery_methods` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`user_id_created`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`user_id_last_modified`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD CONSTRAINT `orders_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `orders_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `orders_products_ibfk_3` FOREIGN KEY (`user_id_created`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_products_ibfk_4` FOREIGN KEY (`user_id_last_modified`) REFERENCES `users` (`id`);

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `payment_methods_ibfk_1` FOREIGN KEY (`user_id_created`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payment_methods_ibfk_2` FOREIGN KEY (`user_id_last_modified`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`user_id_created`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`user_id_created`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_4` FOREIGN KEY (`user_id_last_modified`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_id_created`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`user_id_created`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`user_id_last_modified`) REFERENCES `users` (`id`);

--
-- Constraints for table `users_admin`
--
ALTER TABLE `users_admin`
  ADD CONSTRAINT `users_admin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users_token_action`
--
ALTER TABLE `users_token_action`
  ADD CONSTRAINT `users_token_action_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_token_action_ibfk_2` FOREIGN KEY (`user_id_created`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_token_action_ibfk_3` FOREIGN KEY (`user_id_last_modified`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
