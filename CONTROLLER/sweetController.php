<?php
session_start();
require_once '../MODEL/sweetModel.php';

$con = mysqli_connect("localhost", "root", "root", "sweetland");

if (!$con) {
    $response = ['success' => false, 'message' => 'Ошибка подключения к базе данных'];
    echo json_encode($response);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

$sweetId = $data['sweetId'];
$userEmail = $_SESSION['userName'];
$quantity = $data['quantity'];

$sweetModel = new SweetModel($con);

if (!$sweetModel->checkStock($sweetId, $quantity)) {
    $response = ['success' => false, 'message' => 'В наличии недостаточно товара'];
    echo json_encode($response);
    exit();
}

if (!$sweetModel->checkCart($userEmail, $sweetId)) {
    $response = ['success' => false, 'message' => 'Товар уже есть в корзине'];
    echo json_encode($response);
    exit();
}

if ($sweetModel->addOrder($userEmail, $sweetId, $quantity)) {
    $response = ['success' => true, 'message' => 'Товар добавлен в корзину'];
    echo json_encode($response);
} else {
    $response = ['success' => false, 'message' => 'Ошибка при добавлении товара в корзину'];
    echo json_encode($response);
}

mysqli_close($con);
?>
