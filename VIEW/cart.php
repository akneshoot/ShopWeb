<style>
    table {
        margin-left: 2%;
        min-width: 60%;
        height: 30%;
        padding: 1px;
        flex-basis: 50%;
        margin-top: 150px;
        margin-bottom: 150px;
    }

    #order-table {
        flex-basis: 50%;
        margin-left: 300px;
    }
</style>

<?php
session_start();

if (!isset($_SESSION["userName"])) {
    header('Location: ../web/account.php');
    exit(); 
}

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sweetland";

$conn = mysqli_connect("localhost", "root", "root", "sweetland");

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$sql = "SELECT * FROM sweet";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина</title>
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
$userEmail = $_SESSION["userName"];
$cartSql = "SELECT o.orderId, o.payment, o.customerEmail, o.sweetId, o.quantity, s.sweetName, s.price, s.imagePath, o.orderDate
        FROM `order` o
        JOIN `sweet` s ON o.sweetId = s.sweetId
        WHERE o.customerEmail = '$userEmail'";
$cartResult = $conn->query($cartSql);

if ($cartResult->num_rows > 0) {
    ?>
    <table id="order-table">
        <tr>
            <th>Изображение</th>
            <th>Наименование</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Итого</th>
            <th>Дата добавления</th>
        </tr>
        <?php
        while ($row = $cartResult->fetch_assoc()) {
            ?>
            <tr>
                <td><img src="<?php echo $row['imagePath']; ?>" width="200px"></td>
                <td><?php echo $row['sweetName']; ?></td>
                <td><?php echo $row['price']; ?> руб.</td>
                <td>
                    <form method="post" action="../CONTROLLER/cart_controller.php">
                        <input type="hidden" name="orderId" value="<?php echo $row['orderId']; ?>">
                        <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" min="1">
                        
                    </form>
                </td>
                <td><?php echo $row['price'] * $row['quantity']; ?> руб.</td>
                <td><?php echo $row['orderDate']; ?></td>
                <td>
                    <form method="post" action="../CONTROLLER/cart_controller.php">
                        <input type="hidden" name="orderId" value="<?php echo $row['orderId']; ?>">
                        <button type="button" onclick="removeFromCart('<?php echo $row['orderId']; ?>')">Удалить</button>
                    </form>
                </td>



                <script>
                    function removeFromCart(orderId) {
                        var xhr = new XMLHttpRequest();
                        xhr.open("DELETE", "../CONTROLLER/cart_controller.php", true);
                        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

                        xhr.onreadystatechange = function () {
                            if (xhr.readyState == 4) {
                                var response = JSON.parse(xhr.responseText);

                                if (response.success) {
                                    alert("Товар удален из корзины.");
                                    window.location.reload();
                                } else {
                                    alert(response.message);
                                }
                            }
                        };

                        var data = JSON.stringify({ orderId: orderId });
                        xhr.send(data);
                    }
                </script>

    <?php
        }
        ?>
    </table>
    <?php
} else {
    ?>
    <div style="text-align: center; margin-top: 220px; margin-bottom:220px; font-size: 30px">
        <p>Ваша корзина пуста, добавьте товары.</p>
        <a href="sweets.php" style="text-decoration: none; color: #ff6b81; font-weight: bold;">Перейти к покупкам</a>
    </div>
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

<?php
$conn->close();
?>
