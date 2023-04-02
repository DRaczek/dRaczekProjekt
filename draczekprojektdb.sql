-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 02 Kwi 2023, 19:51
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `draczekprojektdb`
--
CREATE DATABASE IF NOT EXISTS `draczekprojektdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci;
USE `draczekprojektdb`;

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
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `date_of_birth`, `created_date`, `user_id_created`, `last_modified_date`, `user_id_last_modified`, `status`) VALUES
(1, 'SYSTEM', 'SYSTEM', 'SYSTEM', 'SYSTEM', '2013-03-01', '2023-03-29 21:19:32', 1, '2023-03-29 21:19:32', 1, 1),
(49, 'godzina.wychowawcza12@gmail.com', '$2y$10$c/0o6ddDlWIdW80CuzDTKO/bjBVV9o6yI3erfustyD/F7Mn/qtR6C', 'Damianawd', 'Raczekawd', '2022-12-30', '2023-04-01 22:02:34', 1, '2023-04-02 15:14:46', 49, 1),
(50, 'test1', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-04-02 15:14:47', 49, 1),
(51, 'test2', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-04-02 15:30:27', 49, 1),
(52, 'test3', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-04-02 14:23:32', 1, 1),
(53, 'test4', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-04-02 15:30:35', 49, 1),
(54, 'test5', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-04-02 17:07:47', 49, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users_admin`
--

CREATE TABLE `users_admin` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `users_admin`
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
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT dla tabeli `users_admin`
--
ALTER TABLE `users_admin`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `users_token_action`
--
ALTER TABLE `users_token_action`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_id_created`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`user_id_created`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`user_id_last_modified`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `users_admin`
--
ALTER TABLE `users_admin`
  ADD CONSTRAINT `users_admin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `users_token_action`
--
ALTER TABLE `users_token_action`
  ADD CONSTRAINT `users_token_action_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_token_action_ibfk_2` FOREIGN KEY (`user_id_created`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_token_action_ibfk_3` FOREIGN KEY (`user_id_last_modified`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
