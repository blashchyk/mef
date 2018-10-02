-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 27 2017 г., 09:48
-- Версия сервера: 5.5.54
-- Версия PHP: 5.6.17-1+deb.sury.org~precise+2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `yii-cms-prod`
--

-- --------------------------------------------------------

--
-- Структура таблицы `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `phone_code` int(5) unsigned NOT NULL,
  `vat_rate` int(2) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=246 ;

--
-- Дамп данных таблицы `country`
--

INSERT INTO `country` (`id`, `name`, `phone_code`, `vat_rate`) VALUES
(1, 'United States', 1, 8),
(2, 'Canada', 1, 10),
(3, 'United Kingdom', 44, NULL),
(4, 'Australia', 61, NULL),
(5, 'Abkhazia', 7, NULL),
(6, 'Afghanistan', 93, NULL),
(7, 'Ajaria', 995, NULL),
(8, 'Akrotiri and Dhekelia', 357, NULL),
(9, 'Albania', 355, NULL),
(10, 'Algeria', 213, NULL),
(11, 'American Samoa', 1684, NULL),
(12, 'Andorra', 376, NULL),
(13, 'Angola', 244, NULL),
(14, 'Anguilla', 1264, NULL),
(15, 'Antigua and Barbuda', 1268, NULL),
(16, 'Argentina', 54, NULL),
(17, 'Armenia', 374, NULL),
(18, 'Aruba', 297, NULL),
(19, 'Austria', 43, NULL),
(20, 'Azerbaijan', 994, NULL),
(21, 'Bahamas', 1242, NULL),
(22, 'Bahrain', 973, NULL),
(23, 'Bangladesh', 880, NULL),
(24, 'Barbados', 1246, NULL),
(25, 'Belarus', 375, NULL),
(26, 'Belgium', 32, NULL),
(27, 'Belize', 501, NULL),
(28, 'Benin', 229, NULL),
(29, 'Bermuda', 1441, NULL),
(30, 'Bhutan', 975, NULL),
(31, 'Bolivia', 591, NULL),
(32, 'Bosnia and Herzegovina', 387, NULL),
(33, 'Botswana', 267, NULL),
(34, 'Brazil', 55, NULL),
(35, 'British Antarctic Territory', 0, NULL),
(36, 'British Indian Ocean Territory', 246, NULL),
(37, 'British Virgin Islands', 1284, NULL),
(38, 'Brunei', 673, NULL),
(39, 'Bulgaria', 359, NULL),
(40, 'Burkina Faso', 226, NULL),
(41, 'Burma', 95, NULL),
(42, 'Burundi', 257, NULL),
(43, 'Cambodia', 855, NULL),
(44, 'Cameroon', 237, NULL),
(45, 'Cape Verde', 238, NULL),
(46, 'Cayman Islands', 1345, NULL),
(47, 'Central African Republic', 236, NULL),
(48, 'Chad', 235, NULL),
(49, 'Chile', 56, NULL),
(50, 'China', 86, NULL),
(51, 'Christmas Island', 61, NULL),
(52, 'Cocos (Keeling) Islands', 61, NULL),
(53, 'Colombia', 57, NULL),
(54, 'Comoros', 269, NULL),
(55, 'Congo-Brazzaville', 242, NULL),
(56, 'Congo-Kinshasa', 243, NULL),
(57, 'Cook Islands', 682, NULL),
(58, 'Costa Rica', 506, NULL),
(59, 'Cote d''Ivoire', 225, NULL),
(60, 'Crimea', 380, NULL),
(61, 'Croatia', 385, NULL),
(62, 'Cuba', 53, NULL),
(63, 'Cyprus', 357, NULL),
(64, 'Czech Republic', 420, NULL),
(65, 'Denmark', 45, NULL),
(66, 'Djibouti', 253, NULL),
(67, 'Dominica', 1767, NULL),
(68, 'Dominican Republic', 1809, NULL),
(69, 'East Timor', 670, NULL),
(70, 'Ecuador', 593, NULL),
(71, 'Egypt', 20, NULL),
(72, 'El Salvador', 503, NULL),
(73, 'Equatorial Guinea', 240, NULL),
(74, 'Eritrea', 291, NULL),
(75, 'Estonia', 372, NULL),
(76, 'Ethiopia', 251, NULL),
(77, 'Falkland Islands', 500, NULL),
(78, 'Faroe Islands', 298, NULL),
(79, 'Federated States of Micronesia', 691, NULL),
(80, 'Fiji', 679, NULL),
(81, 'Finland', 358, NULL),
(82, 'France', 33, NULL),
(83, 'French Southern and Antarctic Lands', 262, NULL),
(84, 'Gabon', 241, NULL),
(85, 'Gambia', 220, NULL),
(86, 'Georgia', 995, NULL),
(87, 'Germany', 49, NULL),
(88, 'Ghana', 233, NULL),
(89, 'Gibraltar', 350, NULL),
(90, 'Greece', 30, NULL),
(91, 'Greenland', 299, NULL),
(92, 'Grenada', 1473, NULL),
(93, 'Guam', 1671, NULL),
(94, 'Guatemala', 502, NULL),
(95, 'Guinea', 224, NULL),
(96, 'Guinea-Bissau', 245, NULL),
(97, 'Guyana', 592, NULL),
(98, 'Haiti', 509, NULL),
(99, 'Honduras', 504, NULL),
(100, 'Hong Kong', 852, NULL),
(101, 'Hungary', 36, NULL),
(102, 'Iceland', 354, NULL),
(103, 'India', 91, NULL),
(104, 'Indonesia', 62, NULL),
(105, 'Iran', 98, NULL),
(106, 'Iraq', 964, NULL),
(107, 'Ireland', 353, NULL),
(108, 'Israel', 972, NULL),
(109, 'Italy', 39, NULL),
(110, 'Jamaica', 1876, NULL),
(111, 'Japan', 81, NULL),
(112, 'Jordan', 962, NULL),
(113, 'Karakalpakstan', 998, NULL),
(114, 'Kazakhstan', 7, NULL),
(115, 'Kenya', 254, NULL),
(116, 'Kiribati', 686, NULL),
(117, 'Kosovo', 381, NULL),
(118, 'Kuwait', 965, NULL),
(119, 'Kyrgyzstan', 996, NULL),
(120, 'Laos', 856, NULL),
(121, 'Latvia', 371, NULL),
(122, 'Lebanon', 961, NULL),
(123, 'Lesotho', 266, NULL),
(124, 'Liberia', 231, NULL),
(125, 'Libya', 218, NULL),
(126, 'Liechtenstein', 423, NULL),
(127, 'Lithuania', 370, NULL),
(128, 'Luxembourg', 352, NULL),
(129, 'Macau', 853, NULL),
(130, 'Macedonia', 389, NULL),
(131, 'Madagascar', 261, NULL),
(132, 'Malawi', 265, NULL),
(133, 'Malaysia', 60, NULL),
(134, 'Maldives', 960, NULL),
(135, 'Mali', 223, NULL),
(136, 'Malta', 356, NULL),
(137, 'Marshall Islands', 692, NULL),
(138, 'Mauritania', 222, NULL),
(139, 'Mauritius', 230, NULL),
(140, 'Mayotte', 262, NULL),
(141, 'Mexico', 52, NULL),
(142, 'Moldova', 373, NULL),
(143, 'Monaco', 377, NULL),
(144, 'Mongolia', 976, NULL),
(145, 'Montenegro', 382, NULL),
(146, 'Montserrat', 1664, NULL),
(147, 'Morocco', 212, NULL),
(148, 'Mozambique', 258, NULL),
(149, 'Nagorno-Karabakh Republic', 374, NULL),
(150, 'Namibia', 264, NULL),
(151, 'Nauru', 674, NULL),
(152, 'Nepal', 977, NULL),
(153, 'Netherlands', 31, NULL),
(154, 'Netherlands Antilles', 599, NULL),
(155, 'New Caledonia', 687, NULL),
(156, 'New Zealand', 64, NULL),
(157, 'Nicaragua', 505, NULL),
(158, 'Niger', 227, NULL),
(159, 'Nigeria', 234, NULL),
(160, 'Niue', 683, NULL),
(161, 'Norfolk Island', 672, NULL),
(162, 'North Korea', 850, NULL),
(163, 'Northern Cyprus', 90392, NULL),
(164, 'Northern Mariana Islands', 1670, NULL),
(165, 'Norway', 47, NULL),
(166, 'Oman', 968, NULL),
(167, 'Pakistan', 92, NULL),
(168, 'Palau', 680, NULL),
(169, 'Palestine', 970, NULL),
(170, 'Panama', 507, NULL),
(171, 'Papua New Guinea', 675, NULL),
(172, 'Paraguay', 595, NULL),
(173, 'Peru', 51, NULL),
(174, 'Philippines', 63, NULL),
(175, 'Pitcairn Islands', 870, NULL),
(176, 'Poland', 48, NULL),
(177, 'Polynesia', 689, NULL),
(178, 'Portugal', 351, NULL),
(179, 'Puerto Rico', 1, NULL),
(180, 'Qatar', 974, NULL),
(181, 'Romania', 40, NULL),
(182, 'Russia', 7, NULL),
(183, 'Rwanda', 250, NULL),
(184, 'Saint Barthelemy', 590, NULL),
(185, 'Saint Helena', 290, NULL),
(186, 'Saint Kitts and Nevis', 1869, NULL),
(187, 'Saint Lucia', 1758, NULL),
(188, 'Saint Martin', 1599, NULL),
(189, 'Saint Pierre and Miquelon', 508, NULL),
(190, 'Saint Vincent and the Grenadines', 1784, NULL),
(191, 'Samoa', 685, NULL),
(192, 'San Marino', 378, NULL),
(193, 'Sao Tome and Principe', 239, NULL),
(194, 'Saudi Arabia', 966, NULL),
(195, 'Senegal', 221, NULL),
(196, 'Serbia', 381, NULL),
(197, 'Seychelles', 248, NULL),
(198, 'Sierra Leone', 232, NULL),
(199, 'Singapore', 65, NULL),
(200, 'Slovakia', 421, NULL),
(201, 'Slovenia', 386, NULL),
(202, 'Solomon Islands', 677, NULL),
(203, 'Somalia', 252, NULL),
(204, 'Somaliland', 252, NULL),
(205, 'South Africa', 27, NULL),
(206, 'South Georgia and the South Sandwich Islands', 500, NULL),
(207, 'South Korea', 82, NULL),
(208, 'South Ossetia', 99534, NULL),
(209, 'Spain', 34, NULL),
(210, 'Sri Lanka', 94, NULL),
(211, 'Sudan', 249, NULL),
(212, 'Suriname', 597, NULL),
(213, 'Swaziland', 268, NULL),
(214, 'Sweden', 46, NULL),
(215, 'Switzerland', 41, NULL),
(216, 'Syria', 963, NULL),
(217, 'Taiwan', 886, NULL),
(218, 'Tajikistan', 992, NULL),
(219, 'Tanzania', 255, NULL),
(220, 'Thailand', 66, NULL),
(221, 'Togo', 228, NULL),
(222, 'Tokelau', 690, NULL),
(223, 'Tonga', 676, NULL),
(224, 'Transnistria', 373, NULL),
(225, 'Trinidad and Tobago', 1868, NULL),
(226, 'Tunisia', 216, NULL),
(227, 'Turkey', 90, NULL),
(228, 'Turkmenistan', 993, NULL),
(229, 'Turks and Caicos Islands', 1649, NULL),
(230, 'Tuvalu', 688, NULL),
(231, 'Uganda', 256, NULL),
(232, 'Ukraine', 380, NULL),
(233, 'United Arab Emirates', 971, NULL),
(234, 'United States Virgin Islands', 1340, NULL),
(235, 'Uruguay', 598, NULL),
(236, 'Uzbekistan', 998, NULL),
(237, 'Vanuatu', 678, NULL),
(238, 'Vatican City', 379, NULL),
(239, 'Venezuela', 58, NULL),
(240, 'Vietnam', 84, NULL),
(241, 'Wallis and Futuna', 681, NULL),
(242, 'Western Sahara', 212, NULL),
(243, 'Yemen', 967, NULL),
(244, 'Zambia', 260, NULL),
(245, 'Zimbabwe', 263, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `ctlg_category`
--

CREATE TABLE IF NOT EXISTS `ctlg_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `sorting` int(4) unsigned DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_ctlg_category_ctlg_category` (`parent_id`),
  KEY `fk_ctlg_category_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `ctlg_category`
--

