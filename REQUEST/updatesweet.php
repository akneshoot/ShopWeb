<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "sweetland";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    $data = json_decode(file_get_contents("php://input"), true);
    $sweetId = $data["sweetId"];
    $newPrice = $data["newPrice"];
    $newQuantity = $data["newQuantity"];

    $checkSql = "SELECT sweetId FROM sweet WHERE sweetId = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $sweetId);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $updateSql = "UPDATE sweet SET price = ?, stock = ? WHERE sweetId = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("dii", $newPrice, $newQuantity, $sweetId);

        if ($updateStmt->execute()) {
            $response = array("status" => "success", "message" => "Информация о товаре изменена.");
        } else {
            $response = array("status" => "error", "message" => "Проблема с обновлением информации о товаре: " . $updateStmt->error);
        }
        $updateStmt->close();
    } else {
        $response = array("status" => "error", "message" => "Товар с ID $sweetId не найден в базе данных");
    }

    $checkStmt->close();
} else {
    $response = array("status" => "error", "message" => "Ошибка метода");
}

$conn->close();

header("Content-Type: application/json");
echo json_encode($response);
?>
