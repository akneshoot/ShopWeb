<?php
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['customerEmail']) && isset($data['sweetId'])) {
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "sweetland";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Соединение не удалось: " . $conn->connect_error);
        }
        $userCheckStmt = $conn->prepare("SELECT * FROM `customer` WHERE `email` = ?");
        $userCheckStmt->bind_param("s", $data['customerEmail']);
        $userCheckStmt->execute();
        $userCheckStmt->store_result();

        if ($userCheckStmt->num_rows > 0) {
            $checkStmt = $conn->prepare("SELECT * FROM `order` WHERE `customerEmail` = ? AND `sweetId` = ?");
            $checkStmt->bind_param("si", $data['customerEmail'], $data['sweetId']);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows > 0) {
                $deleteStmt = $conn->prepare("DELETE FROM `order` WHERE `customerEmail` = ? AND `sweetId` = ?");
                $deleteStmt->bind_param("si", $data['customerEmail'], $data['sweetId']);

                if ($deleteStmt->execute()) {
                    $response = array('success' => true, 'message' => 'Товар удален из корзины');
                    echo json_encode($response);
                } else {
                    $response = array('success' => false, 'message' => 'Не удалось удалить товар из корзины');
                    echo json_encode($response);
                }

                $deleteStmt->close();
            } else {
                $response = array('success' => false, 'message' => 'Товар не найден в корзине');
                echo json_encode($response);
            }

            $checkStmt->close();
        } else {
            $response = array('success' => false, 'message' => 'Пользователь не найден');
            echo json_encode($response);
        }

        $userCheckStmt->close();
        $conn->close();
    } else {
        $response = array('success' => false, 'message' => 'Предоставлены неверные данные');
        echo json_encode($response);
    }
} else {
    http_response_code(405); 
    echo json_encode(array('error' => 'Неверный метод запроса'));
}
?>