INSERT INTO `ctlg_category` (`id`, `parent_id`, `user_id`, `name`, `slug`, `description`, `visible`, `sorting`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Smartphones', 'smartphones', '', 1, 1, NULL, 1458636576),
(2, NULL, 1, 'Laptops', 'laptops', '', 1, 2, NULL, 1497881481),
(3, NULL, 1, 'Tablets', 'tablets', '', 1, 3, NULL, 1458636605),
(4, NULL, 1, 'Gadgets', 'gadgets', '', 1, 4, NULL, 1458636624),
(5, NULL, 1, 'Headphones', 'headphones', '', 1, 5, NULL, 1458637153),
(6, NULL, 1, 'Printers', 'printers', '', 1, 6, NULL, 1458636897),
(7, NULL, 1, 'Camera', 'camera', '', 1, 7, NULL, 1458637307);

-- --------------------------------------------------------

--
-- Структура таблицы `ctlg_category_i18n`
--

CREATE TABLE IF NOT EXISTS `ctlg_category_i18n` (
  `id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`,`language`),
  KEY `fk_ctlg_category_i18n_i18n_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `ctlg_field`
--

CREATE TABLE IF NOT EXISTS `ctlg_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(1) unsigned NOT NULL DEFAULT '0',
  `sorting` int(4) unsigned DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_ctlg_field_ctlg_category` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `ctlg_field`
--

INSERT INTO `ctlg_field` (`id`, `category_id`, `name`, `type`, `sorting`, `visible`) VALUES
(1, 2, 'Diagonal', 3, NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `ctlg_filter`
--

CREATE TABLE IF NOT EXISTS `ctlg_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(1) unsigned NOT NULL DEFAULT '0',
  `category_id` int(11) DEFAULT NULL,
  `sorting` int(4) unsigned DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_ctlg_filter_ctlg_category` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `ctlg_filter`
--

INSERT INTO `ctlg_filter` (`id`, `field`, `type`, `category_id`, `sorting`, `visible`) VALUES
(1, 'name', 1, NULL, 1, 1),
(2, 'price', 2, NULL, 2, 1),
(3, 'user_id', 5, NULL, 3, 1),
(4, 'producer', 5, NULL, 4, 1),
(5, '1', 4, 2, 5, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `ctlg_product`
--

CREATE TABLE IF NOT EXISTS `ctlg_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `producer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` float DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `sorting` int(4) unsigned DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_ctlg_product_ctlg_category` (`parent_id`),
  KEY `fk_ctlg_product_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `ctlg_product`
--

INSERT INTO `ctlg_product` (`id`, `parent_id`, `user_id`, `name`, `slug`, `producer`, `image`, `price`, `description`, `visible`, `sorting`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Samsung Galaxy s7', 'samsung-galaxy-s7', 'Samsung', '1458637833.jpg', 850, 'Brand: Samsung\r\nOperating System:	Android	\r\nStyle: Bar\r\nColour: Black	\r\nCamera Resolution:	 12.0MP\r\nConnectivity: 3G, 4G	\r\nModel: Samsung Galaxy S7 Edge\r\nStorage Capacity:	32GB', 1, 1, 1458637833, 1493907276),
(2, 1, 15, 'Apple Iphone 6s', 'apple-iphone-6s', 'Apple', '1458638079.jpg', 800, 'Brand: Apple\r\nStorage Capacity: 128GB\r\nScreen Size: 5.5"\r\nCamera Resolution: 12.0MP\r\n', 1, 2, 1458638079, 1493907270),
(3, 1, 1, 'Motorolla Nexus 6', 'motorolla-nexus-6', 'Motorolla', '1458638323.jpg', 400, 'Operating System: Android 5.0 Lollipop\r\nDisplay: 5.96" AMOLED\r\nMemory: 3GB\r\nCamera: 13MP IMX 214 Image Sensor\r\n', 1, 3, 1458638323, 1493907265),
(4, 2, 3, 'New HP Black 15.6" 15-f211wm Touchscreen', 'new-hp-black-15.6"-15-f211wm-touchscreen', 'HP', '1458638581.jpg', 400, 'Brand: HP\r\nProcessor Speed: 2.16 GHz with a Max Turbo Speed of 2.58 1MB Cache\r\nMemory:	4GB DDR3L SDRAM (1 DIMM)\r\nHard Drive Capacity: 500GB 5400RPM hard drive\r\nOperating System:	Windows 10 Home', 1, 4, 1458638581, 1497881664),
(5, 2, 2, 'ASUS-X553MA', 'asus-x553ma', 'Asus', '1458638817.jpg', 400, 'Brand: ASUS\r\nModel: X553MA\r\nProcessor Speed: 2.16GHz\r\nOperating System:	Windows 8.1\r\nScreen Size:	15.6"\r\nMemory:	4GB', 1, 5, 1458638817, 1497881646),
(6, 2, 1, 'Lenovo Yoga 3', 'lenovo-yoga-3', '', '1458639029.jpg', 600, 'Brand: Lenovo\r\nProcessor Speed: 1.10GHz\r\nOperating System:	Windows 8.1\r\nScreen Size:	13.3"\r\nMemory:	8GB\r\nHard Drive Capacity: 256GB', 1, 6, 1458639029, 1497881641),
(7, 3, 1, 'LENOVO YOGA TAB', 'lenovo-yoga-tab', 'Lenovo', '1458639254.jpg', 200, 'Brand: Lenovo\r\nProcessor: Quad Core 1.3GHz\r\nOperating System:	Android 5.1 Lollipop\r\nDisplay:	8" HD(800x1280), IPS 10 Touch Screen\r\nStorage Capacity:	16GB\r\n', 1, 7, 1458639254, 1493907243),
(8, 3, 1, 'TABLET SAMSUNG GALAXY TAB', 'tablet-samsung-galaxy-tab', 'Samsung', '1458639405.jpg', 300, 'Brand: SAMSUNG\r\nOperating System:	Android 5.0.X Lollipop\r\nProcessor Speed:	1.2 GHz\r\nScreen Size:	9.7"\r\nStorage Capacity:	32GB\r\nProcessor:	Quad Core', 1, 8, 1458639405, 1493907235),
(9, 3, 2, 'Sony Xperia Tablet Z Black', 'sony-xperia-tablet-z-black', 'Sony', '1458639583.jpg', 350, 'Brand: Sony\r\nResolution: 1920 x 1080\r\nModel: Xperia Tablet Z (SGP321)\r\nScreen Size:	10.1''''\r\nMemory Capacity:	16gb\r\nCamera Resolution:	8 Megapixel', 1, 9, 1458639583, 1493907222),
(10, 4, 3, 'Apple Watch Sport', 'apple-watch-sport', 'Apple', '1458639859.jpg', 350, 'Brand: Apple\r\nCompatible Operating System: iOS - Apple\r\nModel: Watch Sport\r\n', 1, 10, 1458639859, 1493907227),
(11, 4, 3, 'Samsung Galaxy Gear S', 'samsung-galaxy-gear-s', 'Samsung', '1458640025.jpg', 150, 'Brand: Samsung\r\nBluetooth Compliant: 4.1\r\nModel: SM-R750V\r\nDisplay Size (Diagonal):	2 inches\r\nOperating System:	Tizen\r\nScreen Type:	Super AMOLED', 1, 11, 1458640025, 1493907213),
(12, 4, 2, 'Bluetooth Wrist SMART Bracelet', 'bluetooth-wrist-smart-bracelet', 'Apple', '1458640202.jpg', 10, 'Brand: Unbranded/Generic\r\nStorage Capacity:	32 MB\r\nModel: L12S\r\nCompatible Operating System: IOS-Apple,Android\r\n', 1, 12, 1458640202, 1493907206),
(13, 5, 15, 'Beats urBeats', 'beats-urbeats', 'Apple', '1458641467.jpg', 70, 'Color: Brand:	\r\nBeats by Dr. DreWhite\r\nMPN: BT IN URBTS2 WH', 1, 13, 1458641467, 1493907192),
(14, 5, 15, 'Apple iPhone Headphone Earpods', 'apple-iphone-headphone-earpods', 'Apple', '1458641671.jpg', 5, 'iPhone 6 PLUS, 6, 5, 5c, 5s, 4, 4S,\r\niPad Mini, iPad 4, iPad 1/2/3\r\n', 1, 14, 1458641671, 1493907153),
(15, 5, 3, 'Original Samsung 3.5mm', 'original-samsung-3.5mm', 'Samsung', '1458641845.jpg', 5, 'Brand: Samsung\r\nMPN: Does Not Apply\r\nUPC: Does not apply', 1, 15, 1458641845, 1493907145);

-- --------------------------------------------------------

--
-- Структура таблицы `ctlg_product_field`
--

CREATE TABLE IF NOT EXISTS `ctlg_product_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_ctlg_product_field_ctlg_product` (`product_id`),
  KEY `fk_ctlg_product_field_ctlg_category` (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `ctlg_product_field`
--

INSERT INTO `ctlg_product_field` (`id`, `product_id`, `field_id`, `value`) VALUES
(1, 6, 1, '13'),
(2, 5, 1, '15'),
(3, 4, 1, '15');

-- --------------------------------------------------------

--
-- Структура таблицы `ctlg_product_i18n`
--

CREATE TABLE IF NOT EXISTS `ctlg_product_i18n` (
  `id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`,`language`),
  KEY `fk_ctlg_product_i18n_i18n_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `faq_category`
--

CREATE TABLE IF NOT EXISTS `faq_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `visible` tinyint(1) DEFAULT '1',
  `sorting` int(4) unsigned DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_faq_category_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `faq_category`
--

INSERT INTO `faq_category` (`id`, `user_id`, `name`, `slug`, `keywords`, `visible`, `sorting`, `created_at`, `updated_at`) VALUES
(1, 1, 'Our project development progress', 'our-project-development-progress', '', 1, 1, 1458634905, 1458913534),
(2, 1, 'Quality and process control', 'quality-and-process-control', '', 1, 2, 1458634959, 1458634959),
(3, 1, 'Other details about the working process', 'other-details-about-the-working-process', '', 1, 3, 1458635503, 1458635503);

-- --------------------------------------------------------

--
-- Структура таблицы `faq_category_i18n`
--

CREATE TABLE IF NOT EXISTS `faq_category_i18n` (
  `id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`,`language`),
  KEY `fk_faq_category_i18n_i18n_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `faq_category_i18n`
--

INSERT INTO `faq_category_i18n` (`id`, `language`, `name`) VALUES
(1, 'ru', 'Разработка нашего проэкта');

-- --------------------------------------------------------

--
-- Структура таблицы `faq_item`
--

CREATE TABLE IF NOT EXISTS `faq_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `visible` tinyint(1) DEFAULT '1',
  `sorting` int(4) unsigned DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_faq_item_faq_category` (`parent_id`),
  KEY `fk_faq_item_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `faq_item`
--

INSERT INTO `faq_item` (`id`, `parent_id`, `user_id`, `name`, `slug`, `description`, `visible`, `sorting`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'How can I be confident of the quality and reliability?', 'how-can-i-be-confident-of-the-quality-and-reliability?', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 1, 1, 1458635319, 1482309377),
(2, 2, 1, 'Do you do software testing, verifications and QA services?', 'do-you-do-software-testing,-verifications-and-qa-services?', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 1, 2, 1458635346, 1458635703),
(3, 1, 1, 'Do you provide post-development maintenance?', 'do-you-provide-post-development-maintenance?', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 1, 3, 1458635357, 1458635708),
(4, 2, 1, 'How do you deal with urgent bug fixing?', 'how-do-you-deal-with-urgent-bug-fixing?', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 1, 4, 1458635371, 1458635713),
(5, 1, 1, 'How detailed set of requirements do you require from us?', 'how-detailed-set-of-requirements-do-you-require-from-us?', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 1, 5, 1458635428, 1458635765),
(6, 1, 1, 'How can I monitor and control project development progress?', 'how-can-i-monitor-and-control-project-development-progress?', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 1, 6, 1458635441, 1458635718),
(7, 3, 1, 'What time zone is Technologies in?', 'what-time-zone-is-technologies-in?', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 1, 7, 1458635575, 1459078971),
(8, 3, 1, 'What if my question is not answered on this page?', 'what-if-my-question-is-not-answered-on-this-page?', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 1, 8, 1458635584, 1458635726);

-- --------------------------------------------------------

--
-- Структура таблицы `faq_item_i18n`
--

CREATE TABLE IF NOT EXISTS `faq_item_i18n` (
  `id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`,`language`),
  KEY `fk_faq_item_i18n_i18n_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `faq_item_i18n`
--

INSERT INTO `faq_item_i18n` (`id`, `language`, `name`, `description`) VALUES
(1, 'ru', 'Как я могу быть уверен в качестве и надёжности ?', '');

-- --------------------------------------------------------

--
-- Структура таблицы `i18n_language`
--

CREATE TABLE IF NOT EXISTS `i18n_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `language` (`language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `i18n_language`
--

INSERT INTO `i18n_language` (`id`, `language`, `name`) VALUES
(1, 'en', 'English'),
(2, 'ru', 'Русский');

-- --------------------------------------------------------

--
-- Структура таблицы `i18n_message`
--

CREATE TABLE IF NOT EXISTS `i18n_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=322 ;

--
-- Дамп данных таблицы `i18n_message`
--

INSERT INTO `i18n_message` (`id`, `category`, `message`) VALUES
(1, 'app', 'Signup Confirmation'),
(2, 'app', 'Password Reset Link'),
(3, 'app', 'User with the same email as in {client} account already exists but isn''t linked to it.<br /> Login using email first to link it.'),
(4, 'app', 'The {client} account is already linked to a different user.'),
(5, 'app', 'The {client} account is already linked to your user.'),
(6, 'app', 'You are not allowed to perform this action.<br /> Only registered administrators can login to the Admin Panel.'),
(7, 'app', 'The {client} account is successfully linked to your user.'),
(8, 'app', 'The {client} account is successfully linked to your user.<br /> The data associated with an old user logged with the {client} account before is merged with your user now.'),
(9, 'app', 'No file uploaded.'),
(10, 'app', 'The file is empty.'),
(11, 'app', 'Wrong image format. Allowed formats are jpg, png and gif.'),
(12, 'app', 'File uploading error. No writing/modifying file permission.'),
(13, 'app', 'Refresh Data'),
(14, 'app', 'Add New Record'),
(15, 'app', 'Block Selected'),
(16, 'app', 'Unblock Selected'),
(17, 'app', 'Mark Selected as Read'),
(18, 'app', 'Mark Selected as Unread'),
(19, 'app', 'Delete Selected'),
(20, 'app', 'Are you sure you want to delete the selected items?'),
(21, 'app', 'Per page'),
(22, 'app', 'Hello'),
(23, 'app', 'Thank you for signup'),
(24, 'app', 'Follow the link below to confirm your email'),
(25, 'app', 'Your personal data'),
(26, 'app', 'Follow the link below to reset your password'),
(27, 'app', 'Incorrect username or password.'),
(28, 'app', 'ID'),
(29, 'app', 'Name'),
(30, 'app', 'Slug'),
(31, 'app', 'Default'),
(32, 'app', 'Language'),
(33, 'app', 'Link Name'),
(34, 'app', 'Page Title'),
(35, 'app', 'Meta Keywords'),
(36, 'app', 'Meta Description'),
(37, 'app', 'Header'),
(38, 'app', 'Content'),
(39, 'app', 'Category'),
(40, 'app', 'Message'),
(41, 'app', 'Only logged'),
(42, 'app', 'Only not logged'),
(43, 'app', 'Owner'),
(44, 'app', 'Sorting'),
(45, 'app', 'Visible'),
(46, 'app', 'Title'),
(47, 'app', 'Created'),
(48, 'app', 'Updated'),
(49, 'app', 'Custom'),
(50, 'app', 'System'),
(51, 'app', 'Type'),
(52, 'app', 'Role Name'),
(53, 'app', 'Male'),
(54, 'app', 'Female'),
(55, 'app', 'Username'),
(56, 'app', 'Auth Key'),
(57, 'app', 'Password Hash'),
(58, 'app', 'Password Reset Token'),
(59, 'app', 'Access Token'),
(61, 'app', 'First Name'),
(62, 'app', 'Last Name'),
(63, 'app', 'Role'),
(64, 'app', 'Country'),
(65, 'app', 'Zip'),
(66, 'app', 'City'),
(67, 'app', 'Address'),
(68, 'app', 'Phone'),
(69, 'app', 'Avatar'),
(70, 'app', 'Birth Date'),
(71, 'app', 'Gender'),
(72, 'app', 'Verified'),
(73, 'app', 'Active'),
(74, 'app', 'Last Login'),
(75, 'app', 'User'),
(76, 'app', 'Source'),
(77, 'app', 'Source ID'),
(78, 'app', 'Screen Name'),
(79, 'app', 'Parent'),
(80, 'app', 'Module Name'),
(81, 'app', 'Keywords'),
(82, 'app', 'Module'),
(83, 'app', 'Menu'),
(84, 'app', 'Page'),
(85, 'app', 'Link Caption'),
(86, 'app', 'Url'),
(87, 'app', 'No'),
(88, 'app', 'Yes'),
(89, 'app', 'Parent Category'),
(90, 'app', 'Description'),
(91, 'app', 'Translation'),
(92, 'app', 'Source Message'),
(93, 'app', 'Question'),
(94, 'app', 'Sender Email'),
(95, 'app', 'Sender Name'),
(96, 'app', 'Subject'),
(97, 'app', 'Letter Body'),
(98, 'app', 'Opened'),
(99, 'app', 'Verification Code'),
(100, 'app', 'Sender'),
(102, 'app', 'Phone Code'),
(103, 'app', 'Image'),
(104, 'app', 'Image Url'),
(105, 'app', 'Thumbnail Url'),
(106, 'app', 'Key'),
(107, 'app', 'Value'),
(108, 'app', 'Code'),
(109, 'app', 'Menu Name'),
(110, 'app', 'Price'),
(111, 'app', 'The requested page does not exist.'),
(112, 'app', 'Saving value error.'),
(113, 'app', 'Link a new Social Account'),
(114, 'app', 'Edit User'),
(116, 'app', 'Users'),
(117, 'app', 'Add User'),
(118, 'app', 'Block'),
(119, 'app', 'Unblock'),
(120, 'app', 'Expand'),
(121, 'app', 'Search'),
(122, 'app', 'Reset'),
(123, 'app', 'Roles'),
(124, 'app', 'Add Role'),
(125, 'app', 'General'),
(126, 'app', 'Contacts'),
(127, 'app', 'Settings'),
(128, 'app', 'Password'),
(129, 'app', 'Create'),
(130, 'app', 'Update'),
(131, 'app', 'Delete Image'),
(132, 'app', 'Are you sure you want to delete the image?'),
(133, 'app', 'Edit Theme'),
(134, 'app', 'Themes'),
(135, 'app', 'Delete'),
(137, 'app', 'Add Theme'),
(138, 'app', 'Theme Settings'),
(139, 'app', 'Noname'),
(140, 'app', 'Set as Default'),
(141, 'app', 'Are you sure you want to set the theme as default?'),
(142, 'app', 'Edit Setting'),
(143, 'app', 'Add Setting'),
(144, 'app', 'Site Settings'),
(145, 'app', 'Edit Page'),
(146, 'app', 'Pages'),
(147, 'app', 'Add Page'),
(148, 'app', 'Translation List'),
(149, 'app', 'Categories'),
(150, 'app', 'Add Category'),
(151, 'app', 'Menus'),
(152, 'app', 'Add Menu'),
(153, 'app', 'Meta Tags'),
(154, 'app', 'Translations'),
(155, 'app', 'Admin Panel'),
(156, 'app', 'My Profile'),
(157, 'app', 'Logout'),
(158, 'app', 'Created by'),
(159, 'app', 'Edit Translation'),
(160, 'app', 'Add Translation'),
(162, 'app', 'Edit Language'),
(163, 'app', 'Languages'),
(164, 'app', 'Add Language'),
(165, 'app', 'Language Info'),
(166, 'app', 'Edit Category'),
(167, 'app', 'Disable'),
(168, 'app', 'Enable'),
(170, 'app', 'Media Category'),
(171, 'app', 'Edit Product'),
(172, 'app', 'Products'),
(173, 'app', 'Add Product'),
(176, 'app', 'Edit Module'),
(177, 'app', 'Modules'),
(178, 'app', 'Add Module'),
(179, 'app', 'Module Settings'),
(180, 'app', 'Login'),
(182, 'app', 'The above error occurred while the Web server was processing your request.'),
(183, 'app', 'Please contact us if you think this is a server error. Thank you.'),
(184, 'app', 'Edit Item'),
(185, 'app', 'Items'),
(186, 'app', 'Questions'),
(187, 'app', 'Add Question'),
(188, 'app', 'Add Item'),
(190, 'app', 'Link Caption Translations'),
(191, 'app', 'Edit Menu'),
(192, 'app', 'Add New Menu Item'),
(193, 'app', 'Custom Link'),
(194, 'app', 'Text Item'),
(195, 'app', 'Item Count'),
(196, 'app', 'Caption'),
(197, 'app', 'Toggle'),
(198, 'app', 'Show Details'),
(199, 'app', 'Hide Details'),
(200, 'app', 'Add Items'),
(201, 'app', 'Add Pages'),
(202, 'app', 'Add Link'),
(203, 'app', 'Add Text Item'),
(204, 'app', 'Select All'),
(205, 'app', 'Item List'),
(206, 'app', 'List does not contain any items.'),
(207, 'app', 'Edit Email'),
(208, 'app', 'View Email'),
(209, 'app', 'Emails'),
(210, 'app', 'Add Email'),
(211, 'app', 'Mark as Not Read'),
(212, 'app', 'Mark as Read'),
(214, 'app', 'User Email'),
(215, 'app', 'Edit Role'),
(216, 'app', 'User Role'),
(217, 'app', 'Permission'),
(218, 'app', 'User doesn’t have access to the admin panel'),
(219, 'app', 'Super admin has full access to the admin panel'),
(220, 'app', 'Page Categories'),
(222, 'app', 'Edit File'),
(223, 'app', 'Media'),
(224, 'app', 'Add File'),
(225, 'app', 'Media Files'),
(226, 'app', 'Copy'),
(227, 'app', 'Media File'),
(228, 'app', 'Generated'),
(229, 'app', 'Data Export'),
(230, 'app', 'Sign In to Your Account'),
(231, 'app', 'Please fill out the following fields to login:'),
(232, 'app', 'Sign In With'),
(233, 'app', 'If you forgot your password you can'),
(234, 'app', 'reset it'),
(235, 'app', 'Please fill out the following fields to signup:'),
(236, 'app', 'Signup'),
(237, 'app', 'Please fill out your email. A link to reset password will be sent there.'),
(238, 'app', 'Save'),
(239, 'app', 'Change Password'),
(240, 'app', 'Edit Profile'),
(241, 'app', 'Web development company'),
(242, 'app', 'Our team consists of experienced web developers, designers and managers.'),
(243, 'app', 'We are looking for new clients or ongoing relationship with new business partners!'),
(244, 'app', 'Hire dedicated team of Professional web Developers & Designers and other experts from us and you can be sure that you will be always provided with the high quality and timeliness of our work.'),
(245, 'app', 'About Us'),
(246, 'app', 'Blog'),
(247, 'app', 'Contact Info'),
(248, 'app', 'Telephone'),
(249, 'app', 'Fax'),
(251, 'app', 'Drop Us A Few Lines'),
(252, 'app', 'If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.'),
(253, 'app', 'E-mail'),
(254, 'app', 'Full Name'),
(255, 'app', 'Submit'),
(256, 'app', 'Homepage'),
(257, 'app', 'Contact Us'),
(258, 'app', 'Submit'),
(260, 'app', 'Login via Networks'),
(261, 'app', 'Thank you for signup. An activation link is sent to {email} to verify your email address.'),
(262, 'app', 'There is a registering user error. Please correct validation errors.'),
(263, 'app', 'Your signup is confirmed. Thank you for using our site.'),
(264, 'app', 'Access token error. Please check your confirmation link.'),
(265, 'app', 'A reset password link is sent to your email. Please, сheck your email for further instructions.'),
(266, 'app', 'Sorry, we are unable to reset password for email provided.'),
(267, 'app', 'New password is successfully saved. Thank you for using our site.'),
(268, 'app', 'Thank you for contacting us. We will respond to you as soon as possible.'),
(269, 'app', 'There is an sending email error.'),
(270, 'app', 'Send'),
(271, 'app', 'Quick Links'),
(272, 'app', 'Do not hesitate to {contact_link} if you have any questions or feature requests'),
(273, 'app', 'contact us'),
(274, 'app', 'Copyright'),
(275, 'app', 'All Rights Reserved'),
(276, 'app', 'Content Rubrics'),
(277, 'app', 'My Company'),
(278, 'app', 'Helpful Data'),
(279, 'app', 'Online'),
(280, 'app', 'Support'),
(281, 'app', 'Our'),
(282, 'app', 'Data'),
(283, 'app', 'Protection'),
(284, 'app', 'Category does not contain any items.'),
(285, 'app', 'Meet Our Team'),
(286, 'app', 'Show All'),
(287, 'app', 'Product Info'),
(288, 'app', 'Latest Items'),
(289, 'app', 'by'),
(290, 'app', 'on'),
(291, 'app', 'All Categories'),
(292, 'app', 'Top Stories'),
(293, 'app', 'Read More'),
(294, 'app', 'This username has already been taken.'),
(295, 'app', 'This email address has already been taken.'),
(296, 'app', 'Wrong password reset token.'),
(297, 'app', 'Old Password is incorrect.'),
(298, 'app', 'There is no user with such email.'),
(299, 'app', 'of'),
(300, 'app', 'Network'),
(301, 'app', 'Accounts'),
(302, 'app', 'Generel'),
(303, 'app', 'Networks'),
(304, 'app', 'Uncategorised'),
(305, 'app', 'Type Name'),
(306, 'app', 'Confirm Password'),
(307, 'app', 'Inherited'),
(308, 'app', 'Enable Selected'),
(309, 'app', 'Disable Selected'),
(310, 'app', 'More'),
(311, 'app', 'Read'),
(312, 'app', 'Yes (use Link Caption of the selected page)'),
(313, 'app', 'No (enter Link Caption and translations manually)'),
(314, 'app', 'Catalog'),
(315, 'app', 'FAQ'),
(316, 'app', 'Cancel'),
(317, 'app', 'Test Mode'),
(318, 'app', 'Sorry, but you are not allowed to perform this action because you have been granted only read permissions.'),
(319, 'app', 'Go Back'),
(320, 'app', 'Demo admin credentials for examination'),
(321, 'app', 'Username/password');

-- --------------------------------------------------------

--
-- Структура таблицы `i18n_translation`
--

CREATE TABLE IF NOT EXISTS `i18n_translation` (
  `id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `translation` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`,`language`),
  KEY `fk_i18n_translation_i18n_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `i18n_translation`
--

INSERT INTO `i18n_translation` (`id`, `language`, `translation`) VALUES
(1, 'ru', 'Подтверждение Регистрации'),
(2, 'ru', 'Ссылка на Переустановку Пароля'),
(3, 'ru', 'Пользователь с электронной почтой {client} уже существует, но он не прикреплен к аккаунту. Зайдите используя электронный адрес, чтобы прикрепить пользователя.'),
(4, 'ru', 'Аккаунт {client} уже связан с другим пользователем.'),
(5, 'ru', 'Аккаунт {client} уже связан с вашем пользователем.'),
(6, 'ru', 'Вам запрещено выполнить это действие.<br /> Только зарегистрированным администраторы могут войти в Панель Настроек.'),
(7, 'ru', 'Аккаунт {client} успешно связан с вашем пользователем.'),
(8, 'ru', 'Аккаунт {client} успешно связан с вашим пользователем. Данные связанные с существующим пользователем залогиненным как {client} теперь присоединены к вашему пользователем.'),
(9, 'ru', 'Файл не загружен'),
(10, 'ru', 'Файл пуст.'),
(11, 'ru', 'Неправильный формат изображения. Разрешенные форматы jpg, png и gif.'),
(12, 'ru', 'Ошибка при загрузке файла. Нет разрешения на запись/обновление.'),
(13, 'ru', 'Обновить Данные'),
(14, 'ru', 'Добавить Новую Запись'),
(15, 'ru', 'Блокировать Выбранные'),
(16, 'ru', 'Разблокировать Выбранные'),
(17, 'ru', 'Пометить выбранные как Прочтенные'),
(18, 'ru', 'Пометить выбранные как Непрочтенные'),
(19, 'ru', 'Удалить Выбранные'),
(20, 'ru', 'Вы уверены что хотите удалить выбранные элементы?'),
(21, 'ru', 'На старнице'),
(22, 'ru', 'Здравствуйте,'),
(23, 'ru', 'Спасибо за регистрацию'),
(24, 'ru', 'Перейдите по нижеприведенной ссылке, чтобы подтвердить ваш электронный адрес'),
(25, 'ru', 'Ваши личные данные'),
(26, 'ru', 'Перейдите по нижеприведенной ссылке, чтобы изменить свой пароль'),
(27, 'ru', 'Некорректное Имя Пользователя или Пароль'),
(28, 'ru', NULL),
(29, 'ru', 'Название'),
(30, 'ru', NULL),
(31, 'ru', 'По-умолчанию'),
(32, 'ru', 'Язык '),
(33, 'ru', 'Имя ссылки'),
(34, 'ru', 'Заголовок Страницы'),
(35, 'ru', 'Мета Ключевые Слова'),
(36, 'ru', 'Мета Описание'),
(37, 'ru', 'Хедер'),
(38, 'ru', 'Контент'),
(39, 'ru', 'Категория'),
(40, 'ru', 'Сообщение'),
(41, 'ru', 'Только залогиненные'),
(42, 'ru', 'Только не залогиненные'),
(43, 'ru', 'Владелец'),
(44, 'ru', 'Сортировка'),
(45, 'ru', 'Видимое'),
(46, 'ru', 'Заголовок'),
(47, 'ru', 'Созданое'),
(48, 'ru', 'Обновленное'),
(49, 'ru', 'Пользовательский'),
(50, 'ru', 'Системный'),
(51, 'ru', 'Тип'),
(52, 'ru', 'Название Роли'),
(53, 'ru', 'Мужчина'),
(54, 'ru', 'Женщина'),
(55, 'ru', 'Имя Пользователя'),
(56, 'ru', 'Ключ авторизации'),
(57, 'ru', 'Хэш Пароля'),
(58, 'ru', 'Ключ на Смену Пароля'),
(59, 'ru', 'Ключ доступа'),
(61, 'ru', 'Имя'),
(62, 'ru', 'Фамилия'),
(63, 'ru', 'Роль'),
(64, 'ru', 'Страна'),
(65, 'ru', 'Почтовый Код'),
(66, 'ru', 'Город'),
(67, 'ru', 'Адрес'),
(68, 'ru', 'Телефон'),
(69, 'ru', 'Аватар'),
(70, 'ru', 'Дата Рождения'),
(71, 'ru', 'Пол'),
(72, 'ru', 'Подтверждён'),
(73, 'ru', 'Активирован'),
(74, 'ru', 'Последний Логин'),
(75, 'ru', 'Пользователь'),
(76, 'ru', 'Источник'),
(77, 'ru', 'ID Источника'),
(78, 'ru', 'Ник Аккаунта'),
(79, 'ru', 'Родитель'),
(80, 'ru', 'Имя Модуля'),
(81, 'ru', 'Ключевые слова'),
(82, 'ru', 'Модуль'),
(83, 'ru', 'Меню'),
(84, 'ru', 'Страница'),
(85, 'ru', 'Подпись к Ссылке'),
(86, 'ru', NULL),
(87, 'ru', 'Нет'),
(88, 'ru', 'Да'),
(89, 'ru', 'Родительская Категория'),
(90, 'ru', 'Описание'),
(91, 'ru', 'Перевод'),
(92, 'ru', 'Исходный Текст'),
(93, 'ru', 'Вопрос'),
(94, 'ru', 'E-mail Отправителя'),
(95, 'ru', 'Имя Отправителя'),
(96, 'ru', 'Тема'),
(97, 'ru', 'Текст Письма'),
(98, 'ru', 'Открытый'),
(99, 'ru', 'Код Подтверждения'),
(100, 'ru', 'Отправитель'),
(102, 'ru', 'Телефонный Код'),
(103, 'ru', 'Изображение'),
(104, 'ru', 'Адрес Изображения'),
(105, 'ru', 'Адрес Эскиза'),
(106, 'ru', 'Ключ'),
(107, 'ru', 'Значение'),
(108, 'ru', 'Код'),
(109, 'ru', 'Название Меню'),
(110, 'ru', 'Цена'),
(111, 'ru', 'Запрашиваемая страница не существует.'),
(112, 'ru', 'Ошибка сохранения значения.'),
(113, 'ru', 'Привязать новый Социальный Аккаунт'),
(114, 'ru', 'Редактировать Пользователя'),
(116, 'ru', 'Пользователи'),
(117, 'ru', 'Добавить Пользователя'),
(118, 'ru', 'Блокировать'),
(119, 'ru', 'Разблокировать'),
(120, 'ru', 'Расширить'),
(121, 'ru', 'Поиск'),
(122, 'ru', 'Сбросить'),
(123, 'ru', 'Роли'),
(124, 'ru', 'Добавить Роль'),
(125, 'ru', 'Общие'),
(126, 'ru', 'Контакты'),
(127, 'ru', 'Настройки'),
(128, 'ru', 'Пароль'),
(129, 'ru', 'Создать'),
(130, 'ru', 'Обновить'),
(131, 'ru', 'Удалить Изображение'),
(132, 'ru', 'Вы уверены что хотите удалить изображение?'),
(133, 'ru', 'Редактировать Тему'),
(134, 'ru', 'Темы'),
(135, 'ru', 'Удалить'),
(137, 'ru', 'Добавить Тему'),
(138, 'ru', 'Настройки темы'),
(139, 'ru', 'Без имени'),
(140, 'ru', 'По-умолчанию'),
(141, 'ru', 'Вы уверены что хотите установить тему по умолчанию?'),
(142, 'ru', 'Редактировать Настройку'),
(143, 'ru', 'Добавить Настройку'),
(144, 'ru', 'Настройки Сайта'),
(145, 'ru', 'Редактировать Страницу'),
(146, 'ru', 'Страницы'),
(147, 'ru', 'Добавить Страницу'),
(148, 'ru', 'Список Переводов'),
(149, 'ru', 'Категории'),
(150, 'ru', 'Добавить Категорию'),
(151, 'ru', 'Меню'),
(152, 'ru', 'Добавить Меню'),
(153, 'ru', 'Мета Теги'),
(154, 'ru', 'Переводы'),
(155, 'ru', 'Админ Панель'),
(156, 'ru', 'Мой Профиль'),
(157, 'ru', 'Выйти'),
(158, 'ru', 'Создано'),
(159, 'ru', 'Редактировать Перевод'),
(160, 'ru', 'Добавить Перевод'),
(162, 'ru', 'Редактировать Язык'),
(163, 'ru', 'Языки'),
(164, 'ru', 'Добавить Язык'),
(165, 'ru', 'Информация о Языке'),
(166, 'ru', 'Редактировать Категорию'),
(167, 'ru', 'Отключить'),
(168, 'ru', 'Активировать'),
(170, 'ru', 'Медиа-категория'),
(171, 'ru', 'Редактировать Продукт'),
(172, 'ru', 'Товары'),
(173, 'ru', 'Добавить Продукт'),
(176, 'ru', 'Редактировать Модуль'),
(177, 'ru', 'Модули'),
(178, 'ru', 'Добавить Модуль'),
(179, 'ru', 'Параметры Модуля'),
(180, 'ru', 'Логин'),
(182, 'ru', 'Вышеприведенная ошибка возникла во время обработки вашего запроса сервером.'),
(183, 'ru', 'Пожалуйста, свяжитесь с нами если вы думаете, что это ошибка со стороны сервера. Спасибо.'),
(184, 'ru', 'Редактировать Элемент'),
(185, 'ru', 'Элементы'),
(186, 'ru', 'Вопросы'),
(187, 'ru', 'Добавить Вопрос'),
(188, 'ru', 'Добавить Элемент'),
(190, 'ru', 'Переводы Подписи к Ссылке'),
(191, 'ru', 'Редактировать Меню'),
(192, 'ru', 'Добавить Новый Элемент Меню'),
(193, 'ru', 'Пользовательская ссылка'),
(194, 'ru', 'Текстовый Элемент'),
(195, 'ru', 'Количество Элементов'),
(196, 'ru', 'Подпись'),
(197, 'ru', 'Опции'),
(198, 'ru', 'Показать Детали'),
(199, 'ru', 'Скрыть Детали'),
(200, 'ru', 'Добавить Элементы'),
(201, 'ru', 'Добавить Страницы'),
(202, 'ru', 'Добавить Ссылку'),
(203, 'ru', 'Добавить Текстовый Элемент'),
(204, 'ru', 'Выбрать Все'),
(205, 'ru', 'Список Элементов'),
(206, 'ru', 'Список не содержит элементов.'),
(207, 'ru', 'Редактировать Письмо'),
(208, 'ru', 'Просмотреть Письмо'),
(209, 'ru', 'Письма'),
(210, 'ru', 'Добавить Письмо'),
(211, 'ru', 'Пометить как Непрочтенное'),
(212, 'ru', 'Пометить как Прочтенное'),
(214, 'ru', 'Email пользователя'),
(215, 'ru', 'Редактировать Роль'),
(216, 'ru', 'Роль Пользователя'),
(217, 'ru', 'Права Доступа'),
(218, 'ru', 'Пользователь не имеет прав для доступа в панель администрирования'),
(219, 'ru', 'Супер админ имеет полный доступ к панели настроек'),
(220, 'ru', 'Категории Страниц'),
(222, 'ru', 'Редактировать Файл'),
(223, 'ru', 'Медиа'),
(224, 'ru', 'Добавить Файл'),
(225, 'ru', 'Медиа-файлы'),
(226, 'ru', 'Копия'),
(227, 'ru', 'Медиа-файл'),
(228, 'ru', 'Сгенерировано'),
(229, 'ru', 'Експорт Данных'),
(230, 'ru', 'Зайти в Свой Аккаунт'),
(231, 'ru', 'Пожалуйста, заполните следующие поля для входа:'),
(232, 'ru', 'Зайти с Помощью'),
(233, 'ru', 'Если вы забыли пароль вы можете'),
(234, 'ru', 'повторно установить его'),
(235, 'ru', 'Пожалуйста, заполните следующие поля для регистрации:'),
(236, 'ru', 'Зарегистрироваться'),
(237, 'ru', 'Пожалуйста, введите вашу электронную почту. Ссылка на смену пароля будет выслана на эту почту.'),
(238, 'ru', 'Сохранить'),
(239, 'ru', 'Изменить Пароль'),
(240, 'ru', 'Редактировать Профиль'),
(241, 'ru', 'Компания веб-разработки'),
(242, 'ru', 'Наша команда состоит из опытных веб-разработчиков, дизайнеров и менеджеров.'),
(243, 'ru', 'Мы ищем новых клиентов или долгосрочные бизнес-отношения!'),
(244, 'ru', 'Наняв специализированную команду Профессиональных веб-разработчиков и дизайнеров, а также других наших експертов вы можете быть уверены в том, что вам всегда будет предоставлен результат высокого качества в поставленные сроки.'),
(245, 'ru', 'О Компании'),
(246, 'ru', 'Блог'),
(247, 'ru', 'Контактная Информация'),
(248, 'ru', 'Контактный телефон'),
(249, 'ru', 'Факс'),
(251, 'ru', 'Напишите Нам Пару Строк'),
(252, 'ru', 'Если у вас есть деловые предложения или другие вопросы, пожалуйста, заполните следующую форму чтобы связаться с нами. Спасибо.'),
(253, 'ru', NULL),
(254, 'ru', 'Полное Имя'),
(255, 'ru', 'Отправить'),
(256, 'ru', 'Домашняя Страница'),
(257, 'ru', 'Свяжитесь С Нами'),
(260, 'ru', 'Войти через Социальные Сети'),
(261, 'ru', 'Спасибо за регистрацию. Ссылка для активации отправлена на {email} для подтверждения вашей электронной почты.'),
(262, 'ru', 'Ошибка регистрации пользователя. Пожалуйста, исправьте ошибки валидации.'),
(263, 'ru', 'Ваша регистрация подтверждена. Спасибо за использование нашего сайта.'),
(264, 'ru', 'Ошибка ключа доступа. Пожалуйста, проверьте вашу ссылку для подтверждения.'),
(265, 'ru', 'Ссылка на смену пароля отправлена на вашу электронную почту. Пожалуйста, проверьте вашу почту для получения дальнейших инструкций.'),
(266, 'ru', 'Извините, мы не смогли поменять пароль для предоставленной электронной почты.'),
(267, 'ru', 'Новый пароль успешно сохранен. Спасибо за использование нашего сайта.'),
(268, 'ru', 'Спасибо, что связались с нами. Мы ответим вам в ближайший срок.'),
(269, 'ru', 'Ошибка отправки письма.'),
(270, 'ru', 'Отправить'),
(271, 'ru', 'Полезные ссылки'),
(272, 'ru', 'Если у вас есть какие-либо вопросы или пожелания, пожалуйста, {contact_link}'),
(273, 'ru', 'свяжитесь с нами'),
(274, 'ru', 'Авторское право'),
(275, 'ru', 'Все Права Защищены'),
(276, 'ru', 'Рубрики Содержимого'),
(277, 'ru', 'Моя Компания'),
(278, 'ru', 'Полезная Информация'),
(279, 'ru', NULL),
(280, 'ru', 'Поддержка'),
(281, 'ru', 'Наши'),
(282, 'ru', 'Данных'),
(283, 'ru', 'Защита'),
(284, 'ru', 'Категория не содержит элементов.'),
(285, 'ru', 'Наша Команда'),
(286, 'ru', 'Показать Все'),
(287, 'ru', 'Информация о Продукте'),
(288, 'ru', 'Новые Предложения'),
(289, 'ru', 'от'),
(290, 'ru', 'от'),
(291, 'ru', 'Все Категории'),
(292, 'ru', 'Последние Статьи'),
(293, 'ru', 'Читать дальше'),
(294, 'ru', 'Имя пользователя занято.'),
(295, 'ru', 'Электронная почта занята.'),
(296, 'ru', 'Неверный пароль сброса токена.'),
(297, 'ru', 'Старый пароль некорректно введён.'),
(298, 'ru', 'Пользователя с данной электронной почтой не существует.'),
(299, 'ru', 'из'),
(300, 'ru', 'Социальная cеть'),
(301, 'ru', 'Аккаунты'),
(302, 'ru', 'Общие'),
(303, 'ru', 'Социальные cети'),
(304, 'ru', 'Без категории'),
(305, 'ru', 'Тип'),
(306, 'ru', 'Подтверждение пароля'),
(307, 'ru', 'Наследуемая'),
(308, 'ru', 'Сделать Доступными Выделенные'),
(309, 'ru', 'Сделать Недоступными Выделенные'),
(310, 'ru', 'Еще'),
(311, 'ru', 'Просмотр'),
(312, 'ru', 'Да (наследовать подпись ссылки из текущей страницы)'),
(313, 'ru', 'Нет (ввести подпись ссылки и ее переводы вручную)'),
(314, 'ru', 'Каталог'),
(315, 'ru', 'Вопросы'),
(316, 'ru', 'Отменить'),
(317, 'ru', 'Тестовый режим'),
(318, 'ru', 'Извините, но у вас нет доступа для выполнения данного действия, потому что Вы получили доступ только на чтение.'),
(319, 'ru', 'Назад'),
(320, 'ru', 'Доступы для тестового администратора'),
(321, 'ru', 'Имя пользователя/пароль');

-- --------------------------------------------------------

--
-- Структура таблицы `mail`
--

CREATE TABLE IF NOT EXISTS `mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sender_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `opened` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `mail`
--

INSERT INTO `mail` (`id`, `sender_email`, `sender_name`, `subject`, `body`, `opened`, `created_at`, `updated_at`) VALUES
(1, 'john-doe@gmail.com', 'John Doe', 'I have a question', 'I have a question to your company please answer', 0, 1464704401, 1464704401),
(2, 'john-doe@gmail.com', 'John Doe', 'I have a question', 'I have a question to your company please answer', 0, 1464704420, 1464704420),
(3, 'john-doe@gmail.com', 'John Doe', 'I have a question', 'I have a question to your company please answer', 0, 1464704468, 1464704468),
(4, 'john-doe@gmail.com', 'John Doe', 'I have a question', 'I have a question to your company please answer', 1, 1464776054, 1466977449),
(5, 'panasenko708@gmail.com', 'Dima Panasenko', 'Test', 'Sample text', 0, 1468849434, 1468849434);

-- --------------------------------------------------------

--
-- Структура таблицы `media_category`
--

CREATE TABLE IF NOT EXISTS `media_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `sorting` int(4) unsigned DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_media_category_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `media_category`
--

INSERT INTO `media_category` (`id`, `user_id`, `name`, `slug`, `description`, `visible`, `sorting`, `created_at`, `updated_at`) VALUES
(1, 1, 'Web development', 'web-development', '', 1, 1, 1458633376, 1458633376),
(2, 1, '3D Modeling', '3d-modeling', '', 1, 2, 1458633542, 1458633542);

-- --------------------------------------------------------

--
-- Структура таблицы `media_file`
--

CREATE TABLE IF NOT EXISTS `media_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `sorting` int(4) unsigned DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_media_file_media_category` (`parent_id`),
  KEY `fk_media_file_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `media_file`
--

INSERT INTO `media_file` (`id`, `parent_id`, `user_id`, `name`, `file`, `visible`, `sorting`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Computer academy “Step”', '1458633358.jpg', 1, 1, 1458633358, 1458662671),
(2, 1, 1, 'Printfresh studio', '1458633427.jpg', 1, 2, 1458633427, 1458662671),
(3, 2, 1, 'Exterior Design', '1458633595.jpg', 1, 3, 1458633464, 1458662671),
(4, 1, 1, 'Board of Certifications', '1458633646.jpg', 1, 4, 1458633646, 1458662671),
(5, 2, 1, 'Exterior Design', '1458633684.jpg', 1, 5, 1458633684, 1458662671),
(6, 1, 1, 'Flowers Shop', '1458633792.jpg', 1, 7, 1458633792, 1458662671),
(7, 1, 1, 'Media Miro', '1458633853.jpg', 1, 6, 1458633853, 1458662671),
(8, 1, 1, 'Truck Festival', '1458633891.jpg', 1, 8, 1458633891, 1458662671),
(9, 2, 1, 'Interior Design', '1458633952.jpg', 1, 9, 1458633952, 1458662671),
(10, 1, 2, 'For Matteo Beltrama', '1459162105.jpg', 1, 10, 1459162105, 1459162105);

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`id`, `type`, `name`, `code`) VALUES
(1, 1, 'Main', 'main'),
(2, 0, 'Info', 'info'),
(3, 0, 'Quick Links', 'quick-links'),
(4, 0, 'Content Links', 'content-links');

-- --------------------------------------------------------

--
-- Структура таблицы `menu_item`
--

CREATE TABLE IF NOT EXISTS `menu_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `type` int(1) unsigned NOT NULL DEFAULT '0',
  `link_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sorting` int(4) unsigned DEFAULT NULL,
  `inherited` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_menu_item_menu` (`menu_id`),
  KEY `fk_menu_item_menu_item` (`parent_id`),
  KEY `fk_menu_item_page` (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=50 ;

--
-- Дамп данных таблицы `menu_item`
--

INSERT INTO `menu_item` (`id`, `menu_id`, `parent_id`, `page_id`, `type`, `link_name`, `url`, `sorting`, `inherited`) VALUES
(4, 1, NULL, 1, 0, 'Main', '', 1, 1),
(5, 1, NULL, 2, 0, 'Company', '', 2, 1),
(6, 1, 5, 3, 0, 'About Us', '', 1, 1),
(7, 1, 5, 4, 0, 'Projects', '', 3, 1),
(13, 1, 5, 10, 0, 'Contacts', '', 2, 1),
(14, 2, NULL, 2, 0, 'Company', '', 1, 1),
(15, 2, 14, 3, 0, 'About Us', '', 1, 1),
(16, 2, 14, 4, 0, 'Projects', '', 2, 1),
(17, 2, NULL, 5, 0, 'Documents', '', 2, 1),
(18, 2, 17, 6, 0, 'Audio', '', 1, 1),
(19, 2, 17, 7, 0, 'Video', '', 2, 1),
(20, 2, 17, 8, 0, 'Articles', '', 3, 1),
(21, 2, 17, 9, 0, 'Archive', '', 4, 1),
(27, 2, NULL, 11, 0, 'Signup', '', 3, 1),
(28, 1, NULL, 11, 0, 'Signup', '', 9, 1),
(29, 1, NULL, 14, 0, 'Login', '', 10, 1),
(30, 1, NULL, 16, 0, 'My profile', '', 8, 1),
(31, 1, NULL, 15, 0, 'Logout', '', 11, 1),
(32, 1, 30, 16, 0, 'My Profile', '', 1, 1),
(33, 1, 30, 17, 0, 'Edit Profile', '', 2, 1),
(34, 1, 30, 13, 0, 'Reset Password', '', 3, 1),
(35, 1, 30, 18, 0, 'Social Accounts', '', 4, 1),
(36, 1, NULL, 19, 0, 'Blog', '', 3, 1),
(37, 1, NULL, 21, 0, 'Gallery', '', 4, 1),
(38, 1, NULL, 22, 0, 'Faq', '', 6, 1),
(39, 1, NULL, 23, 0, 'Catalog', '', 5, 1),
(40, 3, NULL, 1, 0, 'Main', '', 1, 1),
(41, 3, NULL, 3, 0, 'About Us', '', 2, 1),
(42, 3, NULL, 4, 0, 'Projects', '', 3, 1),
(43, 3, NULL, 10, 0, 'Contacts', '', 4, 1),
(44, 4, NULL, 19, 0, 'Blog', '', 1, 1),
(45, 4, NULL, 21, 0, 'Gallery', '', 2, 1),
(46, 4, NULL, 22, 0, 'Faq', '', 3, 1),
(47, 4, NULL, 23, 0, 'Catalog', '', 4, 1),
(48, 1, NULL, 33, 0, 'Cart', '', 7, 1),
(49, 1, 30, 32, 0, 'Orders', '', 5, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `menu_item_i18n`
--

CREATE TABLE IF NOT EXISTS `menu_item_i18n` (
  `id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `link_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`,`language`),
  KEY `fk_menu_item_i18n_i18n_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `menu_item_i18n`
--

INSERT INTO `menu_item_i18n` (`id`, `language`, `link_name`) VALUES
(6, 'ru', 'О Нас'),
(7, 'ru', 'Проекты'),
(13, 'ru', 'Контакты'),
(32, 'ru', 'Мой Профиль'),
(33, 'ru', 'Редактировать Профиль'),
(34, 'ru', 'Изменить Пароль'),
(35, 'ru', 'Социальные Аккаунты');

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1458594564),
('m130524_201442_init', 1458594565),
('m150207_210500_i18n_init', 1458594565),
('m160229_160119_user_init', 1458594566),
('m160229_160242_content_init', 1458594566),
('m160229_160242_module_init', 1472124384),
('m160229_160248_role_init', 1458594566),
('m160229_160253_content_init', 1472124384),
('m160229_160253_module_init', 1458594566),
('m160229_160301_setting_init', 1472131820),
('m160229_160314_country_init', 1458594566),
('m160229_160324_catalog_init', 1458594566),
('m160229_160330_gallery_init', 1458594566),
('m160229_160600_media_init', 1458594566),
('m160229_160610_mail_init', 1458594566),
('m160307_094445_faq_init', 1458594566),
('m160307_094755_theme_init', 1472121609),
('m160313_102555_i18n_content_init', 1458922354),
('m160323_113811_i18n_catalog_init', 1458913246),
('m160324_112736_i18n_faq_init', 1458913246),
('m160505_112500_quote_init', 1472120485),
('m160506_144503_i18n_quote_init', 1472120485),
('m160510_073922_slider_init', 1472131820),
('m160510_134635_i18n_slider_init', 1481879957),
('m160510_144635_order_init', 1492675915),
('m170424_083118_catalog_field_init', 1494837423),
('m170424_083218_catalog_filter_init', 1493799580);

-- --------------------------------------------------------

--
-- Структура таблицы `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `sorting` int(4) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_module_module` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `module`
--

INSERT INTO `module` (`id`, `parent_id`, `name`, `slug`, `visible`, `sorting`) VALUES
(1, NULL, 'Users', 'user', 1, 1),
(2, 1, 'Roles', 'role', 1, 2),
(3, NULL, 'Pages', 'page', 1, 3),
(4, 3, 'Menus', 'menu', 1, 4),
(5, NULL, 'Settings', 'setting', 1, 13),
(6, NULL, 'Modules', 'module', 0, 15),
(7, NULL, 'Media', 'media', 1, 10),
(8, NULL, 'Emails', 'mail', 1, 11),
(9, NULL, 'Catalog', 'catalog', 1, 5),
(10, NULL, 'FAQ', 'faq', 1, 7),
(11, NULL, 'Themes', 'theme', 1, 14),
(12, NULL, 'Translations', 'i18n', 1, 16),
(13, NULL, 'Slider', 'slider', 1, 9),
(14, NULL, 'Quotes', 'quote', 1, 8),
(15, NULL, 'Orders', 'order', 1, 6),
(16, NULL, 'Countries', 'country', 0, 12);

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `vat_tax` int(11) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `payment_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_user` (`user_id`),
  KEY `fk_order_country` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=41 ;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`id`, `user_id`, `first_name`, `last_name`, `country_id`, `zip`, `city`, `address`, `phone`, `price`, `vat_tax`, `description`, `payment_id`, `transaction_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 470, NULL, '', NULL, NULL, 1, 1492677244, 1492677244),
(2, 2, 'Alex', 'Kotlyar', 232, '62000', 'Zaporozie', 'Ivanova 1-2', '096830870', 70, NULL, '', NULL, NULL, 1, 1492693429, 1492693429),
(3, 2, 'Alex', 'Kotlyar', 232, '62000', 'Zaporozie', 'Ivanova 1-2', '096830870', 5, NULL, '', NULL, NULL, 1, 1492698286, 1492698286),
(4, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1492760110, 1492760110),
(5, 2, 'Alex', 'Kotlyar', 232, '62000', 'Zaporozie', 'Ivanova 1-2', '096830870', 5, NULL, '', NULL, NULL, 1, 1492775421, 1492775421),
(6, 2, 'Alex', 'Kotlyar', 232, '62000', 'Zaporozie', 'Ivanova 1-2', '096830870', 70, NULL, '', NULL, NULL, 1, 1493202220, 1493202220),
(7, 2, 'Alex', 'Kotlyar', 232, '62000', 'Zaporozie', 'Ivanova 1-2', '096830870', 70, NULL, '', NULL, NULL, 1, 1493202239, 1493202239),
(8, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 5, NULL, '', NULL, NULL, 1, 1493206884, 1493206884),
(9, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493215117, 1493215117),
(10, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493215181, 1493215181),
(11, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493215245, 1493215245),
(12, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493279977, 1493279977),
(13, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493280709, 1493280709),
(14, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493280770, 1493280770),
(15, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493281416, 1493281416),
(16, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493281912, 1493281912),
(17, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493282630, 1493282630),
(18, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493282719, 1493282719),
(19, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493282735, 1493282735),
(20, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493282755, 1493282755),
(21, 15, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493282816, 1493282816),
(22, 15, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493283320, 1493283320),
(23, 15, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493283326, 1493283326),
(24, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 0, NULL, '', NULL, NULL, 1, 1493288204, 1493288204),
(25, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493288644, 1493288644),
(26, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493289247, 1493289247),
(27, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493289257, 1493289257),
(28, 15, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', NULL, NULL, 1, 1493289356, 1493289356),
(29, 2, 'Alex', 'Kotlyar', 232, '62000', 'Zaporozie', 'Ivanova 1-2', '096830870', 5, NULL, '', 'PAY-1S928858EH688501ULEA6UPI', NULL, 1, 1493297723, 1493297725),
(30, 2, 'Alex', 'Kotlyar', 232, '62000', 'Zaporozie', 'Ivanova 1-2', '096830870', 5, NULL, '', 'PAY-9SJ90079UY535330TLEA6UUI', '3TR147681W5288314', 1, 1493297739, 1493297788),
(31, 15, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', 'PAY-4MV92859BR422261ALEA7LLY', NULL, 1, 1493300653, 1493300655),
(32, 2, 'Alex', 'Kotlyar', 232, '62000', 'Zaporozie', 'Ivanova 1-2', '11111111', 70, NULL, '', 'PAY-7A714205W24932737LEE5RGY', NULL, 0, 1493817497, 1493817499),
(33, 2, 'Alex', 'Kotlyar', 232, '62000', 'Zaporozie', 'Ivanova 1-2', '11111111', 70, NULL, '', 'PAY-37N17893MJ7443612LEFNUJI', '03402741FK332713P', 1, 1493883427, 1493883480),
(34, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', 'PAY-7GA733466B969224PLEFNVEQ', NULL, 0, 1493883519, 1493883538),
(35, 2, 'Alex', 'Kotlyar', 232, '62000', 'Zaporozie', 'Ivanova 1-2', '11111111', 70, NULL, '', 'PAY-16299032S5522815VLEFNVOY', NULL, 0, 1493883578, 1493883579),
(36, 16, 'Nataliia', 'Lebed', 2, '12345', 'New York', 'gytir68r tr6', '126546456', 5, 10, '', 'PAY-26T965962S455710BLEFPJPY', '21G8413171176393X', 1, 1493890237, 1493890292),
(37, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 5, NULL, '', NULL, NULL, 0, 1493900695, 1493900695),
(38, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 5, NULL, '', 'PAY-73D99799AP374061MLEFR3JQ', '53X46479XY056460X', 1, 1493900706, 1493900749),
(39, 1, 'Tanya', 'Nazarchuk', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 50, NULL, '', 'PAY-3X343117W1352192XLEFR6TY', '8UP509614F0798426', 1, 1493901132, 1493901160),
(40, 1, 'Tanya', 'Gold', 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', 70, NULL, '', 'PAY-6U787519MR6961306LE3G2ZY', NULL, 0, 1496739173, 1496739175);

-- --------------------------------------------------------

--
-- Структура таблицы `order_item`
--

CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `item_price` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_item_order` (`order_id`),
  KEY `fk_order_item_ctlg_product` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=42 ;

--
-- Дамп данных таблицы `order_item`
--

INSERT INTO `order_item` (`id`, `order_id`, `product_id`, `amount`, `item_price`) VALUES
(1, 1, 14, 4, 5),
(2, 1, 11, 1, 150),
(3, 1, 8, 1, 300),
(4, 2, 13, 1, 70),
(5, 3, 14, 1, 5),
(6, 4, 13, 1, 70),
(7, 5, 14, 1, 5),
(8, 6, 13, 1, 70),
(9, 7, 13, 1, 70),
(10, 8, 14, 1, 5),
(11, 9, 13, 1, 70),
(12, 10, 13, 1, 70),
(13, 11, 13, 1, 70),
(14, 12, 13, 1, 70),
(15, 13, 13, 1, 70),
(16, 14, 13, 1, 70),
(17, 15, 13, 1, 70),
(18, 16, 13, 1, 70),
(19, 17, 13, 1, 70),
(20, 18, 13, 1, 70),
(21, 19, 13, 1, 70),
(22, 20, 13, 1, 70),
(23, 21, 13, 1, 70),
(24, 22, 13, 1, 70),
(25, 23, 13, 1, 70),
(26, 25, 13, 1, 70),
(27, 26, 13, 1, 70),
(28, 27, 13, 1, 70),
(29, 28, 13, 1, 70),
(30, 29, 14, 1, 5),
(31, 30, 14, 1, 5),
(32, 31, 13, 1, 70),
(33, 32, 13, 1, 70),
(34, 33, 13, 1, 70),
(35, 34, 13, 1, 70),
(36, 35, 13, 1, 70),
(37, 36, 15, 1, 5),
(38, 37, 15, 1, 5),
(39, 38, 15, 1, 5),
(40, 39, 15, 10, 5),
(41, 40, 13, 1, 70);

-- --------------------------------------------------------

--
-- Структура таблицы `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `link_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sorting` int(4) unsigned DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `header` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_page_page_category` (`parent_id`),
  KEY `fk_page_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=37 ;

--
-- Дамп данных таблицы `page`
--

INSERT INTO `page` (`id`, `parent_id`, `user_id`, `link_name`, `slug`, `sorting`, `visible`, `title`, `meta_keywords`, `meta_description`, `header`, `content`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Main', 'index', 1, 1, '', '', '', '', '<p><span>We are working with up-to-date technology and strive for implementation of all the latest solutions offered by web-development progress. We offer you use of convenient content management systems that help manage the site easily.</span></p>\r\n\r\n<p><span>Our company gives support in the project development process for each client. Moreover we provide necessary training needed for site maintenance. Mutual understanding and particular approach takes an integral part in our work.</span></p>\r\n\r\n', NULL, 1482352974),
(2, NULL, 1, 'Company', 'company', 2, 1, '', '', '', '', '<p><span style="color:rgb(48, 48, 48); font-family:open sans,sans-serif; font-size:18px">We are working with up-to-date technology and strive for implementation of all the latest solutions offered by web-development progress. We offer you use of convenient content management systems that help manage the site easily.</span></p>', NULL, 1482352996),
(3, NULL, 1, 'About Us', 'about', 3, 1, '', '', '', '', '<div class="row">  <div class="col-sm-12">    <p class="lead text-red">Web development company.</p>    <p>      Our team consists of experienced web developers, designers and managers. We are looking for new clients or ongoing relationship with new business partners! Hire dedicated team of Professional web Developers & Designers and other experts from us and you can be sure that you will be always provided with the high quality and timeliness of our work.    </p>    <br /><br />  </div></div><div class="row">  <div class="col-sm-6">    <div class="embed-responsive embed-responsive-16by9">      <iframe src="//player.vimeo.com/video/67449472?title=0&amp;byline=0&amp;portrait=0" width="500" height="281" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>    </div>  </div>  <div class="col-sm-6">    <p class="well">      Our team consists of experienced web developers, designers and managers.    </p>    <ul class="ft-list">      <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>      <li>Donec vel nisi sit amet mauris dapibus aliquam quis vel magna.</li>      <li>Donec vulputate tellus quis volutpat congue.</li>      <li>Sed ultrices eros eu euismod semper.</li>      <li>Integer vulputate mauris in eleifend laoreet.</li>     <li>Donec vulputate tellus quis volutpat congue.</li      <li>Sed ultrices eros eu euismod semper.</li>    </ul>  </div></div> \r\n', NULL, 1461665471),
(4, NULL, 1, 'Projects', 'project', 4, 1, '', '', '', '', '<p>Some, who have had early access to the Micro Bit, have come up with amazing projects - like the Yorkshire school that sent one up 32km (20 miles) on a balloon bringing back pictures of its journey to the fringes of space.</p>\r\n\r\n<p>But, amid all the excitement from the young people getting a new toy, this is where the serious stuff starts. Big claims have been made for how this project can change the way children learn about and engage with technology. Now, it&#39;s up to teachers to make that happen.</p>\r\n\r\n<p><img alt="" src="/storage/images/media/2/thumbnail-1458633427.jpg" style="height:105px; width:160px" /><img alt="" src="/storage/images/media/7/thumbnail-1458633853.jpg" style="height:135px; width:160px" /><img alt="" src="/storage/images/media/6/thumbnail-1458633792.jpg" /></p>', NULL, 1482353045),
(5, NULL, 1, 'Documents', 'document', 5, 1, '', '', '', '', '<p>Some, who have had early access to the Micro Bit, have come up with amazing projects - like the Yorkshire school that sent one up 32km (20 miles) on a balloon bringing back pictures of its journey to the fringes of space.</p>\r\n\r\n<p>But, amid all the excitement from the young people getting a new toy, this is where the serious stuff starts. Big claims have been made for how this project can change the way children learn about and engage with technology. Now, it&#39;s up to teachers to make that happen.</p>\r\n', NULL, 1482353064),
(6, NULL, 1, 'Audio', 'audio', 6, 1, '', '', '', '', '<p>The brand new&nbsp;<strong>BBC Music app</strong>&nbsp;is now available to download for your mobile or tablet (iOS and Android) for free. Bringing you the finest music moments from across BBC TV, Radio and Online, the app gives you access to exclusive live performances, interviews, playlists and much more</p>\r\n', NULL, 1482353086),
(7, NULL, 1, 'Video', 'video', 7, 1, '', '', '', '', '<p>Some, who have had early access to the Micro Bit, have come up with amazing projects - like the Yorkshire school that sent one up 32km (20 miles) on a balloon bringing back pictures of its journey to the fringes of space.</p>\r\n\r\n<p>But, amid all the excitement from the young people getting a new toy, this is where the serious stuff starts. Big claims have been made for how this project can change the way children learn about and engage with technology. Now, it&#39;s up to teachers to make that happen.</p>\r\n', NULL, 1482353108),
(8, NULL, 1, 'Articles', 'articles', 8, 1, '', '', '', '', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>\r\n', NULL, 1458658914),
(9, NULL, 1, 'Archive', 'archive', 9, 1, '', '', '', '', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>\r\n', NULL, 1458659088),
(10, NULL, 1, 'Contacts', 'contact', 10, 1, '', '', '', '', '', NULL, 1458660775),
(11, NULL, 1, 'Signup', 'user/signup', 11, 3, '', '', '', '', '', NULL, 1458659164),
(12, NULL, 1, 'Reset Password', 'user/request-password-reset', 12, 3, '', '', '', '', '', NULL, 1458660098),
(13, NULL, 1, 'Reset Password', 'user/reset-password', 13, 1, '', '', '', '', '', NULL, 1458660120),
(14, NULL, 1, 'Login', 'user/login', 14, 3, '', '', '', '', '', NULL, 1458659812),
(15, NULL, 1, 'Logout', 'user/logout', 15, 2, '', '', '', '', '', NULL, 1458659831),
(16, NULL, 1, 'My Profile', 'user/profile', 16, 2, '', '', '', '', '', NULL, 1458660165),
(17, NULL, 1, 'Edit Profile', 'user/edit-profile', 17, 2, '', '', '', '', '', NULL, 1458660221),
(18, NULL, 1, 'Social Accounts', 'user/social', 18, 2, '', '', '', '', '', NULL, 1458660251),
(19, NULL, 1, 'Blog', 'blog/index', 19, 1, '', '', '', '', '', 1458209892, 1458660272),
(20, NULL, 1, 'Blog Post', 'blog/post', 20, 1, '', '', '', '', '', 1458210059, 1458660290),
(21, NULL, 1, 'Gallery', 'gallery/index', 21, 1, '', '', '', '', '', 1458210079, 1458660414),
(22, NULL, 1, 'FAQ', 'faq/index', 22, 1, '', '', '', '', '', 1458210106, 1460551617),
(23, NULL, 1, 'Catalog', 'catalog/index', 23, 1, '', '', '', '', '', 1458210123, 1458660505),
(24, NULL, 1, 'Product', 'catalog/product', 24, 1, '', '', '', '', '', 1458210170, 1458660525),
(25, 1, 1, 'Music app', 'music-app', 25, 1, '', '', '', 'BBC Music just got personal: get to know the new BBC Music app', '<p>The brand new&nbsp;<strong>BBC Music app</strong>&nbsp;is now available to download for your mobile or tablet (iOS and Android) for free. Bringing you the finest music moments from across BBC TV, Radio and Online, the app gives you access to exclusive live performances, interviews, playlists and much more.</p>\r\n\r\n<p style="margin-left:auto; margin-right:auto">Download the app now to start discovering more of the BBC Music you love.</p>\r\n\r\n<h2>Make It Personal</h2>\r\n\r\n<p><img alt="" src="http://ichef.bbci.co.uk/images/ic/976xn/p03jsmjk.jpg" style="height:549px; width:976px" /></p>\r\n\r\n<p>When you first download the app you&#39;ll be able to tell it what kind of music and radio you listen to. It then works some magic to serve up a very personalised selection of amazing music content from around the BBC. So whether you&#39;re a fan of Miles Davis, Underworld, Brahms or The 1975, the app will learn what you like and find the best clips for you. Your specially created selection will include festival moments, intimate sessions and interviews, all tailored to your taste and saving you the hassle of searching for the clips you want.</p>\r\n\r\n<div>\r\n<h2>Get Discovering</h2>\r\n\r\n<div><br />\r\n<img alt="" src="http://ichef.bbci.co.uk/images/ic/976xn/p03kbc2g.jpg" style="height:549px; width:976px" /></div>\r\n\r\n<div>So on top of enjoying the music you love the BBC Music app is also a gateway to unearthing fresh discoveries. Use the app to hear artists for the first time via specially selected playlists from your favourite shows, presenters and events. If you&#39;re always keeping an ear out for something new, the app will do the work to showcase exciting moments from artists you&#39;ve yet to discover.</div>\r\n\r\n<div>\r\n<h2>What&#39;s That Song?</h2>\r\n\r\n<p><img alt="" src="http://ichef.bbci.co.uk/images/ic/976xn/p03kbjg9.jpg" style="height:549px; width:976px" /></p>\r\n\r\n<p>Simple but effective. Heard a song you love on BBC Radio but don&#39;t know the artist or title? Quickly find the track by telling the BBC Music app when you were listening. You&#39;ll also be able to use My Tracks to store all your favourites.</p>\r\n\r\n<h2>Export and Listen</h2>\r\n\r\n<p><img alt="" src="http://ichef.bbci.co.uk/images/ic/976xn/p03kbv94.jpg" style="height:549px; width:976px" /></p>\r\n\r\n<p>Use My Tracks to store all your favouite songs and export the list to one of our partners Spotify and Deezer to listen to them in full. Simply add a song to &lsquo;My Tracks&rsquo;, select a streaming partner by tapping their logo and start listening.<br />\r\nHow&#39;s It For You?</p>\r\n\r\n<p>This is just the first version of the BBC Music app and we&rsquo;ll be looking for ways to make it better. So if you think of something, let us know. You can get in touch via the Feedback section in the app, on Twitter or our Facebook page. We&rsquo;d love to hear what you think.</p>\r\n</div>\r\n</div>\r\n', 1458631870, 1458632133),
(26, 2, 2, 'iPhone and iPad Pro', 'iphone-and-ipad-pro', 26, 1, '', '', '', 'Apple unveils smaller iPhone and iPad Pro', '<p><img alt="" src="http://ichef.bbci.co.uk/news/660/cpsprodpb/399C/production/_88884741_f8d51fbb-f2dd-43aa-bfa5-0a20a4c6f3ce.png" style="height:371px; width:660px" /></p>\r\n\r\n<p>Apple has announced smaller versions of the iPhone and iPad Pro at an event hosted in San Francisco and streamed online.</p>\r\n\r\n<p>The iPhone SE has the same processing and graphics performance of the larger Apple 6S, the firm said, and can capture 4K video.</p>\r\n\r\n<p>The new iPad Pro will have a 9.7 inch screen - the same size as the original iPad.</p>\r\n\r\n<p>The iPhone SE will be available in 110 countries by the end of May.</p>\r\n\r\n<p>With a starting price of $399/$499 (&pound;277/&pound;346), the new iPhone is the &quot;most affordable&quot; handset Apple has ever released, Apple said.</p>\r\n\r\n<p>It also said the new iPad Pro would be available in three different storage sizes with an extra large 256GB version.</p>\r\n\r\n<p>Pricing will begin at $599 for the smallest version and will ship in the US at the end of the month.</p>\r\n\r\n<p><img alt="" src="http://ichef.bbci.co.uk/news/624/cpsprodpb/2DE4/production/_88884711_ipd2.png" style="height:351px; width:624px" /></p>\r\n\r\n<h2>Small iPhone</h2>\r\n\r\n<p>Apple said it sold 30 million four-inch handsets last year, however its handset sales have slowed in recent months in line with the overall smartphone market.</p>\r\n\r\n<p>Some analysts are predicting up to a 15% decline in shipments in the first quarter of 2016 alone.</p>\r\n\r\n<p>&quot;The smart phone market has definitely consolidated around five and six inch devices globally so the question is why has Apple come out with a slightly smaller version?&quot; said Annette Zimmerman, a research director at analyst Gartner.</p>\r\n\r\n<p>&quot;It is not really to capture a trend, but these people who are on an iPhone 4 or 5 and are quite happy with the size.</p>\r\n\r\n<p>&quot;It&#39;s a way to upgrade them and obviously selling a phone with a smaller screen size helps with the margins on these devices,&quot; she added.</p>\r\n\r\n<p>&quot;I don&#39;t think it will lead to the sort of strong growth we saw after the iPhone 6 came out - that would be really difficult to top.&quot;</p>\r\n\r\n<h2>Analysis: Dave Lee, North America technology reporter</h2>\r\n\r\n<p><img alt="" src="http://ichef.bbci.co.uk/news/624/cpsprodpb/BC82/production/_88885284_gettyimages-516858760.jpg" style="height:191px; width:624px" /></p>\r\n\r\n<p>Chief executive Tim Cook addressed the elephant in the room right away. Apple&#39;s court battle with the FBI over encryption heads to court on Tuesday. Mr Cook said he did not ever expect to be &quot;at odds with government&quot;. He said Apple &quot;would not shrink&quot; from its responsibility to protect encryption.</p>\r\n\r\n<p>The comments received a warm applause from the audience - but Tuesday will be a very different story as the company comes face-to-face with the families of the victims of the San Bernardino attack.</p>\r\n\r\n<p>Monday&#39;s launch was just as expected. With iPhone sales slowing, Apple needed to capture some new customers - and the iPhone SE will likely do just that.</p>\r\n\r\n<p>It&#39;s aimed at the types of people whose budget can&#39;t quite stretch to a new premium iPhone - people who may have instead gone for an Android device.</p>\r\n\r\n<p>Unlike the 5c, Apple&#39;s last budget iPhone, the SE doesn&#39;t come in a range of cheap and cheerful colours. This is meant to feel like a top product, only smaller.</p>\r\n\r\n<h2>No surprises</h2>\r\n\r\n<p>Geoff Blaber from CCS Insight said there were &quot;no surprises&quot; but that the products were still &quot;crucial&quot; to Apple&#39;s business.</p>\r\n\r\n<p>&quot;A new price point and new hardware should not be underestimated,&quot; he said.</p>\r\n\r\n<p>&quot;The iPhone SE and iPad Pro 9.7 could be viewed as largely iterative but nonetheless they are still crucial products for Apple as it looks to bolster growth across two crucially important categories&quot;.</p>\r\n\r\n<p>Some observers were underwhelmed by Apple&#39;s latest news.</p>\r\n\r\n<p>&quot;We have officially run out of ideas for new products,&quot;&nbsp;<a class="story-body__link-external" href="https://twitter.com/jeffbakalar/status/711976789376159744" style="-webkit-tap-highlight-color:rgba(17, 103, 168, 0.298039); border-bottom-color:rgb(220, 220, 220); border-bottom-style:solid; border-width:0px 0px 1px; font-family:inherit; font-size:1rem; font-stretch:inherit; font-style:inherit; font-variant:inherit; font-weight:bold; letter-spacing:inherit; line-height:1.375; margin:0px; padding:0px; text-decoration:none; vertical-align:baseline">tweeted tech podcaster Jeff Bakalar.</a></p>\r\n\r\n<p><img alt="" src="http://ichef.bbci.co.uk/news/624/cpsprodpb/DF32/production/_88883175_liam.png" style="height:351px; width:624px" /></p>\r\n\r\n<p>The firm also showed off a recycling robot called Liam which can strip down old iPhones into their components for reuse.</p>\r\n\r\n<p>The Apple Watch is to come down in price to $299 (&pound;207) from its launch price of $349, chief executive Tim Cook also announced.</p>\r\n\r\n<div><br />\r\n<img alt="" src="http://ichef-1.bbci.co.uk/news/624/cpsprodpb/128C/production/_88884740_newbands.png" style="height:351px; width:624px" /></div>\r\n', 1458632894, 1485334481),
(27, 2, 3, 'Micro Bit giveaway', 'micro-bit-giveaway', 27, 1, '', '', '', 'Can the Micro Bit inspire a million?', '<p>It was last May that the BBC unveiled an ambitious plan to give a million schoolchildren a tiny device designed to inspire them to get coding. Now, after a few bumps in the road, the Micro Bits are finally ending up in the hands of children.</p>\r\n\r\n<p>The tiny device can be plugged into a computer and programmed to do all sorts of cool stuff, and Year Seven pupils across the UK are being told it is theirs to take home.</p>\r\n\r\n<p>Some, who have had early access to the Micro Bit, have come up with amazing projects - like the Yorkshire school that sent one up 32km (20 miles) on a balloon bringing back pictures of its journey to the fringes of space.</p>\r\n\r\n<p>But, amid all the excitement from the young people getting a new toy, this is where the serious stuff starts. Big claims have been made for how this project can change the way children learn about and engage with technology. Now, it&#39;s up to teachers to make that happen.</p>\r\n\r\n<p>I&#39;ve been talking to two people with different perspectives on the Micro Bit. Steve Hodges is a Microsoft engineer who was closely involved in the design of the device and Drew Buddie is head of computing at a girls&#39; school and chairman of NAACE, an educational technology association.</p>\r\n\r\n<p>Steve told me that his whole career in computing had started as a result of the BBC Micro in the 1980s.</p>\r\n\r\n<p>&quot;I begged my parents to buy me one for home. I told them I would never ask for anything again if they bought me a BBC Micro!&quot; he recalls.</p>\r\n\r\n<p>His hope is that the Micro Bit will prove similarly inspiring.</p>\r\n\r\n<p>Unlike his generation, today&#39;s children already have access to a variety of computers, so the aims are different.</p>\r\n\r\n<p><img alt="" src="http://ichef-1.bbci.co.uk/news/624/cpsprodpb/5706/production/_88887222_460d62d2-b3f7-4d1e-a0d3-7dc06b82aa31.jpg" style="height:351px; width:624px" /></p>\r\n\r\n<p>&quot;We built a small, low-power &#39;embedded&#39; device, which actually needs a regular computer to program it. In a world of wearable devices, connected gadgets and the &#39;internet of things&#39; the Micro Bit is both relevant and yet unusual - just like the BBC Micro was 35 years ago,&quot; he says.</p>\r\n\r\n<p>Drew is very enthusiastic about the aims of the Micro Bit, and he too harks back to his childhood.</p>\r\n\r\n<p>&quot;For those of us who were around for the BBC Micro, we feel that we are on the very cusp of a renaissance of that era,&quot; he says.</p>\r\n\r\n<p>But the repeated delays in rolling out the device to schools have dismayed him.</p>\r\n\r\n<p>Teachers have had Micro Bits for some weeks but they are being delivered to children just as the term ends.</p>\r\n\r\n<p>&quot;There seems to be a perception at the BBC that teachers were ready to drop everything to use these devices as soon as they became available,&quot; Drew says. He explains that it&#39;s now too late in the year for many to adapt their lesson plans.</p>\r\n\r\n<p><img alt="" src="http://ichef.bbci.co.uk/news/624/cpsprodpb/99D2/production/_88887393_376c2b46-650e-4e11-bb70-e56bb48ef4d1.jpg" style="height:428px; width:624px" /></p>\r\n\r\n<p>The delays are understandable - bringing together a consortium of companies to produce something that had to be exciting, educational and safe was always going to be a challenge. One difficulty came when the team realised that the small watch battery in the original version could be a choke hazard for small brothers and sisters when the device was taken home.</p>\r\n\r\n<p>&quot;The real challenge was the scale of the project,&quot; says Steve Hodges.</p>\r\n\r\n<p>Usually a company will start out making a few thousand of a new device.</p>\r\n\r\n<p>&quot;But we knew that we would be manufacturing one million devices from day one so we needed to plan for every eventuality we could think of to make the device as feature-rich, safe and robust as we could,&quot; he explains.</p>\r\n\r\n<p>I asked Steve whether it might not have been better to give children a Raspberry Pi, the barebones computer that has already been a big hit.</p>\r\n\r\n<p>He sees the two devices being used in tandem but says the Micro Bit is designed to be different, and to attract &quot;students who enjoy a more hands-on, tactile learning style and who would otherwise find coding less appealing&quot;.</p>\r\n\r\n<p><img alt="" src="http://ichef-1.bbci.co.uk/news/624/cpsprodpb/9202/production/_88887373_246f9213-64a0-4b01-a468-9820872d92a1.jpg" style="height:351px; width:624px" /></p>\r\n\r\n<p>One key feature of the Micro Bits is that they belong not to the schools or the teachers but to the children. It seems, however, that some teachers don&#39;t buy into that idea.</p>\r\n\r\n<p>Drew says significant numbers &quot;seem to be suggesting that they will try to hold on to the devices in schools by discouraging the students from taking them home&quot;.</p>\r\n\r\n<p>But he says that won&#39;t happen at his school.</p>\r\n\r\n<p>&quot;My attitude is that I&#39;m going to give them to the girls because they belong to them,&quot; he states.</p>\r\n\r\n<p>He remains enthusiastic about starting some projects and thinks his students will be keen to use their Micro Bits to make some wearable technology. But he says some of the early impetus has been lost and, rather than being incorporated into lessons, the Micro Bit will be taught in lunchtimes and after-school clubs.</p>\r\n\r\n<div><br />\r\n<img alt="" src="http://ichef.bbci.co.uk/news/624/cpsprodpb/E7F2/production/_88887395_5e303547-a780-4a85-a49a-a94364c09c25.jpg" style="height:414px; width:624px" /></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>\r\n<p>The BBC project is focused on schoolchildren who entered Year 7 last September. There is still time for them to get inspired, but it now looks as though it will be in Year 8 that they may really get to grips with their Micro Bits and learn most from them.</p>\r\n\r\n<p>So, what happens to those who enter Year 7 this coming September?</p>\r\n\r\n<p>There is talk of turning the Micro Bit into a commercial product and, given the level of interest in it, that must be a distinct possibility. Then schools would have to decide whether to buy more of the devices.</p>\r\n\r\n<p>The BBC Micro made a big impact in schools and beyond throughout the 1980s, inspiring a generation of computing and gaming entrepreneurs.</p>\r\n\r\n<p>It is a big act to follow, but let&#39;s hope the Micro Bit can now begin to open a new generation&#39;s eyes to the creative potential of computing.</p>\r\n</div>\r\n', 1458633337, 1485334584),
(28, 3, 1, 'Google''s offer', 'google''s-offer', 28, 1, '', '', '', 'Google helps offer vastly faster Internet in Cuba', '<p>HAVANA -- Google is opening a cutting-edge online technology center at the studio of one of Cuba&#39;s most famous artists, offering free Internet at speeds nearly 70 times faster than those now available to the Cuban public. President Barack Obama says Google&#39;s efforts in Cuba are part of a wider plan to improve access to the Internet across the island</p>\r\n\r\n<p>The U.S. technology giant has built a studio equipped with dozens of laptops, cellphones and virtual-reality goggles at the complex run by Alexis Leiva Machado, a sculptor known as Kcho. Obama said Sunday that Google was also launching a broader effort to improve Cubans&#39; Internet access across the island.</p>\r\n\r\n<p>The company gave no specifics, and Ben Rhodes, deputy national security adviser, said Monday that no further details would be announced during Obama&#39;s visit.</p>\r\n\r\n<p>In an exclusive tour of the site with The Associated Press on Monday, Google&#39;s head of Cuba operations, Brett Perlmutter, said the company was optimistic that the Google+Kcho.Mor studio would be part of a broader cooperative effort to bring Internet access to the Cuban people.</p>\r\n\r\n<p>&quot;We want to show the world what happens when you combine Cuban creative energy with technology that&#39;s first in class,&quot; he said.</p>\r\n\r\n<p>The studio will be open five days a week, from 7 a.m. to midnight, for about 40 people at a time, Kcho said.</p>\r\n\r\n<p>The project has limited reach but enormous symbolic importance in a country that has long maintained strict control of Internet access, which some Cuban officials sees as a potential national security threat. Officials have described said the Internet as a potential tool for the United States to exert influence over the island&#39;s culture and politics.</p>\r\n\r\n<p>The connection at the Kcho studio is provided by Cuba&#39;s state-run telecommunications company over a new fiber-optic connection and Obama&#39;s comments indicate the new Google-Cuba relationship was negotiated at the highest levels of the U.S. and Cuban governments.</p>\r\n\r\n<p>Perlmutter declined to comment on any broader plans by the company, but said the Kcho center would feature upload and download speed of 70 megabytes per second. That is blazingly fast in comparison with the public WiFi available to most Cubans for $2, nearly a tenth of the average monthly salary, for an hour of access at roughly 1 megabyte per second.</p>\r\n\r\n<p>Kcho said he was paying for the new connection himself but declined to say how much he was being charged.</p>\r\n\r\n<p>Google has been trying for more than a year to improve Cuba&#39;s access to the Web with large-scale projects like those it has carried out in other developing countries. Kcho has long maintained close relationship with the Castro government and became the first independent source of free Internet in Cuba last year when he began offering free WiFi at his studio.</p>\r\n\r\n<p>Soon after, the Cuban government announced that it was opening $2-an-hour WiFi spots across the country in a move that has dramatically increased Cubans&#39; access to the Internet, allowing many to video-chat with families abroad and see relatives for the first time.</p>\r\n\r\n<p>Cuba still has one of the world&#39;s lowest rates of Internet penetration.</p>\r\n\r\n<p>&nbsp;</p>\r\n', 1458635634, 1458635634),
(29, 3, 1, 'WhatsApp app', 'whatsapp-app', 29, 1, '', '', '', 'WhatsApp Challenges Slack And E-Mail With New File-Sharing Feature', '<p>WhatsApp has made it possible for the first time for users to share documents as part of a new update for iOS and Android.</p>\r\n\r\n<p>On Android, users who tap the paper-clip icon for attachments&nbsp;will see a &ldquo;Document&rdquo; button, while on iOS, users who tap the upload icon will see the option to &ldquo;Share Document.&rdquo;</p>\r\n\r\n<p>For now the feature appears to be limited to PDF files but it does pull files from third-party cloud storage apps enabled on the phone, including iCloud Drive, Dropbox and Quip.</p>\r\n\r\n<p>This is an important upgrade for small businesses who use WhatsApp to communicate with one another, or with customers &ndash; for example making it easier to share invoices and price lists or product information that&rsquo;s stored on a cloud service like Dropbox.</p>\r\n\r\n<p><img alt="" src="http://blogs-images.forbes.com/parmyolson/files/2016/03/FullSizeRender-2.jpg" style="height:448px; width:650px" /></p>\r\n\r\n<p>In January&nbsp;<a href="http://www.forbes.com/sites/parmyolson/2016/01/18/whatsapp-businesses-free-1-billion/#240afc19b6bd" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; font-size: inherit; line-height: inherit; font-family: inherit; vertical-align: baseline; text-decoration: none; -webkit-tap-highlight-color: transparent; color: rgb(0, 56, 145);" target="_self">WhatsApp announced</a>&nbsp;it was going to start testing tools that would allow businesses and organizations to chat with users on its network.</p>\r\n\r\n<p>It gave examples of asking an airline about a delayed flight or voicing concerns to your bank about potentially fraudulent activity &mdash; essentially customer service tools.Document sharing could prove to be a useful feature for some of the first businesses that get deeper access to WhatsApp&rsquo;s API to communicate with their customers on the network.</p>\r\n', 1458636057, 1458636057),
(30, 3, 1, 'Facebook Reactions', 'facebook-reactions', 30, 1, '', '', '', 'Reactions Now Available Globally', '<p><img alt="" src="https://fbnewsroomus.files.wordpress.com/2016/02/reactions-image-en_us.png?w=960" style="height:484px; width:860px" /></p>\r\n\r\n<p>Every day, people come to Facebook to discover what&rsquo;s happening in their world and around the world, and to share all kinds of things, whether that&rsquo;s updates that are happy, sad, funny or thought-provoking. News Feed is the central way you can get updates about your friends, family and anything else that matters to you, and the central place to have conversations with the people you care about. We&rsquo;ve been listening to people and know that there should be more ways to easily and quickly express how something you see in News Feed makes you feel. That&rsquo;s why today we are launching Reactions, an extension of the Like button, to give you more ways to share your reaction to a post in a quick and easy way.</p>\r\n\r\n<p>To add a reaction, hold down the Like button on mobile or hover over the Like button on desktop to see the reaction image options, then tap either Like, Love, Haha, Wow, Sad or Angry.</p>\r\n\r\n<p>We understand that this is a big change, and want to be thoughtful about rolling this out. For more than a year we have been conducting global research including focus groups and surveys to determine what types of reactions people would want to use most. We also looked at how people are already commenting on posts and the top stickers and emoticons as signals for the types of reactions people are already using to determine which reactions to offer.</p>\r\n\r\n<p>We have been testing Reactions in a few markets since last year, and have received positive feedback so far. Today, we&rsquo;re excited to offer it to everyone who uses Facebook around the world.&nbsp;We will&nbsp;continue learning and listening to feedback to make sure we have a set of&nbsp;reactions that will be useful for everyone.&nbsp;We hope you enjoy the new Reactions!</p>\r\n', 1458636392, 1458662391),
(31, 1, 15, 'Sing with Spotify', 'sing-with-spotify', 31, 1, '', '', '', 'Go Behind The Lyrics with Spotify and Genius', '<p>Ever hear a song and wonder what it means? What inspired its lyrics? Why the artist chose to work with certain collaborators, and<strong>&nbsp;</strong>what they were doing in the studio when they recorded it?</p>\r\n\r\n<p>It&rsquo;s this kind of curiosity that drove us to team up with&nbsp;<a href="http://www.genius.com/" style="box-sizing: border-box; text-decoration: none; background: 0px 0px;">Genius</a>, the world&rsquo;s largest collection of song lyrics and crowdsourced musical knowledge, giving you a chance to more deeply connect with the artists and songs you love.</p>\r\n\r\n<p>Starting today, we&rsquo;re introducing a brand new playlist,&nbsp;<a href="https://open.spotify.com/user/spotify/playlist/2Fd6UiLzCkgCuodfRFd4OQ" style="box-sizing: border-box; text-decoration: none; background: 0px 0px;"><strong>Behind the Lyrics (Hip Hop)</strong></a>, followed by&nbsp;<strong>Behind the Lyrics (HITS)</strong>&nbsp;in the coming week. These playlists, curated by Spotify and Genius, will allow you to go Behind the Lyrics of your favorite hip hop tunes.</p>\r\n\r\n<p>Tracks on these playlists will include lyrical excerpts, fun facts, annotations, and stories straight from the artists and from the Genius community, all of which are frequently updated. Simply hit &lsquo;Play&rsquo; on this Genius-powered playlist to learn more about your favorite artists and songs.</p>\r\n\r\n<p>To kick things off, three of today&rsquo;s biggest artists &mdash;&nbsp;<a href="https://open.spotify.com/user/genius_official/playlist/19Uwi1IKNitNY573ewDgu3" style="box-sizing: border-box; text-decoration: none; background: 0px 0px;"><strong>Pusha T</strong></a>,&nbsp;<a href="https://open.spotify.com/user/genius_official/playlist/5lGi40wsEbDATXJNkk2FrU" style="box-sizing: border-box; text-decoration: none; background: 0px 0px;"><strong>Tinashe</strong></a>, and&nbsp;<a href="https://open.spotify.com/user/genius_official/playlist/0l9vxryBTxxqZ6rsXfktpN" style="box-sizing: border-box; text-decoration: none; background: 0px 0px;"><strong>Diplo</strong></a>&nbsp;&mdash; will take you Behind the Lyrics and share their personal take on some of their favorite tracks.</p>\r\n\r\n<p>&ldquo;I&rsquo;ve partnered with Genius and Spotify to take you &lsquo;Behind The Lyrics&rsquo; of my greatest songs because every word that I write means something to me,&rdquo; says Pusha T. &ldquo;Together we&rsquo;ve found a way to bring my fans a deeper listening experience and raise the bar for songwriters.&rdquo;</p>\r\n\r\n<p>&ldquo;Spotify and Genius are creating a really cool connection between me and my fans on another level than I normally can connect with them,&rdquo; says Tinashe. &ldquo;Not only are they able to hear the music and see the lyrics, but they are also able to understand where I was coming from when I wrote them and kind of get inside my head, which is really cool.&rdquo;</p>\r\n\r\n<p>&ldquo;Being a producer and writer, I really love to see how some songs resonate with fans from the feeling / meaning or just sound of the records,&rdquo; says Diplo. &ldquo;I have always been a person that dissects music and studies it. I was a sample spotter and I learned how to make music by listening to it. Genius and Spotify are working together to break down music to the bare bones and get deeper into its true core.&rdquo;</p>\r\n\r\n<p>Rolling out today, the new Spotify and Genius Behind the Lyrics experience is available to all Spotify iPhone users with the exception of iPhone 4/s.</p>\r\n\r\n<p>We&rsquo;re just getting started! Expect the Genius treatment on much more music you love soon.</p>\r\n', 1458636513, 1458922680),
(32, NULL, 1, 'Orders', 'order/index', 25, 1, NULL, NULL, NULL, NULL, NULL, 1458210170, 1458210170),
(33, NULL, 1, 'Cart', 'order/cart', 26, 1, NULL, NULL, NULL, NULL, NULL, 1458210170, 1458210170),
(34, NULL, 1, 'Checkout', 'order/checkout', 27, 1, NULL, NULL, NULL, NULL, NULL, 1458210170, 1458210170),
(35, NULL, 1, 'Thank You', 'order/thank', 28, 1, NULL, NULL, NULL, NULL, '<p>You have successfully completed your order.</p>\r\n\r\n<p>Our team will contact you as soon as possible.</p>', 1458210170, 1458210170),
(36, NULL, 1, 'Cancel Order', 'order/cancel', 29, 1, NULL, NULL, NULL, NULL, '<p>You have canceled your order.</p>', 1458210170, 1458210170);

-- --------------------------------------------------------

--
-- Структура таблицы `page_category`
--

CREATE TABLE IF NOT EXISTS `page_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `sorting` int(4) unsigned DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_page_category_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `page_category`
--

INSERT INTO `page_category` (`id`, `user_id`, `name`, `slug`, `visible`, `sorting`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Music', 'music', 1, 1, 1458631594, 1458922875),
(2, NULL, 'Technology', 'technology', 1, 2, 1458632735, 1485334553),
(3, NULL, 'Social Media', 'social-media', 1, 3, 1458635417, 1458635417);

-- --------------------------------------------------------

--
-- Структура таблицы `page_category_i18n`
--

CREATE TABLE IF NOT EXISTS `page_category_i18n` (
  `id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`,`language`),
  KEY `fk_page_category_i18n_i18n_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `page_category_i18n`
--

INSERT INTO `page_category_i18n` (`id`, `language`, `name`) VALUES
(1, 'ru', 'Музыка');

-- --------------------------------------------------------

--
-- Структура таблицы `page_i18n`
--

CREATE TABLE IF NOT EXISTS `page_i18n` (
  `id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `link_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `header` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`,`language`),
  KEY `fk_page_i18n_i18n_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `page_i18n`
--

INSERT INTO `page_i18n` (`id`, `language`, `link_name`, `title`, `meta_keywords`, `meta_description`, `header`, `content`) VALUES
(1, 'ru', 'Главная', '', '', '', '', ''),
(2, 'ru', 'Компания', '', '', '', '', ''),
(3, 'ru', 'О Нас', '', '', '', '', ''),
(4, 'ru', 'Проекты', '', '', '', '', '<p>тестовый контент</p>\r\n'),
(5, 'ru', 'Документы', '', '', '', '', ''),
(6, 'ru', 'Аудио', '', '', '', '', ''),
(7, 'ru', 'Видео', '', '', '', '', ''),
(8, 'ru', 'Статьи', '', '', '', '', ''),
(9, 'ru', 'Архив', '', '', '', '', ''),
(10, 'ru', 'Контакты', '', '', '', '', ''),
(11, 'ru', 'Регистрация', '', '', '', '', ''),
(12, 'ru', 'Изменить Пароль', '', '', '', '', ''),
(13, 'ru', 'Изменить Пароль', '', '', '', '', ''),
(14, 'ru', 'Вход', '', '', '', '', ''),
(15, 'ru', 'Выход', '', '', '', '', ''),
(16, 'ru', 'Профиль', '', '', '', '', ''),
(17, 'ru', 'Редактировать Профиль', '', '', '', '', ''),
(18, 'ru', 'Социальные Аккаунты', '', '', '', '', ''),
(19, 'ru', 'Блог', '', '', '', '', ''),
(20, 'ru', 'Пост Блога', '', '', '', '', ''),
(21, 'ru', 'Галерея', '', '', '', '', ''),
(22, 'ru', 'ЧаВо', '', '', '', '', ''),
(23, 'ru', 'Каталог', '', '', '', '', ''),
(24, 'ru', 'Продукт', '', '', '', '', ''),
(31, 'ru', 'Пойте с Spotify', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `quote`
--

CREATE TABLE IF NOT EXISTS `quote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `sorting` int(4) unsigned DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_quote_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `quote`
--

INSERT INTO `quote` (`id`, `user_id`, `name`, `image`, `description`, `visible`, `sorting`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jonh Harvey', NULL, 'It-master have been superb. Their customer service is great. The guys there respond very quickly and go above and beyond to help.', 1, 1, 1472115099, 1472116403),
(2, 1, 'Jonh Stocco', NULL, 'It-masters did an amazing job and we wholeheartedly recommend them to all colleagues and associates as the ''full package deal'' -a team full of cuttong-edge talent, dedication, and passion for web design and development.', 1, 2, 1472116626, 1472116626),
(3, 1, 'Jack Cole', NULL, 'I can''t say enough about the excellent work that It-master has done on our website. They took a below-average website and transformmed it into an appealing and informative website. It was an absolute pleasure to work woth them. The designer listened to my thoughts and suggestions and far surpassed my expectations. I highly recommend that you use It-master to develop your website.', 1, 3, 1472116870, 1482250504);

-- --------------------------------------------------------

--
-- Структура таблицы `quote_i18n`
--

CREATE TABLE IF NOT EXISTS `quote_i18n` (
  `id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`,`language`),
  KEY `fk_quote_i18n_i18n_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) unsigned NOT NULL DEFAULT '0',
  `value_type` int(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `setting`
--

INSERT INTO `setting` (`id`, `type`, `value_type`, `title`, `key`, `value`) VALUES
(1, 1, 0, 'Default Site Title', 'site_title', 'Company Site'),
(2, 1, 0, 'Default Meta Keywords', 'site_meta_keywords', 'Company Site'),
(3, 1, 0, 'Default Meta Description', 'site_meta_description', 'Company Site'),
(4, 1, 0, 'Administrator Email', 'admin_email', 'tanya.v.nazarchuk@gmail.com'),
(5, 1, 0, 'Administrator Name', 'admin_name', 'Admin Name'),
(6, 0, 0, 'Organization Address', 'contact_address', 'Sobornyi Ave, 218А, Zaporizhia, Zaporizka oblast, 69000'),
(7, 0, 0, 'Organization Phone', 'contact_phone', '+380(612) 584 1256'),
(8, 0, 0, 'Organization Mail', 'contact_mail', 'info@itmaster-soft.com'),
(9, 0, 0, 'Organization Fax', 'contact_fax', '+1-212-9876543'),
(10, 0, 0, 'Organization Twitter', 'contact_twitter', 'https://twitter.com/?lang=en'),
(11, 0, 0, 'Organization Web-site', 'contact_site', 'http://hire.itmaster-soft.com');

-- --------------------------------------------------------

--
-- Структура таблицы `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `video_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forward_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `position` int(1) unsigned NOT NULL DEFAULT '0',
  `button_caption` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sorting` int(4) unsigned DEFAULT NULL,
  `theme_id` int(11) DEFAULT '2',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_slider_user` (`user_id`),
  KEY `fk_slider_theme` (`theme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `slider`
--

INSERT INTO `slider` (`id`, `user_id`, `name`, `image`, `description`, `video_url`, `forward_url`, `type`, `visible`, `position`, `button_caption`, `sorting`, `theme_id`, `created_at`, `updated_at`) VALUES
(2, NULL, 'Web Development Company', '1472108907.jpg', '<p>Our team consists of experienced web developers, designers and managers.<br/>We are looking for new clients or ongoing relationship with new business partners !', '', '/about', 0, 1, 0, 'About us', 2, 2, 1472108907, 1472108907),
(3, NULL, 'Web Development Company', '1472109021.jpg', '<p>Our team consists of experienced web developers, designers and managers.<br /> We are looking for new clients or ongoing relationship with new business partners!<br /> Hire dedicated team of Professional web Developers &amp; Designers and other experts from us and you can be sure that you will be always provided with the high quality and timeliness of our work.</p>', '', '/contact', 0, 1, 1, 'Contact us', 3, 2, 1472109021, 1472109021),
(4, NULL, 'Smart IT solutions for your challenging ideas', '1472109377.jpg', '<ul class="slider-list">\r\n	<li><span><i class="fa fa-check"></i>Any Complexity Websites</span></li>\r\n	<li><span><i class="fa fa-check"></i>Project development of any complexity</span></li>\r\n	<li><span><i class="fa fa-check"></i>Implementation of search engine optimization</span></li>\r\n</ul>\r\n', '', '/catalog/index', 0, 1, 2, 'Check our products', 4, 2, 1472109377, 1482250717),
(6, NULL, 'Smart IT solutions for your challenging ideas', '1481880075.png', '<p>It is convenient to work with us, because we have integrated services. With our help you can order creating a website from scratch, as well as updating and redesigning your current resource. We offer all services, which are connected with site development from planning, designing and making-up to off-site modules and add-ins development.</p>\r\n', '', '', 0, 1, 0, '', 6, 3, 1481880075, 1481880075),
(7, NULL, 'Smart IT solutions for your challenging ideas', '1481880192.jpg', '<p>Ordering a site in IT Master you get a resource that is made according to the latest standards of modern web design with the requirements of search engines and is comfortable to use.</p>\r\n', '', '', 0, 1, 0, '', 7, 3, 1481880192, 1481880192),
(8, NULL, 'We Are Creating Great Products For You!', '1481880266.png', '<ul class="slider-list">\r\n	<li><span><i class="fa fa-check"></i>Proffesional web development</span></li>\r\n	<li><span><i class="fa fa-check"></i>Websites support</span></li>\r\n	<li><span><i class="fa fa-check"></i>Hire dedicated developers</span></li>\r\n	<li><span><i class="fa fa-check"></i>Various web services</span></li>\r\n	<li><span><i class="fa fa-check"></i>Modern technologies</span></li>\r\n</ul>\r\n', '', '', 0, 1, 0, '', 8, 3, 1481880266, 1481883351);

-- --------------------------------------------------------

--
-- Структура таблицы `slider_i18n`
--

CREATE TABLE IF NOT EXISTS `slider_i18n` (
  `id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `button_caption` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`,`language`),
  KEY `fk_slider_i18n_i18n_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `theme`
--

CREATE TABLE IF NOT EXISTS `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `sorting` int(4) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `theme`
--

INSERT INTO `theme` (`id`, `name`, `slug`, `default`, `sorting`) VALUES
(1, 'Basic', 'basic', 0, 1),
(2, 'Colored', 'colored', 1, 2),
(3, 'White', 'white', 0, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role_id` int(11) NOT NULL DEFAULT '1',
  `country_id` int(11) DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` int(11) DEFAULT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `last_login_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  UNIQUE KEY `access_token` (`access_token`),
  KEY `fk_user_user_role` (`role_id`),
  KEY `fk_user_country` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `access_token`, `email`, `first_name`, `last_name`, `role_id`, `country_id`, `zip`, `city`, `address`, `phone`, `avatar`, `birthday`, `gender`, `verified`, `active`, `created_at`, `updated_at`, `last_login_at`) VALUES
(1, 'tanya', 'rqCWisc52mDl44St5u8wtbgKFy_WY7mB', '$2y$13$tzZOnOzfajkeyJgGkgVxP.6BpT6acIgzkgwpCMuMLV5m/aWxXfDEW', 'pZzT7l-F5IxXEPwZodB3EPTfVmrorT2r_1452986682', NULL, 'tanya@gmail.com', 'Tanya', 'Gold', 2, 232, '6900', 'Zaporozie', 'Doroshenko 4-28', '096830870', '1472122205.jpg', 1484870400, 1, 1, 1, 1450874841, 1493972847, 1500207838),
(2, 'alex', 'vlrTzbhrwHQSsYIYE2N3PrFjqULGHdxQ', '$2y$13$OKfNrfLS.As/88bEt2wMledK5U8A3LHBNiVWmeBgDS80hF5K9y5K.', NULL, NULL, 'alex@gmail.com', 'Alex', 'Kotlyar', 2, 232, '62000', 'Zaporozie', 'Ivanova 1-2', '11111111', '1458638462.png', NULL, 0, 1, 1, 1452969958, 1458638462, 1495448906),
(3, 'nadia', 'sfhtsJwNJMGSZto0vfasc6aMxpMJW9kD', '$2y$13$uc2wBNlchNdRLpOP.KEwD.KXlAEw76JPDhcv3qACbpTFTjio2ZQXW', NULL, NULL, 'nadia@gmail.com', 'Nadia', 'Bezhan', 2, 232, '62000', 'Zaporozie', 'Metalurgov 2-1', '+380630524344', '1482352765.jpg', 376185600, 1, 1, 1, 1452970230, 1482352765, 1459157007),
(15, 'demo', 'rhCbK0fGb3D_gUBe6lOtYT6ESzjM9_UW', '$2y$13$j9ptu97LepvafcH572tbhOHZrc.EvvTI9VC878guh/vrCyXnRcOOa', NULL, NULL, 'demo@gmail.com', 'Demo', 'Demo', 2, NULL, '', '', '', '', '1482352844.jpg', NULL, 0, 1, 1, 1460381778, 1482352844, 1501056638),
(16, 'lebed_nata', '6MF8F26U09BwuTiJE_5qBK4dGwe3K5JG', '$2y$13$Jap8xjbyXiErzy3MIKPXKOPVEb5KapuoQbDO48LsJaiCc9hERQFU2', NULL, NULL, 'lebed_nata@list.ru', 'Nataliia', 'Lebed', 2, 1, '12345', 'New York', '', '126546456', '1493884631.jpg', NULL, 1, 1, 1, 1493884631, 1493884722, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user_auth`
--

CREATE TABLE IF NOT EXISTS `user_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `source` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `source_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `screen_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_auth_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `user_auth`
--

INSERT INTO `user_auth` (`id`, `user_id`, `source`, `source_id`, `screen_name`) VALUES
(4, 1, 'google', '110765284483580761046', NULL),
(5, 15, 'facebook', '10209314372478073', NULL),
(6, 15, 'google', '101590368372744416241', NULL),
(7, 15, 'twitter', '174604188', 'natalia_lebed'),
(8, 1, 'facebook', '1148683255252567', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user_permission`
--

CREATE TABLE IF NOT EXISTS `user_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `type` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_user_permission_user_role` (`role_id`),
  KEY `fk_user_permission_module` (`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=65 ;

--
-- Дамп данных таблицы `user_permission`
--

INSERT INTO `user_permission` (`id`, `role_id`, `module_id`, `type`) VALUES
(1, 3, 1, 1),
(2, 3, 1, 2),
(3, 3, 1, 3),
(4, 3, 1, 4),
(5, 3, 2, 1),
(6, 3, 2, 2),
(7, 3, 2, 3),
(8, 3, 2, 4),
(9, 3, 3, 1),
(10, 3, 3, 2),
(11, 3, 3, 3),
(12, 3, 3, 4),
(13, 3, 4, 1),
(14, 3, 4, 2),
(15, 3, 4, 3),
(16, 3, 4, 4),
(17, 3, 5, 1),
(18, 3, 5, 2),
(19, 3, 5, 3),
(20, 3, 5, 4),
(21, 3, 6, 1),
(22, 3, 6, 2),
(23, 3, 6, 3),
(24, 3, 6, 4),
(25, 3, 7, 1),
(26, 3, 7, 2),
(27, 3, 7, 3),
(28, 3, 7, 4),
(29, 3, 8, 1),
(30, 3, 8, 2),
(31, 3, 8, 3),
(32, 3, 8, 4),
(33, 3, 9, 1),
(34, 3, 9, 2),
(35, 3, 9, 3),
(36, 3, 9, 4),
(37, 3, 10, 1),
(38, 3, 10, 2),
(39, 3, 10, 3),
(40, 3, 10, 4),
(41, 3, 11, 1),
(42, 3, 11, 2),
(43, 3, 11, 3),
(44, 3, 11, 4),
(45, 3, 12, 1),
(46, 3, 12, 2),
(47, 3, 12, 3),
(48, 3, 12, 4),
(49, 3, 13, 1),
(50, 3, 13, 2),
(51, 3, 13, 3),
(52, 3, 13, 4),
(53, 3, 14, 1),
(54, 3, 14, 2),
(55, 3, 14, 3),
(56, 3, 14, 4),
(57, 3, 15, 1),
(58, 3, 15, 2),
(59, 3, 15, 3),
(60, 3, 15, 4),
(61, 3, 16, 1),
(62, 3, 16, 2),
(63, 3, 16, 3),
(64, 3, 16, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `user_role`
--

INSERT INTO `user_role` (`id`, `type`, `name`) VALUES
(1, 1, 'User'),
(2, 1, 'Super Admin'),
(3, 0, 'Admin');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `ctlg_category`
--
ALTER TABLE `ctlg_category`
  ADD CONSTRAINT `fk_ctlg_category_ctlg_category` FOREIGN KEY (`parent_id`) REFERENCES `ctlg_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ctlg_category_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `ctlg_category_i18n`
--
ALTER TABLE `ctlg_category_i18n`
  ADD CONSTRAINT `fk_ctlg_category_i18n_ctlg_category` FOREIGN KEY (`id`) REFERENCES `ctlg_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ctlg_category_i18n_i18n_language` FOREIGN KEY (`language`) REFERENCES `i18n_language` (`language`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `ctlg_field`
--
ALTER TABLE `ctlg_field`
  ADD CONSTRAINT `fk_ctlg_field_ctlg_category` FOREIGN KEY (`category_id`) REFERENCES `ctlg_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `ctlg_filter`
--
ALTER TABLE `ctlg_filter`
  ADD CONSTRAINT `fk_ctlg_filter_ctlg_category` FOREIGN KEY (`category_id`) REFERENCES `ctlg_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `ctlg_product`
--
ALTER TABLE `ctlg_product`
  ADD CONSTRAINT `fk_ctlg_product_ctlg_category` FOREIGN KEY (`parent_id`) REFERENCES `ctlg_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ctlg_product_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `ctlg_product_field`
--
ALTER TABLE `ctlg_product_field`
  ADD CONSTRAINT `fk_ctlg_product_field_ctlg_category` FOREIGN KEY (`field_id`) REFERENCES `ctlg_field` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ctlg_product_field_ctlg_product` FOREIGN KEY (`product_id`) REFERENCES `ctlg_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `ctlg_product_i18n`
--
ALTER TABLE `ctlg_product_i18n`
  ADD CONSTRAINT `fk_ctlg_product_i18n_ctlg_product` FOREIGN KEY (`id`) REFERENCES `ctlg_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ctlg_product_i18n_i18n_language` FOREIGN KEY (`language`) REFERENCES `i18n_language` (`language`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `faq_category`
--
ALTER TABLE `faq_category`
  ADD CONSTRAINT `fk_faq_category_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `faq_category_i18n`
--
ALTER TABLE `faq_category_i18n`
  ADD CONSTRAINT `fk_faq_category_i18n_faq_category` FOREIGN KEY (`id`) REFERENCES `faq_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_faq_category_i18n_i18n_language` FOREIGN KEY (`language`) REFERENCES `i18n_language` (`language`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `faq_item`
--
ALTER TABLE `faq_item`
  ADD CONSTRAINT `fk_faq_item_faq_category` FOREIGN KEY (`parent_id`) REFERENCES `faq_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_faq_item_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `faq_item_i18n`
--
ALTER TABLE `faq_item_i18n`
  ADD CONSTRAINT `fk_faq_item_i18n_faq_item` FOREIGN KEY (`id`) REFERENCES `faq_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_faq_item_i18n_i18n_language` FOREIGN KEY (`language`) REFERENCES `i18n_language` (`language`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `i18n_translation`
--
ALTER TABLE `i18n_translation`
  ADD CONSTRAINT `fk_i18n_translation_i18n_language` FOREIGN KEY (`language`) REFERENCES `i18n_language` (`language`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_i18n_translation_i18n_message` FOREIGN KEY (`id`) REFERENCES `i18n_message` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `media_category`
--
ALTER TABLE `media_category`
  ADD CONSTRAINT `fk_media_category_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `media_file`
--
ALTER TABLE `media_file`
  ADD CONSTRAINT `fk_media_file_media_category` FOREIGN KEY (`parent_id`) REFERENCES `media_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_media_file_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `menu_item`
--
ALTER TABLE `menu_item`
  ADD CONSTRAINT `fk_menu_item_menu` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_menu_item_menu_item` FOREIGN KEY (`parent_id`) REFERENCES `menu_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_menu_item_page` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `menu_item_i18n`
--
ALTER TABLE `menu_item_i18n`
  ADD CONSTRAINT `fk_menu_item_i18n_i18n_language` FOREIGN KEY (`language`) REFERENCES `i18n_language` (`language`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_menu_item_i18n_page` FOREIGN KEY (`id`) REFERENCES `menu_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `fk_module_module` FOREIGN KEY (`parent_id`) REFERENCES `module` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_order_country` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `fk_order_item_ctlg_product` FOREIGN KEY (`product_id`) REFERENCES `ctlg_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_item_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `fk_page_page_category` FOREIGN KEY (`parent_id`) REFERENCES `page_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_page_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `page_category`
--
ALTER TABLE `page_category`
  ADD CONSTRAINT `fk_page_category_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `page_category_i18n`
--
ALTER TABLE `page_category_i18n`
  ADD CONSTRAINT `fk_page_category_i18n_i18n_language` FOREIGN KEY (`language`) REFERENCES `i18n_language` (`language`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_page_category_i18n_page_category` FOREIGN KEY (`id`) REFERENCES `page_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `page_i18n`
--
ALTER TABLE `page_i18n`
  ADD CONSTRAINT `fk_page_i18n_i18n_language` FOREIGN KEY (`language`) REFERENCES `i18n_language` (`language`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_page_i18n_page` FOREIGN KEY (`id`) REFERENCES `page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `quote`
--
ALTER TABLE `quote`
  ADD CONSTRAINT `fk_quote_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `quote_i18n`
--
ALTER TABLE `quote_i18n`
  ADD CONSTRAINT `fk_quote_i18n_i18n_language` FOREIGN KEY (`language`) REFERENCES `i18n_language` (`language`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_quote_i18n_quote` FOREIGN KEY (`id`) REFERENCES `quote` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `slider`
--
ALTER TABLE `slider`
  ADD CONSTRAINT `fk_slider_theme` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_slider_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `slider_i18n`
--
ALTER TABLE `slider_i18n`
  ADD CONSTRAINT `fk_slider_i18n_i18n_language` FOREIGN KEY (`language`) REFERENCES `i18n_language` (`language`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_slider_i18n_slider` FOREIGN KEY (`id`) REFERENCES `slider` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_country` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_user_role` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_auth`
--
ALTER TABLE `user_auth`
  ADD CONSTRAINT `fk_user_auth_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_permission`
--
ALTER TABLE `user_permission`
  ADD CONSTRAINT `fk_user_permission_module` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_permission_user_role` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
