-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 03, 2012 at 08:51 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wpbay`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_jzzf_element`
--

CREATE TABLE IF NOT EXISTS `wp_jzzf_element` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `form` bigint(20) NOT NULL,
  `order` int(12) NOT NULL,
  `type` varchar(1024) NOT NULL,
  `title` varchar(1024) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `formula` varchar(1024) NOT NULL,
  `value` varchar(1024) NOT NULL,
  `value2` varchar(1024) NOT NULL,
  `default` varchar(1024) NOT NULL,
  `external` int(1) NOT NULL,
  `params` varchar(2048) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `wp_jzzf_element`
--

INSERT INTO `wp_jzzf_element` (`id`, `form`, `order`, `type`, `title`, `name`, `formula`, `value`, `value2`, `default`, `external`, `params`) VALUES
(19, 3, 5, 'f', 'Third', 'third_out', 'third', '', '', '', 0, ''),
(18, 3, 4, 'f', 'Second', 'second_out', 'second', '', '', '', 0, ''),
(17, 3, 3, 'f', 'First', 'first_out', 'first', '', '', '', 0, ''),
(16, 3, 2, 'n', 'Third: Default 10, factor 1.12', 'third', '', '1.12', '', '10', 0, ''),
(15, 3, 1, 'n', 'Second: Default 10, no factor', 'second', '', '', '', '10', 0, ''),
(14, 3, 0, 'n', 'First: No Default, no factor', 'first', '', '', '', '', 0, ''),
(21, 4, 0, 'd', 'No Options', 'first', '', '', '', '', 0, ''),
(22, 4, 1, 'd', 'Two Options, default first, no values', 'second', '', '', '', '', 0, ''),
(23, 4, 2, 'd', 'Two Options, default second, values', 'third', '', '', '', '', 0, ''),
(24, 4, 3, 'd', 'Three Options', 'fourth', '', '', '', '', 0, ''),
(25, 4, 4, 'f', 'First', 'first_out', 'first', '', '', '', 0, ''),
(26, 4, 5, 'f', 'Second', 'second_out', 'second', '', '', '', 0, ''),
(27, 4, 6, 'f', 'Third', 'third_out', 'third', '', '', '', 0, ''),
(28, 4, 7, 'f', 'Fourth', 'fourth_out', 'fourth', '', '', '', 0, ''),
(29, 5, 0, 'r', 'No options', 'first', '', '', '', '', 0, ''),
(30, 5, 1, 'r', 'Two options, default first, no values', 'second', '', '', '', '', 0, ''),
(31, 5, 2, 'r', 'Two options, default second, values', 'third', '', '', '', '', 0, ''),
(32, 5, 3, 'r', 'Three options, default third, values', 'fourth', '', '', '', '', 0, ''),
(33, 5, 4, 'f', 'First', 'first_out', 'first', '', '', '', 0, ''),
(34, 5, 5, 'f', 'Second', 'second_out', 'second', '', '', '', 0, ''),
(35, 5, 6, 'f', 'Third', 'third_out', 'third', '', '', '', 0, ''),
(36, 5, 7, 'f', 'Fourth', 'fourth_out', 'fourth', '', '', '', 0, ''),
(37, 6, 0, 'c', 'No values, default checked', 'first', '', '', '', '1', 0, ''),
(38, 6, 1, 'f', 'First', 'first_out', 'first', '', '', '', 0, ''),
(39, 6, 2, 'c', 'No unchecked value, default unchecked', 'second', '', '10', '', '0', 0, ''),
(40, 6, 3, 'f', 'Second', 'second_out', 'second', '', '', '', 0, ''),
(41, 6, 4, 'c', 'Normal', 'third', '', '20', '10', '1', 0, ''),
(42, 6, 5, 'f', 'Third', 'third_out', 'third', '', '', '', 0, ''),
(43, 7, 0, 'n', 'Number entry (ID=id1)', 'id1', '', '1', '', '100', 0, ''),
(44, 7, 1, 'r', 'Radio buttons (ID=id2)', 'id2', '', '', '', '', 0, ''),
(45, 7, 2, 'f', 'Output (id3)', 'id3', 'id1*id2', '', '', '', 0, ''),
(46, 8, 0, 'n', 'Number Entry (ID=id1)', 'id1', '', '', '', '200', 0, ''),
(47, 8, 1, 'r', 'Radio (id2)', 'id2', '', '', '', '', 0, ''),
(48, 8, 2, 'f', 'Output', 'id3', 'id1+id2', '', '', '', 0, ''),
(49, 9, 0, 'n', 'Есть силы нью мы', 'element', '', '', '', 'Бы должником интервьюирования про', 0, ''),
(50, 10, 0, 'n', 'First', 'first', '', '', '', '3', 0, ''),
(51, 10, 1, 'n', 'Second', 'second', '', '', '', '4', 0, ''),
(52, 10, 2, 'f', 'Sum', 'sum', 'first+second', '', '', '', 0, ''),
(53, 10, 3, 'f', 'Difference', 'difference', 'first-second', '', '', '', 0, ''),
(54, 10, 4, 'f', 'Product', 'product', 'first*second', '', '', '', 0, ''),
(55, 10, 5, 'f', 'Division', 'division', 'first/second', '', '', '', 0, ''),
(56, 10, 6, 'f', 'Exponentiation', 'exponentiation', 'first^second', '', '', '', 0, ''),
(57, 10, 7, 'f', 'Cube', 'cube', 'first^3', '', '', '', 0, ''),
(58, 10, 8, 'f', 'Precedence: first+2*second', 'precedence', 'first+2*second', '', '', '', 0, ''),
(59, 10, 9, 'f', 'Association: (first+2)*second', 'association', '(first+2)*second', '', '', '', 0, ''),
(70, 12, 4, 'f', 'Greater or Equal', 'ge', 'first>=second', '', '', '', 0, ''),
(69, 12, 3, 'f', 'Less', 'less', 'first<second', '', '', '', 0, ''),
(68, 12, 2, 'f', 'Greater', 'greater', 'first>second', '', '', '', 0, ''),
(67, 12, 1, 'n', 'Second', 'second', '', '', '', '20', 0, ''),
(66, 12, 0, 'n', 'First', 'first', '', '', '', '10', 0, ''),
(71, 12, 5, 'f', 'Less or Equal', 'le', 'first<=second', '', '', '', 0, ''),
(72, 12, 6, 'f', 'Not Equal', 'ne', 'first<>second', '', '', '', 0, ''),
(73, 12, 7, 'f', 'Equal', 'eq', 'first=second', '', '', '', 0, ''),
(74, 12, 8, 'f', 'If less', 'if', 'IF(first<second,10,20)', '', '', '', 0, ''),
(75, 13, 0, 'n', 'n', 'n', '', '', '', '0', 0, ''),
(76, 13, 1, 'f', 'sin(n*pi()/4)', 'sin', 'sin(n*pi()/4)', '', '', '', 0, ''),
(77, 13, 2, 'f', 'cos(n*pi()/4)', 'cos', 'cos(n*pi()/4)', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `wp_jzzf_form`
--

CREATE TABLE IF NOT EXISTS `wp_jzzf_form` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `theme` int(12) NOT NULL,
  `css` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `wp_jzzf_form`
--

INSERT INTO `wp_jzzf_form` (`id`, `title`, `name`, `theme`, `css`) VALUES
(3, 'Number', 'number', 1, ''),
(4, 'Dropdown', 'dropdown', 1, ''),
(5, 'Radio', 'radio', 1, ''),
(6, 'Checkbox', 'checkbox', 1, ''),
(7, 'Multiple 1', 'multiple_1', 1, ''),
(8, 'Multiple 2', 'multiple_2', 1, ''),
(9, 'Russian', 'russian', 1, ''),
(10, 'Arithmetics', 'arithmetics', 1, ''),
(12, 'Logical', 'logical', 1, ''),
(13, 'Maths', 'maths', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `wp_jzzf_option`
--

CREATE TABLE IF NOT EXISTS `wp_jzzf_option` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order` int(12) NOT NULL,
  `element` bigint(20) NOT NULL,
  `default` int(1) NOT NULL,
  `title` varchar(1024) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `value` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `wp_jzzf_option`
--

INSERT INTO `wp_jzzf_option` (`id`, `order`, `element`, `default`, `title`, `name`, `value`) VALUES
(1, 0, 22, 1, 'Option A', '', ''),
(2, 1, 22, 0, 'Option B', '', ''),
(3, 0, 23, 0, 'Option A', '', '11'),
(4, 1, 23, 1, 'Option B', '', '22'),
(5, 0, 24, 0, 'Option A', '', '10'),
(6, 1, 24, 0, 'Option B', '', '20'),
(7, 2, 24, 1, 'Option C', '', '30'),
(15, 0, 44, 1, 'duplicate', '', '2'),
(8, 0, 30, 1, 'Option A', '', ''),
(9, 1, 30, 0, 'Option B', '', ''),
(10, 0, 31, 0, 'Option A', '', '11'),
(11, 1, 31, 1, 'Option B', '', '22'),
(12, 0, 32, 0, 'Option A', '', '10'),
(13, 1, 32, 0, 'Option B', '', '20'),
(14, 2, 32, 1, 'Option C', '', '30'),
(16, 1, 44, 0, 'triplicate', '', '3'),
(17, 2, 44, 0, 'quatruplicate', '', '4'),
(18, 0, 47, 0, 'Plus ten', '', '10'),
(19, 1, 47, 1, 'Plus two', '', '20'),
(20, 2, 47, 0, 'Plus three', '', '30');
