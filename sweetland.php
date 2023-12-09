<?php session_start(); ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweetLand</title>
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
                    <a href="sweetland.php"><img src="Images/SweetLand - Logo (Black).png" width="125px"></a>
                </div>

                <nav>
                    <ul id="MenuItems">
                        <li><a href="sweetland.php">Домашняя страница</a></li>
                        <li><a href="sweets.php">Сладости</a></li>
                        <li><a href="about-us.php">О сладостях</a></li>
                        

                        <?php if (isset($_SESSION["userName"])) { ?><li><a href="logout.php">Выйти</a></li>
                        <?php } ?>
                    </ul>
                </nav>
                <a href="cart.php"><img src="Images/cart.png" width="30px" height="30px"></a>

            </div>
            <div class="row">
                <div class="col-2">
                    <h1>Сладости - Это Уникальное<br>Волшебство!</h1>
                    <p>Окунитесь в волшебный мир наших сладких угощений, где каждый вкус становится неповторимым путешествием по гармонии ароматов и текстур.
                    Наш ассортимент представляет собой искусное сочетание традиций и инноваций в мире кондитерского искусства. 
                    Выбирайте наши сладкие наслаждения, чтобы привнести в свою жизнь порцию волшебства и наслаждаться каждым моментом в компании великолепных вкусов.</p>
                    <a href="sweets.php" class="btn">Перейти к каталогу &#8594;</a>
                </div>
                <div class="col-2">
                    <img src="Images/candy.png">
                </div>
            </div>
        </div>
    </div>


    <div class="categories">
        <div class="small-container">
            <div class="row">
                <?php

                $con = mysqli_connect("localhost", "root", "root", "sweetland");

                if (!$con) {
                    die("Извините, технические проблемы");
                }

                $sql = "SELECT * FROM `sweet` limit 6";

                $result = mysqli_query($con, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                ?>

                        <div class="col-3">
                            <a href="sweet-details.php?id=<?php echo $row['sweetId'] ?>"><img src="<?php echo $row['imagePath']; ?>"></a>
                        </div>
                <?php


                    }
                }

                mysqli_close($con);

                ?>
            </div>
        </div>

    </div>


    <div class="offer">
        <div class="small-container">
            <div class="row">
                <?php

                $con = mysqli_connect("localhost", "root", "root", "sweetland");

                if (!$con) {
                    die("Ошибка");
                }

                $sql = "SELECT * FROM `sweet` WHERE sweetName = 'Карамелька'";

                $result = mysqli_query($con, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                ?>
                        <div class="col-2">
                            <img src="<?php echo $row['imagePath'] ?>" class="offer-img">
                        </div>
                        <div class="col-2">
                            <p>Доступно исключительно в SweetLand</p>
                            <h1><?php echo $row['sweetName'] ?></h1>
                            <small><?php echo $row['description'] ?><br></small>
                            <a href="sweet-details.php?id=<?php echo $row['sweetId'] ?>" class="btn">Купить сейчас &#8594;</a>
                        </div>
            </div>
        </div>
    </div>
<?php

                    }
                }

                mysqli_close($con);

?>

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-2">
                    <img src="Images/SweetLand - Logo (White).png">
                    <p>Наша цель состоит в том, чтобы постоянно доставлять вам удовольствие и
                        <br> помогать извлекать пользу из сладких моментов.</p>
                </div>

            </div>
            <hr>
        </div>
    </div>

</body>

</html>
