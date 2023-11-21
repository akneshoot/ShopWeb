SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `sweet`;

CREATE TABLE IF NOT EXISTS `sweet` (
  `sweetId` int(5) NOT NULL,
  `sweetName` varchar(100) NOT NULL,
  `stock` int(3) NOT NULL,
  `id_maker` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `imagePath` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `sweet` (`sweetId`, `sweetName`, `stock`, `id_maker`, `id_category`, `imagePath`, `price`, `description`) VALUES
(1, 'Шоколадные пряники', 10, 1, 1 , 'uploads/1.png ', 200, 'Нежные шоколадные пряники, идеальные для сладкого угощения.'),
(2, 'Мармеладные червячки', 6, 2, 3, 'uploads/2.png ', 150, 'Мармеладки, созданные для тех, кто ценит нежные вкусы.'),
(3, 'Тропический микс', 15, 3, 2, 'uploads/3.png ', 160 , 'Сочный фруктовый микс, который подарит вам радугу в каждом глотке.'),
(4, 'Карамелька', 30, 4, 4, 'uploads/4.png ', 250, 'Карамель во всех цветах радуги, чтобы поднять настроение и подарить сладкие моменты.');

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

DROP TABLE IF EXISTS `category`;

CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `category` (`id_category`, `category_name`) VALUES
(1, 'Шоколадные сладости'),
(2, 'Фруктовые сладости'),
(3, 'Мармелад'),
(4, 'Карамель'),
(5, 'Печенье'),
(6, 'Зефир'),
(7, 'Шоколадные батончики'),
(8, 'Леденцы');

DROP TABLE IF EXISTS `maker`;

CREATE TABLE IF NOT EXISTS `maker` (
  `id_maker` int(11) NOT NULL,
  `maker_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `maker` (`id_maker`, `maker_name`) VALUES
(1, 'Сладкий уголок'),
(2, 'Фруктовый рай'),
(3, 'Мармеладные грезы'),
(4, 'Сладкий мир');

DROP TABLE IF EXISTS `order`;

CREATE TABLE IF NOT EXISTS `order` (
  `orderId` int(5) NOT NULL AUTO_INCREMENT,
  `payment` int(5) NOT NULL,
  `customerEmail` varchar(50) NOT NULL,
  `sweetId` int(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`orderId`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;



INSERT INTO `order` (`orderId`, `payment`, `customerEmail`, `sweetId`, `quantity`) VALUES
(1, 4000, 'helloworld@gmail.com', 1, 2),
(2, 2000, 'nastosanastos@gmail.com', 6, 1),
(3, 2000, 'ahaha@gmail.com', 1, 1);



ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

ALTER TABLE `maker`
  ADD PRIMARY KEY (`id_maker`);

ALTER TABLE `sweet`
  ADD PRIMARY KEY (`sweetId`),
  ADD KEY `id_category` (`id_category`),
  ADD KEY `id_maker` (`id_maker`);

ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `maker`
  MODIFY `id_maker` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `sweet`
  MODIFY `sweetId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `sweet`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`),
  ADD CONSTRAINT `fk_maker` FOREIGN KEY (`id_maker`) REFERENCES `maker` (`id_maker`);
COMMIT;

DELIMITER //

CREATE TRIGGER after_order_insert
AFTER INSERT ON `order`
FOR EACH ROW
BEGIN
    DECLARE sweet_stock INT;
    DECLARE new_stock INT;
    SELECT `stock` INTO sweet_stock FROM `sweet` WHERE `sweetId` = NEW.`sweetId`;
    SET new_stock = sweet_stock - NEW.`quantity`;
    UPDATE `sweet` SET `stock` = new_stock WHERE `sweetId` = NEW.`sweetId`;
END;
//
DELIMITER ;

DELIMITER //

CREATE PROCEDURE loginProcedure(IN userName1 VARCHAR(255), IN password1 VARCHAR(255))
BEGIN
    SELECT * FROM `customer` WHERE `email` = userName1 AND `password` = password1;
END //
DELIMITER ;

DELIMITER //

CREATE FUNCTION registerFunction(userName VARCHAR(255), email VARCHAR(255), password VARCHAR(255)) RETURNS INT
BEGIN
    DECLARE newCustomerId INT;

    INSERT INTO `customer` (`username`, `email`, `password`) VALUES (userName, email, password);
    SET newCustomerId = LAST_INSERT_ID();

    RETURN newCustomerId;
END //

DELIMITER ;
