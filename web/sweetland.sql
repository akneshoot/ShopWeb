-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 12, 2023 at 01:39 AM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;



DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `loginProcedure` (IN `userName1` VARCHAR(255), IN `password1` VARCHAR(255))   BEGIN
    SELECT * FROM `customer` WHERE `email` = userName1 AND `password` = password1;
END$$


CREATE DEFINER=`root`@`localhost` FUNCTION `registerFunction` (`userName` VARCHAR(255), `email` VARCHAR(255), `password` VARCHAR(255)) RETURNS INT(11)  BEGIN
    DECLARE newCustomerId INT;

    INSERT INTO `customer` (`username`, `email`, `password`) VALUES (userName, email, password);
    SET newCustomerId = LAST_INSERT_ID();

    RETURN newCustomerId;
END$$

DELIMITER ;


CREATE TABLE `category` (
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
(7, 'Выпечка'),
(8, 'Леденцы'),
(9, 'Готовый завтрак');



CREATE TABLE `customer` (
  `customerId` int(5) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `customer` (`customerId`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', 'adminka1!'),
(7, 'nastos', 'nastyasid04@gmail.com', 'pupukuku1!'),
(8, 'nastya', 'nastyasid03@gmail.com', 'Molsodj1!');



CREATE TABLE `maker` (
  `id_maker` int(11) NOT NULL,
  `maker_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `maker` (`id_maker`, `maker_name`) VALUES
(1, 'Посиделькино'),
(2, 'Бон-пари'),
(3, '7DAYS'),
(4, 'Акконд'),
(7, 'Milka'),
(8, 'Kinder'),
(9, 'Maltesers'),
(10, 'Oreo'),
(11, 'Happy Mallow'),
(12, 'HARIBO');



CREATE TABLE `order` (
  `orderId` int(5) NOT NULL,
  `payment` int(5) NOT NULL,
  `customerEmail` varchar(50) NOT NULL,
  `sweetId` int(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `orderDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `order` (`orderId`, `payment`, `customerEmail`, `sweetId`, `quantity`, `orderDate`) VALUES
(1, 4000, 'helloworld@gmail.com', 1, 2, '2023-12-09 19:59:40'),
(2, 2000, 'nastosanastos@gmail.com', 6, 1, '2023-12-09 19:59:40'),
(3, 2000, 'ahaha@gmail.com', 1, 1, '2023-12-09 19:59:40'),
(36, 160, 'nastyasid04@gmail.com', 3, 1, '2023-12-12 01:28:23'),
(34, 80, 'nastyasid03@gmail.com', 4, 10, '2023-12-11 11:32:54');


DELIMITER $$
CREATE TRIGGER `after_order_insert` AFTER INSERT ON `order` FOR EACH ROW BEGIN
    DECLARE sweet_stock INT;
    DECLARE new_stock INT;
    SELECT `stock` INTO sweet_stock FROM `sweet` WHERE `sweetId` = NEW.`sweetId`;
    SET new_stock = sweet_stock - NEW.`quantity`;
    UPDATE `sweet` SET `stock` = new_stock WHERE `sweetId` = NEW.`sweetId`;
END
$$
DELIMITER ;



CREATE TABLE `sweet` (
  `sweetId` int(11) NOT NULL,
  `sweetName` varchar(100) NOT NULL,
  `stock` int(3) NOT NULL,
  `id_maker` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `imagePath` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `description` varchar(500) NOT NULL,
  `weight` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `sweet` (`sweetId`, `sweetName`, `stock`, `id_maker`, `id_category`, `imagePath`, `price`, `description`, `weight`) VALUES
(1, 'Шоколадные пряники', 10, 1, 1, 'uploads/1(1).png ', 200, 'Фигурные шоколадные пряники в двойной глазури. Особо мягкие! Бездрожжевое тесто замешано в два этапа. Тесто обязательно отдыхает, чтобы прянички получились пористыми и воздушными.', 150),
(2, 'Мармеладные червячки', 6, 2, 3, 'uploads/2.png ', 150, '\"Бон Пари Кислые червячки\" — это жевательный мармелад, приготовленный в форме червяков с добавлением витамина С, красителей и желатина. Отличается насыщенным вкусом чёрной смородины, лимона, малины и яблока.', 90),
(3, 'Круассаны \"7DAYS\"', 14, 3, 7, 'uploads/3.png ', 160, 'Круассаны \"7DAYS\" - готовая к употреблению выпечка из нежного теста с восхитительными кремовыми и джемовыми начинками. Мини-круассаны \"7DAYS\" - это много маленьких вкусных круассанов в одной упаковке.', 180),
(4, 'Карамелька', 30, 4, 4, 'uploads/4.png ', 250, 'Конфеты Рози блюз ассорти от торговой марки Акконд это двухцветная карамель , сочетающая натуральные сливки и фруктово-ягодные вкусы (малина, земляника, апельсин). Лакомство овальной формы, упаковано в красивую оранжевую обертку с герметичными швами.', 100),
(5, 'Новогодний календарь \"Kinder\"', 30, 8, 1, 'uploads/5.png ', 2000, 'Новогодний календарь Kinder Maxi Mix с молочным шоколадом - это отличный выбор для тех, кто любит сладости и хочет получить удовольствие от праздника. Кроме того, этот календарь - это отличный способ начать подготовку к Новому Году уже сейчас. Каждый день вы будете открывать новую шоколадку и наслаждаться ее вкусом. Это поможет вам создать новогоднее настроение и подготовиться к празднику.', 350),
(16, 'Шоколадное печенье \"Kinder Happy Hippo\"', 200, 8, 1, 'uploads/512734.970.png', 400, 'Вкуснейшее лакомство Kinder Happy Hippo Cacao - в коробке 5х20,7 вафельных батончиков в виде бегемотиков. Внутри каждого бегемотика - двойная начинка - молочная и шоколадная. Сверху вафельные бегемотики обсыпаны до половины шоколадной крупкой. Одна из самых популярных сладостей немецкого производителя Киндер.', 105),
(17, 'Печенье \"Milka Choco Pause\"', 50, 7, 5, 'uploads/7216adbe2d8824d4da8e598d524861e8.png', 250, 'Печенье Milka «Шоколадная пауза» - лакомство, способное утолить голод. Продукт состоит из двух хрустящих кусочков сладкого теста с нежной сливочно-шоколадной прослойкой из альпийского молочного шоколада, которая тает во рту. Сладость обладает приятным ароматом и мягким вкусом. Состоящий из натуральных ингредиентов продукт отлично подойдет для перекуса на работе или учебе.', 260),
(18, 'Шоколадные драже конфеты \"Maltesers\"', 140, 9, 1, 'uploads/3180883-900x900-transformed.png', 100, 'Драже Maltesers - это хрустящие шарики, покрытые молочным шоколадом. Maltesers - легкий взгляд на шоколад. Maltesers - настолько нежные и легкие, что даже не тонут в воде. Конфеты Maltesers многим запомнились своим неповторимым вкусом и яркой, узнаваемой упаковкой. Мало кто знает, что именно шоколадный шарик является традиционным шведским лакомством, подаваемым на Рождество.', 37),
(19, 'Печенье \"Oreo Crunchy Bites\"', 120, 10, 5, 'uploads/1637645_1-transformed.png', 320, 'Печенье Орео Кранчи Байтс - это мини-версия знаменитого печенья в новой упаковке. Маленькое печенье состоит из двух шоколадно-сахарных коржиков-дисков, которые покрыты нежным шоколадом, а внутри волшебная начинка из масла и сахарной пудры. Удобная упаковка помещается в маленькую сумочку и закрывается на стикер для сохранения свежести.', 110),
(20, 'Готовый завтрак с маршмеллоу \"Rick and Morty\"', 10, 11, 9, 'uploads/d108006579804u_3-transformed.png', 350, 'Привыкли начинать свой день с вкусных хлопьев с молоком? Обожаете зефир? Тогда самое время отведать нашу сладкую новинку. Специально к выходу нового сезона нашумевшего сериала \"Рик и Морти\" мы подготовили для вас интересный готовый завтрак Happy Mallow \"Рик и Морти\". Яркое сочетание шоколадных шариков и хрустящего маршмеллоу перевернёт привычные представления о сухих завтраках. В его состав добавлен витаминный комплекс для поддержки вашего организма.', 240),
(21, 'Готовый завтрак с маршмеллоу \"BATMAN\"', 50, 11, 9, 'uploads/1zrr091u3q220y28i0yfy3wtj6i6h8rp_pixian_ai.png', 350, 'ухой завтрак Happy Mallow The Batman - это яркое сочетание кукурузных шариков и хрустящего маршмеллоу, 100% натуральный хрустящий маршмеллоу высушивается по специальной технологии до лёгкого хруста и когда попадает в молоко, то снаружи становится мягким, а внутри остаётся хрустящим. Завтрак Happy Mallow The Batman не содержит глютен - сложный белок, содержащийся в большинстве злаковых культур.', 240),
(23, 'Мармелад жевательный \"HARIBO Pico Balla\" ', 250, 12, 3, 'uploads/product-29191_pixian_ai.png', 150, 'Настройтесь на фруктово-сочный перекус с HARIBO Пико-балла! Попробуйте разнообразные и самые неожиданные сочетания фруктовых вкусов. Новая рецептура с использованием преимущественно растительных компонентов позволит насладиться Пико-Баллой и вегетарианцам!', 160);


ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);


ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerId`);


ALTER TABLE `maker`
  ADD PRIMARY KEY (`id_maker`);


ALTER TABLE `order`
  ADD PRIMARY KEY (`orderId`);


ALTER TABLE `sweet`
  ADD PRIMARY KEY (`sweetId`),
  ADD KEY `id_category` (`id_category`),
  ADD KEY `id_maker` (`id_maker`);


ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;


ALTER TABLE `customer`
  MODIFY `customerId` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;


ALTER TABLE `maker`
  MODIFY `id_maker` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;


ALTER TABLE `order`
  MODIFY `orderId` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;


ALTER TABLE `sweet`
  MODIFY `sweetId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;


ALTER TABLE `sweet`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`),
  ADD CONSTRAINT `fk_maker` FOREIGN KEY (`id_maker`) REFERENCES `maker` (`id_maker`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
