<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sweetland"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['user_email'])) {
        $userEmail = $_GET['user_email'];

        $query = "SELECT * FROM `order` WHERE `customerEmail` = '$userEmail'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $cartItems = array();

            while ($row = $result->fetch_assoc()) {
                $cartItems[] = $row;
            }

            echo json_encode($cartItems);
        } else {
            echo json_encode(array('message' => 'Для этого пользователя в корзине нет товаров.'));
        }
    } else {
        echo json_encode(array('message' => 'Неверный запрос. Укажите адрес электронной почты пользователя.'));
    }
}
$conn->close();
?>
