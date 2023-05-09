-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 09, 2023 at 12:21 PM
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
(30, 'Bluzy', 'img/uploads/categories/2023-05-06-20-42-26_g185b_charcoal_ff.png', '2023-05-06 20:42:26', 49, '2023-05-06 20:42:26', 49, 1),
(31, 'T-shirty', 'img/uploads/categories/2023-05-06-20-43-32_tshirtpng.parspng.com_.png', '2023-05-06 20:43:32', 49, '2023-05-06 20:43:32', 49, 1),
(32, 'Spodnie', 'img/uploads/categories/2023-05-06-20-44-43_khaki-pant-png-transparent-image.png', '2023-05-06 20:44:43', 49, '2023-05-06 20:44:43', 49, 1);

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
(68, 49, 0, 'Damian Zmienione', 'Raczek Zmienione', 'Mordarka Zmienione', 344, '34-601', 'Limanowa  Zmienione', 'PL', '5240257126', 'awdawd  Zmienione', 1, 'https://allegro.pl/moje-allegro/zakupy/kupione/278e6890-e2ac-11ed-9386-55551c9662ed', 3, 0, 2, '2023-05-08 13:32:33', 49, '2023-05-08 14:44:30', 49, 1),
(69, 59, 1, 'aaa', 'aaa', 'aaa', 344, '34-600', 'aaa', 'PL', '5240257126', 'aaa', 2, 'Brak danych', 3, 1, 0, '2023-05-08 17:41:06', 59, '2023-05-08 17:41:06', 59, 1),
(70, 59, 1, 'bbb', 'bbb', 'bbbb', 344, '34-600', 'bbb', 'PL', '5240257126', 'bbbb', 2, 'Brak danych', 1, 1, 0, '2023-05-08 17:44:49', 59, '2023-05-08 17:44:49', 59, 1);

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
(67, 68, 27, 4, '2023-05-08 13:32:34', 49, '2023-05-08 13:32:34', 49, 1),
(68, 68, 24, 3, '2023-05-08 13:32:34', 49, '2023-05-08 13:32:34', 49, 1),
(69, 68, 23, 1, '2023-05-08 13:32:34', 49, '2023-05-08 13:32:34', 49, 1),
(70, 69, 23, 3, '2023-05-08 17:41:06', 59, '2023-05-08 17:41:06', 59, 1),
(71, 69, 24, 3, '2023-05-08 17:41:06', 59, '2023-05-08 17:41:06', 59, 1),
(72, 69, 26, 3, '2023-05-08 17:41:06', 59, '2023-05-08 17:41:06', 59, 1),
(73, 69, 27, 2, '2023-05-08 17:41:06', 59, '2023-05-08 17:41:06', 59, 1),
(74, 70, 23, 1, '2023-05-08 17:44:49', 59, '2023-05-08 17:44:49', 59, 1),
(75, 70, 24, 1, '2023-05-08 17:44:49', 59, '2023-05-08 17:44:49', 59, 1),
(76, 70, 25, 8, '2023-05-08 17:44:49', 59, '2023-05-08 17:44:49', 59, 1);

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
  `gender` tinyint(3) UNSIGNED NOT NULL,
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

