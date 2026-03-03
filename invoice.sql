-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2025 at 10:49 AM
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
-- Database: `food_order`
--

DELIMITER $$

DROP PROCEDURE IF EXISTS ConfirmOrderAndReduceQuantity$$

CREATE DEFINER=`root`@`localhost`
PROCEDURE ConfirmOrderAndReduceQuantity (IN p_order_id INT)
BEGIN
    DECLARE v_product_id INT;
    DECLARE v_quantity_ordered INT;
    DECLARE v_product_quantity INT;
    DECLARE done INT DEFAULT 0;

    DECLARE cur_items CURSOR FOR
        SELECT product_id, quantity
        FROM order_items
        WHERE order_id = p_order_id;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    START TRANSACTION;

    OPEN cur_items;

    read_loop: LOOP
        FETCH cur_items INTO v_product_id, v_quantity_ordered;

        IF done = 1 THEN
            LEAVE read_loop;
        END IF;

        SELECT quantity
        INTO v_product_quantity
        FROM products
        WHERE id = v_product_id
        FOR UPDATE;

        IF v_product_quantity < v_quantity_ordered THEN
            ROLLBACK;
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Not enough stock for product';
        END IF;

        UPDATE products
        SET quantity = quantity - v_quantity_ordered
        WHERE id = v_product_id;
    END LOOP;

    CLOSE cur_items;

    UPDATE orders
    SET status = 'confirmed'
    WHERE id = p_order_id;

    COMMIT;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category_image` varchar(255) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `icon_class` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `category_image`, `is_active`, `created_at`, `updated_at`, `icon_class`) VALUES
(17, 'Coffee', 'The coffee category includes a variety of rich and aromatic coffee beverages. From Espresso to Latte and Cappuccino, these drinks are crafted with high_quality coffee to energize and fresh consumers, making them perfect for mornings or any time of the day.', '1756289388_download.jfif', 1, '2025-08-27 10:09:48', '2025-08-27 16:10:31', NULL),
(20, 'Appetizers', 'An appetizer is a small, savory dish served before a main meal.\r\nIts purpose is to stimulate the appetite and prepare the palate for the dishes to come.\r\nOften served as finger food or a small course, it\'s designed to be light and not too filling.\r\nAppetizers can also be a social item, enjoyed with a drink while mingling before the main event.', '1756799543_Appetizers.jpg', 1, '2025-09-02 07:52:23', '2025-09-02 07:52:23', NULL),
(21, 'Main Courses', 'The main course, or entrée, is the primary and most substantial dish of a meal. It is the central part of the dining experience, typically featuring a protein like meat, fish, or a vegetarian alternative, accompanied by starches and vegetables.', '1756799877_main coursw.jpg', 1, '2025-09-02 07:57:57', '2025-09-02 07:57:57', NULL),
(22, 'Desserts', 'Desserts are sweet courses served at the end of a meal to provide a satisfying, concluding finish. They come in a vast array of forms, including cakes, pies, ice cream, pastries, and fruit. The role of a dessert is to offer a pleasant contrast to the savory flavors of the main course.', '1756804467_dessert.avif', 1, '2025-09-02 09:14:27', '2025-09-02 09:14:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` enum('pending','confirmed','paid','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `total_amt` decimal(10,2) DEFAULT NULL,
  `delivery_fee` decimal(10,2) DEFAULT NULL,
  `tax_amount` decimal(10,2) DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `order_id`, `status`, `created_at`, `user_id`, `total_amt`, `delivery_fee`, `tax_amount`, `grand_total`) VALUES
