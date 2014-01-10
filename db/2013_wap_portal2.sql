-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 09, 2014 at 12:14 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `2013_wap_portal2`
--
CREATE DATABASE IF NOT EXISTS `2013_wap_portal2` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `2013_wap_portal2`;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `ban_id` int(11) unsigned NOT NULL,
  `ban_name` varchar(255) DEFAULT NULL,
  `ban_title` varchar(255) DEFAULT NULL,
  `ban_file` varchar(255) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ban_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`ban_id`, `ban_name`, `ban_title`, `ban_file`, `status_id`) VALUES
(1, 'Banner1', NULL, '1_img1.jpg', 1),
(2, 'Banner2', NULL, '2_1003089_572654196107212_800720408_n.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `billing_info`
--

CREATE TABLE IF NOT EXISTS `billing_info` (
  `binfo_id` bigint(22) unsigned NOT NULL,
  `ord_id` bigint(22) unsigned DEFAULT NULL,
  `binfo_card_company` varchar(255) DEFAULT NULL,
  `binfo_card_number` varchar(50) DEFAULT NULL,
  `binfo_exp_date` varchar(255) DEFAULT NULL,
  `binfo_rec_name` varchar(255) NOT NULL,
  `binfo_rec_address1` varchar(255) NOT NULL,
  `binfo_rec_address2` varchar(100) NOT NULL,
  `binfo_rec_city` varchar(255) NOT NULL,
  `state_id` varchar(2) NOT NULL,
  `countries_id` int(11) unsigned NOT NULL,
  `binfo_reczip` varchar(255) NOT NULL,
  `binfo_rec_phone` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `billing_info`
--

INSERT INTO `billing_info` (`binfo_id`, `ord_id`, `binfo_card_company`, `binfo_card_number`, `binfo_exp_date`, `binfo_rec_name`, `binfo_rec_address1`, `binfo_rec_address2`, `binfo_rec_city`, `state_id`, `countries_id`, `binfo_reczip`, `binfo_rec_phone`) VALUES
(1, NULL, NULL, NULL, NULL, '', '', '', '', '', 0, '', ''),
(2, 6, 'dsd', 'dsd', '4-2011', 'sdsd', 'dsds', '', 'dsd', '0', 1, '3232', '000-000-0000');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` bigint(22) unsigned NOT NULL,
  `sess_id` varchar(255) NOT NULL,
  `cart_date` date NOT NULL,
  `cart_amount` float(8,2) unsigned NOT NULL,
  `cart_comments` text NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE IF NOT EXISTS `cart_items` (
  `citem_id` bigint(22) unsigned NOT NULL,
  `cart_id` bigint(22) unsigned NOT NULL,
  `pro_id` bigint(22) unsigned NOT NULL,
  `pro_name` varchar(255) NOT NULL,
  `pro_price` float(8,2) unsigned NOT NULL,
  `citem_quantity` int(11) NOT NULL,
  `citem_amount` float(8,2) unsigned NOT NULL,
  `citem_delivery_price` float(8,2) unsigned DEFAULT '0.00',
  PRIMARY KEY (`citem_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` bigint(22) unsigned NOT NULL DEFAULT '0',
  `cat_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `cat_details` text CHARACTER SET utf8,
  `status_id` int(11) unsigned DEFAULT '1',
  `cat_parentid` bigint(22) unsigned DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_details`, `status_id`, `cat_parentid`) VALUES
(1, 'Audio Tracks', 'Audio Tracks', 1, 0),
(2, 'Movies', 'Movies', 1, 0),
(3, 'Ringtones', 'Ringtones', 1, 0),
(4, 'Wallpapers', 'Wallpapers', 1, 0),
(5, 'Rock', 'Rock', 1, 1),
(6, 'Pop', 'Pop', 1, 1),
(11, 'Science', 'Science', 1, 2),
(8, 'Thrill', 'Thrill', 1, 2),
(9, 'Cellphone ringtones', 'Cellphone ringtones', 1, 3),
(10, 'Nature walls', 'Nature walls', 1, 4),
(12, 'Rain', 'Rain', 1, 4),
(13, 'Naats', 'Naats', 1, 1),
(19, 'Songs', 'Songs', 1, 1),
(18, 'Naats', 'Naats', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `categories_ln`
--

CREATE TABLE IF NOT EXISTS `categories_ln` (
  `cat_id` bigint(22) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(11) unsigned NOT NULL DEFAULT '1',
  `cat_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `cat_details` text CHARACTER SET utf8,
  PRIMARY KEY (`cat_id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `categories_ln`
--

INSERT INTO `categories_ln` (`cat_id`, `lang_id`, `cat_name`, `cat_details`) VALUES
(1, 1, 'Audios', 'Audios'),
(2, 1, 'Videos', 'Videos'),
(3, 1, 'Ringtones', 'Ringtones'),
(4, 1, 'Images', 'Images'),
(5, 1, 'Naats', 'Naats'),
(6, 1, 'Songs', 'Songs'),
(11, 1, 'Songs', 'Songs'),
(8, 1, 'Naats', 'Naats'),
(9, 1, 'Cellphone ringtones', 'Cellphone ringtones'),
(10, 1, 'Poerty Cards', 'Poerty Cards'),
(12, 1, 'Wallpapers', 'Wallpapers'),
(5, 2, 'Ù†Ø¹Øª', 'Ù†Ø¹Øª'),
(1, 2, 'Ø¢ÚˆÛŒÙˆ', 'Ø¢ÚˆÛŒÙˆ'),
(2, 2, 'ÙˆÛŒÚˆÛŒÙˆ', 'ÙˆÛŒÚˆÛŒÙˆ'),
(3, 2, 'Ø±Ù†Ú¯ Ù¹ÙˆÙ†Ø²', 'Ø±Ù†Ú¯ Ù¹ÙˆÙ†Ø²'),
(4, 2, 'ØªØµØ§ÙˆÛŒØ±', 'ØªØµØ§ÙˆÛŒØ±'),
(6, 2, 'Ù†ØºÙ…Û’', 'Ù†ØºÙ…Û’'),
(8, 2, 'Ù†Ø¹Øª', 'Ù†Ø¹Øª'),
(11, 2, 'Ù†ØºÙ…Û’', 'Ù†ØºÙ…Û’'),
(9, 2, 'Ù…ÙˆØ¨Ø§Ø¦Ù„ ÙÙˆÙ† Ø±Ù†Ú¯ Ù¹ÙˆÙ†Ø²', 'Ù…ÙˆØ¨Ø§Ø¦Ù„ ÙÙˆÙ† Ø±Ù†Ú¯ Ù¹ÙˆÙ†Ø²'),
(10, 2, 'Ø´Ø§Ø¹Ø±ÛŒ Ú©Ø§Ø±Úˆ', 'Ø´Ø§Ø¹Ø±ÛŒ Ú©Ø§Ø±Úˆ'),
(12, 2, 'ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø±', 'ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø±'),
(13, 1, 'Stage Dramas', 'Stage Dramas'),
(19, 1, 'Poetry', 'Poetry'),
(18, 1, 'Stage Dramas', 'Stage Dramas'),
(13, 2, 'Ø³Ù¹ÛŒØ¬ ÚˆØ±Ø§Ù…Û', 'Ø³Ù¹ÛŒØ¬ ÚˆØ±Ø§Ù…Û'),
(18, 2, 'Ø³Ù¹ÛŒØ¬ ÚˆØ±Ø§Ù…Û', 'Ø³Ù¹ÛŒØ¬ ÚˆØ±Ø§Ù…Û'),
(19, 2, 'Ø´Ø§Ø¹Ø±ÛŒ', 'Ø´Ø§Ø¹Ø±ÛŒ');

-- --------------------------------------------------------

--
-- Table structure for table `category_notifications`
--

CREATE TABLE IF NOT EXISTS `category_notifications` (
  `mem_id` bigint(22) unsigned NOT NULL,
  `cat_id` bigint(22) unsigned NOT NULL,
  PRIMARY KEY (`mem_id`,`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_notifications`
--

INSERT INTO `category_notifications` (`mem_id`, `cat_id`) VALUES
(1, 3),
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `cat_type`
--

CREATE TABLE IF NOT EXISTS `cat_type` (
  `ctype_id` bigint(22) unsigned NOT NULL DEFAULT '0',
  `ctype_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ctype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contact_us_request`
--

CREATE TABLE IF NOT EXISTS `contact_us_request` (
  `cu_id` bigint(22) unsigned NOT NULL,
  `is_viewed` tinyint(1) DEFAULT '0',
  `date` datetime DEFAULT NULL,
  `cu_name` varchar(255) DEFAULT NULL,
  `cu_email` varchar(255) DEFAULT NULL,
  `cu_phone` varchar(255) DEFAULT NULL,
  `cu_comment` tinytext,
  `lang_id` int(10) unsigned DEFAULT '1',
  PRIMARY KEY (`cu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_us_request`
--

INSERT INTO `contact_us_request` (`cu_id`, `is_viewed`, `date`, `cu_name`, `cu_email`, `cu_phone`, `cu_comment`, `lang_id`) VALUES
(4, 1, '2013-07-16 16:27:04', 'Aqeel Ashraf', 'aqeelashraf@gmail.com', '+92 300 4937847', 'This is text message', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE IF NOT EXISTS `contents` (
  `cnt_id` int(11) unsigned NOT NULL,
  `cnt_heading` varchar(255) DEFAULT NULL,
  `cnt_details` text,
  `cnt_title` varchar(255) DEFAULT NULL,
  `cnt_description` text,
  `cnt_keywords` varchar(255) DEFAULT NULL,
  `cnt_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cnt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`cnt_id`, `cnt_heading`, `cnt_details`, `cnt_title`, `cnt_description`, `cnt_keywords`, `cnt_file`) VALUES
(1, 'Welcome to Wap Portal', '', 'Welcome to Wap Portal', 'welcome to wap portal', 'Welcome to Wap Portal', NULL),
(2, 'About', '        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi</p> \r\n        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>', 'About', 'About', 'About', NULL),
(3, 'Register Details', '', 'Register', 'Register', 'Register', NULL),
(4, 'Login', '', 'Login', 'Login', 'Login', NULL),
(5, 'Audio Tracks', '', 'Audio Tracks', 'Audio Tracks', 'Audio Tracks', NULL),
(6, 'Movies', '', 'Movies', 'Movies', 'Movies', NULL),
(7, 'Ringtones', '', 'Ringtones', 'Ringtones', 'Ringtones', NULL),
(8, 'Wallpapers', '', 'Wallpapers', 'Wallpapers', 'Wallpapers', NULL),
(9, 'Contact Us', '', 'Contact Us', 'Contact Us', 'Contact Us', NULL),
(10, 'Change Password', '', 'Change Password', 'Change Password', 'Change Password', NULL),
(11, 'FAQ', '', 'FAQ', 'FAQ', 'FAQ', NULL),
(12, 'Search', '', 'Search', 'Search', 'Search', NULL),
(13, 'News', '', 'News', 'News', 'News', NULL),
(14, 'Forgot Password', '', 'Forgot Password', 'Forgot Password', 'Forgot Password', NULL),
(15, 'My Wishlist', '', 'My Wishlist', 'My Wishlist', 'My Wishlist', NULL),
(19, 'My Gifted Items', '', 'My Gifted Items', 'My Gifted Items', 'My Gifted Items', NULL),
(20, 'Details', '', 'Details', 'Details', 'Details', NULL),
(21, 'Buy Package', '', 'Buy Package', 'Buy Package', 'Buy Package', NULL),
(22, 'Dashboard', '', 'Dashboard', 'Dashboard', 'Dashboard', NULL),
(24, 'My Package History', '', 'My Package History', 'My Package History', 'My Package History', NULL),
(23, 'My Consumption History', '', 'My Consumption History', 'My Consumption History', 'My Consumption History', NULL),
(25, 'Convert Downloads and Streams', '', 'Convert Downloads and Streams', 'Convert Downloads and Streams', 'Convert Downloads and Streams', NULL),
(26, 'Set As Facebook Wallpaper', '', 'Set As Facebook Wallpaper', 'Set As Facebook Wallpaper', 'Set As Facebook Wallpaper', NULL),
(27, 'Set Notifiable Categories', '', 'Set Notifiable Categories', 'Set Notifiable Categories', 'Set Notifiable Categories', NULL),
(28, 'Product Details', '', 'Product Details', 'Product Details', 'Product Details', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contents_ln`
--

CREATE TABLE IF NOT EXISTS `contents_ln` (
  `cnt_id` int(11) unsigned NOT NULL,
  `lang_id` int(11) unsigned NOT NULL DEFAULT '1',
  `cnt_heading` varchar(255) DEFAULT NULL,
  `cnt_details` text,
  `cnt_title` varchar(255) DEFAULT NULL,
  `cnt_description` text,
  `cnt_keywords` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cnt_id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `contents_ln`
--

INSERT INTO `contents_ln` (`cnt_id`, `lang_id`, `cnt_heading`, `cnt_details`, `cnt_title`, `cnt_description`, `cnt_keywords`) VALUES
(1, 1, 'Welcome to Wap Portal', '', 'Welcome to Wap Portal', 'welcome to wap portal', 'Welcome to Wap Portal'),
(2, 1, 'About', '        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi</p> \r\n        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>', 'About', 'About', 'About'),
(3, 1, 'Register Details', '', 'Register Details', 'Register Details', 'Register Details'),
(4, 1, 'Login', '', 'Login', 'Login', 'Login'),
(5, 1, 'Audio Tracks', '', 'Audio Tracks', 'Audio Tracks', 'Audio Tracks'),
(6, 1, 'Movies', '', 'Movies', 'Movies', 'Movies'),
(7, 1, 'Ringtones', '', 'Ringtones', 'Ringtones', 'Ringtones'),
(8, 1, 'Wallpapers', '', 'Wallpapers', 'Wallpapers', 'Wallpapers'),
(9, 1, 'Contact Us', '', 'Contact Us', 'Contact Us', 'Contact Us'),
(10, 1, 'Change Password', '', 'Change Password', 'Change Password', 'Change Password'),
(11, 1, 'FAQ', '', 'FAQ', 'FAQ', 'FAQ'),
(12, 1, 'Search', '', 'Search', 'Search', 'Search'),
(13, 1, 'News', '', 'News', 'News', 'News'),
(14, 1, 'Forgot Password', '', 'Forgot Password', 'Forgot Password', 'Forgot Password'),
(15, 1, 'My Wishlist', '', 'My Wishlist', 'My Wishlist', 'My Wishlist'),
(19, 1, 'My Gifted Items', '', 'My Gifted Items', 'My Gifted Items', 'My Gifted Items'),
(20, 1, 'Details', '', 'Details', 'Details', 'Details'),
(21, 1, 'Buy Package', '', 'Buy Package', 'Buy Package', 'Buy Package'),
(22, 1, 'Dashboard', '', 'Dashboard', 'Dashboard', 'Dashboard'),
(24, 1, 'My Package History', '', 'My Package History', 'My Package History', 'My Package History'),
(23, 1, 'My Consumption History', '', 'My Consumption History', 'My Consumption History', 'My Consumption History'),
(1, 2, 'WAP Ù¾ÙˆØ±Ù¹Ù„ Ù…ÛŒÚº Ø®ÙˆØ´ Ø¢Ù…Ø¯ÛŒØ¯ ', '', 'WAP Ù¾ÙˆØ±Ù¹Ù„ Ù…ÛŒÚº Ø®ÙˆØ´ Ø¢Ù…Ø¯ÛŒØ¯', 'WAP Ù¾ÙˆØ±Ù¹Ù„ Ù…ÛŒÚº Ø®ÙˆØ´ Ø¢Ù…Ø¯ÛŒØ¯', 'WAP Ù¾ÙˆØ±Ù¹Ù„ Ù…ÛŒÚº Ø®ÙˆØ´ Ø¢Ù…Ø¯ÛŒØ¯'),
(2, 2, 'Ø¨Ø§Ø±Û’ Ù…ÛŒÚº', 'ÛÙ… Ù†Û’ Ø§ÛŒÚ© Ø¯Ø±Ø¬Û Ø¨Ù†Ø¯ÛŒ Ú©Ùˆ Ú†Ú¾ÙˆÚ‘Ù†Û’ Ú©Û’ Ù„Ø¦Û’ Ø§Ø³ Ø¨Ø§Øª Ú©Ø§ ÛŒÙ‚ÛŒÙ† ÛÙˆØŒ Ø¨Ù„Ú©Û Ø¬Ù…Ù„Û Ø§Ø³ ØµÙØ­Û’ Ù¾Ø± Ú©Ø§Ù„Ù… Ø¨ÛØ§Ø¤ Ú©Û’ Ø§Ù†ØªØ¸Ø§Ù… Ø§ÙˆØ± Ù‚Ø§Ø¨Ù„ Ø§Ø¹ØªÙ…Ø§Ø¯ Ù…Ù„Û’ Ú¯Ø§. Ø§ÛŒÚ© Ú†Ú¾ÙˆÙ¹ÛŒ Ø³ÛŒ Ù…Ø«Ø§Ù„ Ú©Û’ Ø·ÙˆØ± Ù¾Ø± Ú©Û’ Ø¹Ù„Ø§ÙˆÛ Ù…ÛŒÚºØŒ ÛÙ…ÛŒÚº Ø§Ø³ Ú©Û’ Ø¬Ø³ Ù…ØªÙ† ÙØ§Ø±Ù… Ú©ÛŒ Ù¹ÙˆÚ©Ø±ÛŒ Ù…ÛŒÚº Ø´Ø§Ù…Ù„ ÛÙˆÙ†Û’ Ú©ÛŒ ØµÙˆØ±Øª Ù…ÛŒÚº Ø°ÛŒÙ„ Ù…ÛŒÚº Ø³Û’ Ø§Ù† Ù…Ø±Ø¯ÙˆÚº Ù…ÛŒÚº Ø³Û’ Ú©Ú†Ú¾. Ú©ÙˆØ¦ÛŒ Ù…Ø§Ù„ Ú©ÛŒ Ú‘Ù„Ø§Ø¦ Ø§Ø³ Ù…ØªÙ† Ú©Ùˆ Ù…Ù†ØªØ®Ø¨ Ú©Ø±ÛŒÚº Ø§ÙˆØ± ØµØ±Ù rghit pclae Ù…Ø¹Ù„ÙˆÙ…Ø§Øª Ù…ÛŒÚº zzril duis Ø¯Ø±Ø¯ Ù„Ø§Ø¦Ø³Ù†Ø³ ÛŒØ§ÙØªÛ ÛÛ’ Ø§ÛŒÚ© Ú©Û’ Ù„Ø¦Û’ ØªÛŒØ§Ø± Ø§Ø«Ø§Ø«Û Ù‚ÛŒÙ…Øª Ú©ÛŒ Ú©Ù…ÛŒ Ú©ÛŒ ÙˆØ¬Û Ø³Û’ Ù†ÙØ±Øª Ú©Ø±ØªÛ’ ÛÛŒÚº Ø¬Ùˆ Ù†ÛÛŒÚº ÛÛ’ Ù…ÛŒÚº ØªØ±Ù…ÛŒÙ… Ú©Ø±ÛŒÚº ÛŒØ§ Ø§ÙˆÙ„Ù…Ù¾Ú© Ù¾Ø±ÛŒØ´Ø§Ù† Ú©Ù† Ù†ØªØ§Ø¦Ø¬ØŒ ÛŒØ§ Ù¾ÛŒÙ…Ø§Ù†Û’ Ù¾Ø± Ú©ÛŒ Ø§ÛŒÚ© Ø±ÛŒÙ†Ø¬ Ù…ÛŒÚº Ø³Û’ Ø§ÛŒÚ© Ù…ÛŒÚº Ù…Ø³ØªÙ‚Ø¨Ù„ Ù‚Ø±ÛŒØ¨ Ù…ÛŒÚº Ø¯Ø±Ø¯ ÛÙˆÙ†Ø§ Ú†Ø§ÛØªÛ’ ÛÛŒÚº Ù…ÛŒÚº ØªÙ„Ø§Ø´ Ú©Ø±ÛŒÚº\r\nÛÙ… Ù†Û’ Ø§ÛŒÚ© Ø¯Ø±Ø¬Û Ø¨Ù†Ø¯ÛŒ Ú©Ùˆ Ú†Ú¾ÙˆÚ‘Ù†Û’ Ú©Û’ Ù„Ø¦Û’ Ø§Ø³ Ø¨Ø§Øª Ú©Ø§ ÛŒÙ‚ÛŒÙ† ÛÙˆØŒ Ø¨Ù„Ú©Û Ø¬Ù…Ù„Û Ø§Ø³ ØµÙØ­Û’ Ù¾Ø± Ú©Ø§Ù„Ù… Ø¨ÛØ§Ø¤ Ú©Û’ Ø§Ù†ØªØ¸Ø§Ù… Ø§ÙˆØ± Ù‚Ø§Ø¨Ù„ Ø§Ø¹ØªÙ…Ø§Ø¯ Ù…Ù„Û’ Ú¯Ø§. Ø§ÛŒÚ© Ú†Ú¾ÙˆÙ¹ÛŒ Ø³ÛŒ Ù…Ø«Ø§Ù„ Ú©Û’ Ø·ÙˆØ± Ù¾Ø± Ú©Û’ Ø¹Ù„Ø§ÙˆÛ Ù…ÛŒÚºØŒ ÛÙ…ÛŒÚº Ø§Ø³ Ú©Û’ Ø¬Ø³ Ù…ØªÙ† ÙØ§Ø±Ù… Ú©ÛŒ Ù¹ÙˆÚ©Ø±ÛŒ Ù…ÛŒÚº Ø´Ø§Ù…Ù„ ÛÙˆÙ†Û’ Ú©ÛŒ ØµÙˆØ±Øª Ù…ÛŒÚº Ø°ÛŒÙ„ Ù…ÛŒÚº Ø³Û’ Ø§Ù† Ù…Ø±Ø¯ÙˆÚº Ù…ÛŒÚº Ø³Û’ Ú©Ú†Ú¾.', 'Ø¨Ø§Ø±Û’ Ù…ÛŒÚº', 'Ø¨Ø§Ø±Û’ Ù…ÛŒÚº', 'Ø¨Ø§Ø±Û’ Ù…ÛŒÚº'),
(3, 2, 'ØªÙØµÛŒÙ„Ø§Øª Ø±Ø¬Ø³Ù¹Ø±', '', 'ØªÙØµÛŒÙ„Ø§Øª Ø±Ø¬Ø³Ù¹Ø±', 'ØªÙØµÛŒÙ„Ø§Øª Ø±Ø¬Ø³Ù¹Ø±', 'ØªÙØµÛŒÙ„Ø§Øª Ø±Ø¬Ø³Ù¹Ø±'),
(4, 2, 'Ù„Ø§Ú¯ Ø§Ù†', '', 'Ù„Ø§Ú¯ Ø§Ù†', 'Ù„Ø§Ú¯ Ø§Ù†', 'Ù„Ø§Ú¯ Ø§Ù†'),
(5, 2, 'Ø¢ÚˆÛŒÙˆ Ù¹Ø±ÛŒÚ©Ø³', '', 'Ø¢ÚˆÛŒÙˆ Ù¹Ø±ÛŒÚ©Ø³', 'Ø¢ÚˆÛŒÙˆ Ù¹Ø±ÛŒÚ©Ø³', 'Ø¢ÚˆÛŒÙˆ Ù¹Ø±ÛŒÚ©Ø³'),
(6, 2, 'ÙÙ„Ù…ÙˆÚº', '', 'ÙÙ„Ù…ÙˆÚº', 'ÙÙ„Ù…ÙˆÚº', 'ÙÙ„Ù…ÙˆÚº'),
(7, 2, 'Ø±Ù†Ú¯ Ù¹ÙˆÙ†Ø²', '', 'Ø±Ù†Ú¯ Ù¹ÙˆÙ†Ø²', 'Ø±Ù†Ú¯ Ù¹ÙˆÙ†Ø²', 'Ø±Ù†Ú¯ Ù¹ÙˆÙ†Ø²'),
(8, 2, 'ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø±', '', 'ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø±', 'ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø±', 'ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø±'),
(9, 2, 'ÛÙ… Ø³Û’ Ø±Ø§Ø¨Ø·Û Ú©Ø±ÛŒÚº', '', 'ÛÙ… Ø³Û’ Ø±Ø§Ø¨Ø·Û Ú©Ø±ÛŒÚº', 'ÛÙ… Ø³Û’ Ø±Ø§Ø¨Ø·Û Ú©Ø±ÛŒÚº', 'ÛÙ… Ø³Û’ Ø±Ø§Ø¨Ø·Û Ú©Ø±ÛŒÚº'),
(10, 2, 'Ù¾Ø§Ø³ ÙˆØ±Úˆ ØªØ¨Ø¯ÛŒÙ„ Ú©Ø±ÛŒÚº', '', 'Ù¾Ø§Ø³ ÙˆØ±Úˆ ØªØ¨Ø¯ÛŒÙ„ Ú©Ø±ÛŒÚº', 'Ù¾Ø§Ø³ ÙˆØ±Úˆ ØªØ¨Ø¯ÛŒÙ„ Ú©Ø±ÛŒÚº', 'Ù¾Ø§Ø³ ÙˆØ±Úˆ ØªØ¨Ø¯ÛŒÙ„ Ú©Ø±ÛŒÚº'),
(11, 2, 'Ø³ÙˆØ§Ù„Ø§Øª', '', 'Ø³ÙˆØ§Ù„Ø§Øª', 'Ø³ÙˆØ§Ù„Ø§Øª', 'Ø³ÙˆØ§Ù„Ø§Øª'),
(12, 2, 'ØªÙ„Ø§Ø´', '', 'ØªÙ„Ø§Ø´', 'ØªÙ„Ø§Ø´', 'ØªÙ„Ø§Ø´'),
(13, 2, 'Ø®Ø¨Ø±', '', 'Ø®Ø¨Ø±', 'Ø®Ø¨Ø±', 'Ø®Ø¨Ø±'),
(14, 2, 'Ù¾Ø§Ø³ ÙˆØ±Úˆ Ø¨Ú¾ÙˆÙ„ Ú¯ÛŒØ§', '', 'Ù¾Ø§Ø³ ÙˆØ±Úˆ Ø¨Ú¾ÙˆÙ„ Ú¯ÛŒØ§', 'Ù¾Ø§Ø³ ÙˆØ±Úˆ Ø¨Ú¾ÙˆÙ„ Ú¯ÛŒØ§', 'Ù¾Ø§Ø³ ÙˆØ±Úˆ Ø¨Ú¾ÙˆÙ„ Ú¯ÛŒØ§'),
(15, 2, 'Ù…ÛŒØ±ÛŒ Ø®ÙˆØ§ÛØ´ Ú©ÛŒ ÙÛØ±Ø³Øª', '', 'Ù…ÛŒØ±ÛŒ Ø®ÙˆØ§ÛØ´ Ú©ÛŒ ÙÛØ±Ø³Øª', 'Ù…ÛŒØ±ÛŒ Ø®ÙˆØ§ÛØ´ Ú©ÛŒ ÙÛØ±Ø³Øª', 'Ù…ÛŒØ±ÛŒ Ø®ÙˆØ§ÛØ´ Ú©ÛŒ ÙÛØ±Ø³Øª'),
(19, 2, 'Ù…ÛŒØ±Ø§ ØªØ­ÙÛ’ Ø§Ø´ÛŒØ§Ø¡', '', 'Ù…ÛŒØ±Ø§ ØªØ­ÙÛ’ Ø§Ø´ÛŒØ§Ø¡', 'Ù…ÛŒØ±Ø§ ØªØ­ÙÛ’ Ø§Ø´ÛŒØ§Ø¡', 'Ù…ÛŒØ±Ø§ ØªØ­ÙÛ’ Ø§Ø´ÛŒØ§Ø¡'),
(20, 2, 'ØªÙØµÛŒÙ„Ø§Øª', '', 'ØªÙØµÛŒÙ„Ø§Øª', 'ØªÙØµÛŒÙ„Ø§Øª', 'ØªÙØµÛŒÙ„Ø§Øª'),
(21, 2, 'Ù¾ÛŒÚ©Ø¬ Ø®Ø±ÛŒØ¯Ù†Û’', '', 'Ù¾ÛŒÚ©Ø¬ Ø®Ø±ÛŒØ¯Ù†Û’', 'Ù¾ÛŒÚ©Ø¬ Ø®Ø±ÛŒØ¯Ù†Û’', 'Ù¾ÛŒÚ©Ø¬ Ø®Ø±ÛŒØ¯Ù†Û’'),
(22, 2, 'ÚˆÛŒØ´ Ø¨ÙˆØ±Úˆ', '', 'ÚˆÛŒØ´ Ø¨ÙˆØ±Úˆ', 'ÚˆÛŒØ´ Ø¨ÙˆØ±Úˆ', 'ÚˆÛŒØ´ Ø¨ÙˆØ±Úˆ'),
(23, 2, 'Ù…ÛŒØ±ÛŒ Ú©Ú¾Ù¾Øª Ú©ÛŒ ØªØ§Ø±ÛŒØ®', '', 'Ù…ÛŒØ±ÛŒ Ú©Ú¾Ù¾Øª Ú©ÛŒ ØªØ§Ø±ÛŒØ®', 'Ù…ÛŒØ±ÛŒ Ú©Ú¾Ù¾Øª Ú©ÛŒ ØªØ§Ø±ÛŒØ®', 'Ù…ÛŒØ±ÛŒ Ú©Ú¾Ù¾Øª Ú©ÛŒ ØªØ§Ø±ÛŒØ®'),
(24, 2, 'Ù…ÛŒØ±ÛŒ Ù¾ÛŒÚ©Ø¬ Ú©ÛŒ ØªØ§Ø±ÛŒØ®', '', 'Ù…ÛŒØ±ÛŒ Ù¾ÛŒÚ©Ø¬ Ú©ÛŒ ØªØ§Ø±ÛŒØ®', 'Ù…ÛŒØ±ÛŒ Ù¾ÛŒÚ©Ø¬ Ú©ÛŒ ØªØ§Ø±ÛŒØ®', 'Ù…ÛŒØ±ÛŒ Ù¾ÛŒÚ©Ø¬ Ú©ÛŒ ØªØ§Ø±ÛŒØ®'),
(25, 2, 'ØªØ¨Ø¯ÛŒÙ„ Ù…Ù‚Ø¨ÙˆÙ„ÛŒØª Ø§ÙˆØ± Ø³Ù„Ø³Ù„Û’', '', 'ØªØ¨Ø¯ÛŒÙ„ Ù…Ù‚Ø¨ÙˆÙ„ÛŒØª Ø§ÙˆØ± Ø³Ù„Ø³Ù„Û’', 'ØªØ¨Ø¯ÛŒÙ„ Ù…Ù‚Ø¨ÙˆÙ„ÛŒØª Ø§ÙˆØ± Ø³Ù„Ø³Ù„Û’', 'ØªØ¨Ø¯ÛŒÙ„ Ù…Ù‚Ø¨ÙˆÙ„ÛŒØª Ø§ÙˆØ± Ø³Ù„Ø³Ù„Û’'),
(25, 1, 'Convert Downloads and Streams', '', 'Convert Downloads and Streams', 'Convert Downloads and Streams', 'Convert Downloads and Streams'),
(26, 1, 'Set As Facebook Wallpaper', '', 'Set As Facebook Wallpaper', 'Set As Facebook Wallpaper', 'Set As Facebook Wallpaper'),
(27, 1, 'Set Notifiable Categories', '', 'Set Notifiable Categories', 'Set Notifiable Categories', 'Set Notifiable Categories'),
(26, 2, 'ÙÛŒØ³ Ø¨Ú© Ú©Û’ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø± Ú©Û’ Ø·ÙˆØ± Ù¾Ø± Ù…Ù‚Ø±Ø± Ú©Ø±ÛŒÚº', '', 'ÙÛŒØ³ Ø¨Ú© Ú©Û’ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø± Ú©Û’ Ø·ÙˆØ± Ù¾Ø± Ù…Ù‚Ø±Ø± Ú©Ø±ÛŒÚº', 'ÙÛŒØ³ Ø¨Ú© Ú©Û’ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø± Ú©Û’ Ø·ÙˆØ± Ù¾Ø± Ù…Ù‚Ø±Ø± Ú©Ø±ÛŒÚº', 'ÙÛŒØ³ Ø¨Ú© Ú©Û’ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø± Ú©Û’ Ø·ÙˆØ± Ù¾Ø± Ù…Ù‚Ø±Ø± Ú©Ø±ÛŒÚº'),
(27, 2, 'Ù…Ù‚Ø±Ø± Notifiable Ø²Ù…Ø±Û Ø¬Ø§Øª', '', 'Ù…Ù‚Ø±Ø± Notifiable Ø²Ù…Ø±Û Ø¬Ø§Øª', 'Ù…Ù‚Ø±Ø± Notifiable Ø²Ù…Ø±Û Ø¬Ø§Øª', 'Ù…Ù‚Ø±Ø± Notifiable Ø²Ù…Ø±Û Ø¬Ø§Øª'),
(28, 1, 'Product Details', '', 'Product Details', 'Product Details', 'Product Details');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `countries_id` int(11) NOT NULL AUTO_INCREMENT,
  `countries_name` varchar(64) NOT NULL DEFAULT '',
  `countries_iso_code_2` char(2) NOT NULL DEFAULT '',
  `countries_iso_code_3` char(3) NOT NULL DEFAULT '',
  `address_format_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`countries_id`),
  KEY `IDX_COUNTRIES_NAME` (`countries_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=240 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`countries_id`, `countries_name`, `countries_iso_code_2`, `countries_iso_code_3`, `address_format_id`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', 1),
(2, 'Albania', 'AL', 'ALB', 1),
(3, 'Algeria', 'DZ', 'DZA', 1),
(4, 'American Samoa', 'AS', 'ASM', 1),
(5, 'Andorra', 'AD', 'AND', 1),
(6, 'Angola', 'AO', 'AGO', 1),
(7, 'Anguilla', 'AI', 'AIA', 1),
(8, 'Antarctica', 'AQ', 'ATA', 1),
(9, 'Antigua and Barbuda', 'AG', 'ATG', 1),
(10, 'Argentina', 'AR', 'ARG', 1),
(11, 'Armenia', 'AM', 'ARM', 1),
(12, 'Aruba', 'AW', 'ABW', 1),
(13, 'Australia', 'AU', 'AUS', 1),
(14, 'Austria', 'AT', 'AUT', 5),
(15, 'Azerbaijan', 'AZ', 'AZE', 1),
(16, 'Bahamas', 'BS', 'BHS', 1),
(17, 'Bahrain', 'BH', 'BHR', 1),
(18, 'Bangladesh', 'BD', 'BGD', 1),
(19, 'Barbados', 'BB', 'BRB', 1),
(20, 'Belarus', 'BY', 'BLR', 1),
(21, 'Belgium', 'BE', 'BEL', 1),
(22, 'Belize', 'BZ', 'BLZ', 1),
(23, 'Benin', 'BJ', 'BEN', 1),
(24, 'Bermuda', 'BM', 'BMU', 1),
(25, 'Bhutan', 'BT', 'BTN', 1),
(26, 'Bolivia', 'BO', 'BOL', 1),
(27, 'Bosnia and Herzegowina', 'BA', 'BIH', 1),
(28, 'Botswana', 'BW', 'BWA', 1),
(29, 'Bouvet Island', 'BV', 'BVT', 1),
(30, 'Brazil', 'BR', 'BRA', 1),
(31, 'British Indian Ocean \r\n\r\nTerritory', 'IO', 'IOT', 1),
(32, 'Brunei Darussalam', 'BN', 'BRN', 1),
(33, 'Bulgaria', 'BG', 'BGR', 1),
(34, 'Burkina Faso', 'BF', 'BFA', 1),
(35, 'Burundi', 'BI', 'BDI', 1),
(36, 'Cambodia', 'KH', 'KHM', 1),
(37, 'Cameroon', 'CM', 'CMR', 1),
(38, 'Canada', 'CA', 'CAN', 1),
(39, 'Cape Verde', 'CV', 'CPV', 1),
(40, 'Cayman Islands', 'KY', 'CYM', 1),
(41, 'Central African Republic', 'CF', 'CAF', 1),
(42, 'Chad', 'TD', 'TCD', 1),
(43, 'Chile', 'CL', 'CHL', 1),
(44, 'China', 'CN', 'CHN', 1),
(45, 'Christmas Island', 'CX', 'CXR', 1),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', 1),
(47, 'Colombia', 'CO', 'COL', 1),
(48, 'Comoros', 'KM', 'COM', 1),
(49, 'Congo', 'CG', 'COG', 1),
(50, 'Cook Islands', 'CK', 'COK', 1),
(51, 'Costa Rica', 'CR', 'CRI', 1),
(52, 'Cote D''Ivoire', 'CI', 'CIV', 1),
(53, 'Croatia', 'HR', 'HRV', 1),
(54, 'Cuba', 'CU', 'CUB', 1),
(55, 'Cyprus', 'CY', 'CYP', 1),
(56, 'Czech Republic', 'CZ', 'CZE', 1),
(57, 'Denmark', 'DK', 'DNK', 1),
(58, 'Djibouti', 'DJ', 'DJI', 1),
(59, 'Dominica', 'DM', 'DMA', 1),
(60, 'Dominican Republic', 'DO', 'DOM', 1),
(61, 'East Timor', 'TP', 'TMP', 1),
(62, 'Ecuador', 'EC', 'ECU', 1),
(63, 'Egypt', 'EG', 'EGY', 1),
(64, 'El Salvador', 'SV', 'SLV', 1),
(65, 'Equatorial Guinea', 'GQ', 'GNQ', 1),
(66, 'Eritrea', 'ER', 'ERI', 1),
(67, 'Estonia', 'EE', 'EST', 1),
(68, 'Ethiopia', 'ET', 'ETH', 1),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', 1),
(70, 'Faroe Islands', 'FO', 'FRO', 1),
(71, 'Fiji', 'FJ', 'FJI', 1),
(72, 'Finland', 'FI', 'FIN', 1),
(73, 'France', 'FR', 'FRA', 1),
(74, 'France, Metropolitan', 'FX', 'FXX', 1),
(75, 'French Guiana', 'GF', 'GUF', 1),
(76, 'French Polynesia', 'PF', 'PYF', 1),
(77, 'French Southern Territories', 'TF', 'ATF', 1),
(78, 'Gabon', 'GA', 'GAB', 1),
(79, 'Gambia', 'GM', 'GMB', 1),
(80, 'Georgia', 'GE', 'GEO', 1),
(81, 'Germany', 'DE', 'DEU', 5),
(82, 'Ghana', 'GH', 'GHA', 1),
(83, 'Gibraltar', 'GI', 'GIB', 1),
(84, 'Greece', 'GR', 'GRC', 1),
(85, 'Greenland', 'GL', 'GRL', 1),
(86, 'Grenada', 'GD', 'GRD', 1),
(87, 'Guadeloupe', 'GP', 'GLP', 1),
(88, 'Guam', 'GU', 'GUM', 1),
(89, 'Guatemala', 'GT', 'GTM', 1),
(90, 'Guinea', 'GN', 'GIN', 1),
(91, 'Guinea-bissau', 'GW', 'GNB', 1),
(92, 'Guyana', 'GY', 'GUY', 1),
(93, 'Haiti', 'HT', 'HTI', 1),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD', 1),
(95, 'Honduras', 'HN', 'HND', 1),
(96, 'Hong Kong', 'HK', 'HKG', 1),
(97, 'Hungary', 'HU', 'HUN', 1),
(98, 'Iceland', 'IS', 'ISL', 1),
(99, 'India', 'IN', 'IND', 1),
(100, 'Indonesia', 'ID', 'IDN', 1),
(101, 'Iran (Islamic Republic of)', 'IR', 'IRN', 1),
(102, 'Iraq', 'IQ', 'IRQ', 1),
(103, 'Ireland', 'IE', 'IRL', 1),
(104, 'Israel', 'IL', 'ISR', 1),
(105, 'Italy', 'IT', 'ITA', 1),
(106, 'Jamaica', 'JM', 'JAM', 1),
(107, 'Japan', 'JP', 'JPN', 1),
(108, 'Jordan', 'JO', 'JOR', 1),
(109, 'Kazakhstan', 'KZ', 'KAZ', 1),
(110, 'Kenya', 'KE', 'KEN', 1),
(111, 'Kiribati', 'KI', 'KIR', 1),
(112, 'Korea, Democratic People''s \r\n\r\nRepublic of', 'KP', 'PRK', 1),
(113, 'Korea, Republic of', 'KR', 'KOR', 1),
(114, 'Kuwait', 'KW', 'KWT', 1),
(115, 'Kyrgyzstan', 'KG', 'KGZ', 1),
(116, 'Lao People''s Democratic \r\n\r\nRepublic', 'LA', 'LAO', 1),
(117, 'Latvia', 'LV', 'LVA', 1),
(118, 'Lebanon', 'LB', 'LBN', 1),
(119, 'Lesotho', 'LS', 'LSO', 1),
(120, 'Liberia', 'LR', 'LBR', 1),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', 1),
(122, 'Liechtenstein', 'LI', 'LIE', 1),
(123, 'Lithuania', 'LT', 'LTU', 1),
(124, 'Luxembourg', 'LU', 'LUX', 1),
(125, 'Macau', 'MO', 'MAC', 1),
(126, 'Macedonia, The Former Yugoslav \r\n\r\nRepublic of', 'MK', 'MKD', 1),
(127, 'Madagascar', 'MG', 'MDG', 1),
(128, 'Malawi', 'MW', 'MWI', 1),
(129, 'Malaysia', 'MY', 'MYS', 1),
(130, 'Maldives', 'MV', 'MDV', 1),
(131, 'Mali', 'ML', 'MLI', 1),
(132, 'Malta', 'MT', 'MLT', 1),
(133, 'Marshall Islands', 'MH', 'MHL', 1),
(134, 'Martinique', 'MQ', 'MTQ', 1),
(135, 'Mauritania', 'MR', 'MRT', 1),
(136, 'Mauritius', 'MU', 'MUS', 1),
(137, 'Mayotte', 'YT', 'MYT', 1),
(138, 'Mexico', 'MX', 'MEX', 1),
(139, 'Micronesia, Federated States \r\n\r\nof', 'FM', 'FSM', 1),
(140, 'Moldova, Republic of', 'MD', 'MDA', 1),
(141, 'Monaco', 'MC', 'MCO', 1),
(142, 'Mongolia', 'MN', 'MNG', 1),
(143, 'Montserrat', 'MS', 'MSR', 1),
(144, 'Morocco', 'MA', 'MAR', 1),
(145, 'Mozambique', 'MZ', 'MOZ', 1),
(146, 'Myanmar', 'MM', 'MMR', 1),
(147, 'Namibia', 'NA', 'NAM', 1),
(148, 'Nauru', 'NR', 'NRU', 1),
(149, 'Nepal', 'NP', 'NPL', 1),
(150, 'Netherlands', 'NL', 'NLD', 1),
(151, 'Netherlands Antilles', 'AN', 'ANT', 1),
(152, 'New Caledonia', 'NC', 'NCL', 1),
(153, 'New Zealand', 'NZ', 'NZL', 1),
(154, 'Nicaragua', 'NI', 'NIC', 1),
(155, 'Niger', 'NE', 'NER', 1),
(156, 'Nigeria', 'NG', 'NGA', 1),
(157, 'Niue', 'NU', 'NIU', 1),
(158, 'Norfolk Island', 'NF', 'NFK', 1),
(159, 'Northern Mariana Islands', 'MP', 'MNP', 1),
(160, 'Norway', 'NO', 'NOR', 1),
(161, 'Oman', 'OM', 'OMN', 1),
(162, 'Pakistan', 'PK', 'PAK', 1),
(163, 'Palau', 'PW', 'PLW', 1),
(164, 'Panama', 'PA', 'PAN', 1),
(165, 'Papua New Guinea', 'PG', 'PNG', 1),
(166, 'Paraguay', 'PY', 'PRY', 1),
(167, 'Peru', 'PE', 'PER', 1),
(168, 'Philippines', 'PH', 'PHL', 1),
(169, 'Pitcairn', 'PN', 'PCN', 1),
(170, 'Poland', 'PL', 'POL', 1),
(171, 'Portugal', 'PT', 'PRT', 1),
(172, 'Puerto Rico', 'PR', 'PRI', 1),
(173, 'Qatar', 'QA', 'QAT', 1),
(174, 'Reunion', 'RE', 'REU', 1),
(175, 'Romania', 'RO', 'ROM', 1),
(176, 'Russian Federation', 'RU', 'RUS', 1),
(177, 'Rwanda', 'RW', 'RWA', 1),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', 1),
(179, 'Saint Lucia', 'LC', 'LCA', 1),
(180, 'Saint Vincent and the \r\n\r\nGrenadines', 'VC', 'VCT', 1),
(181, 'Samoa', 'WS', 'WSM', 1),
(182, 'San Marino', 'SM', 'SMR', 1),
(183, 'Sao Tome and Principe', 'ST', 'STP', 1),
(184, 'Saudi Arabia', 'SA', 'SAU', 1),
(185, 'Senegal', 'SN', 'SEN', 1),
(186, 'Seychelles', 'SC', 'SYC', 1),
(187, 'Sierra Leone', 'SL', 'SLE', 1),
(188, 'Singapore', 'SG', 'SGP', 4),
(189, 'Slovakia (Slovak Republic)', 'SK', 'SVK', 1),
(190, 'Slovenia', 'SI', 'SVN', 1),
(191, 'Solomon Islands', 'SB', 'SLB', 1),
(192, 'Somalia', 'SO', 'SOM', 1),
(193, 'South Africa', 'ZA', 'ZAF', 1),
(194, 'South Georgia and the South \r\n\r\nSandwich Islands', 'GS', 'SGS', 1),
(195, 'Spain', 'ES', 'ESP', 3),
(196, 'Sri Lanka', 'LK', 'LKA', 1),
(197, 'St. Helena', 'SH', 'SHN', 1),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', 1),
(199, 'Sudan', 'SD', 'SDN', 1),
(200, 'Suriname', 'SR', 'SUR', 1),
(201, 'Svalbard and Jan Mayen \r\n\r\nIslands', 'SJ', 'SJM', 1),
(202, 'Swaziland', 'SZ', 'SWZ', 1),
(203, 'Sweden', 'SE', 'SWE', 1),
(204, 'Switzerland', 'CH', 'CHE', 1),
(205, 'Syrian Arab Republic', 'SY', 'SYR', 1),
(206, 'Taiwan', 'TW', 'TWN', 1),
(207, 'Tajikistan', 'TJ', 'TJK', 1),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA', 1),
(209, 'Thailand', 'TH', 'THA', 1),
(210, 'Togo', 'TG', 'TGO', 1),
(211, 'Tokelau', 'TK', 'TKL', 1),
(212, 'Tonga', 'TO', 'TON', 1),
(213, 'Trinidad and Tobago', 'TT', 'TTO', 1),
(214, 'Tunisia', 'TN', 'TUN', 1),
(215, 'Turkey', 'TR', 'TUR', 1),
(216, 'Turkmenistan', 'TM', 'TKM', 1),
(217, 'Turks and Caicos Islands', 'TC', 'TCA', 1),
(218, 'Tuvalu', 'TV', 'TUV', 1),
(219, 'Uganda', 'UG', 'UGA', 1),
(220, 'Ukraine', 'UA', 'UKR', 1),
(221, 'United Arab Emirates', 'AE', 'ARE', 1),
(222, 'United Kingdom', 'GB', 'GBR', 1),
(223, 'United States', 'US', 'USA', 2),
(224, 'United States Minor Outlying \r\n\r\nIslands', 'UM', 'UMI', 1),
(225, 'Uruguay', 'UY', 'URY', 1),
(226, 'Uzbekistan', 'UZ', 'UZB', 1),
(227, 'Vanuatu', 'VU', 'VUT', 1),
(228, 'Vatican City State (Holy \r\n\r\nSee)', 'VA', 'VAT', 1),
(229, 'Venezuela', 'VE', 'VEN', 1),
(230, 'Viet Nam', 'VN', 'VNM', 1),
(231, 'Virgin Islands (British)', 'VG', 'VGB', 1),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', 1),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF', 1),
(234, 'Western Sahara', 'EH', 'ESH', 1),
(235, 'Yemen', 'YE', 'YEM', 1),
(236, 'Yugoslavia', 'YU', 'YUG', 1),
(237, 'Zaire', 'ZR', 'ZAR', 1),
(238, 'Zambia', 'ZM', 'ZMB', 1),
(239, 'Zimbabwe', 'ZW', 'ZWE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE IF NOT EXISTS `faqs` (
  `faq_id` bigint(22) unsigned NOT NULL DEFAULT '0',
  `faq_question` varchar(255) DEFAULT NULL,
  `faq_answer` text,
  PRIMARY KEY (`faq_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`faq_id`, `faq_question`, `faq_answer`) VALUES
(7, 'What are the main requirements?', '$50,000 Annualized income and selecting a home with 30% equity after repairs are completed'),
(8, 'What should I bring?', 'The advertised home has been identified as an outstanding below market opportunity that we would be willing to purchase and owner finance to a strong income family. The status of the home is active at the time of posting but it quickly changes to a pending sales status because homes that are 30% or more below market are quickly recognized by other sharp people who submit an offer. It is important to act quickly when you find a great deal. The only way to confirm availability is to call the listing agent or the seller.'),
(9, 'Is the house advertised still available?', 'The advertised home has been identified as an outstanding below market opportunity that we would be willing to purchase and owner finance to a strong income family. The status of the home is active at the time of posting but it quickly changes to a pending sales status because homes that are 30% or more below market are quickly recognized by other sharp people who submit an offer. It is important to act quickly when you find a great deal. The only way to confirm availability is to call the listing agent or the seller.'),
(10, 'Could I become an Investor and make money by participating in socially responsible investing?', 'Yes, you can. Step #1 is to view a live home buyer presentation and then everything will begin to make sense. Step #2 is to view an investor presentation and then everything is a rubber stamp process. We do the same thing over and over.'),
(11, 'Can I bring my own investor?', 'Absolutely. Your potential investor needs to view our income based home buyer presentation on how the program works. Set an appointment for them to come in with you. We can get them pre-approved within 48 hours.'),
(12, 'Are there any affiliate opportunities?', 'The income based funding concept is expanding nationally. If you have seen the IBF power point presentation, and you have good communication skills, you can be a Presenter. We provide training and you can be provided with your own customized website to track leads, appointments, and clients. You can even become a Transaction Engineer and have your own real estate business.');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `lang_id` int(11) unsigned NOT NULL,
  `lang_name` varchar(255) DEFAULT NULL,
  `lang_code` varchar(2) DEFAULT NULL,
  `lang_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`lang_id`, `lang_name`, `lang_code`, `lang_file`) VALUES
(1, 'English', 'en', 'lang_en.php'),
(2, 'Ø§Ø±Ø¯Ùˆ', 'ur', 'lang_ur.php');

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE IF NOT EXISTS `listings` (
  `list_id` bigint(22) unsigned NOT NULL DEFAULT '0',
  `cat_id` bigint(22) unsigned DEFAULT NULL,
  `list_title` varchar(255) DEFAULT NULL,
  `list_details` text,
  `list_file` varchar(255) DEFAULT NULL,
  `list_keywords` varchar(255) DEFAULT NULL,
  `list_hits` bigint(22) DEFAULT NULL,
  `status_id` smallint(1) DEFAULT NULL,
  `list_extra_details` text,
  `list_date` date DEFAULT NULL,
  PRIMARY KEY (`list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `mem_id` bigint(22) unsigned NOT NULL,
  `mem_login` varchar(255) DEFAULT NULL,
  `mem_password` varchar(255) DEFAULT NULL,
  `mem_email` varchar(255) DEFAULT NULL,
  `mem_phone` varchar(255) DEFAULT NULL,
  `mem_address` varchar(255) DEFAULT NULL,
  `mem_city` varchar(255) DEFAULT NULL,
  `mem_state` varchar(255) DEFAULT NULL,
  `mem_zcode` varchar(255) DEFAULT NULL,
  `status_id` int(11) unsigned DEFAULT '1',
  `mem_datecreated` date DEFAULT NULL,
  `mem_lastupdated` date DEFAULT NULL,
  `mem_last_login` date DEFAULT NULL,
  `mem_confirm` int(1) unsigned DEFAULT '1' COMMENT '1',
  `mem_fname` varchar(255) DEFAULT NULL,
  `mem_lname` varchar(255) DEFAULT NULL,
  `pak_id` int(11) unsigned NOT NULL DEFAULT '0',
  `pak_expiry` date DEFAULT NULL,
  `pak_isexpired` smallint(1) unsigned DEFAULT '0',
  `lang_id` int(11) unsigned DEFAULT '1',
  PRIMARY KEY (`mem_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`mem_id`, `mem_login`, `mem_password`, `mem_email`, `mem_phone`, `mem_address`, `mem_city`, `mem_state`, `mem_zcode`, `status_id`, `mem_datecreated`, `mem_lastupdated`, `mem_last_login`, `mem_confirm`, `mem_fname`, `mem_lname`, `pak_id`, `pak_expiry`, `pak_isexpired`, `lang_id`) VALUES
(1, '012345', '21232f297a57a5a743894a0e4a801fc3', 'aqeelashraf@gmail.com', '+923004937847', '123 hampton Bay', 'Houston', 'Google', '77007', 1, '2013-08-17', '2013-08-22', '2014-01-03', 1, 'admin', 'admin', 2, '2013-12-28', 0, 1),
(4, '968574', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2013-10-24', NULL, '2013-10-24', 1, NULL, NULL, 0, NULL, 0, 1),
(3, '03456975375', NULL, 'info@domain.com', '', '', '', '', '', 1, '2013-10-23', NULL, '2013-11-12', 1, 'umar', 'ayaz', 3, '2013-12-12', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `member_status`
--

CREATE TABLE IF NOT EXISTS `member_status` (
  `mem_confirm_id` int(11) unsigned NOT NULL,
  `mem_confirm_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`mem_confirm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member_status`
--

INSERT INTO `member_status` (`mem_confirm_id`, `mem_confirm_name`) VALUES
(0, 'Not Confirm'),
(1, 'Confirm');

-- --------------------------------------------------------

--
-- Table structure for table `mem_logs`
--

CREATE TABLE IF NOT EXISTS `mem_logs` (
  `mlog_id` bigint(22) unsigned NOT NULL,
  `mem_id` bigint(22) unsigned DEFAULT NULL,
  `cat_id` bigint(22) unsigned DEFAULT NULL,
  `ustype_id` int(11) unsigned DEFAULT NULL,
  `pr_id` bigint(22) unsigned DEFAULT NULL,
  `mlog_date` date DEFAULT NULL,
  `mlog_time` time DEFAULT NULL,
  `counter` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`mlog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mem_logs`
--

INSERT INTO `mem_logs` (`mlog_id`, `mem_id`, `cat_id`, `ustype_id`, `pr_id`, `mlog_date`, `mlog_time`, `counter`) VALUES
(1, 1, 4, 1, 15, '2013-12-27', '11:56:37', 6),
(2, 1, 4, 1, 15, '2013-12-27', '11:57:31', 5),
(3, 1, 4, 1, 15, '2013-12-27', '11:58:26', 5),
(4, 1, 4, 1, 15, '2013-12-27', '12:06:53', 5),
(5, 1, 4, 1, 15, '2013-12-27', '12:10:15', 5),
(6, 1, 4, 1, 15, '2013-12-27', '12:14:08', 5),
(7, 1, 4, 1, 15, '2013-12-27', '12:20:50', 5),
(8, 1, 4, 1, 15, '2013-12-27', '12:24:10', 1),
(9, 1, 1, 1, 1, '2013-12-27', '13:05:32', 5),
(10, 1, 1, 1, 1, '2013-12-27', '18:53:55', 5),
(11, 1, 1, 2, 1, '2013-12-28', '03:29:29', 2),
(12, 1, 4, 1, 67, '2013-12-28', '03:41:26', 5),
(13, 1, 4, 2, 67, '2013-12-28', '03:41:30', 5),
(14, 1, 1, 1, 1, '2013-12-28', '04:10:06', 5),
(15, 1, 4, 1, 53, '2013-12-28', '05:59:43', 5),
(16, 1, 4, 1, 53, '2013-12-28', '06:13:28', 5),
(17, 1, 4, 1, 53, '2013-12-28', '06:30:00', 1),
(18, 1, 4, 2, 33, '2013-12-28', '07:02:58', 1),
(19, 1, 4, 2, 31, '2013-12-28', '07:06:49', 2),
(20, 1, 4, 2, 67, '2013-12-28', '07:15:13', 5),
(21, 1, 4, 1, 67, '2013-12-28', '07:17:03', 2),
(22, 1, 4, 2, 67, '2013-12-28', '07:17:36', 3),
(23, 1, 1, 1, 5, '2014-01-02', '17:51:07', 1),
(24, 1, 1, 2, 5, '2014-01-02', '17:51:13', 1),
(25, 1, 1, 1, 1, '2014-01-02', '18:52:17', 3),
(26, 1, 4, 1, 16, '2014-01-02', '18:53:27', 2),
(27, 1, 4, 1, 27, '2014-01-04', '00:16:54', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mem_pak_limits`
--

CREATE TABLE IF NOT EXISTS `mem_pak_limits` (
  `mpl_id` bigint(22) unsigned NOT NULL,
  `mem_id` bigint(22) unsigned DEFAULT NULL,
  `mem_pak_downloads` int(11) unsigned DEFAULT '0',
  `mem_pak_downloads_con` int(11) unsigned DEFAULT '0',
  `mem_pak_stream` int(11) unsigned DEFAULT '0',
  `mem_pak_stream_con` int(11) unsigned DEFAULT '0',
  `mem_pak_gift` int(11) unsigned DEFAULT '0',
  `mem_pak_gift_con` int(11) unsigned DEFAULT '0',
  `pak_id` int(11) unsigned DEFAULT NULL,
  `mem_pak_date` date DEFAULT NULL,
  `mem_pak_expiry` date DEFAULT NULL,
  `mem_pak_isexpired` smallint(1) unsigned DEFAULT '0',
  `mem_pak_credits` bigint(22) unsigned NOT NULL,
  `pstatus_id` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`mpl_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mem_pak_limits`
--

INSERT INTO `mem_pak_limits` (`mpl_id`, `mem_id`, `mem_pak_downloads`, `mem_pak_downloads_con`, `mem_pak_stream`, `mem_pak_stream_con`, `mem_pak_gift`, `mem_pak_gift_con`, `pak_id`, `mem_pak_date`, `mem_pak_expiry`, `mem_pak_isexpired`, `mem_pak_credits`, `pstatus_id`) VALUES
(2, 1, 3, 0, 2, 0, 300, 1, 3, '2013-12-17', '2014-01-16', 0, 254, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mem_transactions`
--

CREATE TABLE IF NOT EXISTS `mem_transactions` (
  `mt_id` bigint(22) unsigned NOT NULL,
  `mem_id` bigint(22) unsigned DEFAULT NULL,
  `pak_id` int(11) unsigned DEFAULT '0',
  `tup_id` int(11) unsigned DEFAULT '0',
  `mt_date` date DEFAULT NULL,
  PRIMARY KEY (`mt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` int(11) unsigned NOT NULL,
  `cnt_id` int(11) unsigned DEFAULT '0',
  `mtype_id` smallint(2) DEFAULT NULL,
  `menu_title` varchar(255) DEFAULT NULL,
  `menu_url` varchar(255) DEFAULT 'page.php',
  `menu_parent_id` int(11) unsigned DEFAULT '0',
  `menu_bg` varchar(255) DEFAULT NULL,
  `status_id` tinyint(1) DEFAULT '1',
  `menu_link` smallint(1) unsigned DEFAULT '1',
  `menu_show` smallint(1) unsigned DEFAULT '0' COMMENT '0 all, 1 login, 2 not login',
  `menu_order` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `cnt_id`, `mtype_id`, `menu_title`, `menu_url`, `menu_parent_id`, `menu_bg`, `status_id`, `menu_link`, `menu_show`, `menu_order`) VALUES
(1, 1, 0, 'Home', 'index.php', 0, '', 1, 1, 0, 1),
(2, 2, 0, 'About', '', 0, '', 1, 1, 0, 2),
(4, 4, 3, 'Login', 'login.php', 0, NULL, 1, 1, 0, 4),
(5, 5, 5, 'Audio Tracks', 'audios.php', 0, NULL, 1, 1, 0, 5),
(6, 6, 5, 'Movies', 'movies.php', 0, NULL, 1, 1, 0, 6),
(3, 3, 3, 'Register', 'register.php', 0, NULL, 1, 1, 0, 3),
(7, 7, 5, 'Ringtones', 'ringtones.php', 0, NULL, 1, 1, 0, 7),
(8, 8, 5, 'Wallpapers', 'wallpapers.php', 0, NULL, 1, 1, 0, 8),
(9, 9, 0, 'Contact Us', 'contact.php', 0, NULL, 1, 1, 0, 9),
(10, 10, 3, 'Change Password', 'change_pass.php', 0, NULL, 1, 1, 0, 10),
(11, 11, 0, 'FAQ', 'faq.php', 0, NULL, 1, 1, 0, 11),
(12, 12, 3, 'Search', 'search.php', 0, NULL, 1, 1, 0, 12),
(13, 13, 0, 'News', 'news.php', 0, NULL, 1, 1, 0, 13),
(14, 14, 3, 'Forgot Password', 'forgot_password.php', 0, NULL, 1, 1, 0, 14),
(15, 15, 1, 'My Wishlist', 'my_wishlist.php', 0, NULL, 1, 1, 0, 21),
(19, 19, 1, 'My Gifted Items', 'my_gifts.php', 0, NULL, 1, 1, 0, 22),
(20, 20, 3, 'Details', 'details.php', 0, NULL, 1, 1, 0, 20),
(21, 21, 1, 'Buy Package', 'packages.php', 0, NULL, 1, 1, 0, 16),
(22, 22, 1, 'Dashboard', 'dashboard.php', 0, NULL, 1, 1, 0, 15),
(23, 23, 1, 'My Consumption History', 'my_consumption.php', 0, NULL, 1, 1, 0, 23),
(24, 24, 1, 'My Package History', 'my_package_history.php', 0, NULL, 1, 1, 0, 17),
(25, 25, 3, 'Convert Downloads and Streams', 'convert.php', 0, NULL, 1, 1, 0, 25),
(26, 26, 3, 'Set As Facebook Wallpaper', 'set_as_wallpaper.php', 0, NULL, 1, 1, 0, 26),
(27, 27, 1, 'Set Notifiable Categories', 'notifications.php', 0, NULL, 1, 1, 0, 27),
(28, 27, NULL, 'Product Details', 'details2.php', 0, NULL, 1, 1, 0, 28);

-- --------------------------------------------------------

--
-- Table structure for table `menu_ln`
--

CREATE TABLE IF NOT EXISTS `menu_ln` (
  `menu_id` int(11) unsigned NOT NULL,
  `lang_id` int(11) unsigned NOT NULL DEFAULT '1',
  `menu_title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`menu_id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_ln`
--

INSERT INTO `menu_ln` (`menu_id`, `lang_id`, `menu_title`) VALUES
(1, 1, 'Home'),
(2, 1, 'About'),
(4, 1, 'Login'),
(5, 1, 'Audio'),
(6, 1, 'Videos'),
(3, 1, 'Register'),
(7, 1, 'Ringtones'),
(8, 1, 'Images'),
(9, 1, 'Contact Us'),
(10, 1, 'Change Password'),
(11, 1, 'FAQ'),
(12, 1, 'Search'),
(13, 1, 'News'),
(14, 1, 'Forgot Password'),
(15, 1, 'My Wishlist'),
(19, 1, 'My Gifted Items'),
(20, 1, 'Details'),
(21, 1, 'Buy Package'),
(22, 1, 'Dashboard'),
(23, 1, 'My Consumption History'),
(24, 1, 'My Package History'),
(1, 2, 'Ú¯Ú¾Ø±'),
(2, 2, 'Ø¨Ø§Ø±Û’ Ù…ÛŒÚº'),
(5, 2, 'Ø¢ÚˆÛŒÙˆ'),
(6, 2, 'ÙˆÚˆÛŒÙˆ'),
(7, 2, 'Ú¯Ú¾Ù†Ù¹ÛŒ'),
(8, 2, 'ØªØµØ§ÙˆÛŒØ±'),
(9, 2, 'Ø±Ø§Ø¨Ø·Û Ú©Ø±ÛŒÚº'),
(11, 2, 'Ø³ÙˆØ§Ù„Ø§Øª'),
(13, 2, 'Ø®Ø¨Ø±ÛŒÚº'),
(22, 2, 'ÚˆÛŒØ´ Ø¨ÙˆØ±Úˆ'),
(21, 2, 'Ù¾ÛŒÚ©ÛŒØ¬ Ø®Ø±ÛŒØ¯ÛŒÚº'),
(24, 2, 'Ù…ÛŒØ±Ø§ Ù¾ÛŒÚ©Ø¬ Ú©ÛŒ ØªØ§Ø±ÛŒØ®'),
(15, 2, 'Ù…ÛŒØ±ÛŒ Ø®ÙˆØ§ÛØ´ Ú©ÛŒ ÙÛØ±Ø³Øª'),
(19, 2, 'Ù…ÛŒØ±Ø§ ØªØ­ÙÛ’ Ø§Ø´ÛŒØ§Ø¡'),
(23, 2, 'Ù…ÛŒØ±ÛŒ Ú©Ú¾Ù¾Øª Ú©ÛŒ ØªØ§Ø±ÛŒØ®'),
(3, 2, 'Ø±Ø¬Ø³Ù¹Ø±'),
(4, 2, 'Ù„Ø§Ú¯ Ø§Ù†'),
(10, 2, 'Ù¾Ø§Ø³ ÙˆØ±Úˆ ØªØ¨Ø¯ÛŒÙ„ Ú©Ø±ÛŒÚº'),
(12, 2, 'ØªÙ„Ø§Ø´'),
(14, 2, 'Ù¾Ø§Ø³ ÙˆØ±Úˆ Ø¨Ú¾ÙˆÙ„ Ú¯ÛŒØ§'),
(20, 2, 'ØªÙØµÛŒÙ„Ø§Øª'),
(25, 1, 'Convert Downloads and Streams'),
(26, 1, 'Set As Facebook Wallpaper'),
(27, 1, 'Set Notifiable Categories'),
(25, 2, 'ØªØ¨Ø¯ÛŒÙ„ Ù…Ù‚Ø¨ÙˆÙ„ÛŒØª Ø§ÙˆØ± Ø³Ù„Ø³Ù„Û’'),
(26, 2, 'ÙÛŒØ³ Ø¨Ú© Ú©Û’ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø± Ú©Û’ Ø·ÙˆØ± Ù¾Ø± Ù…Ù‚Ø±Ø± Ú©Ø±ÛŒÚº'),
(27, 2, 'Ù…Ù‚Ø±Ø± Notifiable Ø²Ù…Ø±Û Ø¬Ø§Øª'),
(28, 1, 'Product Details');

-- --------------------------------------------------------

--
-- Table structure for table `menu_type`
--

CREATE TABLE IF NOT EXISTS `menu_type` (
  `mtype_id` smallint(2) NOT NULL,
  `mtype_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mtype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_type`
--

INSERT INTO `menu_type` (`mtype_id`, `mtype_name`) VALUES
(0, 'Home'),
(1, 'Contents'),
(2, 'Contact'),
(3, 'Login'),
(4, 'Register'),
(5, 'Categories');

-- --------------------------------------------------------

--
-- Table structure for table `my_collection`
--

CREATE TABLE IF NOT EXISTS `my_collection` (
  `mc_id` bigint(22) unsigned NOT NULL,
  `pr_id` bigint(22) unsigned DEFAULT NULL,
  `mem_id` bigint(22) unsigned DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `mc_added_date` date DEFAULT NULL,
  PRIMARY KEY (`mc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `my_collection`
--

INSERT INTO `my_collection` (`mc_id`, `pr_id`, `mem_id`, `cat_id`, `mc_added_date`) VALUES
(1, 1, 1, 1, '2013-12-11'),
(2, 12, 1, 4, '2013-12-11'),
(3, 6, 1, 3, '2013-12-11'),
(4, 5, 1, 2, '2013-12-11'),
(5, 16, 1, 4, '2013-12-11'),
(6, 13, 1, 4, '2013-12-20'),
(7, 34, 1, 1, '2014-01-02');

-- --------------------------------------------------------

--
-- Table structure for table `my_consumption`
--

CREATE TABLE IF NOT EXISTS `my_consumption` (
  `myc_id` bigint(22) unsigned NOT NULL,
  `pr_id` bigint(22) unsigned DEFAULT NULL,
  `mem_id` bigint(22) unsigned DEFAULT NULL,
  `myc_added_date` date DEFAULT NULL,
  `cat_id` int(11) unsigned DEFAULT NULL,
  `consume_type` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`myc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `my_consumption`
--

INSERT INTO `my_consumption` (`myc_id`, `pr_id`, `mem_id`, `myc_added_date`, `cat_id`, `consume_type`) VALUES
(1, 1, 1, '2013-12-14', 1, 2),
(2, 1, 1, '2013-12-14', 1, 1),
(3, 13, 1, '2013-12-17', 4, 1),
(4, 13, 1, '2013-12-17', 4, 2),
(5, 13, 1, '2013-12-17', 4, 2),
(6, 13, 1, '2013-12-17', 4, 2),
(7, 13, 1, '2013-12-17', 4, 2),
(8, 13, 1, '2013-12-17', 4, 2),
(9, 13, 1, '2013-12-17', 4, 2),
(10, 13, 1, '2013-12-17', 4, 2),
(11, 13, 1, '2013-12-17', 4, 2),
(12, 13, 1, '2013-12-17', 4, 2),
(13, 13, 1, '2013-12-17', 4, 2),
(14, 13, 1, '2013-12-17', 4, 2),
(15, 13, 1, '2013-12-17', 4, 2),
(16, 13, 1, '2013-12-17', 4, 2),
(17, 13, 1, '2013-12-17', 4, 1),
(18, 13, 1, '2013-12-17', 4, 1),
(19, 13, 1, '2013-12-17', 4, 1),
(20, 4, 1, '2013-12-26', 1, 2),
(21, 15, 1, '2013-12-27', 4, 2),
(22, 15, 1, '2013-12-27', 4, 1),
(23, 15, 1, '2013-12-27', 4, 1),
(24, 15, 1, '2013-12-27', 4, 1),
(25, 15, 1, '2013-12-27', 4, 1),
(26, 15, 1, '2013-12-27', 4, 1),
(27, 15, 1, '2013-12-27', 4, 1),
(28, 15, 1, '2013-12-27', 4, 1),
(29, 15, 1, '2013-12-27', 4, 1),
(30, 1, 1, '2013-12-27', 1, 1),
(31, 1, 1, '2013-12-27', 1, 1),
(32, 14, 1, '2013-12-27', 4, 2),
(33, 1, 1, '2013-12-27', 1, 1),
(34, 1, 1, '2013-12-28', 1, 2),
(35, 67, 1, '2013-12-28', 4, 1),
(36, 67, 1, '2013-12-28', 4, 2),
(37, 1, 1, '2013-12-28', 1, 1),
(38, 53, 1, '2013-12-28', 4, 1),
(39, 53, 1, '2013-12-28', 4, 1),
(40, 53, 1, '2013-12-28', 4, 1),
(41, 33, 1, '2013-12-28', 4, 2),
(42, 31, 1, '2013-12-28', 4, 2),
(43, 67, 1, '2013-12-28', 4, 2),
(44, 67, 1, '2013-12-28', 4, 1),
(45, 67, 1, '2013-12-28', 4, 2),
(46, 5, 1, '2014-01-02', 1, 1),
(47, 5, 1, '2014-01-02', 1, 2),
(48, 1, 1, '2014-01-02', 1, 1),
(49, 16, 1, '2014-01-02', 4, 1),
(50, 27, 1, '2014-01-04', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `my_gifted_items`
--

CREATE TABLE IF NOT EXISTS `my_gifted_items` (
  `mg_id` bigint(22) unsigned NOT NULL,
  `mg_from` bigint(22) unsigned DEFAULT NULL,
  `mg_to` bigint(22) unsigned DEFAULT NULL,
  `mg_details` varchar(160) DEFAULT NULL,
  `mem_id` bigint(22) unsigned DEFAULT NULL,
  `pr_id` bigint(22) unsigned DEFAULT NULL,
  `cat_id` int(11) unsigned DEFAULT NULL,
  `mg_added_date` date NOT NULL,
  `lang_id` int(11) unsigned DEFAULT '1',
  PRIMARY KEY (`mg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `my_gifted_items`
--

INSERT INTO `my_gifted_items` (`mg_id`, `mg_from`, `mg_to`, `mg_details`, `mem_id`, `pr_id`, `cat_id`, `mg_added_date`, `lang_id`) VALUES
(1, 12345, 12, '12', 1, 34, 1, '2014-01-02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `my_package_history`
--

CREATE TABLE IF NOT EXISTS `my_package_history` (
  `mph_id` bigint(22) unsigned NOT NULL,
  `mem_id` bigint(22) unsigned DEFAULT NULL,
  `pak_id` bigint(22) unsigned DEFAULT NULL,
  `mpl_id` bigint(22) DEFAULT NULL,
  `mph_added_date` date DEFAULT NULL,
  `mem_pak_downloads` bigint(22) unsigned NOT NULL,
  `mem_pak_downloads_con` bigint(22) unsigned NOT NULL,
  `mem_pak_stream` bigint(22) unsigned NOT NULL,
  `mem_pak_stream_con` bigint(22) unsigned NOT NULL,
  `mem_pak_gift` bigint(22) unsigned NOT NULL,
  `mem_pak_gift_con` bigint(22) unsigned NOT NULL,
  `mem_pak_credits` bigint(22) unsigned NOT NULL,
  `mem_pak_isexpired` smallint(1) NOT NULL,
  `mph_expiry` date DEFAULT NULL,
  PRIMARY KEY (`mph_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `my_package_history`
--

INSERT INTO `my_package_history` (`mph_id`, `mem_id`, `pak_id`, `mpl_id`, `mph_added_date`, `mem_pak_downloads`, `mem_pak_downloads_con`, `mem_pak_stream`, `mem_pak_stream_con`, `mem_pak_gift`, `mem_pak_gift_con`, `mem_pak_credits`, `mem_pak_isexpired`, `mph_expiry`) VALUES
(1, 1, 1, 1, '2013-12-17', 10, 2, 20, 0, 30, 0, 0, 1, '2013-12-18'),
(2, 1, 2, 2, '2013-12-17', 2, 2, 1, 0, 60, 1, 100, 1, '2013-12-15'),
(3, 1, 3, 3, '2013-12-17', 6, 0, 4, 0, 600, 0, 596, 1, '2013-12-15'),
(4, 1, 3, 2, '2013-12-17', 3, 0, 2, 0, 300, 1, 254, 0, '2014-01-16');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `status_id` smallint(2) DEFAULT NULL,
  `news_title` varchar(255) DEFAULT NULL,
  `news_details` text,
  `news_created` date DEFAULT NULL,
  `news_modified` date DEFAULT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `user_id`, `status_id`, `news_title`, `news_details`, `news_created`, `news_modified`) VALUES
(1, NULL, 1, 'Launching soon...', 'Launching soon...', '2013-09-27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE IF NOT EXISTS `newsletters` (
  `nletters_id` bigint(22) NOT NULL DEFAULT '0',
  `nletters_title` varchar(255) DEFAULT NULL,
  `nletters_subject` varchar(255) DEFAULT NULL,
  `nletters_details` text,
  `status_id` smallint(1) DEFAULT NULL,
  `nletters_sent_date` date DEFAULT NULL,
  PRIMARY KEY (`nletters_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `newsletters`
--

INSERT INTO `newsletters` (`nletters_id`, `nletters_title`, `nletters_subject`, `nletters_details`, `status_id`, `nletters_sent_date`) VALUES
(1, '11', '22', '33', 1, '2013-09-27');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `not_id` bigint(22) unsigned NOT NULL DEFAULT '0',
  `ntype_id` bigint(22) unsigned DEFAULT NULL,
  `not_text` text,
  PRIMARY KEY (`not_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification_types`
--

CREATE TABLE IF NOT EXISTS `notification_types` (
  `ntype_id` bigint(22) unsigned NOT NULL DEFAULT '0',
  `ntype_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ntype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `ord_id` bigint(22) unsigned NOT NULL,
  `mem_id` int(11) DEFAULT NULL,
  `ord_date` date DEFAULT NULL,
  `ord_amount` decimal(22,2) unsigned DEFAULT '0.00',
  `pstatus_id` int(11) unsigned DEFAULT '0',
  `ordstatus_id` int(11) unsigned DEFAULT '0',
  `ord_txnid` varchar(255) DEFAULT NULL,
  `ship_id` int(11) unsigned DEFAULT '0',
  `ord_ship_amount` double(22,2) unsigned DEFAULT '0.00',
  PRIMARY KEY (`ord_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ord_id`, `mem_id`, `ord_date`, `ord_amount`, `pstatus_id`, `ordstatus_id`, `ord_txnid`, `ship_id`, `ord_ship_amount`) VALUES
(1, 1, '2013-03-29', '250.00', 0, 0, '0', 0, 0.00),
(2, 2, '2013-03-29', '250.00', 0, 0, '0', 0, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE IF NOT EXISTS `order_details` (
  `odet_id` bigint(22) unsigned NOT NULL,
  `ord_id` bigint(22) unsigned DEFAULT NULL,
  `pro_id` bigint(22) unsigned DEFAULT NULL,
  `pro_price` double(22,2) unsigned DEFAULT NULL,
  `odet_qty` int(11) unsigned DEFAULT NULL,
  `size_id` int(11) unsigned DEFAULT '0',
  `pro_weight` double(22,2) unsigned DEFAULT '0.00',
  `odet_custom` tinyint(1) unsigned DEFAULT '0',
  `color_id` int(11) NOT NULL,
  PRIMARY KEY (`odet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`odet_id`, `ord_id`, `pro_id`, `pro_price`, `odet_qty`, `size_id`, `pro_weight`, `odet_custom`, `color_id`) VALUES
(1, 1, 2, 250.00, 1, 0, 0.00, 0, 0),
(2, 2, 2, 250.00, 1, 0, 0.00, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE IF NOT EXISTS `order_status` (
  `ordstatus_id` int(11) unsigned NOT NULL,
  `ordstatus_name` varchar(255) DEFAULT NULL,
  `lang_id` int(11) unsigned DEFAULT '1',
  PRIMARY KEY (`ordstatus_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`ordstatus_id`, `ordstatus_name`, `lang_id`) VALUES
(0, 'Pending', 1),
(1, 'Complete', 1),
(3, 'Shipped', 1),
(4, 'Cancelled', 1);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE IF NOT EXISTS `packages` (
  `pak_id` int(11) unsigned NOT NULL,
  `pak_name` varchar(255) DEFAULT NULL,
  `sc_id` int(11) DEFAULT NULL,
  `pktype_id` int(11) unsigned DEFAULT '0',
  `pat_id` int(11) unsigned NOT NULL,
  `pak_fee` float(11,2) unsigned DEFAULT NULL,
  `status_id` int(11) unsigned DEFAULT '0',
  `pak_downloads` int(11) unsigned DEFAULT '0',
  `pak_streams` int(11) unsigned DEFAULT '0',
  `pak_gifts` int(11) unsigned NOT NULL DEFAULT '0',
  `pak_credits` bigint(22) unsigned DEFAULT NULL COMMENT 'Streams required for each download',
  PRIMARY KEY (`pak_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`pak_id`, `pak_name`, `sc_id`, `pktype_id`, `pat_id`, `pak_fee`, `status_id`, `pak_downloads`, `pak_streams`, `pak_gifts`, `pak_credits`) VALUES
(1, 'Daily', 1, 1, 1, 50.00, 1, 10, 20, 30, 0),
(2, 'Weekly', 1, 2, 2, 150.00, 1, 2, 1, 60, 100),
(3, 'Monthly', 4, 3, 2, 250.00, 1, 3, 2, 300, 300);

-- --------------------------------------------------------

--
-- Table structure for table `packages_ln`
--

CREATE TABLE IF NOT EXISTS `packages_ln` (
  `pak_id` int(11) unsigned NOT NULL,
  `lang_id` int(11) unsigned NOT NULL DEFAULT '1',
  `pak_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pak_id`,`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `packages_ln`
--

INSERT INTO `packages_ln` (`pak_id`, `lang_id`, `pak_name`) VALUES
(1, 1, 'Daily'),
(2, 1, 'Weekly'),
(3, 1, 'Monthly'),
(4, 1, 'sasasasa');

-- --------------------------------------------------------

--
-- Table structure for table `package_cat_limits`
--

CREATE TABLE IF NOT EXISTS `package_cat_limits` (
  `pak_id` bigint(22) unsigned NOT NULL,
  `plt_id` int(11) unsigned NOT NULL,
  `cat_id` bigint(22) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package_cat_limits`
--

INSERT INTO `package_cat_limits` (`pak_id`, `plt_id`, `cat_id`) VALUES
(1, 3, 3),
(1, 3, 2),
(1, 3, 1),
(1, 2, 2),
(1, 2, 1),
(1, 1, 1),
(2, 3, 1),
(2, 2, 2),
(2, 2, 1),
(2, 1, 3),
(2, 1, 2),
(2, 1, 1),
(3, 1, 3),
(3, 1, 4),
(3, 2, 3),
(3, 2, 4),
(3, 3, 3),
(3, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `pak_andor_type`
--

CREATE TABLE IF NOT EXISTS `pak_andor_type` (
  `pat_id` int(11) unsigned NOT NULL,
  `pat_name` varchar(255) NOT NULL,
  PRIMARY KEY (`pat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pak_andor_type`
--

INSERT INTO `pak_andor_type` (`pat_id`, `pat_name`) VALUES
(1, 'AND'),
(2, 'OR');

-- --------------------------------------------------------

--
-- Table structure for table `pak_limit_types`
--

CREATE TABLE IF NOT EXISTS `pak_limit_types` (
  `plt_id` int(11) unsigned NOT NULL,
  `plt_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`plt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pak_limit_types`
--

INSERT INTO `pak_limit_types` (`plt_id`, `plt_name`) VALUES
(1, 'Download'),
(2, 'Stream'),
(3, 'Gift');

-- --------------------------------------------------------

--
-- Table structure for table `pak_type`
--

CREATE TABLE IF NOT EXISTS `pak_type` (
  `pktype_id` int(11) unsigned NOT NULL,
  `pktype_name` varchar(255) DEFAULT NULL,
  `pktype_days` bigint(22) unsigned DEFAULT NULL,
  PRIMARY KEY (`pktype_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pak_type`
--

INSERT INTO `pak_type` (`pktype_id`, `pktype_name`, `pktype_days`) VALUES
(1, 'Daily', 1),
(2, 'Weekly', 7),
(3, 'Monthly', 30);

-- --------------------------------------------------------

--
-- Table structure for table `pay_status`
--

CREATE TABLE IF NOT EXISTS `pay_status` (
  `pstatus_id` int(2) unsigned NOT NULL,
  `pstatus_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pstatus_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pay_status`
--

INSERT INTO `pay_status` (`pstatus_id`, `pstatus_name`) VALUES
(0, 'Pending'),
(1, 'Completed'),
(2, 'Cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `pr_id` bigint(22) unsigned NOT NULL DEFAULT '0',
  `pr_title` varchar(255) DEFAULT NULL,
  `pr_short_details` varchar(255) DEFAULT NULL,
  `pr_long_details` text,
  `pr_meta_keyword` varchar(255) DEFAULT NULL,
  `pr_meta_description` varchar(255) DEFAULT NULL,
  `pr_added_date` date DEFAULT NULL,
  `pr_modified_date` date NOT NULL,
  `status_id` smallint(1) DEFAULT '1',
  `cat_id` bigint(22) unsigned DEFAULT NULL,
  `pr_hits` bigint(22) unsigned DEFAULT '0',
  `pr_file` varchar(255) DEFAULT NULL,
  `pr_thumb` varchar(255) DEFAULT NULL,
  `is_home` smallint(1) DEFAULT '0',
  `is_featured` smallint(1) DEFAULT '0',
  `mem_id` bigint(22) unsigned DEFAULT '1',
  `ptype_id` bigint(22) unsigned DEFAULT NULL,
  PRIMARY KEY (`pr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pr_id`, `pr_title`, `pr_short_details`, `pr_long_details`, `pr_meta_keyword`, `pr_meta_description`, `pr_added_date`, `pr_modified_date`, `status_id`, `cat_id`, `pr_hits`, `pr_file`, `pr_thumb`, `is_home`, `is_featured`, `mem_id`, `ptype_id`) VALUES
(1, 'Dar e Nabi Per', 'An audio naat of Zahid Mehmood Chisti', 'This is a sweet naat of Zahid Mehmood Chisti. Full of love for prophet. Inspiring lyrics.', 'Dar e Nabi Per, Zahid Mehmood Chisti, Audio Naat', 'This is a sweet naat of Zahid Mehmood Chisti. Full of love for prophet. Inspiring lyrics.', '2013-12-31', '0000-00-00', 1, 5, 137, NULL, NULL, 0, 0, 2, NULL),
(2, 'Husn-e-Mehboob Ne', 'A marvellous audio naat of Muhammad Hafiullah. ', 'Muhammad Hafiullaha is a telented young naatkhawan. He has sung this naat with perfect tone and rythem. ', 'Husn e Mehboob, Muhammad Hafiullah, Audio Naat', 'Muhammad Hafiullaha is a telented young naatkhawan. He has sung this naat with perfect tone and rythem. ', '2013-12-31', '0000-00-00', 1, 5, 13, NULL, NULL, 0, 0, 2, NULL),
(3, 'Pegham Saba', 'A popular and perfect naat of Humaira. ', 'Humaira is a famous and melodious singer. She has made this naat really melodious and sweet. ', 'Pegham Saba, Humaira, Audio Naat', 'Humaira is a famous and melodious singer. She has made this naat really melodious and sweet. ', '2013-12-31', '0000-00-00', 1, 5, 16, NULL, NULL, 0, 0, 2, NULL),
(4, 'Qaseeda Burada', 'A perfect version of Qaseeda Burda Sharif in the voice of famous Singer Rahim Shah. ', 'With his excellent voice and singing style, Rahim Shah has made this Qaseed really awesome. ', 'Qaseeda Burada, Rahim Shah, Audio Qaseeda', 'With his excellent voice and singing style, Rahim Shah has made this Qaseed really awesome. ', '2013-12-31', '0000-00-00', 1, 5, 16, NULL, NULL, 0, 0, 2, NULL),
(5, 'Shah-e-Madina', 'A famous naat in the voice of Humaira', 'This naat has been sung many times but Humaira has given it a new touch. This is a perfect one. ', 'Shah e Madina, Humaira, Audio Naat', 'This naat has been sung many times but Humaira has given it a new touch. This is a perfect one. ', '2013-12-31', '0000-00-00', 1, 5, 108, NULL, NULL, 0, 0, 2, NULL),
(6, 'Gham-e-Ashaqi Se Pehlay', 'A sad urdu poem', 'This is a sad urdu poem with background music. All lyrics are heart touching.', 'Audio Urdu Poem, Sad Poem, Urdu Poem', 'This is a sad urdu poem with background music. All lyrics are heart touching.', '2013-12-31', '0000-00-00', 1, 19, 4, NULL, NULL, 0, 0, 2, NULL),
(7, 'Muhabatien Jab Shumar Karna', 'A perfect mixture of romance and seperation', 'This is a melodious urdu romantic poem sung by a female artist with sweet voice.', 'Urdu Poetry, Audio Urdu Poetry, Romantic Poetry', 'This is a melodious urdu romantic poem sung by a female artist with sweet voice.', '2013-12-31', '0000-00-00', 1, 19, 0, NULL, NULL, 0, 0, 2, NULL),
(8, 'Rat Hawaien Tez Theen', 'A melodious audio poem for a rainy night', 'This audio poem describes the scene of a rainy night and the condition of a lover.', 'Audio Poem, Rainy Night Poetry, Love Poetry', 'This audio poem describes the scene of a rainy night and the condition of a lover.', '2013-12-31', '0000-00-00', 1, 19, 0, NULL, NULL, 0, 0, 2, NULL),
(9, 'Soz-e-Gham', 'A sad audio poem', 'This audio poem describes sad feelings of a lover. ', 'Sad Poem, Audio Poem, Poetry For Lover', 'This audio poem describes sad feelings of a lover. ', '2013-12-31', '0000-00-00', 1, 19, 0, NULL, NULL, 0, 0, 2, NULL),
(10, 'Teri Hasti Teri Zaat', 'A pefect romantic poem in audio', 'This is a sweet and romantic audio poem in the voice of a male artist. ', 'Romantic Poem, Audio Romantic Poetry, Urdu Audio Poetry', 'This is a sweet and romantic audio poem in the voice of a male artist. ', '2013-12-31', '0000-00-00', 1, 19, 1, NULL, NULL, 0, 0, 2, NULL),
(11, 'Basant Mere Paish', 'A melodious song on spring season', 'The famous singer Fariha Perveiz has presented this melodious song for Basant lovers. ', 'Fariha Perveiz Song, Basant Song, ', 'The famous singer Fariha Perveiz has presented this melodious song for Basant lovers. ', '2013-12-31', '0000-00-00', 1, 6, 0, NULL, NULL, 0, 0, 2, NULL),
(12, 'Habibi ', 'A beautiful romantic song of Rahim Shah', 'This is a marvellous song of the famous singer Rahim Shah. The lyrics of this song are really good. ', 'Rahim Shah Song, Romantic Urdu Song, Habibi', 'This is a marvellous song of the famous singer Rahim Shah. The lyrics of this song are really good. ', '2013-12-31', '0000-00-00', 1, 6, 0, NULL, NULL, 0, 0, 2, NULL),
(13, 'Neelay Neelay Ambar Par ', 'A popular urdu song in the voice of Belaat Patel', 'This song has been been sung by many singers but Belaat Patel has really made it good.', 'Belaal Patel Songs, Neelay Neelay Ambar, Romantic Song', 'This song has been been sung by many singers but Belaat Patel has really made it good.', '2013-12-31', '0000-00-00', 1, 6, 0, NULL, NULL, 0, 0, 2, NULL),
(14, 'O Vela Yaad Kar ', 'A famous track of Fariha Perveiz', 'This is a popluar track by Fariha Perveiz. Lyrics are really simple and goo and a little bit funny too. ', 'Fariha Perveiz Songs, O Vela Yaad Kar, Popular Song', 'This is a popluar track by Fariha Perveiz. Lyrics are really simple and goo and a little bit funny too. ', '2013-12-31', '0000-00-00', 1, 6, 0, NULL, NULL, 0, 0, 2, NULL),
(15, 'Teri Ummid Tera Intazaar', 'A popular song of Belaal Patel', 'The talented young singer Baleel Patel has made this song really good and new. ', 'Teri Umed Tera Intazaar, Belaat Patel Song', 'The talented young singer Baleel Patel has made this song really good and new', '2013-12-31', '0000-00-00', 1, 6, 0, NULL, NULL, 0, 0, 2, NULL),
(16, 'Badan Mien Aag', 'A romantic poem', 'This is a romantic and beautiful urdu poem', 'Romantic Peom, Urdu Poetry, Image Urdu Poetry', 'This is a romantic and beautiful urdu poem', '2013-12-31', '0000-00-00', 1, 10, 70, NULL, NULL, 0, 0, 2, NULL),
(17, 'Chandni', 'A sweet romantic poem', 'This is a short romantic verse. A perfect one. ', 'Romantic Verse, Romantic Poetry, Chandni', 'This is a short romantic verse. A perfect one. ', '2013-12-31', '0000-00-00', 1, 10, 37, NULL, NULL, 0, 0, 2, NULL),
(18, 'Gum Ho Jata Hon', 'A famous Urdu verse', 'This is a famous verse of Urdu poetry.', 'Famous Urdu Poetry, Urdu Verse, Romantic Verse', 'This is a famous verse of Urdu poetry.', '2013-12-31', '0000-00-00', 1, 10, 2, NULL, NULL, 0, 0, 2, NULL),
(19, 'Khizaan Ki Rut Mien', 'A urdu verse based on old memories', 'This Urdu verse describes the old memories of a lover. ', 'Urdu Verse, Old Memories Poetry, Romantic Poetry', 'This Urdu verse describes the old memories of a lover.', '2013-12-31', '0000-00-00', 1, 10, 22, NULL, NULL, 0, 0, 2, NULL),
(20, 'Charag', 'A wallpaper of urdu poem', 'This is a beautiful wallpaper based on a romantic urdu poem.', 'Poetry Wallpaper, Romantic Poetry Wallpaper, Wallpaper', 'This is a beautiful wallpaper based on a romantic urdu poem.', '2013-12-31', '0000-00-00', 1, 12, 2, NULL, NULL, 0, 0, 2, NULL),
(21, 'Girls Hostel', 'A wallpaper of funny urdu poetry', 'This is a well-designed wallpaper of a funny urdu verse. ', 'Funny Wallpaper, Poetry Wallpaper, Urdu Poetry Wallpaper', 'This is a well-designed wallpaper of a funny urdu verse. ', '2013-12-31', '0000-00-00', 1, 12, 0, NULL, NULL, 0, 0, 2, NULL),
(22, 'Qisay', 'A single-verse wallpaper', 'This beautiful wallpaper contains a singe urdu verse with cool borders. ', 'Urdu Verse Wallpaper, Poetry Wallpaper, Cool Wallpaper', 'This beautiful wallpaper contains a singe urdu verse with cool borders.', '2013-12-31', '0000-00-00', 1, 12, 0, NULL, NULL, 0, 0, 2, NULL),
(23, 'Shehr-e-Ahsas', 'Wallpaper based on sad verse', 'This wallpaper is based on sad urdu verse. ', 'Sad Urdu Verse, Poetry Wallpaper, Small Wallpaper', 'This wallpaper is based on sad urdu verse. ', '2013-12-31', '0000-00-00', 1, 12, 0, NULL, NULL, 0, 0, 2, NULL),
(24, 'Roses', 'A samll wallpaper with roses', 'This small wallpapers contains a couple of decent roses. ', 'Small Wallpaper, Roses Wallpaper', 'This small wallpapers contains a couple of decent roses. ', '2013-12-31', '0000-00-00', 1, 12, 0, NULL, NULL, 0, 0, 2, NULL),
(25, 'Waterfall', 'A waterfall based wallpaper', 'This wallpaper shows a beautiful waterfall. ', 'Waterfall Wallpaper, Beautiful Wallpaer', 'This wallpaper shows a beautiful waterfall. ', '2013-12-31', '0000-00-00', 1, 12, 0, NULL, NULL, 0, 0, 2, NULL),
(26, 'Stones', 'Wallpaper with colorful stones', 'This wallpaper contains small stones of different colors', 'Stone Wallpaper, Colorful Stones, Small Wallpaper', 'This wallpaper contains small stones of different colors', '2013-12-31', '0000-00-00', 1, 12, 0, NULL, NULL, 0, 0, 2, NULL),
(27, 'Spring Dress', 'A fashion based wallpaper', 'This fashion based wallpaper shows a beautiful spring dress of a woman.', 'Fashion Wallpaper, Spring Dress Wallpaper', 'This fashion based wallpaper shows a beautiful spring dress of a woman.', '2013-12-31', '0000-00-00', 1, 12, 13, NULL, NULL, 0, 0, 2, NULL),
(28, 'Sab Da Malik Allah', 'A video naat of ahmed raza qadri', 'This is a beautiful video naat of Ahmed Raza Qadri.', 'Video Naat, Ahmed Raza Qadri Naat, Sab Da Malik Allah', 'This is a beautiful video naat of Ahmed Raza Qadri.', '2013-12-31', '0000-00-00', 1, 8, 3, NULL, NULL, 0, 0, 2, NULL),
(29, 'Sarkar Jantay Hien', 'Famous naat of Ahmed Raza Qadri', 'This is a famous naat, sung by Ahmed Raza Qadri. ', 'Ahmed Raza Qadri Naat, Famous Naat, Sarkar Jantay Hien', 'This is a famous naat, sung by Ahmed Raza Qadri.', '2013-12-31', '0000-00-00', 1, 8, 2, NULL, NULL, 0, 0, 2, NULL),
(30, 'Teray Qurban Habibi Maoulai', 'A Sweet naat of Qaria Amber ', 'Qaria Amber has presented this naat in really a sweet and melodious voice. ', 'Qaria Amber Qadria Naat, Teray Qurban Habibi, Video Naat', 'Qaria Amber has presented this naat in really a sweet and melodious voice. ', '2013-12-31', '0000-00-00', 1, 8, 0, NULL, NULL, 0, 0, 2, NULL),
(31, 'Ya Ilahi Mari Dunya Mien', 'A prayer by Tariq Mehmood Raufi', 'Old naatkhawan Tariq Mehmood Raufi has presented this naat in a perfect way. ', 'Duaia Naat, Tariq Mehmood Raufi Naat, Ya Ilahi Mari Dunya Mien', 'Old naatkhawan Tariq Mehmood Raufi has presented this naat in a perfect way. ', '2013-12-31', '0000-00-00', 1, 8, 0, NULL, NULL, 0, 0, 2, NULL),
(32, 'Begam', 'A comedy clip from stage drama', 'This video comedy clip is from a famous stage drama.', 'Video Comedy, Comedy Clip, Stage Drama', 'This video comedy clip is from a famous stage drama.', '2013-12-31', '0000-00-00', 1, 18, 0, NULL, NULL, 0, 0, 2, NULL),
(33, 'Halwa', 'A short video comedy clip', 'This is a short video comedy clip containing two characters. ', 'Short Comedy Clip, Video Comedy, ', 'This is a short video comedy clip containing two characters. ', '2013-12-31', '0000-00-00', 1, 18, 0, NULL, NULL, 0, 0, 2, NULL),
(34, '', '', '', '', '', '2014-01-02', '0000-00-00', 1, 5, 220, NULL, NULL, 0, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products_ln`
--

CREATE TABLE IF NOT EXISTS `products_ln` (
  `pr_id` bigint(22) unsigned NOT NULL DEFAULT '0',
  `lang_id` int(11) unsigned NOT NULL DEFAULT '1',
  `pr_title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `pr_short_details` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `pr_long_details` text CHARACTER SET utf8,
  `pr_meta_keyword` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `pr_meta_description` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`pr_id`,`lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products_ln`
--

INSERT INTO `products_ln` (`pr_id`, `lang_id`, `pr_title`, `pr_short_details`, `pr_long_details`, `pr_meta_keyword`, `pr_meta_description`) VALUES
(1, 1, 'Dar e Nabi Per', 'An audio naat of Zahid Mehmood Chisti', 'This is a sweet naat of Zahid Mehmood Chisti. Full of love for prophet. Inspiring lyrics.', 'Dar e Nabi Per, Zahid Mehmood Chisti, Audio Naat', 'This is a sweet naat of Zahid Mehmood Chisti. Full of love for prophet. Inspiring lyrics.'),
(1, 2, 'Ø¯Ø± Ù†Ø¨ÛŒ Ù¾Ø± ', 'Ø²Ø§ÛØ¯ Ù…Ø­Ù…ÙˆØ¯ Ú†Ø´ØªÛŒ Ú©ÛŒ Ø¢ÙˆØ§Ø² Ù…ÛŒÚº Ø§ÛŒÚ© Ø¢ÚˆÛŒÙˆ Ù†Ø¹Øª', 'ÛŒÛ Ø®ÙˆØ¨ØµÙˆØ±Øª Ù†Ø¹Øª Ø²Ø§ÛØ¯ Ù…Ø­Ù…ÙˆØ¯ Ú†Ø´ØªÛŒ Ú©ÛŒ Ø¢ÙˆØ§Ø² Ù…ÛŒÚº ÛÛ’Û” Ù†Ø¹Øª Ú©ÛŒ Ø´Ø§Ø¹Ø±ÛŒ Ø§Ù†ØªÛØ§Ø¦ÛŒ Ø¯Ù„ Ø³ÙˆØ² ÛÛ’ Ø§ÙˆØ± Ù…Ø­Ø¨Øª Ø±Ø³ÙˆÙ„ Ø³Û’ Ø¨Ú¾Ø±Ù¾ÙˆØ± ÛÛ’Û”', 'Dar e Nabi Per, Zahid Mehmood Chisti, Audio Naat', 'This is a sweet naat of Zahid Mehmood Chisti. Full of love for prophet. Inspiring lyrics.'),
(2, 1, 'Husn-e-Mehboob Ne', 'A marvellous audio naat of Muhammad Hafiullah. ', 'Muhammad Hafiullaha is a telented young naatkhawan. He has sung this naat with perfect tone and rythem. ', 'Husn e Mehboob, Muhammad Hafiullah, Audio Naat', 'Muhammad Hafiullaha is a telented young naatkhawan. He has sung this naat with perfect tone and rythem. '),
(2, 2, 'Ø­Ø³Ù† Ù…Ø­Ø¨ÙˆØ¨ Ù†Û’', 'Ù…Ø­Ù…Ø¯ Ø­ÙÛŒ Ø§Ù„Ù„Ù„Û Ú©ÛŒ Ø¢ÙˆØ§Ø² Ù…ÛŒÚº Ø§ÛŒÚ© Ù¾Ø± Ø³ÙˆØ² Ù†Ø¹Øª', 'Ù…Ø­Ù…Ø¯ Ø­ÙÛŒ Ø§Ù„Ù„Ù„Û Ø§ÛŒÚ© Ù†ÙˆØ¬ÙˆØ§Ù† Ù†Ø¹Øª Ø®ÙˆØ§Ù† ÛÛŒÚºÛ” Ø§Ù†ÛÙˆÚº Ù†Û’ Ø¨Ú‘Û’ ÛÛŒ Ù¾Ø± Ø³ÙˆØ² Ø§Ù†Ø¯Ø§Ø² Ù…ÛŒÚº Ø§Ø³ Ù†Ø¹Øª Ú©Ùˆ Ù¾Ú‘Ú¾Ø§ ÛÛ’Û”', 'Husn e Mehboob, Muhammad Hafiullah, Audio Naat', 'Muhammad Hafiullaha is a telented young naatkhawan. He has sung this naat with perfect tone and rythem.'),
(3, 1, 'Pegham Saba', 'A popular and perfect naat of Humaira. ', 'Humaira is a famous and melodious singer. She has made this naat really melodious and sweet. ', 'Pegham Saba, Humaira, Audio Naat', 'Humaira is a famous and melodious singer. She has made this naat really melodious and sweet. '),
(3, 2, 'Ù¾ÛŒØºØ§Ù… ØµØ¨Ø§', 'Ø­Ù…ÛŒØ±Ø§ Ú©ÛŒ Ø§ÛŒÚ© Ù…Ø´ÛÙˆØ± Ø§ÙˆØ± Ø®ÙˆØ¨ØµÙˆØ±Øª Ù†Ø¹ØªÛ”', 'Ø­Ù…ÛŒØ±Ø§ Ø§ÛŒÚ© Ù…Ø´ÛÙˆØ± Ø§ÙˆØ± Ù‚Ø§Ø¨Ù„ Ú¯Ù„ÙˆÚ©Ø§Ø±Û ÛÛŒÚºÛ” Ø§Ù†ÛÙˆÚº Ù†Û’ Ø§Ø³ Ù†Ø¹Øª Ù…ÛŒÚº Ù…Ù¹Ú¾Ø§Ø³ Ø§ÙˆØ± Ù…Ø­Ø¨Øª Ø¨Ú¾Ø± Ø¯ÛŒ ÛÛ’', 'Pegham Saba, Humaira, Audio Naat', 'Humaira is a famous and melodious singer. She has made this naat really melodious and sweet. '),
(4, 1, 'Qaseeda Burada', 'A perfect version of Qaseeda Burda Sharif in the voice of famous Singer Rahim Shah. ', 'With his excellent voice and singing style, Rahim Shah has made this Qaseed really awesome. ', 'Qaseeda Burada, Rahim Shah, Audio Qaseeda', 'With his excellent voice and singing style, Rahim Shah has made this Qaseed really awesome. '),
(4, 2, 'Ù‚ØµÛŒØ¯Û Ø¨Ø±Ø¯Û', 'Ù…Ø´ÛÙˆØ± Ú¯Ù„ÙˆÚ©Ø§Ø± Ø±Ø­ÛŒÙ… Ø´Ø§Û Ú©ÛŒ Ø¢ÙˆØ§Ø² Ù…ÛŒÚº Ø§ÛŒÚ© Ø®ÙˆØ¨ØµÙˆØ±Øª Ù‚ØµÛŒØ¯Û', 'Ø±Ø­ÛŒÙ… Ø´Ø§Û Ù†Û’ Ø§Ù¾Ù†ÛŒ Ø®ÙˆØ¨ØµÙˆØ±Øª Ø§ÙˆØ± Ù…ÛŒÙ¹Ú¾ÛŒ Ø¢ÙˆØ§Ø² Ø³Û’ Ù‚ØµÛŒØ¯Û Ø¨Ø±Ø¯Û Ø´Ø±ÛŒÙ Ú©Ùˆ Ø§ÛŒÚ© Ù†ÛŒØ§ Ø±Ù†Ú¯ Ø¯Û’ Ø¯ÛŒØ§ ÛÛ’Û” ', 'Qaseeda Burada, Rahim Shah, Audio Qaseeda', 'With his excellent voice and singing style, Rahim Shah has made this Qaseed really awesome. '),
(5, 1, 'Shah-e-Madina', 'A famous naat in the voice of Humaira', 'This naat has been sung many times but Humaira has given it a new touch. This is a perfect one. ', 'Shah e Madina, Humaira, Audio Naat', 'This naat has been sung many times but Humaira has given it a new touch. This is a perfect one. '),
(5, 2, 'Ø´Ø§Û Ù…Ø¯ÛŒÙ†Û', 'Ø­Ù…ÛŒØ±Ø§ Ú©ÛŒ Ø¢ÙˆØ§Ø² Ù…ÛŒÚº Ø§ÛŒÚ© Ù…Ø´ÛÙˆØ± Ù†Ø¹Øª', 'ÛŒÛ Ù†Ø¹Øª Ú©Ø§ÙÛŒ Ø¯ÙØ¹Û Ù¾Ú‘Ú¾ÛŒ Ø¬Ø§ Ú†Ú©ÛŒ ÛÛ’ Ù„ÛŒÚ©Ù† Ø­Ù…ÛŒØ±Ø§ Ù†Û’ Ø§Ø³Û’ Ø§ÛŒÚ© Ù†Ø¦Û’ Ø§Ù†Ø¯Ø§Ø² Ø³Û’ Ù¾ÛŒØ´ Ú©ÛŒØ§ ÛÛ’Û” ', 'Shah e Madina, Humaira, Audio Naat', 'This naat has been sung many times but Humaira has given it a new touch. This is a perfect one. '),
(6, 1, 'Gham-e-Ashaqi Se Pehlay', 'A sad urdu poem', 'This is a sad urdu poem with background music. All lyrics are heart touching.', 'Audio Urdu Poem, Sad Poem, Urdu Poem', 'This is a sad urdu poem with background music. All lyrics are heart touching.'),
(6, 2, 'ØºÙ… Ø¹Ø§Ø´Ù‚ÛŒ Ø³Û’ Ù¾ÛÙ„Û’', 'Ø§Ø±Ø¯Ùˆ Ú©ÛŒ Ø§ÛŒÚ© ØºÙ…Ú¯ÛŒÙ† ØºØ²Ù„', 'ÛŒÛ Ø¨ÛŒÚ© Ú¯Ø±Ø§ÙˆÙ†Úˆ Ù…ÛŒÙˆØ²Ú© Ú©Û’ Ø³Ø§ØªÚ¾ Ø§Ø±Ø¯Ùˆ Ú©ÛŒ Ø§ÛŒÚ© ØºÙ…Ú¯ÛŒÙ† ØºØ²Ù„ ÛÛ’ Ø¬Ø³ Ú©ÛŒ Ø´Ø§Ø¹Ø±ÛŒ Ø§Ù†ØªÛØ§Ø¦ÛŒ Ø¯Ù„ Ø³ÙˆØ² ÛÛ’Û”', 'Audio Urdu Poem, Sad Poem, Urdu Poem', 'This is a sad urdu poem with background music. All lyrics are heart touching.'),
(7, 1, 'Muhabatien Jab Shumar Karna', 'A perfect mixture of romance and seperation', 'This is a melodious urdu romantic poem sung by a female artist with sweet voice.', 'Urdu Poetry, Audio Urdu Poetry, Romantic Poetry', 'This is a melodious urdu romantic poem sung by a female artist with sweet voice.'),
(7, 2, 'Ù…Ø­Ø¨ØªÛŒÚº Ø¬Ø¨ Ø´Ù…Ø§Ø± Ú©Ø±Ù†Ø§', 'Ø±ÙˆÙ…Ø§Ù†ÛŒ Ø§ÙˆØ± ØºÙ…Ú¯ÛŒÙ† Ø´Ø§Ø¹Ø±ÛŒ Ú©Ø§ Ø§ÛŒÚ© Ø­Ø³ÛŒÙ† Ø§Ù…ØªØ²Ø§Ø¬', 'Ø§ÛŒÚ© Ø®Ø§ØªÙˆÙ† Ø´Ø§Ø¹Ø±Û Ù†Û’ Ø¨Ú‘Û’ Ù…ÛŒÙ¹Ú¾Û’ Ø§ÙˆØ± Ø±ÙˆÙ…Ø§Ù†ÙˆÛŒ Ø§Ù†Ø¯Ø§Ø² Ù…ÛŒÚº Ø§Ø±Ø¯Ùˆ Ú©ÛŒ ÛŒÛ Ù…Ø´ÛÙˆØ± ØºØ²Ù„ Ù¾Ú‘Ú¾ÛŒ ÛÛ’Û”', 'Urdu Poetry, Audio Urdu Poetry, Romantic Poetry', 'This is a melodious urdu romantic poem sung by a female artist with sweet voice.'),
(8, 0, 'Ø±Ø§Øª ÛÙˆØ§Ø¦ÛŒÚº ØªÛŒØ² ØªÚ¾ÛŒÚº', 'Ø¨Ø±Ø³Ø§Øª Ú©ÛŒ Ø§ÛŒÚ© Ø±Ø§Øª Ù¾Û Ø®ÙˆØ¨ØµÙˆØ±Øª ØºØ²Ù„', 'ÛŒÛ Ù†Ø¸Ù… Ø¨Ø±Ø³Ø§Øª Ú©ÛŒ Ø±Ø§Øª Ø§ÙˆØ± Ø§Ø³ Ø±Ø§Øª Ù…ÛŒÚº Ø§ÛŒÚ© Ø¹Ø§Ø´Ù‚ Ú©Û’ Ø¯Ù„ Ú©Ø§ Ù…Ù†Ø¸Ø± Ø¨ÛŒØ§Ù† Ú©Ø±ØªÛŒ ÛÛ’Û”', 'Audio Poem, Rainy Night Poetry, Love Poetry', 'This audio poem describes the scene of a rainy night and the condition of a lover.'),
(8, 1, 'Rat Hawaien Tez Theen', 'A melodious audio poem for a rainy night', 'This audio poem describes the scene of a rainy night and the condition of a lover.', 'Audio Poem, Rainy Night Poetry, Love Poetry', 'This audio poem describes the scene of a rainy night and the condition of a lover.'),
(9, 1, 'Soz-e-Gham', 'A sad audio poem', 'This audio poem describes sad feelings of a lover. ', 'Sad Poem, Audio Poem, Poetry For Lover', 'This audio poem describes sad feelings of a lover. '),
(9, 2, 'Ø³ÙˆØ² ØºÙ…', 'Ø§ÛŒÚ© ØºÙ…Ú¯ÛŒÙ† Ø¢ÚˆÛŒÙˆ ØºØ²Ù„', 'ÛŒÛ Ø¢ÚˆÛŒÙˆ ØºØ²Ù„ Ø§ÛŒÚ© ØºÙ…Ú¯ÛŒÙ† Ø¹Ø§Ø´Ù‚ Ú©ÛŒ Ú©ÛŒÙÛŒØª Ú©ÛŒ Ø¹Ú©Ø§Ø³ÛŒ Ú©Ø±ØªÛŒ ÛÛ’Û”', 'Sad Poem, Audio Poem, Poetry For Lover', 'This audio poem describes sad feelings of a lover. '),
(10, 1, 'Teri Hasti Teri Zaat', 'A pefect romantic poem in audio', 'This is a sweet and romantic audio poem in the voice of a male artist. ', 'Romantic Poem, Audio Romantic Poetry, Urdu Audio Poetry', 'This is a sweet and romantic audio poem in the voice of a male artist. '),
(10, 2, 'ØªÛŒØ±ÛŒ ÛØ³ØªÛŒ ØªÛŒØ±ÛŒ Ø°Ø§Øª', 'Ø§ÛŒÚ© Ø®ÙˆØ¨ØµÙˆØ±Øª Ø±ÙˆÙ…Ø§Ù†ÙˆÛŒ ØºØ²Ù„ ', 'ÛŒÛ Ø§ÛŒÚ© Ø®ÙˆØ¨ØµÙˆØ±Øª Ø±ÙˆÙ…Ø§Ù†ÙˆÛŒ ØºØ²Ù„ ÛÛ’ Ø¬Ø³ Ú©Ùˆ Ù¾Ø± Ú©ÛŒÙ Ø§Ù†Ø¯Ø§Ø² Ù…ÛŒÚº Ù¾ÛŒØ´ Ú©ÛŒØ§ Ú¯ÛŒØ§ ÛÛ’Û”', 'Romantic Poem, Audio Romantic Poetry, Urdu Audio Poetry', 'This is a sweet and romantic audio poem in the voice of a male artist. '),
(11, 1, 'Basant Mere Paish', 'A melodious song on spring season', 'The famous singer Fariha Perveiz has presented this melodious song for Basant lovers. ', 'Fariha Perveiz Song, Basant Song, ', 'The famous singer Fariha Perveiz has presented this melodious song for Basant lovers. '),
(11, 2, 'Ø¨Ø³Ù†Øª Ù…ÛŒØ±Û’ Ù¾ÛŒØ´', 'Ø¨Ø³Ù†Øª Ú©Û’ Ø§ÙˆÙ¾Ø± Ø§ÛŒÚ© Ø®ÙˆØ¨ØµÙˆØ±Øª Ú¯Ø§Ù†Ø§', ' Ù…Ø´ÛÙˆØ± Ú¯Ù„ÙˆÚ©Ø§Ø±Ø§ ÙØ±ÛŒØ­Û Ù¾Ø±ÙˆÛŒØ² Ù†Û’ ÛŒÛ Ú¯Ø§Ù†Ø§ Ø¨Ø³Ù†Øª Ú©Û’ Ú†Ø§ÛÙ†Û’ ÙˆØ§Ù„ÙˆÚº Ú©Û’ Ù„ÛŒÛ’ Ù¾ÛŒØ´ Ú©ÛŒØ§ ÛÛ’Û”', 'Fariha Perveiz Song, Basant Song, ', 'The famous singer Fariha Perveiz has presented this melodious song for Basant lovers. '),
(12, 1, 'Habibi ', 'A beautiful romantic song of Rahim Shah', 'This is a marvellous song of the famous singer Rahim Shah. The lyrics of this song are really good. ', 'Rahim Shah Song, Romantic Urdu Song, Habibi', 'This is a marvellous song of the famous singer Rahim Shah. The lyrics of this song are really good. '),
(12, 2, 'Ø­Ø¨ÛŒØ¨ÛŒ', 'Ø±Ø­ÛŒÙ… Ø´Ø§Û Ú©ÛŒ Ø¢ÙˆØ§Ø² Ù…ÛŒÚº Ø§ÛŒÚ© Ø®ÙˆØ¨ØµÙˆØ±Øª Ø±ÙˆÙ…Ø§Ù†ÙˆÛŒ Ú¯Ø§Ù†Ø§', 'ÛŒÛ Ù…Ø´ÛÙˆØ± Ú¯Ù„ÙˆÚ©Ø§Ø± Ø±Ø­ÛŒÙ… Ø´Ø§Û Ú©Ø§ Ø§ÛŒÚ© Ù…Ø²ÛŒØ¯Ø§Ø± Ú¯Ø§Ù†Ø§ ÛÛ’Û” Ø§Ø³ Ú©ÛŒ Ø´Ø§Ø¹Ø±ÛŒ Ú©Ù…Ø§Ù„ Ø¯Ø±Ø¬Û’ Ú©ÛŒ ÛÛ’Û”', 'Rahim Shah Song, Romantic Urdu Song, Habibi', 'This is a marvellous song of the famous singer Rahim Shah. The lyrics of this song are really good. '),
(13, 1, 'Neelay Neelay Ambar Par ', 'A popular urdu song in the voice of Belaat Patel', 'This song has been been sung by many singers but Belaat Patel has really made it good.', 'Belaal Patel Songs, Neelay Neelay Ambar, Romantic Song', 'This song has been been sung by many singers but Belaat Patel has really made it good.'),
(13, 2, 'Ù†ÛŒÙ„Û’ Ù†ÛŒÙ„Û’ Ø§Ù…Ø¨Ø± Ù¾Ø±', 'Ø¨Ù„Ø§Ù„ Ù¾Ù¹ÛŒÙ„ Ú©ÛŒ Ø¢ÙˆØ§Ø² Ù…ÛŒÚº Ø§ÛŒÚ© Ù…Ø´ÛÙˆØ± Ú¯Ø§Ù†Ø§', 'ÛŒÛ Ú¯Ø§Ù†Ø§ Ú©Ø¦ÛŒ Ú¯Ù„ÙˆÚ©Ø§Ø±ÙˆÚº Ù†Û’ Ú¯Ø§ÛŒØ§ ÛÛ’ Ù„ÛŒÚ©Ù† Ø¨Ù„Ø§Ù„ Ù¾Ù¹ÛŒÙ„ Ù†Û’ Ø§Ø³Û’ Ø§ÛŒÚ© Ù…Ù†ÙØ±Ø¯ Ø§Ù†Ø¯Ø§Ø² Ø³Û’ Ù¾ÛŒØ´ Ú©ÛŒØ§ ÛÛ’Û”', 'Belaal Patel Songs, Neelay Neelay Ambar, Romantic Song', 'This song has been been sung by many singers but Belaat Patel has really made it good.'),
(14, 1, 'O Vela Yaad Kar ', 'A famous track of Fariha Perveiz', 'This is a popluar track by Fariha Perveiz. Lyrics are really simple and goo and a little bit funny too. ', 'Fariha Perveiz Songs, O Vela Yaad Kar, Popular Song', 'This is a popluar track by Fariha Perveiz. Lyrics are really simple and goo and a little bit funny too. '),
(14, 2, 'Ø§Ùˆ ÙˆÛŒÙ„Ø§ ÛŒØ§Ø¯ Ú©Ø±', 'ÙØ±ÛŒØ­Û Ù¾Ø±ÙˆÛŒØ² Ú©Ø§ Ø§ÛŒÚ© Ù…Ø´ÛÙˆØ± Ø²Ù…Ø§Ù†Û Ú¯Ø§Ù†Ø§', 'ÛŒÛ Ù…Ø´ÛÙˆØ± Ú¯Ù„ÙˆÚ©Ø§Ø±Û ÙØ±ÛŒØ­Û Ù¾Ø±ÙˆÛŒØ² Ú©Ø§ Ø§ÛŒÚ© Ù…Ø´ÛÙˆØ± Ú¯Ø§Ù†Ø§ ÛÛ’Û” Ø§Ø³ Ú©ÛŒ Ø´Ø§Ø¹Ø±ÛŒ Ø§Ù†ØªÛØ§Ø¦ÛŒ Ø³Ø§Ø¯Û Ø§ÙˆØ± Ù…Ø²ÛŒØ¯Ø§Ø± ÛÛ’Û”', 'Fariha Perveiz Songs, O Vela Yaad Kar, Popular Song', 'This is a popluar track by Fariha Perveiz. Lyrics are really simple and goo and a little bit funny too. '),
(15, 1, 'Teri Ummid Tera Intazaar', 'A popular song of Belaal Patel', 'The talented young singer Baleel Patel has made this song really good and new. ', 'Teri Umed Tera Intazaar, Belaat Patel Song', 'The talented young singer Baleel Patel has made this song really good and new'),
(15, 2, 'ØªÛŒØ±ÛŒ Ø§Ù…ÛŒØ¯ ØªÛŒØ±Ø§ Ø§Ù†ØªØ¸Ø§Ø±', 'Ø¨Ù„Ø§Ù„ Ù¾Ù¹ÛŒÙ„ Ú©Ø§ Ø§ÛŒÚ© Ù…Ø´ÛÙˆØ± Ú¯Ø§Ù†Ø§', 'Ù‚Ø§Ø¨Ù„ Ø§ÙˆØ± Ù†ÙˆØ¬ÙˆØ§Ù† Ú¯Ù„ÙˆÚ©Ø§Ø± Ø¨Ù„Ø§Ù„ Ù¾Ù¹ÛŒÙ„ Ù†Û’ Ø§Ø³ Ú¯Ø§Ù†Û’ Ú©Ùˆ ÙˆØ§Ù‚Ø¹ÛŒ Ø¨ÛØª Ø®ÙˆØ¨ØµÙˆØ±Øª Ø§Ù†Ø¯Ø§Ø² Ù…ÛŒÚº Ú¯Ø§ÛŒØ§ ÛÛ’Û”', 'Teri Umed Tera Intazaar, Belaat Patel Song', 'The talented young singer Baleel Patel has made this song really good and new'),
(16, 1, 'Badan Mien Aag', 'A romantic poem', 'This is a romantic and beautiful urdu poem', 'Romantic Peom, Urdu Poetry, Image Urdu Poetry', 'This is a romantic and beautiful urdu poem'),
(16, 2, 'Ø¨Ø¯Ù† Ù…ÛŒÚº Ø¢Ú¯', 'Ø§ÛŒÚ© Ø±ÙˆÙ…Ø§Ù†ÙˆÛŒ Ù†Ø¸Ù…', 'ÛŒÛ Ø§Ø±Ø¯Ùˆ Ú©ÛŒ Ø§ÛŒÚ© Ø®ÙˆØ¨ØµÙˆØ±Øª Ø±ÙˆÙ…Ø§Ù†ÙˆÛŒ Ù†Ø¸Ù… ÛÛ’Û” ', 'Romantic Peom, Urdu Poetry, Image Urdu Poetry', 'This is a romantic and beautiful urdu poem'),
(17, 1, 'Chandni', 'A sweet romantic poem', 'This is a short romantic verse. A perfect one. ', 'Romantic Verse, Romantic Poetry, Chandni', 'This is a short romantic verse. A perfect one. '),
(17, 2, 'Ú†Ø§Ù†Ø¯Ù†ÛŒ', 'Ø§ÛŒÚ© Ù…ÛŒÙ¹Ú¾ÛŒ Ø±ÙˆÙ…Ø§Ù†ÙˆÛŒ ØºØ²Ù„', 'ÛŒÛ Ø§ÛŒÚ© Ù…Ø®ØªØµØ± Ø±ÙˆÙ…Ø§Ù†ÙˆÛŒ Ø¨Ù†Ø¯ ÛÛ’Û”', 'Romantic Verse, Romantic Poetry, Chandni', 'This is a short romantic verse. A perfect one. '),
(18, 1, 'Gum Ho Jata Hon', 'A famous Urdu verse', 'This is a famous verse of Urdu poetry.', 'Famous Urdu Poetry, Urdu Verse, Romantic Verse', 'This is a famous verse of Urdu poetry.'),
(18, 2, 'Ú¯Ù… ÛÙˆ Ø¬Ø§ØªØ§ ÛÙˆÚº', 'Ø§Ø±Ø¯Ùˆ Ú©Ø§ Ø§ÛŒÚ© Ù…Ø´ÛÙˆØ± Ø´Ø¹Ø±', 'ÛŒÛ Ø§Ø±Ø¯Ùˆ Ø§Ø¯Ø¨ Ú©Ø§ Ø§ÛŒÚ© Ù…Ø´ÛÙˆØ± Ø´Ø¹Ø± Ø±ÙˆÙ…Ø§Ù†ÙˆÛŒ Ø´Ø¹Ø± ÛÛ’Û” ', 'Famous Urdu Poetry, Urdu Verse, Romantic Verse', 'This is a famous verse of Urdu poetry.'),
(19, 1, 'Khizaan Ki Rut Mien', 'A urdu verse based on old memories', 'This Urdu verse describes the old memories of a lover. ', 'Urdu Verse, Old Memories Poetry, Romantic Poetry', 'This Urdu verse describes the old memories of a lover.'),
(19, 2, 'Ø®Ø²Ø§Úº Ú©ÛŒ Ø±Øª Ù…ÛŒÚº', 'Ù¾Ø±Ø§Ù†ÛŒ ÛŒØ§Ø¯ÙˆÚº Ù¾Ø± Ù…Ø¨Ù†ÛŒ Ø§Ø±Ø¯Ùˆ Ú©ÛŒ Ø§ÛŒÚ© Ù†Ø¸Ù…', 'ÛŒÛ Ù†Ø¸Ù… Ø§ÛŒÚ© Ø¹Ø§Ø´Ù‚ Ú©ÛŒ Ù¾Ø±Ø§Ù†ÛŒ ÛŒØ§Ø¯ÙˆÚº Ú©Ùˆ Ø¨ÛŒØ§Ù† Ú©Ø±ØªÛŒ ÛÛ’Û”', 'Urdu Verse, Old Memories Poetry, Romantic Poetry', 'This Urdu verse describes the old memories of a lover.'),
(20, 1, 'Charag', 'A wallpaper of urdu poem', 'This is a beautiful wallpaper based on a romantic urdu poem.', 'Poetry Wallpaper, Romantic Poetry Wallpaper, Wallpaper', 'This is a beautiful wallpaper based on a romantic urdu poem.'),
(20, 2, 'Ú†Ø±Ø§Øº', 'Ø§Ø±Ø¯Ùˆ Ú©ÛŒ Ù†Ø¸Ù… Ú©Ø§ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø±', 'ÛŒÛ Ø§Ø±Ø¯Ùˆ Ú©ÛŒ Ø§ÛŒÚ© Ø±ÙˆÙ…Ø§Ù†ÙˆÛŒ Ù†Ø¸Ù… Ù¾Ø± Ù…Ø¨Ù†ÛŒ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø± ÛÛ’Û”', 'Poetry Wallpaper, Romantic Poetry Wallpaper, Wallpaper', 'This is a beautiful wallpaper based on a romantic urdu poem.'),
(21, 1, 'Girls Hostel', 'A wallpaper of funny urdu poetry', 'This is a well-designed wallpaper of a funny urdu verse. ', 'Funny Wallpaper, Poetry Wallpaper, Urdu Poetry Wallpaper', 'This is a well-designed wallpaper of a funny urdu verse. '),
(21, 2, 'Ú¯Ø±Ù„Ø² ÛÙˆØ³Ù¹Ù„', 'Ù…Ø²Ø§Ø­ÛŒÛ Ø§Ø±Ø¯Ùˆ Ø´Ø§Ø¹Ø±ÛŒ Ú©Ø§ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø±', 'ÛŒÛ Ø®ÙˆØ¨ØµÙˆØ±Øª ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø± Ø§ÛŒÚ© Ù…Ø²Ø§Ø­ÛŒÛ Ø§Ø±Ø¯Ùˆ Ù†Ø¸Ù… Ù¾Ø± Ù…Ø¨Ù†ÛŒ ÛÛ’Û”', 'Funny Wallpaper, Poetry Wallpaper, Urdu Poetry Wallpaper', 'This is a well-designed wallpaper of a funny urdu verse. '),
(22, 1, 'Qisay', 'A single-verse wallpaper', 'This beautiful wallpaper contains a singe urdu verse with cool borders. ', 'Urdu Verse Wallpaper, Poetry Wallpaper, Cool Wallpaper', 'This beautiful wallpaper contains a singe urdu verse with cool borders.'),
(22, 2, 'Ù‚ØµÛ’', 'Ø§ÛŒÚ© Ø³Ù†Ú¯Ù„ Ø´Ø¹Ø± Ù¾Ø± Ù…Ø¨Ù†ÛŒ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø±', 'ÛŒÛ Ø®ÙˆØ¨ØµÙˆØ±Øª Ú©Ù†Ø§Ø±ÙˆÚº ÙˆØ§Ù„Û’ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø± Ù¾Ø± Ø§Ø±Ø¯Ùˆ Ú©Ø§ Ø§ÛŒÚ© Ø®ÙˆØ¨ØµÙˆØ±Øª Ø´Ø¹Ø± Ú©Ù†Ù†Ø¯Û ÛÛ’Û”', 'Urdu Verse Wallpaper, Poetry Wallpaper, Cool Wallpaper', 'This beautiful wallpaper contains a singe urdu verse with cool borders.'),
(23, 1, 'Shehr-e-Ahsas', 'Wallpaper based on sad verse', 'This wallpaper is based on sad urdu verse. ', 'Sad Urdu Verse, Poetry Wallpaper, Small Wallpaper', 'This wallpaper is based on sad urdu verse. '),
(23, 2, 'Ø´ÛØ± Ø§Ø­Ø³Ø§Ø³', 'ØºÙ…Ú¯ÛŒÙ† Ø´Ø¹Ø± Ù¾Ø± Ù…Ø¨Ù†ÛŒ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø±', 'ÛŒÛ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø± Ø§Ø±Ø¯Ùˆ Ú©Û’ Ø§ÛŒÚ© ØºÙ…Ú¯ÛŒÙ† Ø´Ø¹Ø± Ù¾Ø± Ù…Ø¨Ù†ÛŒ ÛÛ’Û”', 'Sad Urdu Verse, Poetry Wallpaper, Small Wallpaper', 'This wallpaper is based on sad urdu verse. '),
(24, 1, 'Roses', 'A samll wallpaper with roses', 'This small wallpapers contains a couple of decent roses. ', 'Small Wallpaper, Roses Wallpaper', 'This small wallpapers contains a couple of decent roses. '),
(24, 2, 'Ø±ÙˆØ²Ø²', 'Ú¯Ù„Ø§Ø¨ Ú©Û’ Ù¾Ú¾ÙˆÙ„ÙˆÚº Ù¾Ø± Ù…Ø¨Ù†ÛŒ Ø§ÛŒÚ© Ú†Ú¾ÙˆÙ¹Ø§ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø±', 'Ø§Ø³ Ú†Ú¾ÙˆÙ¹Û’ Ø³Û’ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø± Ù…ÛŒÚº Ø¯Ùˆ Ø®ÙˆØ¨ØµÙˆØ±Øª Ú¯Ù„Ø§Ø¨ Ú©Û’ Ù¾Ú¾ÙˆÙ„ ÛÛŒÚºÛ” ', 'Small Wallpaper, Roses Wallpaper', 'This small wallpapers contains a couple of decent roses. '),
(25, 1, 'Waterfall', 'A waterfall based wallpaper', 'This wallpaper shows a beautiful waterfall. ', 'Waterfall Wallpaper, Beautiful Wallpaer', 'This wallpaper shows a beautiful waterfall. '),
(25, 2, 'ÙˆØ§Ù¹Ø±ÙØ§Ù„', 'ÙˆØ§Ù¹Ø±ÙØ§Ù„ ÙˆØ§Ù„ Ø§ÛŒÚ© ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø±', 'Ø§Ø³ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø± Ù…ÛŒÚº Ø§ÛŒÚ© Ø®ÙˆØ¨ØµÙˆØ±Øª Ù¾Ø§Ù†ÛŒ Ú©Ø§ Ú†Ø´Ù…Û Ø¯Ú©Ú¾Ø§ÛŒØ§ Ú¯ÛŒØ§ ÛÛ’Û”', 'Waterfall Wallpaper, Beautiful Wallpaer', 'This wallpaper shows a beautiful waterfall. '),
(26, 1, 'Stones', 'Wallpaper with colorful stones', 'This wallpaper contains small stones of different colors', 'Stone Wallpaper, Colorful Stones, Small Wallpaper', 'This wallpaper contains small stones of different colors'),
(26, 2, 'Ø³Ù¹ÙˆÙ†Ø²', 'Ø±Ù†Ú¯ Ø¨Ø±Ù†Ú¯Û’ Ù¾ØªÚ¾Ø±ÙˆÚº ÙˆØ§Ù„Ø§ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø±', 'Ø§Ø³ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø± Ù…ÛŒÚº Ù…Ø®ØªÙ„Ù Ø±Ù†Ú¯ÙˆÚº Ú©Û’ Ù¾ØªÚ¾Ø± Ø¯Ú©Ú¾Ø§Ø¦Û’ Ú¯Ø¦Û’ ÛÛŒÚºÛ” ', 'Stone Wallpaper, Colorful Stones, Small Wallpaper', 'This wallpaper contains small stones of different colors'),
(27, 1, 'Spring Dress', 'A fashion based wallpaper', 'This fashion based wallpaper shows a beautiful spring dress of a woman.', 'Fashion Wallpaper, Spring Dress Wallpaper', 'This fashion based wallpaper shows a beautiful spring dress of a woman.'),
(27, 2, 'Ø³Ù¾Ø±Ù†Ú¯ ÚˆØ±ÛŒØ³', 'ÙÛŒØ´Ù† Ù¾Ø± Ù…Ø¨Ù†ÛŒ Ø§ÛŒÚ© ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø±', 'Ø§Ø³ ÙˆØ§Ù„ Ù¾ÛŒÙ¾Ø± Ù…ÛŒÚº Ø§ÛŒÚ© Ø¹ÙˆØ±Øª Ú©Ø§ Ù…ÙˆØ³Ù… Ø¨ÛØ§Ø± Ù…ÛŒÚº Ù¾ÛÙ†Ø§ Ø¬Ø§Ù†Û’ ÙˆØ§Ù„Ø§ Ù„Ø¨Ø§Ø³ Ø¯Ú©Ú¾Ø§ÛŒØ§ Ú¯ÛŒØ§ ÛÛ’Û”', 'Fashion Wallpaper, Spring Dress Wallpaper', 'This fashion based wallpaper shows a beautiful spring dress of a woman.'),
(28, 1, 'Sab Da Malik Allah', 'A video naat of ahmed raza qadri', 'This is a beautiful video naat of Ahmed Raza Qadri.', 'Video Naat, Ahmed Raza Qadri Naat, Sab Da Malik Allah', 'This is a beautiful video naat of Ahmed Raza Qadri.'),
(28, 2, 'Ø³Ø¨ Ø¯Ø§ Ù…Ø§Ù„Ú© Ø§Ù„Ù„Û', 'Ø§Ø­Ù…Ø¯ Ø±Ø¶Ø§ Ù‚Ø§Ø¯Ø±ÛŒ Ú©ÛŒ Ø§ÛŒÚ© ÙˆÚˆÛŒÙˆ Ù†Ø¹Øª', 'ÛŒÛ Ø§Ø­Ù…Ø¯ Ø±Ø¶Ø§ Ù‚Ø§Ø¯Ø±ÛŒ Ú©ÛŒ Ø§ÛŒÚ© Ø®ÙˆØ¨ØµÙˆØ±Øª ÙˆÚˆÛŒÙˆ Ù†Ø¹Øª ÛÛ’Û”', 'Video Naat, Ahmed Raza Qadri Naat, Sab Da Malik Allah', 'This is a beautiful video naat of Ahmed Raza Qadri.'),
(29, 1, 'Sarkar Jantay Hien', 'Famous naat of Ahmed Raza Qadri', 'This is a famous naat, sung by Ahmed Raza Qadri. ', 'Ahmed Raza Qadri Naat, Famous Naat, Sarkar Jantay Hien', 'This is a famous naat, sung by Ahmed Raza Qadri.'),
(29, 2, 'Ø³Ø±Ú©Ø§Ø± Ø¬Ø§Ù†ØªÛ’ ÛÛŒÚº', 'Ø§Ø­Ù…Ø¯ Ø±Ø¶Ø§ Ù‚Ø§Ø¯Ø±ÛŒ Ú©ÛŒ Ù…Ø´ÛÙˆØ± Ù†Ø¹Øª', 'ÛŒÛ Ø§Ø­Ù…Ø¯ Ø±Ø¶Ø§ Ù‚Ø§Ø¯Ø±ÛŒ Ú©ÛŒ Ø§ÛŒÚ© Ù…Ø´ÛÙˆØ± ÙˆÚˆÛŒÙˆ Ù†Ø¹Øª ÛÛ’Û”', 'Ahmed Raza Qadri Naat, Famous Naat, Sarkar Jantay Hien', 'This is a famous naat, sung by Ahmed Raza Qadri.'),
(30, 1, 'Teray Qurban Habibi Maoulai', 'A Sweet naat of Qaria Amber ', 'Qaria Amber has presented this naat in really a sweet and melodious voice. ', 'Qaria Amber Qadria Naat, Teray Qurban Habibi, Video Naat', 'Qaria Amber has presented this naat in really a sweet and melodious voice. '),
(30, 2, 'ØªÛŒØ±Û’ Ù‚Ø±Ø¨Ø§Ù† Ø­Ø¨ÛŒØ¨ÛŒ Ù…ÙˆÙ„Ø§Ø¦ÛŒ', 'Ù‚Ø§Ø±ÛŒÛ Ø§Ù…Ø¨Ø± Ú©ÛŒ Ø§ÛŒÚ© Ø®ÙˆØ¨ØµÙˆØ±Øª Ù†Ø¹Øª', 'Ù‚Ø§Ø±ÛŒÛ Ø§Ù…Ø¨Ø± Ù†Û’ Ø§Ø³ Ù†Ø¹Øª Ú©Ùˆ Ø§Ù†ØªÛØ§Ø¦ÛŒ Ø®ÙˆØ¨ØµÙˆØ±Øª Ø§Ù†Ø¯Ø§Ø² Ù…ÛŒÚº Ù¾ÛŒØ´ Ú©ÛŒØ§ ÛÛ’Û”', 'Qaria Amber Qadria Naat, Teray Qurban Habibi, Video Naat', 'Qaria Amber has presented this naat in really a sweet and melodious voice. '),
(31, 1, 'Ya Ilahi Mari Dunya Mien', 'A prayer by Tariq Mehmood Raufi', 'Old naatkhawan Tariq Mehmood Raufi has presented this naat in a perfect way. ', 'Duaia Naat, Tariq Mehmood Raufi Naat, Ya Ilahi Mari Dunya Mien', 'Old naatkhawan Tariq Mehmood Raufi has presented this naat in a perfect way. '),
(31, 2, 'ÛŒØ§ Ø§Ù„ÛÛŒ Ù…ÛŒØ±ÛŒ Ø¯Ù†ÛŒØ§ Ù…ÛŒÚº', 'Ø·Ø§Ø±Ù‚ Ù…Ø­Ù…ÙˆØ¯ Ø±ÙˆÙÛŒ Ú©ÛŒ Ø¯Ø¹Ø§Ø¦ÛŒÛ Ù†Ø¹Øª', 'Ø·Ø§Ø±Ù‚ Ù…Ø­Ù…ÙˆØ¯ Ø±ÙˆÙÛŒ Ù†Û’ Ø§Ø³ Ø¯Ø¹Ø§Ø¦ÛŒÛ Ù†Ø¹Øª Ú©Ùˆ Ø®ÙˆØ¨ØµÙˆØ±Øª Ø§Ù†Ø¯Ø§Ø² Ù…ÛŒÚº Ù¾ÛŒØ´ Ú©ÛŒØ§ ÛÛ’Û” ', 'Duaia Naat, Tariq Mehmood Raufi Naat, Ya Ilahi Mari Dunya Mien', 'Old naatkhawan Tariq Mehmood Raufi has presented this naat in a perfect way. '),
(32, 1, 'Begam', 'A comedy clip from stage drama', 'This video comedy clip is from a famous stage drama.', 'Video Comedy, Comedy Clip, Stage Drama', 'This video comedy clip is from a famous stage drama.'),
(32, 2, 'Ø¨ÛŒÚ¯Ù…', 'Ø³Ù¹ÛŒØ¬ ÚˆØ±Ø§Ù…Û Ø³Û’ Ù„ÛŒØ§ Ú¯ÛŒØ§ Ø§ÛŒÚ© Ú©Ø§Ù…ÛŒÚˆÛŒ Ú©Ù„Ù¾', 'ÛŒÛ ÙˆÚˆÛŒÙˆ Ú©Ø§Ù…ÛŒÚˆÛŒ Ú©Ù„Ù¾ Ø§ÛŒÚ© Ø³Ù¹ÛŒØ¬ ÚˆØ±Ø§Ù…Û’ Ø³Û’ Ù„ÛŒØ§ Ú¯ÛŒØ§ ÛÛ’Û” ', 'Video Comedy, Comedy Clip, Stage Drama', 'This video comedy clip is from a famous stage drama.'),
(33, 1, 'Halwa', 'A short video comedy clip', 'This is a short video comedy clip containing two characters. ', 'Short Comedy Clip, Video Comedy, ', 'This is a short video comedy clip containing two characters. '),
(33, 2, 'Ø­Ù„ÙˆÛ', 'Ø§ÛŒÚ© Ú†Ú¾ÙˆÙ¹Ø§ Ú©Ø§Ù…ÛŒÚˆÛŒ Ú©Ù„Ù¾', 'ÛŒÛ Ú†Ú¾ÙˆÙ¹Ø§ ÙˆÚˆÛŒÙˆ Ú©Ø§Ù…ÛŒÚˆÛŒ Ú©Ù„Ù¾ Ø¯Ùˆ Ú©Ø±Ø¯Ø§Ø±ÙˆÚº Ù¾Ø± Ù…Ø¨Ù†ÛŒ ÛÛ’Û”', 'Short Comedy Clip, Video Comedy, ', 'This is a short video comedy clip containing two characters. '),
(34, 1, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pr_files`
--

CREATE TABLE IF NOT EXISTS `pr_files` (
  `prf_id` bigint(22) unsigned NOT NULL,
  `prf_thumb` varchar(255) DEFAULT NULL,
  `prf_file` varchar(255) DEFAULT NULL,
  `prf_preview` varchar(255) DEFAULT NULL,
  `ptype_id` int(11) unsigned DEFAULT NULL,
  `pr_id` bigint(22) unsigned DEFAULT NULL,
  `status_id` smallint(1) DEFAULT '1',
  `mem_id` bigint(22) unsigned DEFAULT NULL,
  `prf_added_date` date DEFAULT NULL,
  `is_default` smallint(1) DEFAULT NULL,
  PRIMARY KEY (`prf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pr_files`
--

INSERT INTO `pr_files` (`prf_id`, `prf_thumb`, `prf_file`, `prf_preview`, `ptype_id`, `pr_id`, `status_id`, `mem_id`, `prf_added_date`, `is_default`) VALUES
(1, 'Zahid.jpg', 'Dar e Nabi Per.mp3', 'Dar e Nabi Per.mp3', 0, 1, 1, 2, '2013-12-31', NULL),
(2, 'Hafi.jpg', 'Husn-e-Mehboob Ne.mp3', 'Husn-e-Mehboob Ne.mp3', 0, 2, 1, 2, '2013-12-31', NULL),
(3, 'Pegam.jpg', 'Pegham Saba.mp3', 'Pegham Saba.mp3', 0, 3, 1, 2, '2013-12-31', NULL),
(4, 'Rahim.jpg', 'Qaseeda Burada.mp3', 'Qaseeda Burada.mp3', 0, 4, 1, 2, '2013-12-31', NULL),
(5, 'Shah.jpg', 'Shah-e-Madina.mp3', 'Shah-e-Madina.mp3', 0, 5, 1, 2, '2013-12-31', NULL),
(6, 'Gham.jpg', 'Gham-e-Ashaqi Se Pehlay.mp3', 'Gham-e-Ashaqi Se Pehlay.mp3', 0, 6, 1, 2, '2013-12-31', NULL),
(7, 'Love.jpg', 'Muhabatien Jab Shumar Karna.mp3', 'Muhabatien Jab Shumar Karna.mp3', 0, 7, 1, 2, '2013-12-31', NULL),
(8, 'Hawa.jpg', 'Rat Hawaien Tez Theen.mp3', 'Rat Hawaien Tez Theen.mp3', 0, 8, 1, 2, '2013-12-31', NULL),
(9, 'soz.jpg', 'Soz-e-Gham.mp3', 'Soz-e-Gham.mp3', 0, 9, 1, 2, '2013-12-31', NULL),
(10, 'Khushbo.jpg', 'Teri Hasti Teri Zaat.mp3', 'Teri Hasti Teri Zaat.mp3', 0, 10, 1, 2, '2013-12-31', NULL),
(11, 'Fariha.jpg', 'Basant Mere Paish.mp3', 'Basant Mere Paish.mp3', 0, 11, 1, 2, '2013-12-31', NULL),
(12, 'Rahim.jpg', 'Habibi.mp3', 'Habibi.mp3', 0, 12, 1, 2, '2013-12-31', NULL),
(13, 'Ambar.jpg', 'Neelay Neelay Ambar Par.mp3', 'Neelay Neelay Ambar Par.mp3', 0, 13, 1, 2, '2013-12-31', NULL),
(14, 'Fariha2.jpg', 'O Vela Yaad Kar.mp3', 'O Vela Yaad Kar.mp3', 0, 14, 1, 2, '2013-12-31', NULL),
(15, 'Wait.jpg', 'Teri Ummid Tera Intazaar.mp3', 'Teri Ummid Tera Intazaar.mp3', 0, 15, 1, 2, '2013-12-31', NULL),
(16, 'Wait.jpg', 'Badan Mien Aag.jpg', 'Badan Mien Aag.jpg', 0, 16, 1, 2, '2013-12-31', NULL),
(17, 'Wait.jpg', 'Chandni.jpg', 'Chandni.jpg', 0, 17, 1, 2, '2013-12-31', NULL),
(18, 'Wait.jpg', 'Gum Ho Jata Hon.jpg', 'Gum Ho Jata Hon.jpg', 0, 18, 1, 2, '2013-12-31', NULL),
(19, 'Wait.jpg', 'Khizaan Ki Rut Mien.jpg', 'Khizaan Ki Rut Mien.jpg', 0, 19, 1, 2, '2013-12-31', NULL),
(20, 'Wait.jpg', 'Charag.jpg', 'Charag.jpg', 0, 20, 1, 2, '2013-12-31', NULL),
(21, 'Wait.jpg', 'Girls Hostel.jpg', 'Girls Hostel.jpg', 0, 21, 1, 2, '2013-12-31', NULL),
(22, 'Wait.jpg', 'Qisay.jpg', 'Qisay.jpg', 0, 22, 1, 2, '2013-12-31', NULL),
(23, 'Wait.jpg', 'Shehr-e-Ahsas.jpg', 'Shehr-e-Ahsas.jpg', 0, 23, 1, 2, '2013-12-31', NULL),
(24, 'Wait.jpg', 'Roses.jpg', 'Roses.jpg', 0, 24, 1, 2, '2013-12-31', NULL),
(25, 'Wait.jpg', 'Waterfall.jpg', 'Waterfall.jpg', 0, 25, 1, 2, '2013-12-31', NULL),
(26, 'Wait.jpg', 'Stones.jpg', 'Stones.jpg', 0, 26, 1, 2, '2013-12-31', NULL),
(27, 'Wait.jpg', 'Spring Dress.jpg', 'Spring Dress.jpg', 0, 27, 1, 2, '2013-12-31', NULL),
(28, 'Ahmed.jpg', 'Sab Da Malik Allah.mp4', 'Sab Da Malik Allah.mp4', 0, 28, 1, 2, '2013-12-31', NULL),
(29, 'Ahmed2.jpg', 'Sarkar Jantay Hien.mp4', 'Sarkar Jantay Hien.mp4', 0, 29, 1, 2, '2013-12-31', NULL),
(30, 'Habibi.jpg', 'Teray Qurban Habibi Maoulai.mp4', 'Teray Qurban Habibi Maoulai.mp4', 0, 30, 1, 2, '2013-12-31', NULL),
(31, 'Tariq.jpg', 'Ya Ilahi Mari Dunya Mien.mp4', 'Ya Ilahi Mari Dunya Mien.mp4', 0, 31, 1, 2, '2013-12-31', NULL),
(32, 'Beegam.jpg', 'Begam.3gp', 'Begam.3gp', 0, 32, 1, 2, '2013-12-31', NULL),
(33, 'Hal.jpg', 'Halwa.3gp', 'Halwa.3gp', 0, 33, 1, 2, '2013-12-31', NULL),
(34, '34_9287.jpg', '', '', 1, 34, 1, 1, '2014-01-02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pr_types`
--

CREATE TABLE IF NOT EXISTS `pr_types` (
  `ptype_id` int(11) unsigned NOT NULL DEFAULT '0',
  `ptype_value` varchar(255) DEFAULT NULL,
  `cat_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`ptype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pr_types`
--

INSERT INTO `pr_types` (`ptype_id`, `ptype_value`, `cat_id`) VALUES
(1, 'mp3', 1),
(3, 'mp4', 2),
(6, '1200X800', 4),
(7, 'mp3', 3);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_charges`
--

CREATE TABLE IF NOT EXISTS `shipping_charges` (
  `continent_id` smallint(2) NOT NULL,
  `continent_name` varchar(255) DEFAULT NULL,
  `continent_value` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`continent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipping_charges`
--

INSERT INTO `shipping_charges` (`continent_id`, `continent_name`, `continent_value`) VALUES
(1, 'Asia', 300),
(2, 'Africa', 100),
(3, 'North America', 700),
(4, 'South America', 800),
(5, 'Antarctica', 200),
(6, 'Europe', 500),
(7, 'Australia', 400),
(8, 'Miscellaneous countries/Islands', 600);

-- --------------------------------------------------------

--
-- Table structure for table `shortcodes`
--

CREATE TABLE IF NOT EXISTS `shortcodes` (
  `sc_id` int(11) unsigned NOT NULL,
  `sc_code` varchar(255) DEFAULT NULL,
  `sctype_id` int(11) unsigned DEFAULT NULL,
  `cs_isprice` smallint(1) DEFAULT NULL,
  `cs_price` bigint(22) unsigned DEFAULT NULL,
  PRIMARY KEY (`sc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shortcodes`
--

INSERT INTO `shortcodes` (`sc_id`, `sc_code`, `sctype_id`, `cs_isprice`, `cs_price`) VALUES
(1, 'ABC123', 1, 1, 1000),
(2, 'ABC1234', 1, 1, 25000),
(3, '123ABC', 1, NULL, NULL),
(4, '1234ABC', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shortcode_type`
--

CREATE TABLE IF NOT EXISTS `shortcode_type` (
  `sctype_id` int(11) unsigned NOT NULL,
  `sctype_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sctype_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shortcode_type`
--

INSERT INTO `shortcode_type` (`sctype_id`, `sctype_name`) VALUES
(1, 'MO'),
(2, 'MT');

-- --------------------------------------------------------

--
-- Table structure for table `site_config`
--

CREATE TABLE IF NOT EXISTS `site_config` (
  `config_id` int(11) unsigned NOT NULL DEFAULT '0',
  `config_sitename` varchar(255) DEFAULT NULL,
  `config_sitetitle` varchar(255) DEFAULT NULL,
  `config_siteslogan` varchar(255) DEFAULT NULL,
  `config_metakey` text,
  `config_metades` text,
  `config_upload_limit` int(11) unsigned DEFAULT '0',
  `config_site_email` varchar(255) DEFAULT NULL,
  `config_file` varchar(255) DEFAULT NULL,
  `status_id` smallint(1) unsigned DEFAULT '1',
  PRIMARY KEY (`config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `site_config`
--

INSERT INTO `site_config` (`config_id`, `config_sitename`, `config_sitetitle`, `config_siteslogan`, `config_metakey`, `config_metades`, `config_upload_limit`, `config_site_email`, `config_file`, `status_id`) VALUES
(1, 'Wap Portal', 'Wap Portal', 'Learning App', 'Wap Portal', 'Wap Portal', 10240, 'info@domain.com', '1_155312a892hurmat.ico', 1);

-- --------------------------------------------------------

--
-- Table structure for table `site_variables`
--

CREATE TABLE IF NOT EXISTS `site_variables` (
  `sv_id` bigint(22) unsigned NOT NULL,
  `lang_id` bigint(22) unsigned DEFAULT '1',
  `sv_login` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_logout` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_register` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_search` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_audios` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_ringtones` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_movies` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_wallpapers` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_new` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_top_rated` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_most_viewed` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_featured` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_enter_email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_newsletter` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_copyright` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_allrights` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_related_items` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_views` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_view_file` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_listen` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_rating` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_gift` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_wishlist` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_add_to_wishlist` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sv_download` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_news` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_faqs` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_advance_search` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_about` varchar(255) CHARACTER SET utf32 DEFAULT NULL,
  `sv_contact` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_phone` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_message` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_categories` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_submit` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sv_my_account` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`sv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_variables`
--

INSERT INTO `site_variables` (`sv_id`, `lang_id`, `sv_login`, `sv_logout`, `sv_register`, `sv_search`, `sv_audios`, `sv_ringtones`, `sv_movies`, `sv_wallpapers`, `sv_new`, `sv_top_rated`, `sv_most_viewed`, `sv_featured`, `sv_enter_email`, `sv_newsletter`, `sv_copyright`, `sv_allrights`, `sv_related_items`, `sv_views`, `sv_view_file`, `sv_listen`, `sv_rating`, `sv_gift`, `sv_wishlist`, `sv_add_to_wishlist`, `sv_download`, `sv_news`, `sv_faqs`, `sv_advance_search`, `sv_about`, `sv_contact`, `sv_name`, `sv_email`, `sv_phone`, `sv_message`, `sv_categories`, `sv_submit`, `sv_my_account`) VALUES
(1, 1, 'Login', 'Logout', 'Register', 'Enter Keywords...', 'Audio Tracks', 'Ringtones', 'Movies', 'Wallpapers', 'New', 'Top Rated', 'Most Viewed', 'Featured', 'Enter Your Email', 'Signup to our newsletter', 'Copyright', 'All Rights Reserved', 'Related Items', 'Views', 'View', 'Listen', 'Ratings', 'Gift to Friend', 'My Wishlist', 'Add to Wishlist', 'Download', 'News', 'FAQs', 'Advance Search', 'About', 'Contact Us', 'Name', 'Email', 'Phone', 'Message', 'Categories', 'Submit', 'My Account'),
(2, 2, 'Ù„Ø§Ú¯ Ø§Ù†', 'Ù„Ø§Ú¯ Ø¢Ø¤Ù¹ Ú©Ø±ÛŒÚº', 'Ø§Ù†Ø¯Ø±Ø§Ø¬', 'ØªÙ„Ø§Ø´ Ú©Ø±ÛŒÚº', 'Ø¢ÚˆÛŒÙˆ Ú¯Ø§Ù†Û’', 'Ø±Ù†Ú¯ Ù¹ÙˆÙ†Ø²', 'ÙˆÚˆÛŒÙˆØ²', 'ØªØµØ§ÙˆÛŒØ±', 'Ù†Ø¦Û’', 'Ø³Ø¨ Ø³Û’ Ø§ÙˆÙ¾Ø± reted', 'Ø°ÛŒØ§Ø¯Û Ø¯ÛŒÚ©Ú¾Ø§ Ø¬Ø§Ù†Û’ ÙˆØ§Ù„', 'Ù†Ù…Ø§ÛŒØ§Úº', 'Ø§ÛŒ Ù…ÛŒÙ„ Ø¯Ø±Ø¬ Ú©Ø±ÛŒÚº', 'Ù†ÛŒÙˆØ² Ù„ÛŒÙ¹Ø± Ú©Û’ Ù„Ø¦Û’ Ø³Ø§Ø¦Ù† Ø§Ù¾ Ú©Ø±ÛŒÚº', 'Ú©Ø§Ù¾ÛŒ Ø±Ø§Ø¦Ù¹', 'Ø¬Ù…Ù„Û Ø­Ù‚ÙˆÙ‚ Ù…Ø­ÙÙˆØ¸ ÛÛŒÚº', 'Ù…ØªØ¹Ù„Ù‚Û Ø§Ø´ÛŒØ§Ø¡', 'Ú©Ù„ Ø¢Ø±Ø§Ø¡', 'Ø¯ÛŒÚ©Ú¾ÛŒÚº', 'Ø³Ù†Ù†Û’', 'Ø¯Ø±Ø¬Û Ø¨Ù†Ø¯ÛŒ', 'Ø¯ÙˆØ³Øª Ú©Ùˆ ØªØ­ÙÛ', 'Ù…ÛŒØ±ÛŒ Ø®ÙˆØ§ÛØ´ Ú©ÛŒ ÙÛØ±Ø³Øª', 'Ø®ÙˆØ§ÛØ´ Ú©ÛŒ ÙÛØ±Ø³Øª Ù…ÛŒÚº Ø´Ø§Ù…Ù„', 'ÚˆØ§Ø¤Ù† Ù„ÙˆÚˆ', 'Ø®Ø¨Ø±ÛŒÚº', 'Ø³ÙˆØ§Ù„Ø§Øª', 'Ø§ÛŒÚˆÙˆØ§Ù†Ø³ ØªÙ„Ø§Ø´', 'Ø¨Ø§Ø±Û’ Ù…ÛŒÚº', 'ÛÙ… Ø³Û’ Ø±Ø§Ø¨Ø·Û Ú©Ø±ÛŒÚº', 'Ù†Ø§Ù…', 'Ø§ÛŒ Ù…ÛŒÙ„', 'ÙÙˆÙ†', 'Ù¾ÛŒØºØ§Ù…', 'Ø²Ù…Ø±Û’', 'Ø¬Ù…Ø¹ Ú©Ø±Ø§Ø¦ÛŒÚº', 'Ø§Ù¾Ù†Û’ Ø§Ú©Ø§Ø¤Ù†Ù¹ Ù…ÛŒÚº');

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE IF NOT EXISTS `social_links` (
  `link_id` int(11) unsigned NOT NULL,
  `link_title` varchar(100) DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `link_file` varchar(255) DEFAULT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `social_links`
--

INSERT INTO `social_links` (`link_id`, `link_title`, `link_url`, `link_file`, `status_id`) VALUES
(1, 'Facebook', 'https://www.facebook.com/', 'img1.png', 1),
(2, 'Twitter', 'http://www.twitter.com', 'img2.png', 1),
(3, 'Youtube', 'https://www.youtube.com/', 'img3.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` char(40) NOT NULL,
  `state_abbrev` char(2) NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`state_id`, `state_name`, `state_abbrev`) VALUES
(1, 'Alaska', 'AK'),
(2, 'Alabama', 'AL'),
(3, 'American Samoa', 'AS'),
(4, 'Arizona', 'AZ'),
(5, 'Arkansas', 'AR'),
(6, 'California', 'CA'),
(7, 'Colorado', 'CO'),
(8, 'Connecticut', 'CT'),
(9, 'Delaware', 'DE'),
(10, 'District of Columbia', 'DC'),
(11, 'Federated States of Micronesia', 'FM'),
(12, 'Florida', 'FL'),
(13, 'Georgia', 'GA'),
(14, 'Guam', 'GU'),
(15, 'Hawaii', 'HI'),
(16, 'Idaho', 'ID'),
(17, 'Illinois', 'IL'),
(18, 'Indiana', 'IN'),
(19, 'Iowa', 'IA'),
(20, 'Kansas', 'KS'),
(21, 'Kentucky', 'KY'),
(22, 'Louisiana', 'LA'),
(23, 'Maine', 'ME'),
(24, 'Marshall Islands', 'MH'),
(25, 'Maryland', 'MD'),
(26, 'Massachusetts', 'MA'),
(27, 'Michigan', 'MI'),
(28, 'Minnesota', 'MN'),
(29, 'Mississippi', 'MS'),
(30, 'Missouri', 'MO'),
(31, 'Montana', 'MT'),
(32, 'Nebraska', 'NE'),
(33, 'Nevada', 'NV'),
(34, 'New Hampshire', 'NH'),
(35, 'New Jersey', 'NJ'),
(36, 'New Mexico', 'NM'),
(37, 'New York', 'NY'),
(38, 'North Carolina', 'NC'),
(39, 'North Dakota', 'ND'),
(40, 'Northern Mariana Islands', 'MP'),
(41, 'Ohio', 'OH'),
(42, 'Oklahoma', 'OK'),
(43, 'Oregon', 'OR'),
(44, 'Palau', 'PW'),
(45, 'Pennsylvania', 'PA'),
(46, 'Puerto Rico', 'PR'),
(47, 'Rhode Island', 'RI'),
(48, 'South Carolina', 'SC'),
(49, 'South Dakota', 'SD'),
(50, 'Tennessee', 'TN'),
(51, 'Texas', 'TX'),
(52, 'Utah', 'UT'),
(53, 'Vermont', 'VT'),
(54, 'Virgin Islands', 'VI'),
(55, 'Virginia', 'VA'),
(56, 'Washington', 'WA'),
(57, 'West Virginia', 'WV'),
(58, 'Wisconsin', 'WI'),
(59, 'Wyoming', 'WY'),
(60, 'Armed Forces Africa', 'AE'),
(61, 'Armed Forces Americas (except Canada)', 'AA'),
(62, 'Armed Forces Canada', 'AE'),
(63, 'Armed Forces Europe', 'AE'),
(64, 'Armed Forces Middle East', 'AE'),
(65, 'Armed Forces Pacific', 'AP'),
(66, 'None', '--');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(11) unsigned NOT NULL,
  `status_name` varchar(255) DEFAULT NULL,
  `status_name2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_name`, `status_name2`) VALUES
(0, 'Inactive', 'No'),
(1, 'Active', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE IF NOT EXISTS `subscribers` (
  `sub_id` bigint(20) NOT NULL,
  `sub_name` varchar(100) DEFAULT NULL,
  `sub_email` varchar(255) DEFAULT NULL,
  `sub_date` date DEFAULT NULL,
  PRIMARY KEY (`sub_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`sub_id`, `sub_name`, `sub_email`, `sub_date`) VALUES
(1, '', 'info@domain.com', '2013-09-23');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE IF NOT EXISTS `testimonials` (
  `tm_id` int(11) NOT NULL,
  `tm_details` text,
  `tm_signature` varchar(255) DEFAULT NULL,
  `tm_date` date DEFAULT NULL,
  `status_id` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`tm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`tm_id`, `tm_details`, `tm_signature`, `tm_date`, `status_id`) VALUES
(1, 'Donec eu aliquet nibh. Proin blandit auctor luctus. Donec rhoncus aliquet accumsan. Nunc volutpat rhoncus placerat. Quisque ultrices tempus pharetra. Donec laoreet sem vehicula purus sollicitudin feugiat. In egestas metus consectetur justo suscipit adipis', 'John Doe, CEO Company Inc.', '2013-08-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `topups`
--

CREATE TABLE IF NOT EXISTS `topups` (
  `tup_id` int(11) unsigned NOT NULL,
  `tup_name` varchar(255) DEFAULT NULL,
  `tup_fee` float(11,2) unsigned DEFAULT NULL,
  `tup_videos_downloads` int(11) unsigned DEFAULT NULL,
  `tup_videos_streams` int(11) unsigned DEFAULT NULL,
  `tup_audios_downloads` int(11) unsigned DEFAULT NULL,
  `tup_audios_streams` int(11) unsigned DEFAULT NULL,
  `tup_wallpapers_downloads` int(11) unsigned DEFAULT NULL,
  `tup_ringtones_downlaods` int(11) unsigned DEFAULT NULL,
  `tup_gifts` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`tup_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topups`
--

INSERT INTO `topups` (`tup_id`, `tup_name`, `tup_fee`, `tup_videos_downloads`, `tup_videos_streams`, `tup_audios_downloads`, `tup_audios_streams`, `tup_wallpapers_downloads`, `tup_ringtones_downlaods`, `tup_gifts`) VALUES
(1, '1', 2.00, 3, 4, 5, 6, 7, 8, 9);

-- --------------------------------------------------------

--
-- Table structure for table `usage_type`
--

CREATE TABLE IF NOT EXISTS `usage_type` (
  `ustype_id` int(11) unsigned NOT NULL,
  `ustype_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ustype_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usage_type`
--

INSERT INTO `usage_type` (`ustype_id`, `ustype_name`) VALUES
(1, 'Streams'),
(2, 'Downloads');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` tinyint(9) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(255) NOT NULL DEFAULT '',
  `user_password` varchar(255) NOT NULL DEFAULT '',
  `utype_id` int(11) unsigned DEFAULT NULL,
  `ins_id` bigint(22) unsigned DEFAULT '0',
  `tchr_id` int(11) unsigned DEFAULT NULL,
  `status_id` int(11) unsigned DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_password`, `utype_id`, `ins_id`, `tchr_id`, `status_id`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 0, NULL, 1),
(2, 'admin2', 'c84258e9c39059a89ab77d846ddab909', 2, 1, 0, 1),
(3, 'admin3', '32cacb2f994f6b42183a1300d9a3e8d6', 3, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE IF NOT EXISTS `user_type` (
  `utype_id` int(11) unsigned NOT NULL,
  `utype_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`utype_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`utype_id`, `utype_name`) VALUES
(1, 'SuperAdmin'),
(2, 'SchoolAdmin'),
(3, 'Teachers');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `vot_id` bigint(22) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `rate` double(22,1) NOT NULL DEFAULT '0.0',
  `section_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`vot_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=151 ;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`vot_id`, `user_id`, `pro_id`, `rate`, `section_id`) VALUES
(1, 1, 9, 2.0, 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
