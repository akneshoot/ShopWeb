-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 25, 2021 at 04:51 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";




DROP TABLE IF EXISTS `book`;
CREATE TABLE IF NOT EXISTS `book` (
  `bookId` int(5) NOT NULL AUTO_INCREMENT,
  `bookName` varchar(100) NOT NULL,
  `stock` int(3) NOT NULL,
  `author` varchar(100) NOT NULL,
  `genre` varchar(30) NOT NULL,
  `imagePath` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `description` varchar(500) NOT NULL,
  PRIMARY KEY (`bookId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `book` (`bookId`, `bookName`, `stock`, `author`, `genre`, `imagePath`, `price`, `description`) VALUES
(1, 'Шерлок Холмс', 10, 'Артур Конан Дойл', 'Художественная литература', 'uploads/Book Cover.jpg ', 2000, 'Шерлок Холмс - вымышленный детектив конца 19-го и начала 20-го веков, который впервые появился в печати в 1887 году. Он был изобретен британским писателем и врачом сэром Артуром Конан Дойлом. Блестящий лондонский детектив, Холмс знаменит своим мастерством использовать логику и проницательную наблюдательность для раскрытия дел.'),
(2, 'Виноваты наши звезды', 6, 'Джон Грин', 'Романтика', 'uploads/Book Cover 2.jpg ', 1500, 'Виноваты наши звезды - потрясающая книга о девочке-подростке, у которой диагностировали рак легких и которая посещает группу поддержки онкологических больных. ... Хейзел и Огастес отправляются на американские горки эмоций, включая любовь, грусть и романтику, в поисках автора своей любимой книги.'),
(3, 'Метод', 15, 'Шеннон Кирк', 'Триллер', 'uploads/Book Cover 3.jpg ', 1600 , 'Похищенный в одиночестве, перепуганный. Представьте вместо этого беременную, 16-летнюю, способную манипулировать вундеркиндом. Ее запихивают в грязный фургон, и с первого момента похищения она испытывает спокойное желание двух вещей: спасти своего нерожденного сына и безжалостно отомстить.'),
(4, 'Oxford Dictionary', 30, 'Оксфордские публикации', 'Образование', 'uploads/Book Cover 4.jpeg ', 2500, 'Это новое издание включает в себя тысячи совершенно новых слов и значений, а также актуальную энциклопедическую информацию.');



DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `commentId` varchar(8) NOT NULL,
  `date` varchar(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `email` varchar(30) NOT NULL,
  `bookId` varchar(10) NOT NULL,
  PRIMARY KEY (`commentId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customerId` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`customerId`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


INSERT INTO `customer` (`customerId`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin');



DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `orderId` int(5) NOT NULL AUTO_INCREMENT,
  `payment` int(5) NOT NULL,
  `customerEmail` varchar(50) NOT NULL,
  `bookId` int(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`orderId`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;



INSERT INTO `order` (`orderId`, `payment`, `customerEmail`, `bookId`, `quantity`) VALUES
(1, 4000, 'helloworld@gmail.com', 1, 2),
(25, 2000, 'nastosanastos@gmail.com', 6, 1),
(26, 2000, 'ahaha@gmail.com', 1, 1),
COMMIT;