(31, 'INV-20250830073711-83', 83, 'confirmed', '2025-08-30 01:07:11', NULL, NULL, NULL, NULL, NULL),
(32, 'INV-20250830084350-84', 84, 'confirmed', '2025-08-30 02:13:50', NULL, NULL, NULL, NULL, NULL),
(35, '', 98, 'pending', '2025-08-30 04:50:34', 39, 90000.00, 5.00, 4500.00, 94505.00),
(36, 'INV-20250830-9569-99', 99, 'pending', '2025-08-30 04:56:26', 39, 180000.00, 5.00, 9000.00, 189005.00),
(37, 'INV-20250830154444-100', 100, 'pending', '2025-08-30 09:14:44', NULL, NULL, NULL, NULL, NULL),
(38, 'INV-20250831151154-101', 101, 'pending', '2025-08-31 08:41:54', NULL, NULL, NULL, NULL, NULL),
(39, 'INV-20250901-5154-102', 102, 'pending', '2025-08-31 23:14:03', 21, 36000.00, 5.00, 1800.00, 37805.00),
(40, 'INV-20250902-9286-103', 103, 'pending', '2025-09-02 04:00:01', 21, 27000.00, 5.00, 1350.00, 28355.00),
(41, 'INV-20250902104032-104', 104, 'pending', '2025-09-02 04:10:32', NULL, NULL, NULL, NULL, NULL),
(42, 'INV-20250902104151-105', 105, 'pending', '2025-09-02 04:11:51', NULL, NULL, NULL, NULL, NULL),
(43, 'INV-20250902120626-106', 106, 'pending', '2025-09-02 05:36:26', NULL, NULL, NULL, NULL, NULL),
(44, 'INV-20250903-8637-107', 107, 'pending', '2025-09-03 01:14:04', 21, 1050000.00, 5.00, 52500.00, 1102505.00),
(45, 'INV-20250903114255-108', 108, 'pending', '2025-09-03 05:12:55', NULL, NULL, NULL, NULL, NULL),
(46, 'INV-20250903114330-109', 109, 'pending', '2025-09-03 05:13:30', NULL, NULL, NULL, NULL, NULL),
(47, 'INV-20250903122458-110', 110, 'pending', '2025-09-03 05:54:58', NULL, NULL, NULL, NULL, NULL),
(48, 'INV-20250904095155-111', 111, 'pending', '2025-09-04 03:21:55', NULL, NULL, NULL, NULL, NULL),
(49, 'INV-20250904101115-112', 112, 'pending', '2025-09-04 03:41:15', NULL, NULL, NULL, NULL, NULL),
(50, 'INV-20250904101659-113', 113, 'pending', '2025-09-04 03:46:59', NULL, NULL, NULL, NULL, NULL),
(51, 'INV-20250904102410-114', 114, 'pending', '2025-09-04 03:54:10', NULL, NULL, NULL, NULL, NULL),
(52, 'INV-20250904111053-115', 115, 'pending', '2025-09-04 04:40:53', NULL, NULL, NULL, NULL, NULL),
(53, 'INV-20250904121422-116', 116, 'pending', '2025-09-04 05:44:22', NULL, NULL, NULL, NULL, NULL),
(54, 'INV-20250904121458-117', 117, 'pending', '2025-09-04 05:44:58', NULL, NULL, NULL, NULL, NULL),
(55, 'INV-20250904125415-118', 118, 'pending', '2025-09-04 06:24:15', NULL, NULL, NULL, NULL, NULL),
(56, 'INV-20250904-8692-118', 118, 'pending', '2025-09-04 06:50:59', 21, 7000.00, 5.00, 350.00, 7355.00);

-- --------------------------------------------------------

