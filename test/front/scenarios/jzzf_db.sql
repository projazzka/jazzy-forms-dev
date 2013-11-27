-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 27, 2013 at 09:03 PM
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=165 ;

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
(50, 10, 0, 'n', 'First', 'first', '', '', '', '3', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(51, 10, 1, 'n', 'Second', 'second', '', '', '', '4', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(52, 10, 2, 'f', 'Sum', 'sum', 'first+second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(53, 10, 3, 'f', 'Difference', 'difference', 'first-second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(54, 10, 4, 'f', 'Product', 'product', 'first*second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(55, 10, 5, 'f', 'Division', 'division', 'first/second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(56, 10, 6, 'f', 'Exponentiation', 'exponentiation', 'first^second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(57, 10, 8, 'f', 'Cube', 'cube', 'first^3', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(58, 10, 9, 'f', 'Precedence: first+2*second', 'precedence', 'first+2*second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(59, 10, 10, 'f', 'Association: (first+2)*second', 'association', '(first+2)*second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
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
(86, 15, 6, 'n', 'Email', 'email', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(85, 15, 5, 'n', 'Name', 'name', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(84, 15, 4, 'f', 'b=a+10', 'b', 'a+10', '', '', '', 0, '', 1, '$', '', 0, 2, 1, '', '.', '', 1, 1),
(83, 15, 3, 'n', 'a', 'a', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(87, 15, 7, 'e', 'Send', 'send', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(88, 15, 8, 'f', 'c=b*0.9', 'c', 'b*0.9', '', '', '', 0, '', 1, '', '', 0, 2, 1, '', '.', '', 1, 1),
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
(106, 12, 10, 'f', 'String', 'string', 'if(first=10, "Ten", if(first=30, "Thirty", "Other"))', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(107, 15, 0, 'r', 'Greeting', 'greeting', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(108, 15, 1, 'd', 'Farewell', 'farewell', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(109, 15, 2, 'n', 'Phone number', 'phone', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(110, 18, 0, 'n', 'A', 'a', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(111, 18, 1, 'r', 'B', 'b', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(112, 18, 2, 'h', 'Result for {{a}}', 'element', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(113, 18, 3, 't', '{{a}}*{{b}}={{a*b}}', 'element_1', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(114, 18, 4, 'm', 'More info <a href="">about {{a*b}}</a>', 'element_2', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(115, 18, 5, 'f', 'Leading Zeros', 'out', 'a', '', '', '', 0, '', 1, '', '', 4, 9, 0, '', '.', '', 1, 1),
(116, 18, 6, 't', 'Leading Zeros Propagated: {{out}}', 'propagated', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(122, 20, 1, 'f', 'b = a & "foo"', 'b', 'a & "foo"', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(119, 18, 7, 'e', 'Email', 'email', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(121, 20, 0, 'n', 'a', 'a', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(123, 20, 2, 'f', 'c = "foo" & a', 'c', '"foo" & a', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(124, 20, 3, 'f', 'd = "foo" & a & "bar"', 'd', '"foo" & a & "bar"', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(125, 20, 4, 'n', 'n', 'n', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(126, 20, 6, 'f', 'e = a & n', 'e', 'a & n', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(127, 20, 5, 'f', 'formatted n', 'formatted', 'n', '', '', '', 0, '', 1, '', '', 4, 9, 0, '', '.', '', 1, 1),
(128, 20, 7, 'f', 'f = formatted & a', 'f', 'formatted & a', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(129, 20, 8, 'f', 'g = formatted', 'g', 'formatted', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(130, 21, 0, 'n', 'a', 'a', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(131, 21, 1, 'n', 'b', 'b', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(132, 21, 2, 'f', 'formatted a', 'formatted', 'a', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(133, 21, 3, 'f', 'formatted & b', 'c', 'formatted & b', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(134, 22, 0, 't', 'No placeholders here', 'element', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(135, 22, 1, 'n', 'Element', 'element_1', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(136, 22, 2, 'f', 'Element (1)', 'element_1_1', 'element_1', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(137, 23, 0, 'f', 'a=b', 'a', 'b', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(138, 23, 1, 'f', 'b=c', 'b', 'c', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(139, 23, 2, 'f', 'c=a', 'c', 'a', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(143, 24, 1, 'f', 'b=formatted(a)', 'b', 'formatted(a)', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(142, 24, 0, 'n', 'a', 'a', '', '', '', '123.4', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(144, 24, 2, 'f', 'c=a', 'c', 'a', '', '', '', 0, '', 1, '', '', 0, 2, 1, ',', '.', '', 1, 1),
(145, 24, 4, 'f', 'e=formatted(x)', 'e', 'formatted(x)', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(146, 24, 6, 'd', 'drop', 'drop', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(147, 24, 7, 'f', 'o1="You''ve chosen " & label(drop)', 'o1', '"You''ve chosen " & label(drop)', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(148, 24, 8, 'r', 'radio', 'radio', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(149, 24, 9, 'f', 'o2=label(radio)', 'o2', 'label(radio)', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(150, 24, 3, 'f', 'd=formatted(c)&" total"', 'd', 'formatted(c)&" total"', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(151, 24, 5, 'f', 'Element', 'element', '', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(152, 24, 10, 'f', 'o3=label(c)', 'o3', 'label(c)', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(153, 24, 11, 'f', 'o4=label(x)', 'o4', 'label(x)', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(154, 25, 0, 'a', 'Input', 'in', '', '', '', 'Default text here.', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(155, 25, 1, 't', 'You have entered:\n\n{{in}}\n\nThank you.', 'element', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(158, 10, 7, 'f', 'Exponentiation (first^-second)', 'negexpo', 'first*(-2)', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(159, 26, 0, 'e', 'Send', 'send', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(160, 27, 0, 'n', 'Element', 'element', '', '', '', '2', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(161, 27, 1, 'f', 'Element (1)', 'element_1', 'element*100', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(162, 27, 2, 'x', 'Reset', 'element_2', '', '', '', '', 0, '', 1, '', '', 0, 0, 0, '', '', '', 1, 1),
(163, 10, 11, 'f', 'Negation', 'negation', '-first', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1),
(164, 10, 12, 'f', 'Minusplus', 'minusplus', '-first+second', '', '', '', 0, '', 1, '', '', 0, 9, 0, '', '.', '', 1, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `wp_jzzf_email`
--

INSERT INTO `wp_jzzf_email` (`id`, `form`, `to`, `cc`, `bcc`, `from`, `subject`, `message`, `sending`, `ok`, `fail`) VALUES
(1, 0, '{{name}} <{{email}}>>', '', '', '', '', '', 'Sending...', 'Can''t send the message', 'Message sent.'),
(3, 15, '{{name}} <{{email}}>', 'keksar@gmail.com', '', 'mark.zuckerberg@gmail.com', 'From Mark. Hi!', '{{greeting}} {{name}},\nyour price is {{formatted(b)}}.\nInline: {{a+0.5}}. Direct: {{formatted(c)}}\nI will call you at {{phone}}\n{{farewell}},\nMark.', 'Sending...', 'Message sent.', 'Can''t send the message?'),
(4, 18, 'igor.prochazka@gmail.com', '', '', 'Igor <igor.prochazka@gmail.com>', 'Bug test', 'a = {{a}}\n', 'Sending', 'Success', 'Failure'),
(6, 26, '"Igor Prochazka" <igor.prochazka@gmail.com>', '', '', '"Igor Prochazka" <igor.prochazka@gmail.com>', 'Empty mail', '', 'Sending...', 'Message sent', 'Can''t send the message');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

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
(17, 'Invalid', 'invalid', 1, '', 1),
(18, 'Templates', 'templates', 1, '', 1),
(20, 'Strings', 'strings', 1, '', 1),
(21, 'formatted', 'formatted', 1, '', 1),
(22, 'Bug82', 'bug82', 1, '', 1),
(23, 'Circular', 'circular', 1, '', 1),
(24, 'Referencing', 'referencing', 1, '', 1),
(25, 'Textarea', 'textarea', 1, '', 1),
(26, 'Empty Mail', 'empty_mail', 1, '', 1),
(27, 'Reset', 'reset', 1, '', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

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
(30, 2, 104, 0, 'Not sure', '', 'Not sure'),
(31, 0, 107, 1, 'Hello', '', 'Hello'),
(32, 1, 107, 0, 'Hi', '', 'Hi'),
(33, 0, 108, 1, 'Bye', '', 'Bye'),
(34, 1, 108, 0, 'Good bye', '', 'Good bye'),
(35, 0, 111, 1, '1', '', '1'),
(36, 1, 111, 0, '2', '', '2'),
(37, 2, 111, 0, '3', '', '3'),
(42, 1, 146, 0, 'Pears', '', '20'),
(41, 0, 146, 1, 'Apples', '', '10'),
(43, 2, 146, 0, 'Bananas', '', '30'),
(44, 0, 148, 1, 'Texas Instruments', '', '10'),
(45, 1, 148, 0, 'Commodore', '', '20'),
(46, 2, 148, 0, 'Amstrad', '', '30');
