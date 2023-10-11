-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2023 at 09:18 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edu`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabbyconfigs`
--

CREATE TABLE `tabbyconfigs` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `token` text NOT NULL,
  `status` int(11) NOT NULL,
  `instalments` int(11) NOT NULL DEFAULT 3,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  `locked_facilities` text NOT NULL,
  `text` longtext NOT NULL,
  `text_en` longtext NOT NULL,
  `notification` varchar(255) NOT NULL,
  `merchant_id` varchar(255) NOT NULL,
  `webhook_id` varchar(255) NOT NULL,
  `authorization` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tabbyconfigs`
--

INSERT INTO `tabbyconfigs` (`id`, `url`, `token`, `status`, `instalments`, `min`, `max`, `locked_facilities`, `text`, `text_en`, `notification`, `merchant_id`, `webhook_id`, `authorization`, `created_at`, `updated_at`) VALUES
(1, 'https://api.tabby.ai/api/v2/checkout', 'pk_test_7ce7c632-b878-4573-8e27-521d258968f2', 1, 4, 10, 5000, '10,58,72,77,102,112,122,128,129,134,150,151,154,161,172,173,176,178,184,187,193,194,195,196,198,199,200,203,204,208,209', 'تسوق وقسم فاتورتك على دفعات يعني لا تحتاج معاملات طويلة او اوراق تسجيل بل رقم هاتفك وهويتك لتضمن امان عملية الدفع! تقسيم إلى دفعات متعددة. بدون رسوم\r\n\r\n- الحد الادنى : 10 ريال سعودي\r\n- الحد الأقصى : 5000 ريال سعودي\r\n\r\nالأقساط المعتمدة\r\n- عدد الاقساط : 4\r\n- الحد الادنى للقسط : 10\r\n- الحد الاقصى للقسط : 5000', 'Shop and divide your bill into installments, which means that you do not need long transactions or registration papers, but rather your phone number and identity to ensure the security of the payment process! Split into multiple batches. Without fees\r\n\r\n- Minimum amount: 10 Saudi riyals\r\n- Maximum limit: 5000 Saudi riyals\r\n\r\napproved installments \r\n- Number of installments: 4 \r\n- Minimum installment: 10 \r\n- The maximum installment: 5000', 'not', 'theedukeysau', '', '', '2023-06-19 19:05:06', '2023-06-20 05:05:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabbyconfigs`
--
ALTER TABLE `tabbyconfigs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabbyconfigs`
--
ALTER TABLE `tabbyconfigs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
