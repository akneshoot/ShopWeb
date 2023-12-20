<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сладости</title>
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
                    <a href="sweetland.php"><img src="../Images/sweetLand - Logo (Black).png" width="125px"></a>
                </div>

                <nav>
                    <ul id="MenuItems">
                        <li><a href="sweetland.php">Домашняя страница</a></li>
                        <li><a href="sweets.php">Сладости</a></li>
                        <li><a href="about-us.php">О сладостях</a></li>

                        <?php if (isset($_SESSION["userName"])) { ?><li><a href="../CONTROLLER/logout.php">Выйти</a></li><?php } ?>
                    </ul>
                </nav>
                <a href="cart.php"><img src="../Images/cart.png" width="30px" height="30px"></a>
            </div>
        </div>
    </div>

    <?php
session_start();

if (!isset($_SESSION["userName"])) {
    header('Location: ../web/account.php');
}

$con = mysqli_connect("localhost", "root", "root", "sweetland");

if (!$con) {
    die("Извините, произошла какая-то проблема");
}

$sweetId = $_GET['id'];

$sql = "SELECT sweet.*, maker.maker_name, category.category_name FROM sweet 
        INNER JOIN maker ON sweet.id_maker = maker.id_maker
        INNER JOIN category ON sweet.id_category = category.id_category
        WHERE sweet.sweetId = '$sweetId' ";

$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
?>

    <div class="small-container single-product">
        <div class="row">
            <div class="col-2">
                <img src="<?php echo $row['imagePath']; ?>" width="70%">
            </div>
            <div class="col-2">
                <h1><?php echo $row['sweetName']; ?></h1>
                <p>Категория: <?php echo $row['category_name']; ?></p>
                <p>Производитель: <?php echo $row['maker_name']; ?></p>
                <p>Вес: <?php echo $row['weight']; ?> г.</p>
                <h4><?php echo $row['price']; ?> Руб.</h4>
                <form id="buyForm">
                    <input type="number" value="1" name="quantity">
                    <input type="submit" value="Купить" name="buy" id="check">
                </form>
                <h3>Описание сладости</h3>
                <br>
                <p><?php echo $row['description']; ?> </p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("buyForm").addEventListener("submit", function (event) {
            event.preventDefault();

            var quantity = document.getElementsByName("quantity")[0].value;

            if (quantity <= 0) {
                alert("Введите 1 или более единиц сладости.");
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../CONTROLLER/sweetController.php", true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        alert("Товар добавлен в корзину.");
                        window.location.reload();
                    } else {
                        alert(response.message);
                    }
                }
            };

            var data = JSON.stringify({ sweetId: <?php echo $sweetId; ?>, quantity: quantity });
            xhr.send(data);
        });
    </script>

<?php
}
?>



<div class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-col-2">
                <img src="../Images/sweetLand - Logo (White).png">
                <p>Наша цель состоит в том, чтобы постоянно доставлять вам удовольствие и
                    <br> помогать извлекать пользу из сладких моментов.</p>
            </div>
        </div>
        <hr>
    </div>
</div>

</body>

</html>