--
-- Stand-in structure for view `invoice_summary_view`
-- (See below for the actual view)
--
CREATE TABLE `invoice_summary_view` (
`invoice_number` varchar(255)
,`invoice_date` timestamp
,`order_id` int(11)
,`order_status` varchar(30)
,`order_subtotal` decimal(10,0)
,`delivery_fee` decimal(10,2)
,`tax_amount` decimal(10,2)
,`grand_total` decimal(10,2)
,`customer_name` varchar(255)
,`customer_email` varchar(255)
,`customer_phone_number` varchar(30)
);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `total_amt` decimal(10,0) NOT NULL,
  `delivery_address` text NOT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `transaction_id` varchar(255) DEFAULT NULL,
  `delivery_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `payment_method_id`, `total_amt`, `delivery_address`, `status`, `created_at`, `updated_at`, `transaction_id`, `delivery_fee`, `tax_amount`, `grand_total`) VALUES
(83, 21, 1, 450000, '7th Street\r\n5th Street', 'confirmed', '2025-09-01 06:30:20', '2025-08-30 05:37:11', NULL, 5.00, 22500.00, 472505.00),
(84, 39, 1, 100000, 'Mandalay', 'cancelled', '2025-09-02 08:26:16', '2025-09-02 03:56:16', NULL, 5.00, 5000.00, 105005.00),
(87, 39, 1, 450000, 'Pantanaw', 'pending', '2025-08-30 02:59:54', '2025-08-30 02:59:54', NULL, 5.00, 22500.00, 472505.00),
(92, 39, 1, 90000, 'Pantanaw', 'confirmed', '2025-08-30 07:58:57', '2025-08-30 03:28:38', NULL, 5.00, 4500.00, 94505.00),
(94, 39, 1, 360000, 'Yangon', 'confirmed', '2025-08-30 08:12:07', '2025-08-30 03:41:44', NULL, 5.00, 18000.00, 378005.00),
(97, 39, 1, 180000, 'Yangon', 'confirmed', '2025-08-30 09:03:41', '2025-08-30 04:33:13', NULL, 5.00, 9000.00, 189005.00),
(98, 39, 1, 90000, 'Pantanaw', 'confirmed', '2025-08-30 09:20:34', '2025-08-30 04:50:24', NULL, 5.00, 4500.00, 94505.00),
(99, 39, 1, 180000, 'Mandalay', 'confirmed', '2025-08-30 09:26:26', '2025-08-30 04:56:15', NULL, 5.00, 9000.00, 189005.00),
(100, 39, 1, 109000, 'Naypyitaw', 'pending', '2025-08-30 13:44:44', '2025-08-30 13:44:44', NULL, 5.00, 5450.00, 114455.00),
(101, 21, 1, 27000, 'Lanmadaw Street\r\n5th Street', 'cancelled', '2025-09-02 08:27:37', '2025-09-02 03:57:37', NULL, 5.00, 1350.00, 28355.00),
(102, 21, 1, 36000, 'Yangon', 'confirmed', '2025-09-01 06:30:20', '2025-08-31 23:13:55', NULL, 5.00, 1800.00, 37805.00),
(103, 21, 1, 27000, 'Yangon', 'confirmed', '2025-09-02 08:30:01', '2025-09-02 03:59:36', NULL, 5.00, 1350.00, 28355.00),
(104, 21, 1, 14000, '7th Street\r\n5th Street', 'pending', '2025-09-02 08:40:32', '2025-09-02 08:40:32', NULL, 5.00, 700.00, 14705.00),
(105, 21, 1, 16000, '7th Street\r\n5th Street', 'cancelled', '2025-09-02 09:03:26', '2025-09-02 04:33:26', NULL, 5.00, 800.00, 16805.00),
(106, 21, 1, 21000, 'Lanmadaw Street\r\n5th Street', 'pending', '2025-09-02 10:06:26', '2025-09-02 10:06:26', NULL, 5.00, 1050.00, 22055.00),
(107, 21, 1, 1050000, 'Yangon', 'confirmed', '2025-09-03 05:44:04', '2025-09-03 01:13:44', NULL, 5.00, 52500.00, 1102505.00),
(108, 21, 1, 14000, '7th Street\r\n5th Street', 'pending', '2025-09-03 09:42:55', '2025-09-03 09:42:55', NULL, 5.00, 700.00, 14705.00),
(109, 21, 1, 10000, '7th Street\r\n5th Street', 'pending', '2025-09-03 09:43:30', '2025-09-03 09:43:30', NULL, 5.00, 500.00, 10505.00),
(110, 21, 1, 10000, 'Lanmadaw Street\r\n5th Street', 'pending', '2025-09-03 10:24:58', '2025-09-03 10:24:58', NULL, 5.00, 500.00, 10505.00),
(111, 21, 1, 217000, '7th Street\r\n5th Street', 'pending', '2025-09-04 07:51:55', '2025-09-04 07:51:55', NULL, 5.00, 10850.00, 227855.00),
(112, 21, 1, 7000, '7th Street\r\n5th Street', 'pending', '2025-09-04 08:11:15', '2025-09-04 08:11:15', NULL, 5.00, 350.00, 7355.00),
(113, 21, 1, 10000, '7th Street\r\n5th Street', 'pending', '2025-09-04 08:16:59', '2025-09-04 08:16:59', NULL, 5.00, 500.00, 10505.00),
(114, 21, 1, 8000, 'Lanmadaw Street\r\n5th Street', 'pending', '2025-09-04 08:24:10', '2025-09-04 08:24:10', NULL, 5.00, 400.00, 8405.00),
(115, 21, 1, 7000, '7th Street\r\n5th Street', 'pending', '2025-09-04 09:10:53', '2025-09-04 09:10:53', NULL, 5.00, 350.00, 7355.00),
(116, 21, 1, 8000, '7th Street\r\n5th Street', 'pending', '2025-09-04 10:14:22', '2025-09-04 10:14:22', NULL, 5.00, 400.00, 8405.00),
(117, 21, 1, 7000, '7th Street\r\n5th Street', 'cancelled', '2025-09-04 10:52:28', '2025-09-04 06:22:28', NULL, 5.00, 350.00, 7355.00),
(118, 21, 1, 7000, '7th Street\r\n5th Street', 'confirmed', '2025-09-04 11:20:59', '2025-09-04 10:54:15', NULL, 5.00, 350.00, 7355.00);

--
-- Triggers `orders`
--
DELIMITER $$

DROP TRIGGER IF EXISTS restore_stock_on_cancel$$

CREATE TRIGGER restore_stock_on_cancel
AFTER UPDATE ON orders
FOR EACH ROW
BEGIN
    IF NEW.status = 'cancelled' AND OLD.status <> 'cancelled' THEN
        UPDATE products p
        JOIN order_items oi ON p.id = oi.product_id
        SET p.quantity = p.quantity + oi.quantity
        WHERE oi.order_id = NEW.id;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `order_details`
-- (See below for the actual view)
--
CREATE TABLE `order_details` (
`order_id` int(11)
,`total_amt` decimal(10,0)
,`grand_total` decimal(10,2)
,`tax_amount` decimal(10,2)
,`delivery_fee` decimal(10,2)
,`delivery_address` text
,`status_name` varchar(30)
,`created_at` timestamp
,`updated_at` timestamp
,`customer_name` varchar(255)
,`customer_email` varchar(255)
,`customer_phone_number` varchar(30)
,`payment_method_name` varchar(30)
,`payment_method_logo` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(104, 83, 12, 50, 9000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(105, 84, 10, 1, 10000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(106, 84, 12, 10, 9000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(109, 87, 14, 50, 9000, '2025-08-30 09:29:54', '0000-00-00 00:00:00'),
(114, 92, 8, 10, 9000, '2025-08-30 09:58:38', '0000-00-00 00:00:00'),
(116, 94, 9, 40, 9000, '2025-08-30 10:11:44', '0000-00-00 00:00:00'),
(119, 97, 8, 20, 9000, '2025-08-30 11:03:13', '0000-00-00 00:00:00'),
(120, 98, 10, 9, 10000, '2025-08-30 11:20:24', '0000-00-00 00:00:00'),
(121, 99, 8, 10, 9000, '2025-08-30 11:26:15', '0000-00-00 00:00:00'),
(122, 99, 12, 10, 9000, '2025-08-30 11:26:15', '0000-00-00 00:00:00'),
(123, 100, 11, 2, 8000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(124, 100, 14, 2, 9000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(125, 100, 10, 3, 10000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(126, 100, 12, 5, 9000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(127, 101, 14, 3, 9000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(128, 102, 8, 4, 9000, '2025-09-01 05:43:55', '0000-00-00 00:00:00'),
(129, 103, 8, 3, 9000, '2025-09-02 10:29:36', '0000-00-00 00:00:00'),
(130, 104, 15, 2, 7000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(131, 105, 16, 2, 8000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(132, 106, 15, 3, 7000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(133, 107, 15, 150, 7000, '2025-09-03 07:43:44', '0000-00-00 00:00:00'),
(134, 108, 15, 1, 7000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(135, 108, 20, 1, 7000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(136, 109, 10, 1, 10000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(137, 110, 10, 1, 10000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(138, 111, 8, 3, 9000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(139, 111, 10, 12, 10000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(140, 111, 11, 2, 8000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(141, 111, 12, 2, 9000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(142, 111, 14, 4, 9000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(143, 112, 21, 1, 7000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(144, 113, 10, 1, 10000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(145, 114, 16, 1, 8000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(146, 115, 15, 1, 7000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(147, 116, 18, 1, 8000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(148, 117, 21, 1, 7000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(149, 118, 15, 1, 7000, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `order_items_view`
-- (See below for the actual view)
--
CREATE TABLE `order_items_view` (
`order_id` int(11)
,`product_id` int(11)
,`quantity` int(11)
,`price` decimal(10,0)
,`product_name` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `payment_name` varchar(30) NOT NULL,
  `status` varchar(100) NOT NULL,
  `logo_url` varchar(255) NOT NULL,
  `account_details` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payment_name`, `status`, `logo_url`, `account_details`, `created_at`) VALUES
