-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 09, 2025 at 04:33 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamezone`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'da.satani', 'digu7524');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Satani Divyanshu A.', 'prajapati16@gmail.com', 'For Good Service', 'Your Platform provide 100% original products and your services are so good.', '2025-09-27 03:28:01');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `product_details` text NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) DEFAULT 'Pending',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `product_details`, `total_price`, `payment_method`, `order_date`, `status`) VALUES
(1, NULL, 'Satani Divyanshu A.', 'prajapati16@gmail.com', '9725666418', 'rajpar', 'AMD Ryzen 5 x 1', '7199.00', 'Credit/Debit Card', '2025-09-01 16:15:12', 'placed'),
(3, NULL, 'darshan solanki', 'darshan@gmail.com', '9429797509', 'ahmedabad', 'Aorus Geforce Rtx 5090  32 GB x 1', '330999.00', 'Credit/Debit Card', '2025-09-12 10:00:11', 'pending'),
(4, NULL, 'dhruvil parmar', 'parmardhruvil000@gmail.com', '6655445544', 'khandipol society street no.3', 'ASUS RTX 5090 32 GB x 1', '337999.00', 'UPI', '2025-09-12 10:01:49', 'cancelled'),
(5, NULL, 'Satani Divyanshu A.', 'prajapati16@gmail.com', '9725666418', 'rajpar', 'AMD Ryzen 9 x 1, GPU fan x 1, Monitor x 1, headset2 x 1, Motherbord 4 x 1, mouse x 1, ssd 2 x 2, memory 3 x 1, RTX 4070 16GB x 1, Gameing Chair x 1, power splye x 1, table x 1, Keyboard x 1, fan x 3', '58998.84', 'Cash on Delivery', '2025-09-12 10:05:51', 'placed'),
(6, NULL, 'Samsung 990 PRO SSD 1TB', 'dhruvil@gmail.com', '9725666418', 'jkjkjh', 'ASUS RTX 5090 32 GB x 2, mouse x 1', '676997.99', 'Credit/Debit Card', '2025-09-17 10:13:26', 'Pending'),
(7, NULL, 'Satani Divyanshu A.', 'dhruvil@gmail.com', '9725666418', 'hyt', 'cooler x 5', '4999.95', 'Cash on Delivery', '2025-09-17 12:09:14', 'Pending'),
(8, NULL, 'Satani Divyanshu A.', 'prajapati16@gmail.com', '9725666418', 'hyy', 'Cabinet 3 x 1', '999.99', 'UPI', '2025-09-17 12:11:15', 'Pending'),
(9, NULL, 'Satani Divyanshu A.', 'prajapati16@gmail.com', '9725666418', 'rajapr', 'AMD Ryzen 5 x 3', '21597.00', 'Cash on Delivery', '2025-09-20 10:52:14', 'pending'),
(10, NULL, 'Satani Divyanshu A.', 'parmardhruvil000@gmail.com', '6655445544', '122', 'Phone Gaming cooler x 1', '999.99', 'Cash on Delivery', '2025-09-23 21:49:04', 'placed'),
(11, NULL, 'Satani Divyanshu A.', 'prajapati16@gmail.com', '6655445544', 'qwert', 'AMD Ryzen 5 x 1', '7199.00', 'Credit/Debit Card', '2025-09-24 19:34:15', 'cancelled'),
(12, NULL, 'Satani Divyanshu A.', 'prajapati16@gmail.com', '9725666418', 'rajpar, wadhwan city , 363030', 'AMD Ryzen 5 x 5', '35995.00', 'UPI', '2025-09-27 08:53:49', 'placed');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE IF NOT EXISTS `payment_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `method_type` varchar(50) NOT NULL,
  `method_details` text NOT NULL,
  `added_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `user_email`, `method_type`, `method_details`, `added_on`) VALUES
(1, 'prajapati16@gmail.com', 'UPI', 'UPI: divyans1607@.upi', '2025-09-19 04:11:52'),
(2, 'prajapati16@gmail.com', 'Card', 'Card: **** **** **** 5656 | Name: satani divyanshu a | Exp: 05/30', '2025-09-27 03:21:53');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text,
  `stock` int(11) NOT NULL DEFAULT '0',
  `home_page` tinyint(1) NOT NULL DEFAULT '0',
  `category_id` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT '4',
  `brand` varchar(100) NOT NULL DEFAULT 'Unknown',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=159 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `category`, `description`, `stock`, `home_page`, `category_id`, `rating`, `brand`) VALUES
(1, 'AMD Ryzen 5', '7199.00', 'prod_1_1756723516.jpeg', 'PC Gaming Accessories', 'Hgh quality Cpu producti', 43, 1, 1, 4, 'AMD'),
(2, 'AMD Ryzen 7', '17999.00', 'prod_2_1756817649.jpeg', 'PC Gaming Accessories', 'AMD 5000 Series Ryzen 7 5700X Desktop Processor 8 cores 16 Threads 36 MB Cache 3.4 GHz Upto 4.6 GHz AM4 Socket 500 Series Chipset (100-100000926WOF)', 56, 0, 1, 4, 'AMD'),
(3, 'AMD Ryzen 9', '42999.00', 'prod_3_1756817709.jpeg', 'PC Gaming Accessories', 'AMD Ryzen 9 9900X Desktop Processor Zen 5 Architecture with Integrated Radeon Graphics, 12 cores 24 Threads 64 MB Cache, Base Clock 4.4GHz Upto 5.6GHz AM5 Socket, System Memory DDR5-100-100000662WOF', 34, 0, 1, 4, 'AMD'),
(72, 'Razer Cobra Wired Gaming Mouse', '1899.00', '3114AQ6ey9L._SY300_SX300_QL70_FMwebp_.webp', 'PC Gaming Accessories', 'Razer Cobra Wired Gaming Mouse: 58g Lightweight Design - Gen-3 Optical Switches - Chroma RGB Lighting with Underglow - Precise 8500 DPI Optical Sensor - 1 - Speedflex Cable - Black-RZ01-04650100-R3M1', 125, 1, NULL, 4, 'Razer'),
(6, 'Aorus Geforce Rtx 5090  32 GB', '330999.00', 'prod_6_1756817806.jpeg', 'PC Gaming Accessories', 'GIGABYTE GV-N5090AORUS M-32GD | GeForce RTX 5090 AORUS Master 32GB GDDR7 Graphics Card', 44, 1, 2, 4, 'NVIDIA'),
(7, 'ASUS RTX 5090 32 GB', '337999.00', 'prod_7_1756817916.jpeg', 'PC Gaming Accessories', 'ASUS TUF Gaming GeForce RTX â„¢ 5090 32GB GDDR7 OC Edition Gaming Graphics Card (PCIeÂ® 5.0, HDMIÂ®/DP 2.1, 3.6-Slot, Military-Grade Components, Protective PCB Coating, axial-tech Fans, Vapor Chamber)', 45, 1, 2, 4, 'NVIDIA'),
(115, 'NVIDIA GeForce RTX 4080 SUPER Graphics Card', '309999.00', '81rCZZvkIVL._SX522_.jpg', 'PC Gaming Accessories', 'ASUS TUF Gaming NVIDIA GeForce RTX 4080 Super OC Edition Gaming Graphics Card (PCIe 4.0, 16GB GDDR6X, HDMI 2.1a, DisplayPort 1.4a)', 341, 0, NULL, 4, 'NVIDIA'),
(116, 'Kreo X Naruto Hawk Gaming Mouse', '1499.00', '61P+MZXAZ2L._SX522_.jpg', 'PC Gaming Accessories', 'Kreo X Naruto Hawk Gaming Mouse with Programmable Buttons & RGB Lighting, Top Pixart Sensor, Adjustable DPI with 1.5m Long Braided Cable and Optical Sensor, Lightweight & Durable', 2416, 0, NULL, 4, 'Other'),
(15, 'Racing Wheel Set', '12999.00', 'prod_15_1756818069.jpeg', 'PC Gaming Accessories', 'Flashfire Suzuka 900R Racing Wheel Set With Clutch pedals and H-shifter for PC, PS3, PS4, Xbox 360, XBOX ONE and Nintendo Switch(Es900R)', 23, 1, 6, 4, 'Other'),
(16, 'Gameing Chair', '4999.00', 'prod_16_1756818175.jpeg', 'PC Gaming Accessories', 'Green Soul Raptor 2.0 Racing Edition Ergonomic Gaming Chair with Premium PU Leather, Adjustable Neck & Lumbar Pillow, 3D Adjustable Armrests & Heavy Duty Nylon Base (Black & Red) Installation Provided', 114, 1, 5, 4, 'Other'),
(17, 'Phone Gaming cooler', '999.99', 'prod_17_1757483798.jpeg', 'Phone Gaming Accessories', 'High quality Cooler product', 4, 1, 4, 4, 'Other'),
(19, 'fan', '999.99', 'prod_19_1757483745.jpeg', 'PC Gaming Accessories', 'High quality Cooler product', 7, 0, 4, 4, 'Other'),
(20, 'GPU fan', '999.99', 'prod_20_1757483723.jpeg', 'PC Gaming Accessories', 'High quality Gpu product', 9, 0, 2, 4, 'Other'),
(101, 'ASUS CW101 Wireless Keyboard & Mouse Set', '1299.00', '61s-M7gizlL._SX679_.jpg', 'PC Gaming Accessories', 'ASUS Wireless Keyboard and Mouse Set CW101, Upto 1000 Adjustable DPI,2.4 GHz Nano Receiver, Gaming-Grade, Laser-Engraved keycaps, Near-Silent Operation, Compact & Light Weight Design (Black)', 2453, 0, NULL, 4, 'ASUS ROG'),
(22, 'NVIDIA GeForce RTX 4080 SUPER', '999.99', 'prod_22_1757483404.jpeg', 'PC Gaming Accessories', 'NIVIDIA Gaming Geforce RTX 4080 16Gb Gddr6X Oc Edition - Black (Tuf-Rtx4080-O16G-Gaming) - Pci_E', 121, 0, 7, 4, 'NVIDIA'),
(23, 'headset2', '999.99', 'prod_23_1757483380.jpeg', 'PC Gaming Accessories', 'High quality Other product', 9, 0, 7, 4, 'Other'),
(24, 'Intel Core i3', '999.99', 'prod_24_1757483360.jpeg', 'PC Gaming Accessories', 'High quality Cpu product', 10, 0, 1, 4, 'Other'),
(25, 'Intel Core i7', '999.99', 'prod_25_1757483344.jpeg', 'PC Gaming Accessories', 'High quality Cpu product', 10, 0, 1, 4, 'Other'),
(26, 'Intel Core i9', '999.99', 'prod_26_1757483326.jpeg', 'PC Gaming Accessories', 'High quality Cpu product', 10, 0, 1, 4, 'Other'),
(27, 'Keyboard', '999.99', 'prod_27_1757483004.jpeg', 'PC Gaming Accessories', 'High quality Other product', 9, 0, 7, 4, 'Other'),
(28, 'Memory', '999.99', 'prod_28_1757482981.jpeg', 'PC Gaming Accessories', 'High quality Other product', 10, 0, 7, 4, 'Other'),
(29, 'memory 1', '999.99', 'prod_29_1757482943.jpeg', 'PC Gaming Accessories', 'High quality Other product', 10, 0, 7, 4, 'Other'),
(30, 'memory 2', '999.99', 'prod_30_1757482916.jpeg', 'PC Gaming Accessories', 'High quality Other product', 10, 0, 7, 4, 'Other'),
(100, 'ROG Strix Impact III mouse', '2499.00', '71VKMQ-V1GL._SX522_.jpg', 'PC Gaming Accessories', 'ASUS ROG Strix Impact III Gaming Mouse, Semi-Ambidextrous, Wired, Lightweight, 12000 DPI Sensor, 5 programmable Buttons, Replaceable switches, Paracord Cable, FPS Gaming Mouse, Black', 324, 0, NULL, 4, 'ASUS ROG'),
(33, 'Microphone', '999.99', 'prod_33_1757482809.jpeg', 'PC Gaming Accessories', 'High quality Other product', 10, 0, 7, 4, 'Other'),
(34, 'mobile gaming Set', '999.99', 'prod_34_1757482790.jpeg', 'Phone Gaming Accessories', 'High quality Other product', 10, 1, 7, 4, 'Razer'),
(36, 'Prime X299 - All Motherboard', '12999.00', 'prod_36_1757482697.jpeg', 'PC Gaming Accessories', 'High quality Other product', 134, 1, 7, 4, 'ASUS ROG'),
(38, 'ROG Maximus Z892', '999.99', 'prod_38_1757482637.jpeg', 'PC Gaming Accessories', 'High quality Other product', 10, 0, 7, 4, 'ASUS ROG'),
(74, 'EvoFox Deck Smartphone Gamepad', '2499.00', '61yBsKsU-8L._SX679_.jpg', 'Phone Gaming Accessories', 'EvoFox Deck Smartphone Gamepad with iPhone/Android, XBOX, HID & Keymap modes | Bluetooth v5.0 | Dual Vibration motors | Magnetic Hall 3D Joysticks | RGB Lighting and Backlit Controls', 487, 1, NULL, 4, 'Other'),
(75, 'Astra One : Mobile Gaming controller', '1799.00', '61Xl55t-riL._SX679_.jpg', 'Phone Gaming Accessories', 'Astra One : Mobile Gaming controller for your Mobile, Tablet, Console or PC (White); Compatible with Android, iPhone, Windows, Mac, PS3, PS4', 1799, 0, NULL, 4, 'PlayStation'),
(73, 'Mobile Gaming Triggers', '599.00', 'shopping.webp', 'Phone Gaming Accessories', 'SpinBot BattleMods Apex | Mobile Gaming Triggers | Zero Lag Response | 5X Faster with Capacitive Conduction | for BGMI/Free Fire Max/COD Mobile - (Black & Grey)', 722, 0, NULL, 4, 'Other'),
(52, 'power splye', '999.99', 'prod_52_1757084942.jpeg', 'PC Gaming Accessories', 'High quality Other product', 9, 0, 7, 4, 'Other'),
(55, 'RTX 2070 6GB', '999.99', 'prod_55_1757084822.jpeg', 'PC Gaming Accessories', 'High quality Gpu product', 10, 0, 2, 4, 'NVIDIA'),
(56, 'RTX 4070 16GB', '999.99', 'prod_56_1757084804.jpeg', 'PC Gaming Accessories', 'High quality Gpu product', 9, 0, 2, 4, 'NVIDIA'),
(57, 'RTX 4070 Ti 16GB', '999.99', 'prod_57_1757084779.jpeg', 'PC Gaming Accessories', 'High quality Gpu product', 10, 0, 2, 4, 'NVIDIA'),
(58, 'RTX 4080 16GB', '999.99', 'prod_58_1757084761.jpeg', 'PC Gaming Accessories', 'High quality Gpu product', 10, 0, 2, 4, 'NVIDIA'),
(76, 'Gaming Trigger Fire', '165.00', '713yru2j9VL._SX522_.jpg', 'Phone Gaming Accessories', 'Extra Premium PUBG Mobile Gaming Trigger Fire and Aim Button Game Shooter, Sensitive Shoot for PUBG Free FIRE Call of Duty BGMI Compatible with All Smartphones-(3 Pair Sleeves,1 Pair Trigger)\r\n', 2778, 1, NULL, 4, 'Other'),
(60, 'ssd 2', '999.99', 'prod_60_1757084713.jpeg', 'PC Gaming Accessories', 'High quality Other product', 8, 0, 7, 4, 'Other'),
(61, 'Samsung 990 PRO SSD 1TB', '10999.00', 'prod_61_1756818480.jpeg', 'PC Gaming Accessories', 'Samsung 990 PRO SSD 1TB PCIe 4.0 M.2 Internal SSD, Seq. Read Speeds Up to 7,450 MB/s for High End Computing, Gaming, Video Editing and Heavy Duty Workstations, MZ-V9P1T0BW.', 146, 0, 7, 4, 'Other'),
(62, 'table', '999.99', 'prod_62_1757483471.jpeg', 'PC Gaming Accessories', 'High quality Other product', 9, 0, 7, 4, 'Other'),
(63, 'webcam2', '999.99', 'prod_63_1757483674.jpeg', 'PC Gaming Accessories', 'High quality Other product', 10, 0, 7, 4, 'Other'),
(147, 'Backbone One Mobile Gaming Controlle', '9999.00', '71j7Tl+PYhL._SX522_.jpg', 'Phone Gaming Accessories', 'Backbone One Mobile Gaming Controller for Android and iPhone 15 Series (USB-C) - 2nd Gen - Turn Your Phone into a Gaming Console - Play Xbox, PlayStation, Call of Duty, Roblox, Genshin Impact & More', 105, 0, NULL, 4, 'Other'),
(99, 'ROG Strix Scope PBT keyboard', '34999.00', '91YxKZjwOPL._SX522_.jpg', 'PC Gaming Accessories', 'Asus ROG Strix Scope II 96 Wireless Gaming Keyboard, Three-Mode Connection, Shock Absorbing Foam and Switch Dampening Pads, Hot Swappable Pre-Lubricated ROG NX Snow Switches, PBT Keycaps, RGB-Black', 124, 0, NULL, 4, 'ASUS ROG'),
(114, 'NVIDIA GeForce RTX 4090 Graphics Card', '292999.00', '619QTa9dXXL._SX522_.jpg', 'PC Gaming Accessories', 'PNY NVIDIA GeForce RTX 4090 24GB Verto Triple Fan Graphics Card DLSS 3 (384-bit PCIe 4.0, GDDR6X, Supports 4k, Anti-Sag Bracket, HDMI/DisplayPort) - VCG409024TFXPB1', 241, 0, NULL, 4, 'NVIDIA'),
(66, 'ZEBRONICS Optimus Gaming Keyboard', '699.00', '712n88HBTYL._SX679_.jpg', 'PC Gaming Accessories', 'ZEBRONICS Optimus Gaming Keyboard & Mouse Combo, Braided Cable, Gold Plated USB, Upto 3600 DPI, 6 Buttons, High Resolution Sensor, Multicolor LED, Dedicated Macro Keys, 117 Keys (Black)', 72, 1, NULL, 4, 'Other'),
(67, 'Ant Esports MK700 V2 Gaming Keyboard', '499.00', '41xjLpLmXrL._SX300_SY300_QL70_FMwebp_.webp', 'PC Gaming Accessories', 'Ant Esports MK700 V2 Membrane TKL Wired Gaming Keyboard, 87 UV Coated Mechanical feel Keys Cool RGB Backlight Waterproof Keyboard for PC Laptop Mobile Tablets Gaming, Design and Work Mercury White', 265, 0, NULL, 4, 'Other'),
(68, 'RAEGR RapidGear X70 USB Gaming Keyboard', '1499.00', '6103qfrVttL._SX522_.jpg', 'PC Gaming Accessories', 'RAEGR RapidGear X70 USB Gaming Keyboard and Mouse Combo | Made of Aluminium Body | 4 Choices of Adjustable DPI, 3 Rainbow Lighting Modes, Instant Media Access, Gaming Mouse for PC/Laptop/Mac-RG10359', 642, 0, NULL, 4, 'Other'),
(69, 'Cosmic Byte  Mechanical Keyboard', '1499.00', '41nW3bpAL8L._SY300_SX300_QL70_FMwebp_.webp', 'PC Gaming Accessories', 'Cosmic Byte CB-GK-25 Pandora TKL Mechanical Keyboard Upgraded with Swappable Outemu Blue Switches and Rainbow LED (Black/Grey)', 146, 0, NULL, 4, 'Other'),
(70, 'AULA F75  Wireless Mechanical Keyboard', '5499.00', '61r4lrp65bL._SX522_.jpg', 'PC Gaming Accessories', 'AULA F75 75% Wireless Mechanical Keyboard | Hot Swappable | Pre-lubed Linear Switches | RGB Backlit | 2.4GHz/Type-C/Bluetooth Gaming Keyboard (Sea Blue, Graywood Switch)', 135, 0, NULL, 4, 'Other'),
(71, 'Cosmic Byte  Mechanical Keyboard', '1499.00', '41nW3bpAL8L._SY300_SX300_QL70_FMwebp_.webp', 'PC Gaming Accessories', 'Cosmic Byte CB-GK-25 Pandora TKL Mechanical Keyboard Upgraded with Swappable Outemu Blue Switches and Rainbow LED (Black/Grey)', 146, 0, NULL, 4, 'Other'),
(77, 'Vero Forza Glide V2', '350.00', 'prod_77_1759244546.jpg', 'Phone Gaming Accessories', 'Vero Forza Glide V2 (6 Pieces) | Mobile Gaming Sleeve | VFiber 2.0 Technology', 3254, 1, NULL, 4, 'Other'),
(78, 'Magnetic Instant Mobile Cooler', '899.00', '41v0esESNxL._SY300_SX300_QL70_FMwebp_.webp', 'Phone Gaming Accessories', 'Virtutron Frost Master Wired Magnetic Instant Mobile Cooler| Cooling pad | Gaming Fan | For Superfast Cooling Enhanced Refrigeration Chip Compatible For iPhones & Android Devices â€“ (1 Year Warranty)', 1273, 1, NULL, 4, 'Other'),
(79, 'EvoFox Hailstone S Phone Cooler for Gaming', '675.00', '61hbYB98B5L._SX522_.jpg', 'Phone Gaming Accessories', 'EvoFox Hailstone S Phone Cooler for Gaming | 15W 3 Level Cooling | 5000 RPM 7-Blade| Clamp Mount | RGB | Semiconductor Tech | Type-C Powered & Display | Compatible for Android and iPhones (White)', 1457, 0, NULL, 4, 'Other'),
(80, 'Vero Forza Arctic V3 Mobile Cooler for Gaming', '1255.00', '7198KsB3SHL._SX522_.jpg', 'Phone Gaming Accessories', 'Vero Forza Arctic V3 Mobile Cooler for Gaming | Magsafe Compatible | Ultra Quiet 7 Blade Fan | Phone Cooler for Bgmi, Pubg, Freefire, CODM (iPhone/Android)', 435, 0, NULL, 4, 'Other'),
(81, 'GameSir Super Nova Wireless Gaming Controller', '5399.00', '51NJbjY+BbL._SX679_.jpg', 'PC Gaming Accessories', 'GameSir Super Nova Wireless Gaming Controller for PC/Switch/iOS/Android, 1000Hz Polling Rate, Hall Effect Stick & Trigger, 1000mAh with Charging Dock(Blue)', 234, 0, NULL, 4, 'PlayStation'),
(82, 'SONY PlayStation5 Console', '49990.00', 'shopping (2).webp', 'PC Gaming Accessories', 'Experience haptic feedback via the DualSense wireless controller in select PS5 titles and feel the effects and impact of your in-game actions through dynamic sensory feedback.', 1423, 1, NULL, 4, 'PlayStation'),
(83, 'Classic Games Console', '1499.00', '51Jr1PLI0RL.jpg', 'PC Gaming Accessories', 'New World TV Video Games for Kids Wireless 64GB Memory, HD Classic Games Console with TF Card, 9 Emulator Console, HDMI Output TV Video Game Console Game Stick', 324, 0, NULL, 4, 'PlayStation'),
(84, 'Retro Handheld Video Game Console', '3999.00', '71fbmSNs3rL._SX679_.jpg', 'PC Gaming Accessories', 'New World R36S Retro Handheld Video Game Console 3.5 inch Retro Handheld Video Games Consoles Built-in Rechargeable Battery Portable Style Hand Held Game Consoles', 3415, 1, NULL, 4, 'PlayStation'),
(85, 'Spider-Man 2 Limited Controller', '9999.00', '51XzGmx0CYL._SX679_.jpg', 'PC Gaming Accessories', 'Sony DualSense Wireless Controller - Marvel s Spider-Man 2 Limited Edition,Windows PC and Mac computers, Android and iOS mobile phones', 324, 1, NULL, 4, 'PlayStation'),
(86, 'PS5Â® Console Slim â€“ NBA 2K26 Bundle', '54999.00', '61GvZI3CmuL._SX679_.jpg', 'PC Gaming Accessories', 'HDR Technology With an HDR TV, supported PS5 games display an unbelievably vibrant and lifelike range of colors. Tempest 3D AudioTech Immerse yourself in soundscapes where it feels as if the sound comes from every direction. Your surroundings truly come alive with Tempest 3D AudioTech3 in supported games.', 142, 0, NULL, 4, 'PlayStation'),
(87, 'Ant ICE10 Phone Cooler ', '499.00', '61NHb+ezndL._SX522_.jpg', 'Phone Gaming Accessories', 'Ant ICE10 Phone Cooler for Gaming, Universal Phone Cooling Fan with 3 Speed Cooling Modes, RGB Fan, Ultra Quiet LED Temperature Display for iPhone Android Smartphones Cell Phone Cooler_ Black', 243, 0, NULL, 4, 'Other'),
(88, 'Gesto Rechargeable Clip-On Table Fan', '499.00', '81lMt8clylL._SX679_.jpg', 'Phone Gaming Accessories', '\r\nClick to see full view\r\n\r\n\r\nVIDEO\r\n\r\n\r\n\r\n\r\n2+\r\nGesto High Speed Rechargeable Clip-On Table Fan with Digital Display â€“ 360Â° Moving USB Charging Fan for Home,Kitchen,Baby Stroller | 2000mAh Battery,5 Speed Modes,Portable Battery Operated Fan -Black', 3145, 0, NULL, 4, 'Other'),
(89, 'Vk Mart Mobile Gamepad Controller', '2999.00', 'shopping (3).webp', 'Phone Gaming Accessories', 'Vk Mart Mobile Gamepad Controller, One Handed Gaming Keyboard Mouse Converter Mix Pro Gaming Accessory Kit', 341, 0, NULL, 4, 'Other'),
(90, 'ZEBRONICS Jet Premium Wired Headphone', '599.00', '71D1EB5iDzL._SX679_.jpg', 'Phone Gaming Accessories', 'ZEBRONICS Jet Premium Wired Gaming On Ear Headphone with LED Light for earcups, 40mm Neodymium Drivers, 2 Meter Braided Cable, Flexible mic, Suspension Headband, 3.5mm + USB Connector (Black + Blue)', 234, 0, NULL, 4, 'Other'),
(91, 'SpinBot BattleBudz W20 Gaming Wired Earphones', '599.00', '61RoJ5BSotL._SX522_.jpg', 'Phone Gaming Accessories', '\r\nClick to see full view\r\nSpinBot BattleBudz W20 Gaming Wired Earphones with Dual Mic | Detachable Boom Mic, 10mm Gaming-Tuned Drivers, Shark Fin Eartips for Mobile, PC/Laptop, Xbox One, PS4, PS5 (Green)', 2435, 1, NULL, 4, 'Other'),
(92, 'Cosmic Byte Cb-Ep-03 Wired In Ear Earphones', '999.00', '614XpWcuU9L._SX679_.jpg', 'Phone Gaming Accessories', 'Cosmic Byte Cb-Ep-03 Wired In Ear Earphones With Mic For Pc, Ps4, Mobiles, Tablets (Black)', 1341, 1, NULL, 4, 'Other'),
(93, 'ROG Azoth Extreme 75% Custom Gaming Keyboard', '98999.00', '81UvrysuL4L._SX522_.jpg', 'PC Gaming Accessories', 'ROG Azoth Extreme 75% Custom Gaming Keyboard, Aluminum Chassis, Carbon Fiber Positioning Plate, Adjustable Gasket Mount, 3 Layer Dampening, Color OLED Touchscreen, ROG NX Storm Switches, PBT Keycaps', 124, 0, NULL, 4, 'ASUS ROG'),
(94, 'ASUS ROG Gladius Wired Optical Gaming Mouse', '5500.00', '61kGhTkmFzL._SX679_.jpg', 'PC Gaming Accessories', 'ASUS ROG Gladius II Core Lightweight, Ergonomic, Wired Optical Gaming Mouse with 6200-DPI Sensor, ROG-Exclusive Switch-Socket Design and Aura Sync Lighting', 324, 0, NULL, 4, 'ASUS ROG'),
(95, 'SPIN CART Large Gaming Mouse pad', '250.00', '51ofb1-sFxL._SX522_.jpg', 'PC Gaming Accessories', 'SPIN CART Large Gaming Mouse pad, Long XXL Extended Desk Table Mat Mousepad for Laptop PC Computer (Black Dazzle)', 2452, 1, NULL, 4, 'ASUS ROG'),
(96, ' ASUS ROG Scabbard II Gaming Mouse Pad', '6799.00', '81pvjX+QDNL._SX522_.jpg', 'PC Gaming Accessories', 'ASUS ROG Scabbard II Gaming Mouse Pad - Protective Nano Coating Surface Repels Water-Oil-Dust, Anti-Fray Flat Stitched Edges, Non-Slip Rubber Base, Optimized Surface for Smooth Glide and Comfort', 312, 0, NULL, 4, 'ASUS ROG'),
(97, 'ROG Strix Scope II 96 RX Wireless keyboard', '24999.00', '81Gd2c8ljmL._SX522_.jpg', 'PC Gaming Accessories', 'ASUS ROG Strix Scope II Gaming Keyboard, pre-lubed ROG RX Red Linear Optical switches, Sound-dampening Foam, PBT doubleshot keycaps, Streaming hotkeys, Multi-Function Controls, Wrist Rest', 245, 0, NULL, 4, 'ASUS ROG'),
(98, 'ROG Harpe Ace Mini mouse', '54999.00', '71FxEXsbzJL._SX522_.jpg', 'PC Gaming Accessories', 'ASUS ROG Harpe Ace Extreme Wireless Gaming Mouse, Carbon Fiber Build, 47g Lightweight, AimPoint Pro 42K Optical Sensor, Optical Micro Switches, ROG Polling Rate Booster, Esports & FPS Gaming, Black', 241, 0, NULL, 4, 'ASUS ROG'),
(102, 'ASUS ROG Hyperion GR701 Full-Tower Cabinet', '31999.00', '81H1cnMzvfL._SX679_.jpg', 'PC Gaming Accessories', 'ASUS ROG Hyperion GR701 Full-Tower Gaming Case for Upto EATX Motherboards with USB 3.2 Gen 1, USB Type-C Front Panel, Smoked Tempered Glass, Brushed Aluminum & Steel Construction, and Four Case Fans', 100, 1, NULL, 4, 'ASUS ROG'),
(103, 'TUF Gaming H3 headset', '1299.00', '71wJQn4VdmL._SX679_.jpg', 'PC Gaming Accessories', 'Cosmic Byte H3 Gaming Wired over ear Headphone With Mic For Pc, Laptops, Mobiles, Ps4, Xbox One (Blue)', 357, 0, NULL, 4, 'ASUS ROG'),
(104, 'ROG Delta II headset', '42999.00', '71szOzu7UjL._SX522_.jpg', 'PC Gaming Accessories', 'ASUS A701ROGDELTAII/BLK GhdstASUS A701 Rog Delta II/blk', 24, 0, NULL, 4, 'ASUS ROG'),
(105, 'Intel Core i7 12700', '25999.00', 'A1-1-16.jpg', 'PC Gaming Accessories', 'Intel Core i7 12700 12 Gen Desktop Processor OEM (Without Box & Fan)', 105, 0, NULL, 4, 'Other'),
(106, 'AMD Ryzen 9 9950X3D ', '67599.00', 'A1-1-7.jpg', 'PC Gaming Accessories', 'AMD Ryzen 9 9950X3D Gaming and Content Creation AM5 Desktop Processor', 124, 0, NULL, 4, 'AMD'),
(107, 'AMD Ryzen 5 5600GT', '12000.00', 'A2-1.jpg', 'PC Gaming Accessories', 'AMD Ryzen 5 5600GT Processor With Radeon Graphics', 320, 0, NULL, 4, 'AMD'),
(108, 'AMD Ryzen 3 3200G', '5499.00', '3200g-1-1.jpg', 'PC Gaming Accessories', 'AMD Ryzen 3 3200G With RX Vega 8 Graphics Processor\r\n', 234, 0, NULL, 4, 'AMD'),
(109, 'ASUS Dual NVIDIA GeForce RTX 5060 Ti', '43999.00', '81-KEx-lGSL._SX679_.jpg', 'PC Gaming Accessories', 'ASUS Dual NVIDIA GeForce RTX 5060 Ti 8GB GDDR7 OC Edition - Graphics Card (PCIe 5.0, DLSS 4, HDMI 2.1b, DisplayPort 2.1b, 2.5-Slot, Axial Fans, 0dB Technology, Dual BIOS)', 1064, 0, NULL, 4, 'NVIDIA'),
(110, 'NVIDIA SHIELD TV Pro', '39999.00', '51ZGCIbrgFL._SX522_.jpg', 'PC Gaming Accessories', 'NVIDIA Shield TV Pro | 4K HDR Streaming Media Player, High Performance, Dolby Vision, 3GB RAM, 2X USB, Compatible with Alexa', 104, 0, NULL, 4, 'NVIDIA'),
(111, 'Riitek 13.3\" Portable Tri-Screen monitor', '31999.00', '61AvNQCDbYL._SX522_.jpg', 'PC Gaming Accessories', 'Riitek 13.3\" Portable Tri-Screen Monitor for 13.3\"-17.3\" Laptop, Fhd 1080P with Kickstand,USB/Type C compaitbility ; Compatible with All Macos, Windows, 1 Year Door Step Warranty', 1045, 0, NULL, 4, 'NVIDIA'),
(112, 'AULA F75 75% Side Engraved Tri Mode Keyboard', '6999.00', '81d-saClxgL._SX522_.jpg', 'PC Gaming Accessories', 'AULA F75 75% Side Engraved Tri Mode TKL 80 Keys Wireless Mechanical Gaming Keyboard With Knob | 4000mAh Battery, South-Facing RGB Backlit Pre-Lubed Hot Swappable | Black Contour - Star Vector Switch', 2476, 1, NULL, 4, 'Other'),
(113, 'Lenovo Legion R27fc-30 Monitor', '15999.00', '61L4ttOzI0L._SX679_.jpg', 'PC Gaming Accessories', 'Lenovo Legion R27fc-30, 27 Inch (68.58cm), FHD 1920x1080, 240Hz, Black, 0.5ms, AMD FreeSync, NVIDIA G-Sync, 99% sRGB, Speaker, 2xHDMI, 1xDP, Tilt, Swivel, Pivot, Height Adjust Stand Gaming Monitor', 1043, 1, NULL, 4, 'Other'),
(117, 'MSI Geforce RTX 5090 32G  SOC Graphic Card', '412999.00', '61W07KSaKYL._SX450_.jpg', 'PC Gaming Accessories', 'MSI Geforce RTX 5090 32G SUPRIM Liquid SOC Graphic Card - NVIDIA Geforce RTX 5090 GPU, 32GB GDDR7 512-Bit Memory, 28 Gbps, PCI_e Gen 5 X 16 Interface, Upto 2565 Mhz, STORMFORCE Fan', 243, 1, NULL, 4, 'NVIDIA'),
(118, 'MSI Geforce RTX 5090 32G Vanguard  Graphic Card ', '355269.00', '71LnSVieIHL._SY450_.jpg', 'PC Gaming Accessories', 'MSI Geforce RTX 5090 32G Vanguard SOC pci_e_x16 Graphic Card - NVIDIA Geforce RTX 5090 GPU, 32GB GDDR7 512-Bit Memory, 28 Gbps, PCI Express Gen 5 Interface, Upto 2512 Mhz, STORMFORCE Fan', 341, 0, NULL, 4, 'NVIDIA'),
(119, 'Halo Infinite', '599.00', '51LGSvIq5jL._SY550_.jpg', 'PC Gaming Accessories', 'HALO INFINITE | PC GAME | EMAIL DELIVERY IN 24 HRS', 2415, 0, NULL, 4, 'Xbox'),
(120, 'Sony PS5 Ghost of Yotei', '5199.00', '81p8hiryVYL._SX466_.jpg', 'PC Gaming Accessories', 'EMBARK ON A JOURNEY AT THE EDGE OF JAPAN Discover beautiful landscapes outside of feudal-era Japan that are waiting to be explored. This tale takes place in the lands surrounding Mount YÅtei, a towering peak on the periphery of this snowy northern region', 2413, 0, NULL, 4, 'Xbox'),
(121, 'Forza Horizon 4 - Standard Edition', '3299.00', '716ej6hzPbL._SX425_.jpg', 'PC Gaming Accessories', '\r\nClick to see full view\r\nXbox Game Studios Forza Horizon 4 - Standard Edition - Xbox & Windows Code Only (No CD/DVD)', 2414, 0, NULL, 4, 'Xbox'),
(122, 'Electronic Arts EA Sports FC 25', '2399.00', '61U9aru+wHL._SX522_.jpg', 'PC Gaming Accessories', 'Electronic Arts EA Sports FC 25 | Standard Edition | PlayStation 5', 210, 0, NULL, 4, 'Xbox'),
(123, 'Capcom Resident Evil 4 Remake', '2164.00', '71KYlXpzFpL._SX466_.jpg', 'PC Gaming Accessories', 'Capcom Resident Evil 4 Remake | Standard Edition | PlayStation 5', 1245, 0, NULL, 4, 'Xbox'),
(124, 'Ubisoft Ubi Soft Far Cry 6', '1699.00', '81ptKW1gJBL._SX425_.jpg', 'PC Gaming Accessories', 'Ubisoft Ubi Soft Far Cry 6 | Standard Edition | Playstation 5 (Ps5)', 1542, 0, NULL, 4, 'Xbox'),
(125, 'Battlefield 6', '4999.00', '61Gg0hsdNyL._SX425_.jpg', 'PC Gaming Accessories', 'Battlefield 6 | Standard Edition| PlayStation 5', 415, 0, NULL, 4, 'Xbox'),
(126, 'Console Grand Theft Auto V', '1999.00', '81kAitW5qAL._SX425_.jpg', 'PC Gaming Accessories', 'Rockstar Games PS5 Video Game ConsoleGrand Theft Auto V', 123, 0, NULL, 4, 'Xbox'),
(127, 'Bandai Namco Tekken 8', '2799.00', '81calZhnlHL._SX466_.jpg', 'PC Gaming Accessories', 'Bandai Namco Tekken 8 | Standard Edition | PlayStation 5', 561, 0, NULL, 4, 'Xbox'),
(128, 'Gears 5', '1999.00', '51FKeuMACgL._SY445_SX342_QL70_FMwebp_.webp', 'PC Gaming Accessories', '\r\nClick to see full view\r\nGears 5 - Standard Edition - Xbox One', 242, 0, NULL, 4, 'Xbox'),
(129, 'Minecraft Java & Bedrock Edition', '1799.00', '71FJEbzhezL._SY550_.jpg', 'PC Gaming Accessories', 'Minecraft Java & Bedrock Edition Bundle PC Code (No CD/DVD)', 3520, 0, NULL, 4, 'Xbox'),
(130, 'Call of Duty: Modern Warfare III', '14099.00', '81VjkKT0hCL._SX425_.jpg', 'PC Gaming Accessories', 'Call of Duty: Modern Warfare III [GRA PS5] [video game]', 146, 0, NULL, 4, 'Xbox'),
(131, 'Razer DeathAdder V3 Pro', '6999.00', '51HNNPbYdML._SY679_.jpg', 'PC Gaming Accessories', 'Razer DeathAdder V3 Pro Wireless Gaming Mouse- White : Ultra Lightweight - Focus Pro 30K Optical Sensor - Optical Switches Gen-3 - HyperSpeed Wireless - 5 Programmable Buttons - RZ01-04630200-R3A1', 351, 1, NULL, 4, 'Razer'),
(132, 'Razer BlackShark V2 Pro', '16999.00', '71Z9KK9-zvL._SY450_.jpg', 'PC Gaming Accessories', 'Razer BlackShark V2 Pro Wireless Gaming Headset 2023 Edition: 50MM Titanium Drivers - HyperClear Super Wideband Mic - Noise-isolating Earcups - 70 Hour Battery Life - Black - RZ04-04530100-R3M1', 2601, 0, NULL, 4, 'Razer'),
(133, 'Razer Huntsman V2', '5999.00', '61rI1qxhC0L._SX450_.jpg', 'PC Gaming Accessories', 'Razer Huntsman Mini - 60% Optical Gaming Keyboard (Linear Red Switch) - FRML Packaging', 755, 0, NULL, 4, 'Razer'),
(134, 'Razer Wolverine V2 Chroma', '2399.00', '71fAlgJnP5L._SX522_.jpg', 'PC Gaming Accessories', 'Razer Wolverine V2 Chroma Wired Gaming Pro Controller for Xbox Series X|S, Xbox One, PC: RGB Lighting - Remappable Buttons & Triggers - Mecha-Tactile Buttons & D-Pad - Trigger Stop-Switches - Black', 863, 0, NULL, 4, 'Razer'),
(135, 'Razer Goliathus Chroma â€“ RGB Mouse Pad', '2099.00', '71OGq-BGi0L._SX355_.jpg', 'PC Gaming Accessories', 'Razer Goliathus Chroma - Gaming Mouse Mat (RZ02-02500100-R3M1)', 544, 0, NULL, 4, 'Razer'),
(136, 'Razer Seiren V2 Pro', '5999.00', '512+nHsiSQL._SX425_.jpg', 'PC Gaming Accessories', 'Razer Seiren V2 X - USB Microphone for Streamers', 677, 0, NULL, 4, 'Razer'),
(137, 'Razer Hammerhead V3', '5899.00', '61EgDyueTcL._SY450_.jpg', 'Phone Gaming Accessories', 'Razer Hammerhead V3 - Wired Earbuds for Gaming', 3451, 0, NULL, 4, 'Razer'),
(138, 'Razer BlackShark V2 X - Analog', '2999.00', '81ZUAZzVYBL._SY450_.jpg', 'Phone Gaming Accessories', 'Razer BlackShark V2 X - Analog Wired Gaming on Ear Headset - Quartz Edition -RZ04-03240800-R3M1', 1346, 1, NULL, 4, 'Razer'),
(139, 'Razer BlackWidow V4 Pro Keyboard', '7599.00', '61BW921g3uL._SY450_.jpg', 'PC Gaming Accessories', 'Razer BlackWidow V4 X -Green Switch 6 Dedicated Macro Keys I Multi-Function Roller and Secondary Media Keys I Mechanical Gaming Keyboard Chroma RGB- Black - RZ03-04700100-R3M1', 914, 0, NULL, 4, 'Razer'),
(140, 'Razer Ornata V3 X Gaming Keyboard', '1999.00', '71l-ZWpTmNL._SX355_.jpg', 'PC Gaming Accessories', 'Razer Ornata V3 X Gaming Keyboard: Low-Profile Keys - Silent Membrane Switches - UV-Coated Keycaps - Spill Resistant - Chroma RGB Lighting - Ergonomic Wrist Rest - Classic Black - RZ03-04470100-R3M1', 851, 0, NULL, 4, 'Razer'),
(141, 'PlayStation VR2', '47999.00', '614KJZb9-IL._SX355_.jpg', 'PC Gaming Accessories', 'PlayStation VR2', 100, 0, NULL, 4, 'PlayStation'),
(142, 'Sony PlayStation 4 Slim Console (1TB)', '26499.00', 'shopping (4).webp', 'PC Gaming Accessories', 'Sony PlayStation 4 Ps4 Slim Console 1Tb Refurbished (Ready Stock)', 145, 0, NULL, 4, 'PlayStation'),
(143, 'DualShock 4 Wireless Controller', '2059.00', '71BV7QqgdsL._SY450_.jpg', 'PC Gaming Accessories', 'ARcNet Dualshock Wireless Controller Game Switch For PS 4 With 3.5 mm Headset Port & 6 Axis Gyro Sensor Wireless USB Controller Compatible for PS 4 Slim/PRO/Fat With Built in Speaker', 530, 0, NULL, 4, 'PlayStation'),
(144, 'PULSE Exploreâ„¢ wireless earbuds', '9999.00', '51Bj-vJ4DoL._SX522_.jpg', 'PC Gaming Accessories', 'PULSE Exploreâ„¢ wireless earbuds', 100, 0, NULL, 4, 'PlayStation'),
(145, 'Razer Quick Charging Stand for Play Station', '3999.00', '214a7aaOW-L._SY355_.jpg', 'PC Gaming Accessories', 'Razer Quick Charging Stand for Play Station 5 DualSense Wireless Controller - Black - RC21-01900200-R3M1', 150, 0, NULL, 4, 'Razer'),
(146, 'PS5 DualSense Charging Station', '1699.00', '61P3XLJ2lVL._SX679_.jpg', 'PC Gaming Accessories', 'PowerA Twin Charging Station For PS5 Dualsense & Dualsense Edge Wireless Controllers,AC Adaptor Included,With LED Indicator,Vertical Dual Controller Fast Charging Dock (Officially Licensed),White\r\n', 146, 0, NULL, 4, 'PlayStation'),
(148, '8BitDo SN30 Pro Controller', '7199.00', '71Mge1Brz1L._SX522_.jpg', 'Phone Gaming Accessories', '8Bitdo Sn30 Pro Bluetooth Gamepad (G Classic Edition) - Nintendo Switch\r\n', 100, 0, NULL, 4, 'Other'),
(149, 'Vero Forza Arctic V3 Mobile Cooler for Gaming', '1278.00', '7198KsB3SHL._SY355_.jpg', 'Phone Gaming Accessories', 'Vero Forza Arctic V3 Mobile Cooler for Gaming | Magsafe Compatible | Ultra Quiet 7 Blade Fan | Phone Cooler for Bgmi, Pubg, Freefire, CODM (iPhone/Android)', 570, 0, NULL, 4, 'Other'),
(150, 'SpinBot  Wired & Wireless Mobile Cooler |', '1699.00', '61ljAUb0crL._SX425_.jpg', 'Phone Gaming Accessories', 'SpinBot Newly Launched IceDot Core X2 Magnetic Wired & Wireless Mobile Cooler | 7 Cooling Modes with 5000mAh Detachable Battery | Ultra-Quiet 42dB High-Speed 6000 RPM Fan | 15W Turbo Cooling', 1000, 0, NULL, 4, 'Other'),
(151, 'SpinBot BattleBudz  Type C Gaming Earphone', '699.00', '51Smy4MQhsL._SY355_.jpg', 'Phone Gaming Accessories', 'SpinBot BattleBudz C30 Wired in Ear Type C Gaming Earphone with Detachable Boom Mic |12mm Drivers | Dedicated Mic Mute Switch', 456, 0, NULL, 4, 'Other'),
(152, 'pTron Boom Type C Wired Headphones', '299.00', '51keyaqMsCL._SX425_.jpg', 'Phone Gaming Accessories', 'pTron Boom Play X3 In-Ear Type C Wired Headphones with Mic, 10mm Drivers for Pristine Sound, In-line Controls, 90 Degree USB-C Connector, 1.2m Tangle-Free Cable, Metal Buds & Wide Compatibility(Black)', 432, 0, NULL, 4, 'Other'),
(153, 'Circle Defender ZX7 Mid-Tower Gaming Cabinet', '5899.00', '81-GO8GkwDL._SX466_.jpg', 'PC Gaming Accessories', 'Circle Defender ZX7 Mid-Tower Gaming Cabinet - Black | Supports ATX, M-ATX, ITX | Reverse Motherboard Compatible | 3X Front, 3X Bottom, 1X Rear 120MM ARGB Fans with Infinity Mirror', 99, 0, NULL, 4, 'Other'),
(154, 'ZEBRONICS ZIUM Mid-Tower Gaming Cabinet', '1299.00', '81NvqrYWevL._SY355_.jpg', 'PC Gaming Accessories', 'ZEBRONICS ZIUM Mid-Tower Gaming Cabinet, M-ATX/M-ITX, Fins focussed Multicolor Rear Fan, Multi Color LED Strip, Acrylic Glass Side Panel, USB 3.0, USB 2.0', 57, 0, NULL, 4, 'Other'),
(155, 'GAMDIAS AEOLUS  Case Fans', '6599.00', '710SSccnpdL._SX342_.jpg', 'PC Gaming Accessories', 'GAMDIAS AEOLUS P2-1203U 3x120mm ARGB PWM Case Fans w/USB Hub, 2 Blades (Standard & Reverse Blades) in 1 Fan Pack, Sync with RGB Motherboards, Easy Installation & Cable Management w/Cabless Daisy Chain', 2642, 0, NULL, 4, 'Other'),
(156, 'ARCTIC ACFAN00135A P12 Value fan', '2499.00', '61i9iqYEEbL._SX342_.jpg', 'PC Gaming Accessories', 'ARCTIC ACFAN00135A P12 Value Pack - Pressure-Optimized 120 mm Fan, Black', 633, 0, NULL, 4, 'Other'),
(157, 'Ant Esports V4 Digital CPU Air Cooler CPU Fan with LED', '1899.00', '41+d83Db-iL._SY300_SX300_QL70_FMwebp_.webp', 'PC Gaming Accessories', 'Ant Esports V4 Digital CPU Air Cooler CPU Fan with LED Temperature Display & ARGB|90mm FAN| Support Intel - LGA1851 / 1700/1200 AMD - AM5 / AM4', 1074, 0, NULL, 4, 'Other'),
(158, 'ARCTIC Freezer 36 Black - Tower CPU Cooler ', '3599.00', '717lrPE5SDL._SX342_.jpg', 'PC Gaming Accessories', 'ARCTIC Freezer 36 Black - Tower CPU Cooler with Push-Pull, Two Pressure-optimised 120 mm P Fans, Fluid Dynamic Bearing, 200â€“1800 RPM, 4 Heatpipes, incl. MX-6 Thermal Compound', 1235, 0, NULL, 4, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `profile_pic`, `phone`, `address`, `password`, `profile_image`) VALUES
(1, 'da.satani', 'prajapati16@gmail.com', 'da.satani', '1758644670_9521.jpg', '9725666418', 'rajpar', '$2y$10$jX03eEkcdAWboCX77FFgteT1fASspZ9ttJGKdYfDo4f/fjmsqu3Gu', NULL),
(2, 'dhruvil', 'dhruvil@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$Chib.lLWqul1d8604us/Q.h.5Kt12ZXUdnED49b5SOncjBmF99L9u', NULL),
(3, 'da.satani', 'divyanshu@123gmail.com', NULL, NULL, NULL, NULL, '$2y$10$thE8bD5tjpqhMovDm7BqwODSvS5aD.GDODerZn2YFgit0O5ZcNmvq', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
