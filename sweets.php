<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог сладостей</title>
    <link rel="stylesheet" href="sweetlandstyle.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="sweetland.php"><img src="Images/sweetLand - Logo (Black).png" width="125px"></a>
                </div>

                <nav>
                    <ul id="MenuItems">
                        <li><a href="sweetland.php">Домашняя страница</a></li>
                        <li><a href="sweets.php">Сладости</a></li>
                        <li><a href="about-us.php">О сладостях</a></li>
                        
                        <?php if (isset($_SESSION["userName"])) { ?><li><a href="logout.php">Выйти</a></li><?php } ?>
                    </ul>
                </nav>
				<a href="cart.php"><img src="Images/cart.png" width="30px" height="30px"></a>

            </div>

        </div>
    </div>

    <div class="small-container">
        <div class="row row-2">
            <h2>Каталог сладостей</h2>
            <form method="post" action="">
                <select name="sort_option">
                    <option value="default">Без сортировки</option>
                    <option value="price down">Отсортировать по цене начиная с дешевого</option>
                    <option value="price up">Отсортировать по цене начиная с дорогого</option>
                    <option value="name start">Отсортировать по имени с начала алфавита</option>
                    <option value="name finish">Отсортировать по имени с конца алфавита</option>
                    <option value="sort category">Сортировать по категории</option>
                </select>
                <select name="category_filter">
                    <option value="all">Все категории</option>
                    <option value="chocolate">Шоколадные сладости</option>
                    <option value="fruit">Фруктовые сладости</option>
                    <option value="marmelad">Мармелад</option>
					<option value="caramel">Карамель</option>
                    <option value="cookie">Печенье</option>
                    <option value="marshmallow">Зефир</option>
					<option value="chocolatebaton">Шоколадные батончики</option>
					<option value="candy">Леденцы</option>
                </select>
                <input type="submit" name="submit" value="Отсортировать">
            </form>
        </div>

        <div class="row">
            <?php
            $con = mysqli_connect("localhost", "root", "root", "sweetland");

            if (!$con) {
                die("Ошибка");
            }

            if (isset($_POST['submit'])) {
                $sort_option = $_POST['sort_option'];
                $category_filter = $_POST['category_filter'];

                switch ($sort_option) {
                    case 'price down':
                        $sql = "SELECT * FROM `sweet` ORDER BY `price` ASC";
                        break;
                    case 'price up':
                        $sql = "SELECT * FROM `sweet` ORDER BY `price` DESC";
                        break;
                    case 'name start':
                        $sql = "SELECT * FROM `sweet` ORDER BY `sweetName` ASC";
                        break;
                    case 'name finish':
                        $sql = "SELECT * FROM `sweet` ORDER BY `sweetName` DESC";
                        break;
                    case 'sort category':
                        if ($category_filter == 'chocolate') {
                            $sql = "SELECT * FROM `sweet` WHERE `id_category` = 1";
                        }
                        if ($category_filter == 'fruit') {
                            $sql = "SELECT * FROM `sweet` WHERE `id_category` = 2";
                        }
                        if ($category_filter == 'marmelad') {
                            $sql = "SELECT * FROM `sweet` WHERE `id_category` = 3";
                        }
                        if ($category_filter == 'caramel') {
                            $sql = "SELECT * FROM `sweet` WHERE `id_category` = 4";
                        }
                        if ($category_filter == 'cookie') {
                            $sql = "SELECT * FROM `sweet` WHERE `id_category` = 5";
                        }
						if ($category_filter == 'marshmallow') {
                            $sql = "SELECT * FROM `sweet` WHERE `id_category` = 6";
                        }
                        if ($category_filter == 'chocolatebaton') {
                            $sql = "SELECT * FROM `sweet` WHERE `id_category` = 7";
                        }
                        if ($category_filter == 'candy') {
                            $sql = "SELECT * FROM `sweet` WHERE `id_category` = 8";
                        }
                        break;
                    default:
                        $sql = "SELECT * FROM `sweet`";
                }
            } else {
                $sql = "SELECT * FROM `sweet`";
            }

            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-4">
                        <a href="sweet-details.php?id=<?php echo $row['sweetId']; ?>"><img src="<?php echo $row['imagePath']; ?>"></a>
                        <h4><?php echo $row['sweetName']; ?>
                            <p>Категория: <?php echo getCategoryName($con, $row['id_category']); ?></p>
                            <p>Производитель: <?php echo getMakerName($con, $row['id_maker']); ?></p>
                            <h4><?php echo $row['price']; ?> Руб.</h4>
                    </div>
            <?php
                }
            } else {
                echo "<h2>Товары не найдены.</h2>";
            }
        
            mysqli_close($con);

            function getCategoryName($con, $categoryId)
            {
                $categoryQuery = "SELECT `category_name` FROM `category` WHERE `id_category` = $categoryId";
                $categoryResult = mysqli_query($con, $categoryQuery);
                $categoryRow = mysqli_fetch_assoc($categoryResult);
                return $categoryRow['category_name'];
            }

            function getMakerName($con, $makerId)
            {
                $makerQuery = "SELECT `maker_name` FROM `maker` WHERE `id_maker` = $makerId";
                $makerResult = mysqli_query($con, $makerQuery);
                $makerRow = mysqli_fetch_assoc($makerResult);
                return $makerRow['maker_name'];
            }
            ?>

        </div>

        <br>
    </div>
    </div>

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-2">
                    <img src="Images/sweetLand - Logo (White).png">
                    <p>Наша цель состоит в том, чтобы постоянно доставлять вам удовольствие и
                        <br> помогать извлекать пользу из сладких моментов.</p>
                </div>
            </div>
            <hr>
        </div>
    </div>

</body>

</html>