(1, 'Cash On Delivery', '', '', '', '2025-08-18 07:05:00'),
(2, 'PayPal', '', '', '', '2025-08-18 07:05:00'),
(3, 'Credit Card', '', '', '', '2025-08-18 07:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `is_available` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_hot` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_name`, `description`, `price`, `quantity`, `product_img`, `is_available`, `created_at`, `is_hot`) VALUES
(8, 17, 'Espresso', 'Espresso is a concentrated coffee beverage brewed by forcing a small amount of nearly boiling water under pressure through finely-ground coffee beans. It is the base for many popular coffee drinks, including lattes and cappuccinos.', 9000, 0, '1756312498_photo-1609359487505-2332d06b3d6a.avif', 1, '2025-09-04 07:51:55', 0),
(9, 17, 'Americano', 'An Americano is a simple coffee drink made by diluting a shot of espresso with hot water. This process creates a beverage that has a similar strength and volume to drip coffee but with the richer, more complex flavor profile of espresso.', 9000, 0, '1756480555_americano.avif', 1, '2025-09-02 05:02:36', 0),
(10, 17, 'Cappuccino', 'A cappuccino is a classic Italian coffee drink made with equal parts of espresso, steamed milk, and milk foam. It is known for its distinct three-layer structure and a rich, creamy texture.', 10000, 6, '1756480696_cappuccino.avif', 1, '2025-09-04 08:16:59', 0),
(11, 17, 'Latte', 'A latte is a coffee beverage made with a shot of espresso and a large amount of steamed milk, topped with a thin layer of milk foam. It is known for its smooth and creamy texture, with a milder coffee flavor than a cappuccino.', 8000, 8, '1756480827_latte.avif', 1, '2025-09-04 07:51:55', 0),
(12, 17, 'Irish Coffee', 'Irish Coffee is a warming cocktail made with hot coffee, Irish whiskey, and sugar, topped with a thick layer of cream. The drink is famously served in a clear glass, with the drinker sipping the hot, boozy coffee through the cool layer of cream.', 9000, 18, '1756480944_irrish.avif', 1, '2025-09-04 07:51:55', 0),
(13, 17, 'Flat White', 'A flat white is an espresso-based coffee drink originating from Australia and New Zealand. It is prepared with a shot of espresso and microfoam, which is steamed milk with a very fine, velvety texture and little to no froth.', 9000, 0, '1756481044_flat white.avif', 1, '2025-09-02 05:02:54', 0),
(14, 17, 'Ristretto', 'A ristretto is a \"restricted\" shot of espresso, made with the same amount of ground coffee but less water. This shorter extraction process results in a more concentrated, sweeter, and less bitter beverage with a fuller body than a standard espresso shot.', 9000, 1, '1756481182_rstretto.avif', 1, '2025-09-04 07:51:55', 0),
(15, 20, 'Spring Rolls', 'Spring rolls are a versatile Asian appetizer made by rolling up a savory filling in a thin pastry or rice paper wrapper. They can be served fresh with dipping sauce or fried until golden brown and crispy.', 7000, 341, '1756799662_Spring Rolls.jpg', 1, '2025-09-04 11:20:59', 0),
(16, 20, 'Dumplings', 'Dumplings are a broad category of dishes consisting of pieces of dough, often wrapped around a savory or sweet filling. They are prepared in many ways, including boiling, steaming, frying, or baking, and are a staple in cuisines worldwide.', 8000, 299, '1756799776_Dumplings.jpg', 1, '2025-09-04 08:24:10', 0),
(17, 21, 'Grilled Salmon', 'Grilled salmon is a healthy and flavorful dish featuring a salmon fillet cooked on a grill, which gives it a smoky flavor and a tender, flaky texture.', 12000, 200, '1756799993_Grilled Salmon.jpg', 1, '2025-09-02 03:29:53', 0),
(18, 21, 'Spaghetti Bolognese', 'Spaghetti Bolognese is a classic Italian-American pasta dish featuring a rich, slow-cooked meat sauce made with beef and tomatoes. The hearty sauce is traditionally served over a bed of long, thin spaghetti noodles.', 8000, 299, '1756804070_Spaghetti Bolognese.avif', 1, '2025-09-04 10:14:22', 0),
(19, 21, 'Shrimp Scampi', 'Shrimp Scampi is an Italian-American dish consisting of shrimp sautéed in a sauce of garlic, butter, and white wine. It\'s often served over pasta or with crusty bread for dipping.', 15000, 500, '1756805286_Shrimp Scampi.avif', 1, '2025-09-02 04:58:06', 0),
(20, 22, 'Crème Brûlée', 'Crème brûlée is a classic French dessert consisting of a rich, creamy custard base, typically flavored with vanilla. It is topped with a layer of sugar that is caramelized with a blowtorch or broiler to form a hard, glassy crust.', 7000, 299, '1756804620_Crème Brûlée.avif', 1, '2025-09-02 04:47:00', 0),
(21, 22, 'Chocolate Lava Cake', 'Chocolate Lava Cake is a rich, decadent dessert with a gooey, molten chocolate center that flows out when the cake is cut. This warm cake is often served with a scoop of vanilla ice cream.', 7000, 399, '1756805341_Chocolate Lava Cake.webp', 1, '2025-09-04 10:52:28', 0),
(22, 22, 'Apple Pie', 'Apple pie is a classic dessert with a flaky, buttery crust and a sweet filling of sliced apples, spices, and sugar. It is often served warm, sometimes topped with a scoop of vanilla ice cream or a slice of cheddar cheese.', 8000, 400, '1756805043_Apple Pie.avif', 1, '2025-09-02 04:54:03', 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `recent_orders_with_images`
-- (See below for the actual view)
--
CREATE TABLE `recent_orders_with_images` (
`order_id` int(11)
,`user_id` int(11)
,`created_at` timestamp
,`total_amt` decimal(10,0)
,`status` varchar(30)
,`product_id` int(11)
,`product_name` varchar(255)
,`product_img` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `today_revenue`
-- (See below for the actual view)
--
CREATE TABLE `today_revenue` (
`total_revenue` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `is_confirmed` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_login` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `date` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `password`, `profile_image`, `role`, `is_confirmed`, `is_active`, `is_login`, `token`, `reset_token`, `reset_token_expiry`, `date`, `created_at`) VALUES
(21, 'Win Myat Phyo', 'winmyatphyo5@gmail.com', '09973412375', '$2y$10$6PfAUA90Ul6VxVkSyGInLOMAdUSHADB4.QpTrV6M4OlxuvCADPTRe', '1756885148_profile.jfif', 0, 1, 0, 0, '', NULL, NULL, 2025, '2025-09-03 07:39:08'),
(22, 'Admin', 'admin@gmail.com', '09691948929', '$2y$10$K..tbSkulh7eSZfejREZh.T4RPI/dgqL8xzQAQi5f4LJ9SxxBklBK', '1756718613_download.png', 1, 1, 1, 0, '', NULL, NULL, 2025, '2025-09-01 09:23:33'),
(39, 'Win Myat Nwe', 'winmyatnwe@gmail.com', '09691948929', '$2y$10$pL0hDEy4KLoVo0uNLLrEKeQ/HVWg/zspIyQfcx/d/GVHhr45fycPy', '1756370900_Screenshot (2).png', 0, 1, 1, 0, '', NULL, NULL, 2025, '2025-08-28 08:48:20');

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_order_history_view`
-- (See below for the actual view)
--
CREATE TABLE `user_order_history_view` (
`order_id` int(11)
,`order_date` timestamp
,`user_id` int(11)
,`grand_total` decimal(10,2)
,`status` varchar(30)
,`payment_method` varchar(30)
,`invoice_number` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_total_order`
-- (See below for the actual view)
--
CREATE TABLE `user_total_order` (
`id` int(11)
,`name` varchar(255)
,`email` varchar(255)
,`profile_image` varchar(255)
,`role` int(11)
,`total_orders` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_best_selling_products`
-- (See below for the actual view)
--
CREATE TABLE `v_best_selling_products` (
`id` int(11)
,`product_name` varchar(255)
,`description` text
,`price` decimal(10,0)
,`product_img` varchar(255)
,`quantity` int(11)
,`total_sold` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Structure for view `invoice_summary_view`
--
DROP TABLE IF EXISTS `invoice_summary_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `invoice_summary_view`  AS SELECT `i`.`invoice_number` AS `invoice_number`, `i`.`created_at` AS `invoice_date`, `o`.`id` AS `order_id`, `o`.`status` AS `order_status`, `o`.`total_amt` AS `order_subtotal`, `o`.`delivery_fee` AS `delivery_fee`, `o`.`tax_amount` AS `tax_amount`, `o`.`grand_total` AS `grand_total`, `u`.`name` AS `customer_name`, `u`.`email` AS `customer_email`, `u`.`phone_number` AS `customer_phone_number` FROM ((`invoices` `i` join `orders` `o` on(`i`.`order_id` = `o`.`id`)) join `users` `u` on(`o`.`user_id` = `u`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `order_details`
--
DROP TABLE IF EXISTS `order_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `order_details`  AS SELECT `o`.`id` AS `order_id`, `o`.`total_amt` AS `total_amt`, `o`.`grand_total` AS `grand_total`, `o`.`tax_amount` AS `tax_amount`, `o`.`delivery_fee` AS `delivery_fee`, `o`.`delivery_address` AS `delivery_address`, `o`.`status` AS `status_name`, `o`.`created_at` AS `created_at`, `o`.`updated_at` AS `updated_at`, `u`.`name` AS `customer_name`, `u`.`email` AS `customer_email`, `u`.`phone_number` AS `customer_phone_number`, `pm`.`payment_name` AS `payment_method_name`, `pm`.`logo_url` AS `payment_method_logo` FROM ((`orders` `o` join `users` `u` on(`o`.`user_id` = `u`.`id`)) left join `payments` `pm` on(`o`.`payment_method_id` = `pm`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `order_items_view`
--
DROP TABLE IF EXISTS `order_items_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `order_items_view`  AS SELECT `oi`.`order_id` AS `order_id`, `oi`.`product_id` AS `product_id`, `oi`.`quantity` AS `quantity`, `p`.`price` AS `price`, `p`.`product_name` AS `product_name` FROM (`order_items` `oi` join `products` `p` on(`oi`.`product_id` = `p`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `recent_orders_with_images`
--
DROP TABLE IF EXISTS `recent_orders_with_images`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `recent_orders_with_images`  AS SELECT `o`.`id` AS `order_id`, `o`.`user_id` AS `user_id`, `o`.`created_at` AS `created_at`, `o`.`total_amt` AS `total_amt`, `o`.`status` AS `status`, `p`.`id` AS `product_id`, `p`.`product_name` AS `product_name`, `p`.`product_img` AS `product_img` FROM ((`orders` `o` join `order_items` `oi` on(`o`.`id` = `oi`.`order_id`)) join `products` `p` on(`oi`.`product_id` = `p`.`id`)) ORDER BY `o`.`created_at` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `today_revenue`
--
DROP TABLE IF EXISTS `today_revenue`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `today_revenue`  AS SELECT coalesce(sum(`orders`.`grand_total`),0) AS `total_revenue` FROM `orders` WHERE cast(`orders`.`created_at` as date) = curdate() AND `orders`.`status` = 'confirmed' ;

-- --------------------------------------------------------

--
-- Structure for view `user_order_history_view`
--
DROP TABLE IF EXISTS `user_order_history_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_order_history_view`  AS SELECT `o`.`id` AS `order_id`, `o`.`created_at` AS `order_date`, `o`.`user_id` AS `user_id`, `o`.`grand_total` AS `grand_total`, `o`.`status` AS `status`, `p`.`payment_name` AS `payment_method`, `i`.`invoice_number` AS `invoice_number` FROM ((`orders` `o` left join `invoices` `i` on(`o`.`id` = `i`.`order_id`)) left join `payments` `p` on(`o`.`payment_method_id` = `p`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `user_total_order`
--
DROP TABLE IF EXISTS `user_total_order`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_total_order`  AS SELECT `u`.`id` AS `id`, `u`.`name` AS `name`, `u`.`email` AS `email`, `u`.`profile_image` AS `profile_image`, `u`.`role` AS `role`, count(`o`.`id`) AS `total_orders` FROM (`users` `u` left join `orders` `o` on(`u`.`id` = `o`.`user_id`)) GROUP BY `u`.`id`, `u`.`name`, `u`.`email`, `u`.`profile_image`, `u`.`role` ORDER BY `u`.`id` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `v_best_selling_products`
--
DROP TABLE IF EXISTS `v_best_selling_products`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_best_selling_products`  AS SELECT `p`.`id` AS `id`, `p`.`product_name` AS `product_name`, `p`.`description` AS `description`, `p`.`price` AS `price`, `p`.`product_img` AS `product_img`, `p`.`quantity` AS `quantity`, sum(`oi`.`quantity`) AS `total_sold` FROM (`products` `p` join `order_items` `oi` on(`p`.`id` = `oi`.`product_id`)) GROUP BY `p`.`id`, `p`.`product_name`, `p`.`description`, `p`.`price`, `p`.`product_img`, `p`.`quantity` ORDER BY sum(`oi`.`quantity`) DESC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_ibfk_1` (`user_id`),
  ADD KEY `payment_method_id` (`payment_method_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_ibfk_1` (`order_id`),
  ADD KEY `order_items_ibfk_2` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_ibfk_1` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
