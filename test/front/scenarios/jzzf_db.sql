-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 15, 2012 at 09:09 PM
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
  `title` text NOT NULL,
  `name` varchar(1024) NOT NULL,
  `formula` text NOT NULL,
  `value` varchar(1024) NOT NULL,
  `value2` varchar(1024) NOT NULL,
  `default` varchar(1024) NOT NULL,
  `external` int(1) NOT NULL,
  `params` varchar(2048) NOT NULL,
  `visible` int(12) NOT NULL DEFAULT '1',
  `prefix` varchar(16) NOT NULL,
  `postfix` varchar(16) NOT NULL,
  `zeros` int(1) NOT NULL,
  `decimals` int(1) NOT NULL DEFAULT '9',
  `fixed` int(1) NOT NULL DEFAULT '0',
  `thousands` varchar(1) NOT NULL,
  `point` varchar(1) NOT NULL DEFAULT '.',
  `classes` varchar(1024) NOT NULL,
  `divisions` int(1) NOT NULL DEFAULT '1',
  `break` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=107 ;

--
-- Dumping data for table `wp_jzzf_element`
--

INSERT INTO `wp_jzzf_element` (`id`, `form`, `order`, `type`, `title`, `name`, `formula`, `value`, `value2`, `default`, `external`, `params`, `visible`, `prefix`, `postfix`, `zeros`, `decimals`, `fixed`, `thousands`, `point`, `classes`, `divisions`, `break`) VALUES
(19, 3, 5, 'f', 'Third', 'third_out', 'element_number_three', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(18, 3, 4, 'f', 'Second', 'second_out', 'element_2', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(17, 3, 3, 'f', 'First', 'first_out', 'first', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(16, 3, 2, 'n', 'Third: Default 10, factor 1.12', 'element_number_three', '', '1.12', '', '10', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(15, 3, 1, 'n', 'Second: Default 10, no factor', 'element_2', '', '', '', '10', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(14, 3, 0, 'n', 'First: No Default, no factor', 'first', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(21, 4, 0, 'd', 'No Options', 'first', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(22, 4, 1, 'd', 'Two Options, default first, no values', 'second', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(23, 4, 2, 'd', 'Two Options, default second, values', 'third', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(24, 4, 3, 'd', 'Three Options', 'fourth', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(25, 4, 5, 'f', 'First', 'first_out', 'first', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(26, 4, 6, 'f', 'Second', 'second_out', 'second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(27, 4, 7, 'f', 'Third', 'third_out', 'third', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(28, 4, 8, 'f', 'Fourth', 'fourth_out', 'fourth', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(29, 5, 0, 'r', 'No options', 'first', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(30, 5, 1, 'r', 'Two options, default first, no values', 'element_2', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(31, 5, 2, 'r', 'Two options, default second, values', 'element_number_three', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(32, 5, 3, 'r', 'Three options, default third, values', 'fourth', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(33, 5, 5, 'f', 'First', 'first_out', 'first', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(34, 5, 6, 'f', 'Second', 'second_out', 'element_2', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(35, 5, 7, 'f', 'Third', 'third_out', 'element_number_three', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(36, 5, 8, 'f', 'Fourth', 'fourth_out', 'fourth', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(37, 6, 0, 'c', 'No values, default checked', 'first', '', '', '', '1', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(38, 6, 1, 'f', 'First', 'first_out', 'first', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(39, 6, 2, 'c', 'No unchecked value, default unchecked', 'element_2nd', '', '10', '', '0', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(40, 6, 4, 'f', 'Second', 'second_out', 'element_2nd', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(41, 6, 5, 'c', 'Normal', 'element_three', '', '20', '10', '1', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(42, 6, 6, 'f', 'Third', 'third_out', 'element_three', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(43, 7, 0, 'n', 'Number entry (ID=id1)', 'id1', '', '1', '', '100', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(44, 7, 1, 'r', 'Radio buttons (ID=id2)', 'id2', '', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(45, 7, 2, 'f', 'Output (id3)', 'id3', 'id1*id2', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(46, 8, 0, 'n', 'Number Entry (ID=id1)', 'id1', '', '', '', '200', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(47, 8, 1, 'r', 'Radio (id2)', 'id2', '', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(48, 8, 2, 'f', 'Output', 'id3', 'id1+id2', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(49, 9, 0, 'n', 'Есть силы нью мы', 'element', '', '', '', 'Бы должником интервьюирования про', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(50, 10, 0, 'n', 'First', 'first', '', '', '', '3', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(51, 10, 1, 'n', 'Second', 'second', '', '', '', '4', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(52, 10, 2, 'f', 'Sum', 'sum', 'first+second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(53, 10, 3, 'f', 'Difference', 'difference', 'first-second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(54, 10, 4, 'f', 'Product', 'product', 'first*second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(55, 10, 5, 'f', 'Division', 'division', 'first/second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(56, 10, 6, 'f', 'Exponentiation', 'exponentiation', 'first^second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(57, 10, 7, 'f', 'Cube', 'cube', 'first^3', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(58, 10, 8, 'f', 'Precedence: first+2*second', 'precedence', 'first+2*second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(59, 10, 9, 'f', 'Association: (first+2)*second', 'association', '(first+2)*second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(70, 12, 4, 'f', 'Greater or Equal', 'ge', 'first>=second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(69, 12, 3, 'f', 'Less', 'less', 'first<second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(68, 12, 2, 'f', 'Greater', 'greater', 'first>second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(67, 12, 1, 'n', 'Second', 'second', '', '', '', '20', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(66, 12, 0, 'n', 'First', 'first', '', '', '', '10', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(71, 12, 5, 'f', 'Less or Equal', 'le', 'first<=second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(72, 12, 6, 'f', 'Not Equal', 'ne', 'first<>second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(73, 12, 7, 'f', 'Equal', 'eq', 'first=second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(74, 12, 8, 'f', 'If less', 'if', 'IF(first<second,10,20)', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(75, 13, 0, 'n', 'n', 'n', '', '', '', '0', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(76, 13, 1, 'f', 'sin(n*pi()/4)', 'sin', 'sin(n*pi()/4)', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(77, 13, 2, 'f', 'cos(n*pi()/4)', 'cos', 'cos(n*pi()/4)', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(86, 15, 3, 'n', 'Email', 'email', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(85, 15, 2, 'n', 'Name', 'name', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(84, 15, 1, 'f', 'b=a+10', 'b', 'a+10', '', '', '', 0, '', 1, '$', '', 0, 2, 1, '', '.', '', 1, 1),
(83, 15, 0, 'n', 'a', 'a', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(87, 15, 4, 'e', 'Send', 'send', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(88, 15, 5, 'f', 'c=b*0.9', 'c', 'b*0.9', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(89, 12, 9, 'f', 'If without if_false', 'if_default', 'if(second=20, 10)', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(90, 16, 0, 'd', 'Input', 'input', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(91, 16, 1, 'f', 'Dollar', 'dollar', 'input', '', '', '', 0, '', 1, '$', '', 0, 2, 1, ',', '.', '', 1, 1),
(92, 16, 2, 'f', 'Propagated', 'propagated', 'dollar', '', '', '', 0, '', 1, '', ' PROP', 8, 9, 0, '', '.', '', 1, 1),
(93, 16, 3, 'f', 'Element (2)', 'sum', 'dollar+propagated', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(94, 17, 0, 'n', 'Input', 'i', '', '', '', '1', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(95, 17, 1, 'f', 'out 1 (valid)', 'o1', 'i+1', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(96, 17, 2, 'f', 'out 2 (missing summand)', 'o2', 'a+', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(97, 17, 3, 'f', 'out 3 (unknown operand)', 'o3', 'i?1', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(98, 17, 4, 'f', 'out 4 (unclosed paranthesis)', 'o4', '(i+1', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(99, 17, 5, 'f', 'out 5 (unclosed quote)', 'o5', '"abc', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(100, 6, 3, 'c', '"yes" or "no"', 'fourth', '', 'yes', 'no', '0', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(101, 6, 7, 'f', 'Fourth', 'fourth_out', 'fourth', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(102, 5, 4, 'r', 'String values', 'fifth', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(103, 5, 9, 'f', 'Fifth', 'fifth_out', 'fifth', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(104, 4, 4, 'd', 'String values', 'fifth', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(105, 4, 9, 'f', 'Fifth', 'fifth_out', 'fifth', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(106, 12, 10, 'f', 'String', 'string', 'if(first=10, "Ten", if(first=30, "Thirty", "Other"))', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_jzzf_email`
--

CREATE TABLE IF NOT EXISTS `wp_jzzf_email` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `form` bigint(20) NOT NULL,
  `to` text NOT NULL,
  `cc` text NOT NULL,
  `bcc` text NOT NULL,
  `from` varchar(1024) NOT NULL,
  `subject` text NOT NULL,
  `message` longtext NOT NULL,
  `sending` text NOT NULL,
  `ok` text NOT NULL,
  `fail` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `wp_jzzf_email`
--

INSERT INTO `wp_jzzf_email` (`id`, `form`, `to`, `cc`, `bcc`, `from`, `subject`, `message`, `sending`, `ok`, `fail`) VALUES
(1, 0, '{{name}} <{{email}}>>', '', '', '', '', '', 'Sending...', 'Can''t send the message', 'Message sent.'),
(3, 15, '{{name}} <{{email}}>', '', '', 'mark.zuckerberg@gmail.com', 'From Mark. Hi!', 'Hi {{name}},\nyour price is {{b}}.\n{{a+0.5}}\nMark.', 'Sending...', 'Can''t send the message', 'Message sent.');

-- --------------------------------------------------------

--
-- Table structure for table `wp_jzzf_form`
--

CREATE TABLE IF NOT EXISTS `wp_jzzf_form` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `name` varchar(1024) NOT NULL,
  `theme` int(12) NOT NULL,
  `css` longtext NOT NULL,
  `realtime` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `wp_jzzf_form`
--

INSERT INTO `wp_jzzf_form` (`id`, `title`, `name`, `theme`, `css`, `realtime`) VALUES
(3, 'Number', 'number', 1, '', 1),
(4, 'Dropdown', 'dropdown', 1, '', 1),
(5, 'Radio', 'radio', 1, '', 1),
(6, 'Checkbox', 'checkbox', 1, '', 1),
(7, 'Multiple 1', 'multiple_1', 1, '', 1),
(8, 'Multiple 2', 'multiple_2', 1, '', 1),
(9, 'Russian', 'russian', 1, '', 1),
(10, 'Arithmetics', 'arithmetics', 1, '', 1),
(12, 'Logical', 'logical', 1, '', 1),
(13, 'Maths', 'maths', 1, '', 1),
(15, 'Mail', 'mail', 1, '', 1),
(16, 'Formatting', 'formatting', 1, '', 1),
(17, 'Invalid', 'invalid', 1, '', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

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
(20, 2, 47, 0, 'Plus three', '', '30'),
(21, 0, 90, 1, 'a) 1234.57', '', '1234.567'),
(22, 1, 90, 0, 'b) 1234.5', '', '1234.5'),
(23, 2, 90, 0, 'c) 1234', '', '1234'),
(24, 3, 90, 0, 'd) 1.234', '', '1.234'),
(25, 0, 102, 1, 'Yes', '', 'yes'),
(26, 1, 102, 0, 'No', '', 'no'),
(27, 2, 102, 0, 'Not sure', '', 'not sure'),
(28, 0, 104, 0, 'Yes', '', 'Yes'),
(29, 1, 104, 0, 'No', '', 'No'),
(30, 2, 104, 0, 'Not sure', '', 'Not sure');
