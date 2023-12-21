<?php

$servername = "localhost";
$username = "root";
$password = "root";
$database = "sweetland";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Соединение не удалось: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->customerId)) {
        $customerId = $data->customerId;
        $checkStmt = $conn->prepare("SELECT customerId FROM customer WHERE customerId = ?");
        $checkStmt->bind_param("i", $customerId);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $deleteStmt = $conn->prepare("DELETE FROM customer WHERE customerId = ?");
            $deleteStmt->bind_param("i", $customerId);

            if ($deleteStmt->execute()) {
                echo json_encode(array("message" => "Пользователь успешно удален."));
            } else {
                echo json_encode(array("message" => "Ошибка удаления пользователя."));
            }

            $deleteStmt->close();
        } else {
            echo json_encode(array("message" => "Пользователь с указанным ID не найден."));
        }

        $checkStmt->close();
    } else {
        echo json_encode(array("message" => "Неверный запрос. Укажите параметр customerId."));
    }
} else {
    echo json_encode(array("message" => "Неверный метод запроса. Используйте метод DELETE."));
}

$conn->close();
?>