INSERT INTO `products` (`id`, `name`, `category_id`, `image_path_1`, `image_path_2`, `image_path_3`, `description`, `price`, `quantity`, `size`, `colour`, `gender`, `view_count`, `last_modified_date`, `user_id_last_modified`, `created_date`, `user_id_created`, `status`) VALUES
(23, 'Bluza The North Face r L BINER GRAPHIC | L', 30, 'img/uploads/products/2023-05-07-11-31-12_bluza-rozpinana-meska-the-nort-face-biner-graphic.png', 'img/uploads/products/2023-05-07-11-31-12_bluza-rozpinana-meska-the-nort-face-biner-graphic-rodzaj-rozpinane-z-kapturem.png', NULL, 'Przyciągająca wzrok w 100% bawełniana bluza z kapturem zapinana na zamek błyskawiczny Biner Graphic z kultowym logo The North Face jest idealna na codzienne letnie wyprawy.', 299.99, 994, '3', '0', 0, 21, '2023-05-07 22:45:11', 49, '2023-05-07 11:29:42', 49, 1),
(24, 'Bluza The North Face r L BINER GRAPHIC | S', 30, 'img/uploads/products/2023-05-07-11-31-49_bluza-rozpinana-meska-the-nort-face-biner-graphic.png', 'img/uploads/products/2023-05-07-11-31-49_bluza-rozpinana-meska-the-nort-face-biner-graphic-rodzaj-rozpinane-z-kapturem.png', NULL, 'Przyciągająca wzrok w 100% bawełniana bluza z kapturem zapinana na zamek błyskawiczny Biner Graphic z kultowym logo The North Face jest idealna na codzienne letnie wyprawy.', 299.99, 993, '1', '0', 0, 9, '2023-05-07 22:45:13', 49, '2023-05-07 11:31:49', 49, 1),
(25, 'Bluza The North Face Resolve Fleece | S', 30, 'img/uploads/products/2023-05-07-11-33-26_polar-damski-the-north-face-resolve.png', NULL, NULL, 'Trzymaj mróz na dystans nawet na eksponowanych górskich szlakach.', 299.99, 991, '3', '0', 1, 7, '2023-05-07 22:49:15', 49, '2023-05-07 11:33:26', 49, 1),
(26, 'Bluza The North Face Half Dome | S', 30, 'img/uploads/products/2023-05-07-11-36-32_bluza-z-kapturem-damska-the-north-face-half-dome.png', 'img/uploads/products/2023-05-07-11-36-32_bluza-z-kapturem-damska-the-north-face-half-dome-marka-the-north-face.png', NULL, 'Bluza z kapturem Half Dome to lekka warstwa ubioru, którą zechcesz mieć zawsze przy sobie.', 349.99, 44, '1', '7', 1, 6, '2023-05-07 22:49:18', 49, '2023-05-07 11:36:32', 49, 1),
(27, 'Polar The North Face niebieski | L', 30, 'img/uploads/products/2023-05-07-11-41-14_polar-meski-the-north-face-resolve-fleece.png', 'img/uploads/products/2023-05-07-11-41-14_polar-meski-the-north-face-resolve-fleece-plec-produkt-meski.png', NULL, 'Nasza bluza polarowa Resolve to idealna warstwa na piesze wędrówki – jest ciepła, szybkoschnąca i odprowadza wilgoć.', 299.99, 994, '3', '3', 0, 8, '2023-05-08 12:54:46', 49, '2023-05-07 11:41:14', 49, 1),
(42, 'Koszulka T-shirt Hi-Tec Eron | L', 31, 'img/uploads/products/2023-05-09-11-22-34_hi-tec-meska-koszulka-t-shirt-eron-bawelniana-plec-produkt-meski.png', 'img/uploads/products/2023-05-09-11-22-34_hi-tec-meska-koszulka-t-shirt-eron-bawelniana-material-dominujacy-bawelna.jpg', 'img/uploads/products/2023-05-09-11-22-34_hi-tec-meska-koszulka-t-shirt-eron-bawelniana-liczba-kieszeni-0.png', 'Męska, klasyczna koszulka, t-shirt ERON z najnowszej marki Hi-Tec świetnie sprawdza się jako uzupełnienie codziennego stroju. Idealna podczas codziennego użytkowania, spacerów po mieście, czy też podczas uprawiania różnych form aktywności sportowej.', 45.00, 1000, '3', '3', 0, 0, '2023-05-09 11:22:34', 59, '2023-05-09 11:22:34', 59, 1),
(43, 'Koszulka T-shirt Hi-Tec Eron | M', 31, 'img/uploads/products/2023-05-09-11-23-13_hi-tec-meska-koszulka-t-shirt-eron-bawelniana-plec-produkt-meski.png', 'img/uploads/products/2023-05-09-11-23-13_hi-tec-meska-koszulka-t-shirt-eron-bawelniana-material-dominujacy-bawelna.jpg', 'img/uploads/products/2023-05-09-11-23-13_hi-tec-meska-koszulka-t-shirt-eron-bawelniana-liczba-kieszeni-0.png', 'Męska, klasyczna koszulka, t-shirt ERON z najnowszej marki Hi-Tec świetnie sprawdza się jako uzupełnienie codziennego stroju. Idealna podczas codziennego użytkowania, spacerów po mieście, czy też podczas uprawiania różnych form aktywności sportowej.', 45.00, 500, '2', '3', 0, 0, '2023-05-09 11:23:13', 59, '2023-05-09 11:23:13', 59, 1),
(44, 'Koszulka T-shirt Hi-Tec Eron | XL', 31, 'img/uploads/products/2023-05-09-11-23-48_hi-tec-meska-koszulka-t-shirt-eron-bawelniana-plec-produkt-meski.png', 'img/uploads/products/2023-05-09-11-23-48_hi-tec-meska-koszulka-t-shirt-eron-bawelniana-material-dominujacy-bawelna.jpg', 'img/uploads/products/2023-05-09-11-23-48_hi-tec-meska-koszulka-t-shirt-eron-bawelniana-liczba-kieszeni-0.png', 'Męska, klasyczna koszulka, t-shirt ERON z najnowszej marki Hi-Tec świetnie sprawdza się jako uzupełnienie codziennego stroju. Idealna podczas codziennego użytkowania, spacerów po mieście, czy też podczas uprawiania różnych form aktywności sportowej.', 45.00, 500, '4', '3', 0, 4, '2023-05-09 11:23:48', 59, '2023-05-09 11:23:48', 59, 1),
(45, 'Koszulka T-shirt 4F TSHM536 | S', 31, 'img/uploads/products/2023-05-09-11-28-19_4f-t-shirt-sportowy-koszulka-meska-bawelniana.png', 'img/uploads/products/2023-05-09-11-28-19_4f-t-shirt-sportowy-koszulka-meska-bawelniana-plec-produkt-meski.png', 'img/uploads/products/2023-05-09-11-28-19_4f-t-shirt-sportowy-koszulka-meska-bawelniana-liczba-kieszeni-0.png', 'Zależy Ci na wysokiej jakości ubrań i dodatków? Nie musisz dalej szukać! T-SHIRT marki 4F spełnia wszystkie Twoje oczekiwania. Został wykonany z najwyższej klasy materiałów, dlatego imponuje nie tylko designem, ale także innymi walorami. Jest niezwykle żywotny i wygodny w użytkowaniu oraz, co szczególnie ważne, nadają się do uprawiania wszelkich dyscyplin sportowych!', 40.00, 1000, '1', '1', 0, 0, '2023-05-09 11:28:19', 59, '2023-05-09 11:26:18', 59, 1),
(46, 'Koszulka T-shirt 4F TSHM536 | M', 31, 'img/uploads/products/2023-05-09-11-26-58_4f-t-shirt-sportowy-koszulka-meska-bawelniana.png', 'img/uploads/products/2023-05-09-11-26-58_4f-t-shirt-sportowy-koszulka-meska-bawelniana-plec-produkt-meski.png', 'img/uploads/products/2023-05-09-11-26-58_4f-t-shirt-sportowy-koszulka-meska-bawelniana-liczba-kieszeni-0.png', 'Zależy Ci na wysokiej jakości ubrań i dodatków? Nie musisz dalej szukać! T-SHIRT marki 4F spełnia wszystkie Twoje oczekiwania. Został wykonany z najwyższej klasy materiałów, dlatego imponuje nie tylko designem, ale także innymi walorami. Jest niezwykle żywotny i wygodny w użytkowaniu oraz, co szczególnie ważne, nadają się do uprawiania wszelkich dyscyplin sportowych!', 40.00, 1000, '2', '1', 0, 0, '2023-05-09 11:26:58', 59, '2023-05-09 11:26:58', 59, 1),
(47, 'Koszulka T-shirt 4F TSHM536 | XXL', 31, 'img/uploads/products/2023-05-09-11-27-37_4f-t-shirt-sportowy-koszulka-meska-bawelniana.png', 'img/uploads/products/2023-05-09-11-27-37_4f-t-shirt-sportowy-koszulka-meska-bawelniana-plec-produkt-meski.png', 'img/uploads/products/2023-05-09-11-27-37_4f-t-shirt-sportowy-koszulka-meska-bawelniana-liczba-kieszeni-0.png', 'Zależy Ci na wysokiej jakości ubrań i dodatków? Nie musisz dalej szukać! T-SHIRT marki 4F spełnia wszystkie Twoje oczekiwania. Został wykonany z najwyższej klasy materiałów, dlatego imponuje nie tylko designem, ale także innymi walorami. Jest niezwykle żywotny i wygodny w użytkowaniu oraz, co szczególnie ważne, nadają się do uprawiania wszelkich dyscyplin sportowych!', 30.00, 100, '5', '1', 0, 1, '2023-05-09 11:27:37', 59, '2023-05-09 11:27:37', 59, 1),
(48, 'T-SHIRT HUGO BOSS DYSKRETNE MAŁE LOGO KLASYCZNY', 31, 'img/uploads/products/2023-05-09-11-31-17_t-shirt-hugo-boss-dyskretne-male-logo-klasyczny.png', NULL, NULL, 'Klasyczny t-shirt HUGO BOSS z dyskretnym logo wykonany został z dbałością o każdy detal co sprawi że będziesz chętnie do niego wracać i nosić go przy każdej okazji. Produkt z powodzeniem nada się również na prezent', 119.99, 100, '3', '0', 0, 0, '2023-05-09 11:31:17', 59, '2023-05-09 11:31:17', 59, 1),
(49, 'Koszulka T-shirt EA7 Emporio Armani ', 31, 'img/uploads/products/2023-05-09-11-33-20_koszulka-t-shirt-ea7-emporio-armani-czarna-r-xl.png', NULL, NULL, 'T-SHIRT EMPORIO ARMANI 3G1TM41 JHRZ', 89.99, 100, '2', '0', 2, 0, '2023-05-09 11:33:20', 59, '2023-05-09 11:33:20', 59, 1),
(50, 'Koszulka T-shirt JHK TSRA | M', 31, 'img/uploads/products/2023-05-09-11-35-36_koszulka-robocza-t-shirt-bawelniany-unisex-roz-m.png', NULL, NULL, 'Koszulka T-shirt JHK TSRA', 17.20, 1000, '2', '7', 2, 0, '2023-05-09 11:35:36', 59, '2023-05-09 11:35:36', 59, 1),
(51, 'Spodnie Jogger Jigga Wear | M', 32, 'img/uploads/products/2023-05-09-11-51-06_spodnie-jogger-jigga-wear-czarne-super-jakosc-m-fason-inny.png', 'img/uploads/products/2023-05-09-11-51-06_spodnie-jogger-jigga-wear-czarne-super-jakosc-m-rozmiar-m.png', 'img/uploads/products/2023-05-09-11-51-06_spodnie-jogger-jigga-wear-czarne-super-jakosc-m-dlugosc-nogawki-dluga.png', 'Unikatowe i wygodne spodnie materiałowe z haftowanym logotypem o regularnym kroju. Posiadają gumę w pasie regulowaną sznurkiem oraz cztery kieszenie.', 99.99, 1000, '2', '0', 0, 0, '2023-05-09 11:51:06', 59, '2023-05-09 11:51:06', 59, 1),
(52, 'Spodnie Jogger Jigga Wear | L', 32, 'img/uploads/products/2023-05-09-11-51-17_spodnie-jogger-jigga-wear-czarne-super-jakosc-m-fason-inny.png', 'img/uploads/products/2023-05-09-11-51-17_spodnie-jogger-jigga-wear-czarne-super-jakosc-m-rozmiar-m.png', 'img/uploads/products/2023-05-09-11-51-17_spodnie-jogger-jigga-wear-czarne-super-jakosc-m-dlugosc-nogawki-dluga.png', 'Unikatowe i wygodne spodnie materiałowe z haftowanym logotypem o regularnym kroju. Posiadają gumę w pasie regulowaną sznurkiem oraz cztery kieszenie.', 99.99, 1000, '3', '0', 0, 0, '2023-05-09 11:51:17', 59, '2023-05-09 11:51:17', 59, 1),
(53, 'Spodnie bojówki Fk_fashion | M', 32, 'img/uploads/products/2023-05-09-11-53-31_it096-1-r-38-robocze-bojowki-pasek-gratis-moro-rozmiar-38.png', 'img/uploads/products/2023-05-09-11-53-31_it096-1-r-38-robocze-bojowki-pasek-gratis-moro-wzor-dominujacy-bez-wzoru.png', NULL, 'Spodnie bojówki Fk_fashion', 105.00, 100, '2', '0', 0, 0, '2023-05-09 11:53:31', 59, '2023-05-09 11:53:31', 59, 1),
(54, 'Spodnie bojówki Fk_fashion | S', 32, 'img/uploads/products/2023-05-09-11-53-40_it096-1-r-38-robocze-bojowki-pasek-gratis-moro-rozmiar-38.png', 'img/uploads/products/2023-05-09-11-53-40_it096-1-r-38-robocze-bojowki-pasek-gratis-moro-wzor-dominujacy-bez-wzoru.png', NULL, 'Spodnie bojówki Fk_fashion', 105.00, 100, '1', '0', 0, 1, '2023-05-09 11:53:40', 59, '2023-05-09 11:53:40', 59, 1),
(55, 'Spodnie rybaczki Agrafka | XS', 32, 'img/uploads/products/2023-05-09-11-59-44_cienkie-spodnie-w-gumke-elastyczne-3-4-letnie-50-plec-produkt-damski.png', 'img/uploads/products/2023-05-09-11-59-44_cienkie-spodnie-w-gumke-elastyczne-3-4-letnie-50.png', NULL, 'Fason spodni jest bardzo przemyślany i sprawia, że są one bardzo wygodne w noszeniu. W pasie znajduje się bardzo rozciągliwa gumka, która zapewnia idealne dopasowanie do sylwetki. Przód spodni zdobią dwie kieszenie, ozdobione guzikami. Tył spodni ma bardziej stonowany, gładki wygląd. Dostępne są w dużej ilości rozmiarów, co z pewnością ucieszy każdą kobietę, która poszukuje modnych ubrań w swoim rozmiarze. Dół nogawek i pas spodni zostały ozdobione paseczkami.  Spodnie są idealne na co dzień - świetnie wyglądają, a jednocześnie zapewniają komfort i wygodę użytkowania. To doskonały wybór dla każdej kobiety, która ceni sobie modę i wygodę.', 79.90, 100, '0', '0', 1, 0, '2023-05-09 11:59:44', 59, '2023-05-09 11:55:44', 59, 1),
(56, 'Spodnie rybaczki Agrafka | S', 32, 'img/uploads/products/2023-05-09-11-59-28_cienkie-spodnie-w-gumke-elastyczne-3-4-letnie-50.png', 'img/uploads/products/2023-05-09-11-59-28_cienkie-spodnie-w-gumke-elastyczne-3-4-letnie-50-plec-produkt-damski.png', NULL, 'Fason spodni jest bardzo przemyślany i sprawia, że są one bardzo wygodne w noszeniu. W pasie znajduje się bardzo rozciągliwa gumka, która zapewnia idealne dopasowanie do sylwetki. Przód spodni zdobią dwie kieszenie, ozdobione guzikami. Tył spodni ma bardziej stonowany, gładki wygląd. Dostępne są w dużej ilości rozmiarów, co z pewnością ucieszy każdą kobietę, która poszukuje modnych ubrań w swoim rozmiarze. Dół nogawek i pas spodni zostały ozdobione paseczkami.  Spodnie są idealne na co dzień - świetnie wyglądają, a jednocześnie zapewniają komfort i wygodę użytkowania. To doskonały wybór dla każdej kobiety, która ceni sobie modę i wygodę.', 79.90, 100, '1', '0', 1, 1, '2023-05-09 11:59:29', 59, '2023-05-09 11:55:54', 59, 1),
(57, 'Spodnie dresowe bordowe Dresy PAKO LORENTE | L', 32, 'img/uploads/products/2023-05-09-11-59-11_spodnie-dresowe-bordowe-dresy-pako-lorente-r-l.png', 'img/uploads/products/2023-05-09-11-59-11_spodnie-dresowe-bordowe-dresy-pako-lorente-r-l-marka-pako-lorente.png', NULL, 'Spodnie dresowe bordowe Dresy PAKO LORENTE', 99.99, 100, '3', '7', 2, 0, '2023-05-09 11:59:11', 59, '2023-05-09 11:59:11', 59, 1),
(58, 'Spodnie proste | S', 32, 'img/uploads/products/2023-05-09-12-11-59_spodnie-damskie-wysoki-stan-mix-kolor-plus-size-fason-proste.png', NULL, NULL, 'długie, proste nogawki (Straight leg), w pasie szeroka niewpijająca się guma, z tyłu dwie kieszenie w szpic oraz z przodu dwie kieszenie  z ozdobnymi dżetami', 59.99, 100, '1', '7', 1, 1, '2023-05-09 12:11:59', 59, '2023-05-09 12:11:59', 59, 1);

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
(49, 'godzina.wychowawcza12@gmail.com', '$2y$10$e1gtlUufqOzZHxYDz2.ZvOO8jNkpMpcrwXMBPwZNY8lZUHE6HCuga', 'Damian', 'Raczek', '2022-12-30', '2023-04-01 22:02:34', 1, '2023-05-06 16:22:05', 49, 1),
(50, 'test1', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-05-06 17:00:48', 49, 1),
(51, 'test2', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-05-06 17:00:49', 49, 1),
(52, 'test3', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-05-06 17:00:25', 49, 1),
(53, 'test4', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-04-10 19:38:30', 49, 1),
(54, 'test5', 'test', 'test', 'test', '2023-04-02', '2023-04-02 14:23:32', 1, '2023-05-06 16:22:25', 49, 1),
(59, 'draczekprojekt@gmail.com', '$2y$10$VdcnF/x6CVWihhaXjTN1meqf.iJBL.p38amXN3rMJN0l6xkc8w8kS', 'Damian', 'Raczek', '2023-03-31', '2023-04-10 15:47:17', 1, '2023-05-06 17:00:48', 49, 1),
(60, 'damian.raczek4206695@gmail.com', '$2y$10$hUIhLo7gAGA7P93X3WiUuuTZ3i8CBZcj7LX8PPXfe7W9P/XvjhOde', 'DamianZmienione', 'RaczekZmienione', '2023-04-01', '2023-04-16 16:12:13', 1, '2023-05-06 17:00:47', 49, 1),
(61, 'admin@dRaczekProjekt.com', '$2y$10$LeS3ubSpd6OFFerPMMMSnufQKGHmRTuvqQQQlD8I9AfeLMQVd1sQ6', 'admin', 'admin', '2023-05-09', '2023-05-09 12:18:25', 1, '2023-05-09 12:18:25', 1, 1);

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
(7, 49),
(8, 59),
(9, 61);

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
  ADD KEY `user_id_created` (`user_id_created`),
  ADD KEY `user_id_last_modified` (`user_id_last_modified`),
  ADD KEY `orders_products_ibfk_1` (`order_id`),
  ADD KEY `orders_products_ibfk_2` (`product_id`);

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `delivery_methods`
--
ALTER TABLE `delivery_methods`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `orders_products`
--
ALTER TABLE `orders_products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `users_admin`
--
ALTER TABLE `users_admin`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users_token_action`
--
ALTER TABLE `users_token_action`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

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
  ADD CONSTRAINT `orders_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
