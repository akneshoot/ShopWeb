<?php
session_start();

if (!isset($_SESSION["userName"])) {
    header('Location: web/account.php');
    exit();
}



require_once('../MODEL/cart_model.php');

$model = new SweetModel("localhost", "root", "root", "sweetland");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    $orderId = $requestData['orderId'];

    $result = $model->deleteSweetFromOrder($orderId);

    if ($result) {
        $response = ['success' => true, 'message' => 'Товар успешно удален из корзины'];
        echo json_encode($response);
        exit();
    } else {
        $response = ['success' => false, 'message' => 'Ошибка при удалении товара из корзины'];
        echo json_encode($response);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['orderId'];
    $quantity = $_POST['quantity'];
    $updateResult = $model->updateOrderQuantity($orderId, $quantity);

    if ($updateResult) {
        header('Location: ../VIEW/cart.php');
        exit();
    } else {
        echo '<script>alert("Ошибка при обновлении количества товара в корзине или товара нет на складе.");</script>';
        echo '<script>window.location.href = "../VIEW/cart.php";</script>';
    }
} else {
    $response = ['success' => false, 'message' => 'Некорректный метод запроса'];
    echo json_encode($response);
}
?>

