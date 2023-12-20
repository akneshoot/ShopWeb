<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sweetland"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT * FROM `order`";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $cartItems = array();

        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }

        header('Content-Type: application/json');
        echo json_encode($cartItems, JSON_PRETTY_PRINT);
    } else {
        echo "Нет никаких товаров в корзине.";
    }
}

$conn->close();

?>
