-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 21, 2012 at 11:45 AM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `osc`
--
CREATE DATABASE `osc` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `osc`;

-- --------------------------------------------------------

--
-- Table structure for table `buy`
--

CREATE TABLE IF NOT EXISTS `buy` (
  `sid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `dateofbuy` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sid`,`gid`,`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buy`
--

INSERT INTO `buy` (`sid`, `gid`, `pid`, `quantity`, `dateofbuy`) VALUES
(2, 2, 1, 10, '2012-04-13 02:07:16'),
(3, 3, 2, 12, '2012-04-13 02:07:37'),
(4, 4, 3, 14, '2012-04-13 02:07:57'),
(5, 5, 4, 13, '2012-04-13 02:08:18'),
(6, 6, 5, 20, '2012-04-13 02:08:37'),
(2, 6, 6, 12, '2012-04-13 02:09:25'),
(4, 4, 7, 18, '2012-04-13 02:09:42'),
(3, 6, 9, 8, '2012-04-13 02:10:03'),
(4, 2, 10, 1, '2012-04-13 02:15:30'),
(5, 6, 11, 13, '2012-04-13 02:15:49'),
(2, 2, 12, 19, '2012-04-13 02:16:06'),
(3, 4, 13, 7, '2012-04-13 02:16:22'),
(5, 5, 14, 16, '2012-04-13 02:16:40'),
(6, 6, 15, 15, '2012-04-13 02:16:54'),
(3, 3, 16, 1, '2012-04-13 02:17:10'),
(4, 2, 17, 5, '2012-04-13 02:17:27'),
(6, 6, 18, 14, '2012-04-13 02:17:40');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `uid` varchar(50) NOT NULL,
  `pid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`uid`,`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`uid`, `pid`, `quantity`) VALUES
('manik', 17, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `pcid` int(11) DEFAULT NULL,
  `cname` varchar(100) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cid`, `pcid`, `cname`, `description`) VALUES
(1, 0, 'Clothing', 'All comfortable and affordable clothing products from MANILAM'),
(2, 1, 'Men', 'Mens Clothing Section'),
(3, 1, 'Women', 'Womens Clothing Section'),
(4, 2, 'M_Child', 'Male Children Clothing Section'),
(5, 2, 'M_Adult', 'Male Adults Clothing Section'),
(6, 4, 'Dresses', 'Children Dresses Are Available Here'),
(7, 5, 'T_shirts', 'Good Quality T_Shirts From Different Reputed Companies Are Available Here'),
(8, 5, 'Jeans', 'Good Quality Jeans From Different Reputed Companies Are Available Here'),
(9, 3, 'W_Child', 'Children Dresses Are Available Here'),
(10, 9, 'Dresses', 'Girls Children Clothing Section'),
(11, 3, 'W_Adult', 'Female Adults Clothing Section'),
(12, 11, 'Chudidaars', 'Chudidaars For Female Adults Are Available Here'),
(13, 11, 'Sarees', 'Sarees Section'),
(14, 0, 'Electronics', 'Different type Of Electronics Goods Of Reputed Companies  Are Available Here'),
(15, 14, 'Mobile Phones', 'Mobile phones section'),
(16, 15, 'Touch Screen Mobiles', 'Good Touch Screen Mobiles Of Reputed Companies Are Available Here'),
(17, 15, 'Basic Model Phones', 'Basic Mobile Phones Section'),
(18, 14, 'Computers', 'Different types Of Computers Of Reputed Companies  Are Available Here'),
(19, 18, 'Desktop', 'Different type Of Desktops Of Reputed Companies  Are Available Here'),
(27, 18, 'Laptops', 'Different types Of Laptops Of Reputed Companies  Are Available Here'),
(28, 0, 'Sports_Equipment', 'All Sports Related Stuff is Available Here'),
(29, 28, 'Football', 'Football Related Products Are Available Here'),
(30, 28, 'Cricket', 'Cricket Related Products Are Available Here');

-- --------------------------------------------------------

--
-- Table structure for table `godowns`
--

CREATE TABLE IF NOT EXISTS `godowns` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `incharge` varchar(50) NOT NULL,
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `godowns`
--

INSERT INTO `godowns` (`gid`, `name`, `location`, `phone`, `incharge`) VALUES
(2, 'Sri Sai priya', 'Chennai', '9092557739', 'Jason'),
(3, 'Sri Supriya', 'Vizag', '9989343434', 'Sampadarao'),
(4, 'Sri Balaji', 'Hyderabad', '9790882931', 'Anil Reddy'),
(5, 'Sri Venkateswara', 'kakinada', '9092799329', 'Venkata Manik'),
(6, 'Sri Laxmi Srinivasa', 'Mahabubabad', '7200294024', 'Laxmi');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
  `ocode` varchar(10) NOT NULL,
  `used` int(11) NOT NULL,
  `percent` int(11) NOT NULL,
  PRIMARY KEY (`ocode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`ocode`, `used`, `percent`) VALUES
