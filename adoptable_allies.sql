-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2024 at 04:18 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adoptable_allies`
--

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `description`, `banner_image`, `status`, `creator_id`, `pet_id`) VALUES
(10, 'Siberrean Huskey', '<p>The Siberian Husky is a medium-sized working dog breed. The breed belongs to the Spitz genetic family. It is recognizable by its thickly furred double coat, erect triangular ears, and distinctive markings, and is smaller than a very similar-looking dog, the Alaskan Malamute</p>', 'assets/images/animals/1708183574_puppy.jpg', 1, 2, 2),
(11, 'Siberrean Huskey', '<p>The Siberian Husky is a medium-sized working dog breed. The breed belongs to the Spitz genetic family. It is recognizable by its thickly furred double coat, erect triangular ears, and distinctive markings, and is smaller than a very similar-looking dog, the Alaskan Malamute</p>', 'assets/images/animals/1708183706_puppy.jpg', 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `animal_image`
--

CREATE TABLE `animal_image` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `animal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `animal_image`
--

INSERT INTO `animal_image` (`id`, `image`, `animal_id`) VALUES
(1, 'assets/images/animalimages/puppy.jpg', 11),
(2, 'assets/images/animalimages/rabbit.jpg', 11);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_id`, `user_id`, `quantity`) VALUES
(1, 7, 3, 1),
(2, 6, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`id`, `name`, `slug`, `banner_image`, `status`) VALUES
(1, 'Cat', 'cat', 'assets/images/pets/1708145640_cat.jpg', 1),
(2, 'Dog', 'dog', 'assets/images/pets/1708146886_puppy.jpg', 1),
(3, 'Rabbit', 'rabbit', 'assets/images/pets/1708146916_rabbit.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pet_products`
--

CREATE TABLE `pet_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `status` int(11) NOT NULL,
  `banner_image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `creator_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pet_products`
--

INSERT INTO `pet_products` (`id`, `title`, `description`, `quantity`, `price`, `status`, `banner_image`, `created_at`, `creator_id`, `pet_id`) VALUES
(2, 'Pads for Pet', '<p>Pads for pet description</p>', 50, 455, 1, 'assets/images/animals/1708529668_pads.png', '2024-02-21 15:34:28', 0, 2),
(3, 'Scratch Board', '<p>scratch board</p>', 50, 500, 1, 'assets/images/animals/1708529728_scratch-board.png', '2024-02-21 15:35:28', 0, 2),
(4, 'Pet Collar', '<p>pet collar</p>', 500, 200, 1, 'assets/images/animals/1708529770_collar.png', '2024-02-21 15:36:10', 0, 2),
(5, 'Pet Bag', '<p>pet bag</p>', 50, 1000, 1, 'assets/images/animals/1708529812_pet-bag-1.png', '2024-02-21 15:36:52', 0, 2),
(6, 'Pet Bag', '<p>cat bag</p>', 50, 800, 1, 'assets/images/animals/1708529845_pet-bag-2.png', '2024-02-21 15:37:25', 0, 1),
(7, 'Pet Grooming Brush', '<p>pet grooming brush</p>', 75, 600, 1, 'assets/images/animals/1708529912_grooming-brush.png', '2024-02-21 15:38:32', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `documents` varchar(255) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `token` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `phone`, `password`, `documents`, `type`, `token`, `status`, `expiry_date`, `created_at`, `updated_at`) VALUES
(2, 'Manish Kumar Dev', 'devmanish1743@gmail.com', '9813347990', '$2y$10$bmF.dfT4jyLdfC7xfEn7hes27DLD5qO9JobKkZj83T6IxnxS8O8aG', NULL, 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjIiLCJlbWFpbCI6ImRldm1hbmlzaDE3NDNAZ21haWwuY29tIiwibmFtZSI6Ik1hbmlzaCBLdW1hciBEZXYiLCJwaG9uZSI6Ijk4MTMzNDc5OTAiLCJ0eXBlIjoiMCIsInN0YXR1cyI6IjEiLCJleHBpcnlfZGF0ZSI6IjIwMjQtMDItMjMgMTA6MTA6MTcifQ.CWYOWGBOK6Jifo4s3wXYtXSHfnZJMcN8Hhvj7cTJ3ho', 1, '2024-02-23 10:10:17', '2024-01-03 17:24:21', '2024-01-03 17:24:21'),
(3, 'Savyata Verma', 'admin@admin.com', '9811234561', '$2y$10$bmF.dfT4jyLdfC7xfEn7hes27DLD5qO9JobKkZj83T6IxnxS8O8aG', NULL, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjMiLCJlbWFpbCI6ImFkbWluQGFkbWluLmNvbSIsIm5hbWUiOiJTYXZ5YXRhIFZlcm1hIiwicGhvbmUiOiI5ODExMjM0NTYxIiwidHlwZSI6IjEiLCJzdGF0dXMiOiIxIiwiZXhwaXJ5X2RhdGUiOiIyMDI0LTAzLTAzIDEzOjI4OjUwIn0.SGG0BJKlUhvNz0zgrygGbYcs4YTUgKLT9I_KKIuXE6A', 1, '2024-03-03 13:28:50', '2024-02-22 06:45:12', '2024-02-22 06:45:12'),
(4, 'Adoptable Allies', 'adoptablealliesssss@gmail.com', '9813347990', '$2y$10$bUkNN6AXssL43kapscFv.e06hQjI77FQMI0DhnE1Jwr4RLKeC7qPe', '{\"1\":\"assets\\/images\\/allies\\/balen.jpg\"}', 2, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjQiLCJlbWFpbCI6ImFkb3B0YWJsZWFsbGllc3Nzc3NAZ21haWwuY29tIiwibmFtZSI6IkFkb3B0YWJsZSBBbGxpZXMiLCJwaG9uZSI6Ijk4MTMzNDc5OTAiLCJ0eXBlIjoiMiIsInN0YXR1cyI6IjEiLCJleHBpcnlfZGF0ZSI6IjIwMjQtMDMtMDMgMTM6Mjg6MDAifQ.epI7-oP2Ud4u3C7N7byreE9ZQB8J-c-LDMgBUHJdf68', 1, '2024-03-03 13:28:00', '2024-02-22 10:01:44', '2024-02-22 10:01:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `animal_image`
--
ALTER TABLE `animal_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet_products`
--
ALTER TABLE `pet_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `animal_image`
--
ALTER TABLE `animal_image`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pet_products`
--
ALTER TABLE `pet_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
