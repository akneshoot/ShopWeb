
<?php
session_start();
require_once '../CONTROLLER/SweetlandController.php';
?>


<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweetLand</title>
    <link rel="icon" type="image/png" href="../Images/favicon.png">
    <link rel="stylesheet" href="../web/sweetlandstyle.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

<div class="header">	
	<div class="container">
	<div class="navbar">
		<div class="logo">
			<a href="../VIEW/sweetland.php"><img src="../Images/SweetLand - Logo (Black).png" width="125px"></a>
		</div>
		
		<nav>
			<ul id="MenuItems">
				<li><a href="../VIEW/sweetland.php">Домашняя страница</a></li>
				<li><a href="../VIEW/sweets.php">Сладости</a></li>
				<li><a href="../VIEW/about-us.php">О сладостях</a></li>
				
			<?php if(isset($_SESSION["userName"])){ ?><li><a href="..//CONTROLLER/logout.php">Выйти</a></li> <?php } ?>
			</ul>
			
		</nav>
		<a href="../VIEW/cart.php"><img src="../Images/cart.png" width="30px" height="30px"></a>
		</div>
            <div class="row">
                <div class="col-2">
                    <h1>Сладости - Это Уникальное<br>Волшебство!</h1>
                    <p>Окунитесь в волшебный мир наших сладких угощений, где каждый вкус становится неповторимым путешествием по гармонии ароматов и текстур.
                    Наш ассортимент представляет собой искусное сочетание традиций и инноваций в мире кондитерского искусства. 
                    Выбирайте наши сладкие наслаждения, чтобы привнести в свою жизнь порцию волшебства и наслаждаться каждым моментом в компании великолепных вкусов.</p>
                    <a href="../VIEW/sweets.php" class="btn">Перейти к каталогу &#8594;</a>
                </div>
                <div class="col-2">
                    <img src="../Images/candy.png">
                </div>
            </div>
        </div>
    </div>


    <div class="offer">
        <div class="small-container">
            <h2 style="border: 10px outset #1f6521; border-radius: 50px; text-align: center; margin-bottom: 30px; font-size: 28px; font-weight: bold">Новинки нашего магазина</h2>
            <div class="row">
                <?php
                $newestSweets = getNewestSweets();
                foreach ($newestSweets as $sweet) {
                ?>
                    <div class="col-3">
                        <a href="sweet-details.php?id=<?php echo $sweet['sweetId'] ?>"><img src="<?php echo $sweet['imagePath']; ?>"></a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <div class="offer">
        <div class="small-container">
            <div class="row">
                <?php
                $specialSweet = getSpecialSweet();
                ?>
                <div class="col-2">
                    <img src="<?php echo $specialSweet['imagePath'] ?>" class="offer-img">
                </div>
                <div class="col-2">
                    <p>Доступно исключительно в SweetLand</p>
                    <h1><?php echo $specialSweet['sweetName'] ?></h1>
                    <small><?php echo $specialSweet['description'] ?><br></small>
                    <a href="sweet-details.php?id=<?php echo $specialSweet['sweetId'] ?>" class="btn">Купить сейчас &#8594;</a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-2">
                    <img src="../Images/SweetLand - Logo (White).png">
                    <p>Наша цель состоит в том, чтобы постоянно доставлять вам удовольствие и
                        <br> помогать извлекать пользу из сладких моментов.</p>
                </div>

            </div>
            <hr>
        </div>
    </div>

</body>

</html>
