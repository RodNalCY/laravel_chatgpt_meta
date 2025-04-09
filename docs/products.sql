-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 07, 2025 at 11:13 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbchatgpt_meta_10x1`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image`, `video`, `location`, `stock`, `price`, `discount_price`, `currency`, `category`, `sku`, `url`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Samsung Galaxy S21 5G', 'El Samsung Galaxy S21 5G cuenta con una pantalla de 6.2 pulgadas, procesador Exynos 2100, 8 GB de RAM y una batería de 4000 mAh.', 's21_5g.jpg', 's21_5g_video.mp4', 'Almacén Central', 100, 799.99, 749.99, 'USD', 'Smartphones', 'SGS21-5G', 'https://www.samsung.com/latin_en/smartphones/galaxy-s21-5g/', '1', '2025-04-07 23:11:32', '2025-04-07 23:11:32'),
(2, 'Samsung Galaxy S22 5G', 'El Samsung Galaxy S22 5G ofrece una pantalla de 6.1 pulgadas, procesador Exynos 2200, 8 GB de RAM y una batería de 3700 mAh.', 's22_5g.jpg', 's22_5g_video.mp4', 'Almacén Norte', 150, 849.99, 799.99, 'USD', 'Smartphones', 'SGS22-5G', 'https://www.samsung.com/latin_en/smartphones/galaxy-s22-5g/', '1', '2025-04-07 23:11:32', '2025-04-07 23:11:32'),
(3, 'Samsung Galaxy A52', 'El Samsung Galaxy A52 cuenta con una pantalla de 6.5 pulgadas, procesador Snapdragon 720G, 8 GB de RAM y una batería de 4500 mAh.', 'a52.jpg', 'a52_video.mp4', 'Almacén Sur', 200, 499.99, 459.99, 'USD', 'Smartphones', 'SGA52', 'https://www.samsung.com/latin_en/smartphones/galaxy-a52/', '1', '2025-04-07 23:11:32', '2025-04-07 23:11:32'),
(4, 'Samsung Galaxy Note20', 'El Samsung Galaxy Note20 ofrece una pantalla de 6.7 pulgadas, procesador Exynos 990, 8 GB de RAM y una batería de 4300 mAh.', 'note20.jpg', 'note20_video.mp4', 'Almacén Este', 80, 999.99, 949.99, 'USD', 'Smartphones', 'SGN20', 'https://www.samsung.com/latin_en/smartphones/galaxy-note20/', '1', '2025-04-07 23:11:32', '2025-04-07 23:11:32'),
(5, 'Samsung Galaxy Z Fold3 5G', 'El Samsung Galaxy Z Fold3 5G presenta una pantalla plegable de 7.6 pulgadas, procesador Snapdragon 888, 12 GB de RAM y una batería de 4400 mAh.', 'z_fold3_5g.jpg', 'z_fold3_5g_video.mp4', 'Almacén Oeste', 50, 1799.99, 1699.99, 'USD', 'Smartphones', 'SGZF3-5G', 'https://www.samsung.com/latin_en/smartphones/galaxy-z-fold3-5g/', '1', '2025-04-07 23:11:32', '2025-04-07 23:11:32'),
(6, 'iPhone 15 Pro Max', 'El iPhone 15 Pro Max cuenta con una pantalla Super Retina XDR de 6.7 pulgadas, chip A17 Pro, sistema de cámara profesional con teleobjetivo 5x y una batería de larga duración.', 'iphone_15_pro_max.jpg', 'iphone_15_pro_max_video.mp4', 'Almacén Central', 120, 1199.99, 1149.99, 'USD', 'Smartphones', 'IP15PM', 'https://www.apple.com/iphone-15-pro/', '1', '2025-04-07 23:11:58', '2025-04-07 23:11:58'),
(7, 'iPhone 14', 'El iPhone 14 ofrece una pantalla Super Retina XDR de 6.1 pulgadas, chip A15 Bionic, sistema de cámara dual avanzado y capacidades de emergencia SOS vía satélite.', 'iphone_14.jpg', 'iphone_14_video.mp4', 'Almacén Norte', 150, 799.99, 749.99, 'USD', 'Smartphones', 'IP14', 'https://www.apple.com/iphone-14/', '1', '2025-04-07 23:11:58', '2025-04-07 23:11:58'),
(8, 'iPad Pro 11\" (2024)', 'El iPad Pro de 11 pulgadas (2024) incorpora el chip M4 de Apple, pantalla Ultra Retina XDR con tecnología OLED y compatibilidad con el Apple Pencil Pro.', 'ipad_pro_11_2024.jpg', 'ipad_pro_11_2024_video.mp4', 'Almacén Sur', 80, 999.99, 949.99, 'USD', 'Tablets', 'IPDPRO1124', 'https://www.apple.com/ipad-pro/', '1', '2025-04-07 23:11:58', '2025-04-07 23:11:58'),
(9, 'iPad Air 11\" (2024)', 'El iPad Air de 11 pulgadas (2024) está equipado con el chip M2 de Apple, pantalla Liquid Retina y soporte para el Apple Pencil de segunda generación.', 'ipad_air_11_2024.jpg', 'ipad_air_11_2024_video.mp4', 'Almacén Este', 100, 699.99, 659.99, 'USD', 'Tablets', 'IPDAIR1124', 'https://www.apple.com/ipad-air/', '1', '2025-04-07 23:11:58', '2025-04-07 23:11:58'),
(10, 'iPad Air 13\" (2024)', 'El iPad Air de 13 pulgadas (2024) ofrece una pantalla más grande, chip M2 de Apple y nuevas opciones de color, ideal para tareas creativas y productividad.', 'ipad_air_13_2024.jpg', 'ipad_air_13_2024_video.mp4', 'Almacén Oeste', 90, 799.99, 759.99, 'USD', 'Tablets', 'IPDAIR1324', 'https://www.apple.com/ipad-air/', '1', '2025-04-07 23:11:58', '2025-04-07 23:11:58'),
(11, 'Xiaomi 14 Ultra', 'El Xiaomi 14 Ultra cuenta con una cámara Leica de nivel profesional, Snapdragon 8 Gen 3 y una pantalla AMOLED de 6.73 pulgadas con tasa de refresco de 120Hz.', 'xiaomi_14_ultra.jpg', 'xiaomi_14_ultra_video.mp4', 'Almacén Central', 80, 1299.00, 1199.00, 'USD', 'Smartphones', 'XM14U', 'https://www.mi.com/global/product/xiaomi-14-ultra/', '1', '2025-04-07 23:12:36', '2025-04-07 23:12:36'),
(12, 'Xiaomi 13T Pro', 'El Xiaomi 13T Pro incluye cámara Leica, carga ultra rápida de 120W, pantalla AMOLED de 144Hz y procesador MediaTek Dimensity 9200+.', 'xiaomi_13t_pro.jpg', 'xiaomi_13t_pro_video.mp4', 'Almacén Este', 95, 799.00, 749.00, 'USD', 'Smartphones', 'XM13TP', 'https://www.mi.com/global/product/xiaomi-13t-pro/', '1', '2025-04-07 23:12:36', '2025-04-07 23:12:36'),
(13, 'Redmi Note 13 Pro+ 5G', 'El Redmi Note 13 Pro+ 5G ofrece una cámara de 200MP, pantalla curva AMOLED de 120Hz y batería de 5000 mAh con carga de 120W.', 'redmi_note_13_pro_plus.jpg', 'redmi_note_13_pro_plus_video.mp4', 'Almacén Norte', 110, 499.00, 459.00, 'USD', 'Smartphones', 'RN13P5G', 'https://www.mi.com/global/product/redmi-note-13-pro-plus-5g/', '1', '2025-04-07 23:12:36', '2025-04-07 23:12:36'),
(14, 'Xiaomi Pad 6', 'La Xiaomi Pad 6 ofrece una pantalla LCD de 11\" con 144Hz, procesador Snapdragon 870, 8GB de RAM y batería de 8840 mAh ideal para productividad y entretenimiento.', 'xiaomi_pad_6.jpg', 'xiaomi_pad_6_video.mp4', 'Almacén Sur', 60, 399.00, 379.00, 'USD', 'Tablets', 'XMPAD6', 'https://www.mi.com/global/product/xiaomi-pad-6/', '1', '2025-04-07 23:12:36', '2025-04-07 23:12:36'),
(15, 'Redmi Pad SE', 'La Redmi Pad SE es una tablet económica con pantalla FHD+ de 11\", procesador Snapdragon 680, y batería de 8000 mAh, perfecta para estudio y uso diario.', 'redmi_pad_se.jpg', 'redmi_pad_se_video.mp4', 'Almacén Oeste', 130, 199.00, 179.00, 'USD', 'Tablets', 'RPADSE', 'https://www.mi.com/global/product/redmi-pad-se/', '1', '2025-04-07 23:12:36', '2025-04-07 23:12:36'),
(16, 'Huawei Mate XT Ultimate Design', 'El Huawei Mate XT Ultimate Design es el primer smartphone plegable en tres partes del mundo, ofreciendo una pantalla OLED de 10.2 pulgadas que se pliega hasta un tamaño compacto de 6.4 pulgadas. Equipado con el procesador Kirin 9010 y 16 GB de RAM.', 'huawei_mate_xt.jpg', 'huawei_mate_xt_video.mp4', 'Almacén Central', 50, 2799.99, 2699.99, 'USD', 'Smartphones', 'HWMXTUD', 'https://consumer.huawei.com/en/phones/mate-xt-ultimate-design/', '1', '2025-04-07 23:13:36', '2025-04-07 23:13:36'),
(17, 'Huawei Pura X', 'El Huawei Pura X es un smartphone plegable que se abre lateralmente, ofreciendo una pantalla de 6.3 pulgadas con una relación de aspecto 16:10. Es el primer dispositivo que ejecuta HarmonyOS Next y cuenta con el asistente de IA Harmony Intelligence.', 'huawei_pura_x.jpg', 'huawei_pura_x_video.mp4', 'Almacén Este', 75, 1037.00, 999.00, 'USD', 'Smartphones', 'HWPX', 'https://consumer.huawei.com/en/phones/pura-x/', '1', '2025-04-07 23:13:36', '2025-04-07 23:13:36'),
(18, 'Huawei MatePad Pro 13.2-inch (2025)', 'La Huawei MatePad Pro 13.2-inch (2025) cuenta con una pantalla OLED flexible de 13.2 pulgadas, procesador Kirin T92, 16 GB de RAM y hasta 1 TB de almacenamiento. Ideal para profesionales creativos y productividad.', 'huawei_matepad_pro_13_2.jpg', 'huawei_matepad_pro_13_2_video.mp4', 'Almacén Norte', 60, 1199.99, 1149.99, 'USD', 'Tablets', 'HWMP1325', 'https://consumer.huawei.com/en/tablets/matepad-pro-13-2/', '1', '2025-04-07 23:13:36', '2025-04-07 23:13:36'),
(19, 'Huawei Pura 80 Pro', 'El Huawei Pura 80 Pro es el sucesor del Pura 70, con una pantalla curva de 6.8 pulgadas y mejoras significativas en tecnología fotográfica, incluyendo un teleobjetivo periscópico mejorado y el sensor OV50X de OmniVision.', 'huawei_pura_80_pro.jpg', 'huawei_pura_80_pro_video.mp4', 'Almacén Sur', 85, 1099.99, 1049.99, 'USD', 'Smartphones', 'HWP80P', 'https://consumer.huawei.com/en/phones/pura-80-pro/', '1', '2025-04-07 23:13:36', '2025-04-07 23:13:36'),
(20, 'Huawei Mate 70 Pro', 'El Huawei Mate 70 Pro cuenta con una pantalla OLED de 6.9 pulgadas, sistema de cámara triple con lentes Leica y batería de 5500 mAh. Ejecuta HarmonyOS 4.3 y ofrece un rendimiento excepcional.', 'huawei_mate_70_pro.jpg', 'huawei_mate_70_pro_video.mp4', 'Almacén Oeste', 90, 999.99, 949.99, 'USD', 'Smartphones', 'HWM70P', 'https://consumer.huawei.com/en/phones/mate-70-pro/', '1', '2025-04-07 23:13:36', '2025-04-07 23:13:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
