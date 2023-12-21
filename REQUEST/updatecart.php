<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sweetland";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['customerEmail']) && isset($data['sweetId']) && isset($data['quantity'])) {
        $customerEmail = $data['customerEmail'];
        $sweetId = $data['sweetId'];
        $quantity = $data['quantity'];
        $checkUserQuery = "SELECT * FROM `customer` WHERE `email` = ?";
        $checkUserStmt = $conn->prepare($checkUserQuery);
        $checkUserStmt->bind_param("s", $customerEmail);
        $checkUserStmt->execute();
        $checkUserResult = $checkUserStmt->get_result();

        if ($checkUserResult->num_rows > 0) {
            $checkCartQuery = "SELECT * FROM `order` WHERE `customerEmail` = ? AND `sweetId` = ?";
            $checkCartStmt = $conn->prepare($checkCartQuery);
            $checkCartStmt->bind_param("si", $customerEmail, $sweetId);
            $checkCartStmt->execute();
            $checkCartResult = $checkCartStmt->get_result();

            if ($checkCartResult->num_rows > 0) {
                $checkStockQuery = "SELECT `stock` FROM `sweet` WHERE `sweetId` = ?";
                $checkStockStmt = $conn->prepare($checkStockQuery);
                $checkStockStmt->bind_param("i", $sweetId);
                $checkStockStmt->execute();
                $checkStockStmt->bind_result($availableStock);
                $checkStockStmt->fetch();
                $checkStockStmt->close();

                if ($quantity > $availableStock) {
                    $response = array('status' => 'error', 'message' => 'Запрошенное количество превышает доступный запас');
                } else {
                    $updateQuantityQuery = "UPDATE `order` SET `quantity` = ? WHERE `customerEmail` = ? AND `sweetId` = ?";
                    $updateQuantityStmt = $conn->prepare($updateQuantityQuery);
                    $updateQuantityStmt->bind_param("iss", $quantity, $customerEmail, $sweetId);
                    $decreaseStockQuery = "UPDATE `sweet` SET `stock` = `stock` - ? WHERE `sweetId` = ?";
                    $decreaseStockStmt = $conn->prepare($decreaseStockQuery);
                    $decreaseStockStmt->bind_param("ii", $quantity, $sweetId);
                    $conn->autocommit(false);

                    if ($updateQuantityStmt->execute() && $decreaseStockStmt->execute()) {
                        $conn->commit();
                        $response = array('status' => 'success', 'message' => 'Количество успешно обновлено');
                    } else {
                        $conn->rollback();
                        $response = array('status' => 'error', 'message' => 'Не удалось обновить количество');
                    }
                    $updateQuantityStmt->close();
                    $decreaseStockStmt->close();
                    $conn->autocommit(true);
                }
            } else {
                $response = array('status' => 'error', 'message' => 'Товар не найден в корзине');
            }
            $checkCartStmt->close();
        } else {
            $response = array('status' => 'error', 'message' => 'Пользователь не найден');
        }
        $checkUserStmt->close();
    } else {
        $response = array('status' => 'error', 'message' => 'Отсутствуют необходимые параметры');
    }
    echo json_encode($response);
}

$conn->close();
?>
