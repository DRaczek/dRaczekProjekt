-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2023 at 09:41 PM
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
(22, 'kat4', 'img/uploads/categories/2023-04-06-23-48-07_img4.png', '2023-04-06 23:48:07', 49, '2023-04-06 23:48:07', 49, 1),
(23, 'kat5', 'img/uploads/categories/2023-04-06-23-48-12_img5.png', '2023-04-06 23:48:12', 49, '2023-04-06 23:48:12', 49, 1),
(24, 'kat6', 'img/uploads/categories/2023-04-06-23-48-17_img6.png', '2023-04-06 23:48:17', 49, '2023-04-06 23:48:17', 49, 1),
(27, 'kattestZmienione', 'img/uploads/categories/2023-04-10-19-29-45_web_site.jpg', '2023-04-10 19:29:45', 49, '2023-04-11 15:38:09', 49, 1);

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
(13, 'produkt 3 super cena lux premium', 24, 'img/uploads/products/2023-04-11-14-45-48_img6.png', NULL, NULL, 'opis', 0.22, 1, '2', '3', 0, '2023-04-11 14:45:48', 49, '2023-04-11 14:45:48', 49, 1),
(14, 'produkt3zzz', 20, 'img/uploads/products/2023-04-11-21-39-00_img6.png', NULL, NULL, 'xxxx', 1.00, 1, '0', '0', 0, '2023-04-11 21:39:00', 49, '2023-04-11 14:47:23', 49, 1);

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
(49, 'godzina.wychowawcza12@gmail.com', '$2y$10$e1gtlUufqOzZHxYDz2.ZvOO8jNkpMpcrwXMBPwZNY8lZUHE6HCuga', 'Damian', 'Raczek', '2022-12-30', '2023-04-01 22:02:34', 1, '2023-04-10 15:31:18', 49, 1),
(50, 'test1', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-04-02 15:14:47', 49, 1),
(51, 'test2', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-04-02 15:30:27', 49, 1),
(52, 'test3', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-04-02 14:23:32', 1, 1),
(53, 'test4', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-04-10 19:38:30', 49, 1),
(54, 'test5', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-04-10 19:38:31', 49, 1),
(59, 'draczekprojekt@gmail.com', '$2y$10$4Gs6h6VstXTHwSIA85QnWe37xD/EyWnDZkvAoEGzjjCezRBCr8uhu', 'Damian', 'Raczek', '2023-03-31', '2023-04-10 15:47:17', 1, '2023-04-10 15:47:17', 1, 1);

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `users_admin`
--
ALTER TABLE `users_admin`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users_token_action`
--
ALTER TABLE `users_token_action`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
