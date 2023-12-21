<?php

header("Content-Type: application/json");
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sweetland";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Соединение не удалось: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);

    $sweetIdToDelete = isset($data['sweetId']) ? intval($data['sweetId']) : 0;

    if ($sweetIdToDelete > 0) {
        $checkSql = "SELECT * FROM sweet WHERE sweetId = $sweetIdToDelete";
        $result = $conn->query($checkSql);

        if ($result->num_rows > 0) {
            $deleteSql = "DELETE FROM sweet WHERE sweetId = $sweetIdToDelete";
            if ($conn->query($deleteSql) === TRUE) {
                echo json_encode(array("message" => "Товар успешно удален"));
            } else {
                echo json_encode(array("error" => "Ошибка удаления: " . $conn->error));
            }
        } else {
            echo json_encode(array("error" => "Товар с указанным SweetId не найден"));
        }
    } else {
        echo json_encode(array("error" => "Недопустимый или отсутствующий параметр SweetId"));
    }
} else {
    echo json_encode(array("error" => "Неверный метод запроса"));
}

$conn->close();
?>
