<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "sweetland";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);
$customerEmail = $input['customerEmail'];
$sweetId = $input['sweetId'];
$quantity = $input['quantity'];
$checkEmailQuery = "SELECT * FROM `customer` WHERE `email` = '$customerEmail'";
$resultEmail = $conn->query($checkEmailQuery);

if ($resultEmail->num_rows > 0) {
    $checkSweetQuery = "SELECT * FROM `sweet` WHERE `sweetId` = $sweetId AND `stock` >= $quantity";
    $resultSweet = $conn->query($checkSweetQuery);

    if ($resultSweet->num_rows > 0) {
        $row = $resultSweet->fetch_assoc();
        $sweetPrice = $row['price'];
        $sql = "INSERT INTO `order` (`customerEmail`, `sweetId`, `quantity`, `payment`) 
                VALUES ('$customerEmail', $sweetId, $quantity, $quantity * $sweetPrice)";

        if ($conn->query($sql) === TRUE) {
            $updateStockQuery = "UPDATE `sweet` SET `stock` = `stock` - $quantity WHERE `sweetId` = $sweetId";
            $conn->query($updateStockQuery);

            $response = array("status" => "success", "message" => "Товар успешно добавлен в корзину");
        } else {
            $response = array("status" => "error", "message" => "Ошибка: " . $sql . "<br>" . $conn->error);
        }
    } else {
        $response = array("status" => "error", "message" => "Товар с ID $sweetId либо не существует, либо имеет недостаточный запас");
    }
} else {
    $response = array("status" => "error", "message" => "Пользователь с адресом электронной почты '$customerEmail' не найден");
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
