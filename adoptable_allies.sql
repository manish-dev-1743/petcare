-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2024 at 04:23 PM
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
-- Table structure for table `adopt_approval`
--

CREATE TABLE `adopt_approval` (
  `id` int(10) UNSIGNED NOT NULL,
  `adopt_id` int(11) NOT NULL,
  `response` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `adopt_approval`
--

INSERT INTO `adopt_approval` (`id`, `adopt_id`, `response`) VALUES
(1, 1, '{\"approval\":\"accept\",\"datetime\":\"2024-03-11T23:46\",\"location\":\"Kathmandu\"}');

-- --------------------------------------------------------

--
-- Table structure for table `adopt_pet`
--

CREATE TABLE `adopt_pet` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `home_address` varchar(255) NOT NULL,
  `ownorRent` varchar(255) NOT NULL,
  `landlordPermission` varchar(255) NOT NULL,
  `ownedPetsBefore` varchar(255) NOT NULL,
  `experienceDescription` text NOT NULL,
  `adoptionReason` text NOT NULL,
  `openToSpecialNeeds` varchar(255) NOT NULL,
  `seen` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `adopt_pet`
--

INSERT INTO `adopt_pet` (`id`, `user_id`, `pet_id`, `fullname`, `number`, `email`, `home_address`, `ownorRent`, `landlordPermission`, `ownedPetsBefore`, `experienceDescription`, `adoptionReason`, `openToSpecialNeeds`, `seen`, `created_at`) VALUES
(1, 3, 11, 'Manish Kumar Dev', '9813347990', 'devmanish1743@gmail.com', 'Kathmandu,Nepal', 'rent', 'yes', 'No', 'Pet Description', 'Pet Description Pet Description Pet Description', 'Yes', 0, '2024-03-09 12:12:23');

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
  `pet_id` int(11) NOT NULL,
  `age` varchar(255) DEFAULT NULL,
  `breed` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `description`, `banner_image`, `status`, `creator_id`, `pet_id`, `age`, `breed`, `gender`, `size`) VALUES
(10, 'Tiger', '<p>The Siberian Husky is a medium-sized working dog breed. The breed belongs to the Spitz genetic family. It is recognizable by its thickly furred double coat, erect triangular ears, and distinctive markings, and is smaller than a very similar-looking dog, the Alaskan Malamute</p>', 'assets/images/animals/1708183574_puppy.jpg', 1, 4, 2, '2 years', 'Siberrean Huskey', 'Male', '2 foot'),
(11, 'Siberrean Huskey', '<p>The Siberian Husky is a medium-sized working dog breed. The breed belongs to the Spitz genetic family. It is recognizable by its thickly furred double coat, erect triangular ears, and distinctive markings, and is smaller than a very similar-looking dog, the Alaskan Malamute</p>', 'assets/images/animals/1708183706_puppy.jpg', 1, 4, 1, '', '', 'Female', '');

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
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `banner_image` varchar(255) NOT NULL,
  `summary` tinytext NOT NULL,
  `description` mediumtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `banner_image`, `summary`, `description`, `created_at`) VALUES
(1, 'Tips for Bringing a rescue dog home', 'assets/images/blogs/1711767956_cat.jpg', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temp or incididunt ut labore et dolore magna aliqua. Ut enim ad minim.', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temp or incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temp or incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temp or incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p><p>Lorem ipsum dolor sit amet, consectetur adipisicingLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temp or incididunt ut labore et dolore magna aliqua. Ut enim ad minim. elit, sed do eiusmod temp or incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temp or incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temp or incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>', '2024-03-30 03:05:56'),
(2, 'Tips for Bringing', 'assets/images/blogs/1711768061_banner-3.png', 'Tips for Bringing a rescue dog home Tips for Bringing a rescue dog home Tips for Bringing a rescue dog home', '<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', '2024-03-30 03:07:41'),
(3, 'Test blog  by developer', 'assets/images/blogs/1711808719_rabbit.jpg', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one ', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.</p>', '2024-03-30 14:25:19');

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
(2, 6, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `uuid` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `name`, `email`, `phone`, `amount`, `payment_status`, `signature`, `uuid`, `created_at`) VALUES
(1, 'Manish Kumar Dev', 'admin@admin.com', '9813347990', '10000', '0', 'zRPqM5ENuT8AeLBFDCBeradkYN3uN4RDHgQ8DxcJLZU=', 'DONATION_1711356911', '2024-03-25 14:40:11'),
(2, 'Manish Kumar Dev', 'admin@admin.com', '9813347990', '1000', '0', '4Y4+dpQYLdkQijWOHVLYByLru5SV0WBl9pMm9htRPbY=', 'DONATION_1711356920', '2024-03-25 14:40:20'),
(3, 'Manish Kumar Dev', 'manish.dev@kmg.com.np', '9813347990', '1000', '1', 'gSo63l8KjcGrnzwftntOMOnrhZoE6Wt5o26n9fVOOVs=', 'DONATION_1711358342', '2024-03-25 15:04:02');