('OFFERIIIT', 1, 10),
('OFFERIIT', 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL,
  `orderdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `oid` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`tid`, `uid`, `orderdate`, `oid`) VALUES
(1, 'admin', '2012-04-12 22:33:34', NULL),
(2, 'admin', '2012-04-12 22:44:38', NULL),
(3, 'admin', '2012-04-13 00:48:32', NULL),
(4, 'manik', '2012-04-13 01:53:20', NULL),
(5, 'ilam', '2012-04-13 01:57:14', NULL),
(6, 'laxmi', '2012-04-13 02:01:19', NULL),
(7, 'manik', '2012-04-13 02:02:02', NULL),
(8, 'laxmi', '2012-04-13 02:03:15', NULL),
(9, 'laxmi', '2012-04-13 02:03:52', NULL),
(10, 'admin', '2012-04-13 09:18:19', 'OFFERIIT'),
(11, 'admin', '2012-04-13 09:26:41', NULL),
(12, 'admin', '2012-04-13 09:27:17', NULL),
(13, 'abc', '2012-04-13 10:33:03', 'OFFERIIIT'),
(14, 'manik', '2012-04-13 15:14:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders_details`
--

CREATE TABLE IF NOT EXISTS `orders_details` (
  `tid` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`tid`,`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders_details`
--

INSERT INTO `orders_details` (`tid`, `pid`, `quantity`) VALUES
(1, 1, 10),
(2, 1, 5),
(3, 1, 2),
(3, 2, 4),
(4, 2, 1),
(4, 7, 1),
(4, 12, 2),
(4, 14, 4),
(4, 17, 1),
(5, 6, 3),
(5, 10, 2),
(5, 13, 6),
(6, 3, 5),
(6, 11, 4),
(7, 9, 7),
(8, 1, 2),
(9, 15, 3),
(10, 3, 2),
(11, 15, 2),
(12, 10, 2),
(13, 13, 3),
(13, 18, 2),
(14, 11, 4);

-- --------------------------------------------------------

--
-- Table structure for table `prod`
--

CREATE TABLE IF NOT EXISTS `prod` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `pname` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `typeprice` varchar(10) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `description` text,
  `cid` int(11) DEFAULT NULL,
  `available` int(11) DEFAULT '0',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `prod`
--

INSERT INTO `prod` (`pid`, `pname`, `price`, `typeprice`, `company`, `description`, `cid`, `available`) VALUES
(1, 'Micromax M456', 5000, 'Piece', 'Micromax', 'Micromax is good and durable', 15, 0),
(2, 'Lenovo Think Pad', 32000, 'Piece', 'Lenovo', 'Good Quality,4 GB Ram,320 GB hard Disk', 27, 0),
(3, 'Dell Inspiron', 35000, 'Piece', 'Dell', 'Good Quality,4 GB Ram,320 GB hard Disk,I3 Processor', 27, 0),
(4, 'Dell', 28000, 'Piece', 'Dell', 'Good Quality,4 GB Ram,320 GB hard Disk', 19, 0),
(5, 'Lenovo', 27000, 'Piece', 'Lenovo', 'Good Quality,4 GB Ram,320 GB hard Disk,I3 Processor', 19, 0),
(6, 'Nokia 1200', 1200, 'Piece', 'Nokia', 'Good Quality,Good Battery Back_up', 17, 0),
(7, 'Samsung Wave 525', 6200, 'Piece', 'Samsung', 'Good Quality,Good Battery Back_up', 16, 0),
(9, 'Pochampalli Sarees', 2000, 'Piece', 'Pochampally Handlooms', 'Good Quality,Durable', 13, 0),
(10, 'Denizen Jeans', 1200, 'Piece', 'Levis', 'Good Quality,Durable', 8, 0),
(11, 'Anarkali Chudidaars', 700, 'Piece', 'Neerus', 'Good Quality,Durable', 12, 0),
(12, 'Reebok Jeans', 3000, 'Piece', 'Reebok', 'Good Quality,Durable', 8, 0),
(13, 'Denizen T_Shirts', 500, 'Piece', 'Levis', 'Good Quality,Durable', 7, 0),
(14, 'Reebok T_Shirts', 700, 'Piece', 'Reebok', 'Good Quality,Durable', 7, 0),
(15, 'Banares Sarees', 1300, 'piece', 'Charmas', 'Good Quality,Durable', 13, 0),
(16, 'Toshiba', 26000, 'Piece', 'Toshiba', 'Good Quality,Durable', 18, 0),
(17, 'Rice Cooker', 3400, 'Piece', 'Ganga', 'Good Quality,Durable', 14, 0),
(18, 'Salwar Kameez', 1200, 'Piece', 'Ushars', 'Looks good on you !! Come and buy', 12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `contract` int(11) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`sid`, `name`, `phone`, `email`, `contract`) VALUES
(2, 'Vinesh', '9490323456', 'vinesh@gmail.com', 9),
(3, 'Vasavi', '9962248696', 'vasavi@gmail.com', 8),
(4, 'Bokkisa koushik', '7200494331', 'bokkisa@gmail.com', 8),
(5, 'Vishnu Teja Kay', '728282828', 'vishnukayteja@gmail.com', 14),
(6, 'Megan', '9029292284', 'megan@gmail.com', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `billadd` varchar(250) DEFAULT NULL,
  `deladd` varchar(250) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `password`, `fname`, `lname`, `phone`, `email`, `billadd`, `deladd`) VALUES
('abc', 'abc', 'abc', 'abc', '934932', 'kdsjfk@gmail.com', 'skdjflksj', 'Tljs'),
('admin', 'admin', 'Administrator', 'MANILAM', '3493493', '', 'Tambaram', 'Melakottaiyur'),
('ilam', 'ilam', 'Ilambharathi', 'Kanniah', '9092557738', 'ilambhaathik@gmail.co.in', '37/5,Welcome Colony, Ananagar , Chennai', '37/5,Welcome Colony, Annanagar , Chennai'),
('laxmi', 'laxmi', 'laxmi', 'pranitha', '7200494024', 'pranithabodla@gmail.com', 'escapes,chennai,600036', 'adyar,chennai,600036'),
('manik', 'manik', 'manik', 'gode', '9092799329', 'manikgode@gmail.com', 'tnagar,chennai,600036', 'annanagar,chennai,600036');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