-- --------------------------------------------------------

--
-- Table structure for table `my_order`
--

CREATE TABLE `my_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_ids` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `is_paid` int(11) NOT NULL,
  `delivery_date` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `uniq_id` int(11) NOT NULL,
  `seen` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `uniq_id`, `seen`, `created_at`) VALUES
(1, 3, 'blog_add', 3, 0, '2024-03-30 14:25:19');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `cart_ids` varchar(255) NOT NULL,
  `location` tinytext NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `amount` float NOT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `uuid` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `cart_ids`, `location`, `payment_type`, `payment_status`, `amount`, `signature`, `uuid`, `created_at`) VALUES
(1, 3, '1,2', 'Kathmandu', 'esewa', '0', 2200, 'MiB8iAOF9c9K+OCDCL5nRoygg6Ho/0iCjpjrAMeemqY=', 'EPAY_1711437943', '2024-03-26 13:10:43');

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
-- Table structure for table `save_list`
--

CREATE TABLE `save_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(2, 'Super Admin', 'admin@admin.com', '9813347990', '$2y$10$SYCvLD8lP322jJjw8ABRKetFPAUvnr6l2th7hg7JZPCopD5jJnv/C', NULL, 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjIiLCJlbWFpbCI6ImRldm1hbmlzaDE3NDNAZ21haWwuY29tIiwibmFtZSI6Ik1hbmlzaCBLdW1hciBEZXYiLCJwaG9uZSI6Ijk4MTMzNDc5OTAiLCJ0eXBlIjoiMCIsInN0YXR1cyI6IjEiLCJleHBpcnlfZGF0ZSI6IjIwMjQtMDMtMzEgMTQ6MjQ6MTMifQ.D08R_30J637750w__X_Pt3EKrYM-05Euns57-i4qOKM', 1, '2024-03-31 14:24:13', '2024-01-03 17:24:21', '2024-01-03 17:24:21'),
(3, 'User', 'user@user.com', '9811234561', '$2y$10$SYCvLD8lP322jJjw8ABRKetFPAUvnr6l2th7hg7JZPCopD5jJnv/C', '[]', 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjMiLCJlbWFpbCI6InVzZXJAdXNlci5jb20iLCJuYW1lIjoiVXNlciIsInBob25lIjoiOTgxMTIzNDU2MSIsInR5cGUiOiIxIiwic3RhdHVzIjoiMSIsImV4cGlyeV9kYXRlIjoiMjAyNC0wMy0zMSAxNToxNjowMCJ9.QY22REFaBJwEaBW67uIzz8EV3IiuNf-ok2TU00VVZWE', 1, '2024-03-31 15:16:00', '2024-02-22 06:45:12', '2024-02-22 06:45:12'),
(4, 'Allies', 'allies@allies.com', '9813347990', '$2y$10$SYCvLD8lP322jJjw8ABRKetFPAUvnr6l2th7hg7JZPCopD5jJnv/C', '{\"1\":\"assets\\/images\\/allies\\/balen.jpg\"}', 2, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjQiLCJlbWFpbCI6ImFkb3B0YWJsZWFsbGllc3Nzc3NAZ21haWwuY29tIiwibmFtZSI6IkFkb3B0YWJsZSBBbGxpZXMiLCJwaG9uZSI6Ijk4MTMzNDc5OTAiLCJ0eXBlIjoiMiIsInN0YXR1cyI6IjEiLCJleHBpcnlfZGF0ZSI6IjIwMjQtMDMtMzEgMTQ6MzQ6MDkifQ.AMgwKyXK3-yzsR68ac5ztnqBc30PIvLLxesXkEqp4Js', 1, '2024-03-31 14:34:09', '2024-02-22 10:01:44', '2024-02-22 10:01:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adopt_approval`
--
ALTER TABLE `adopt_approval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adopt_pet`
--
ALTER TABLE `adopt_pet`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `my_order`
--
ALTER TABLE `my_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
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
-- Indexes for table `save_list`
--
ALTER TABLE `save_list`
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
-- AUTO_INCREMENT for table `adopt_approval`
--
ALTER TABLE `adopt_approval`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `adopt_pet`
--
ALTER TABLE `adopt_pet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `my_order`
--
ALTER TABLE `my_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `save_list`
--
ALTER TABLE `save_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
