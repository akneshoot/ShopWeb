<?php
$servername = "localhost";
$username = "root";
$password = "root"; 
$database = "sweetland"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$sql = "SELECT * FROM sweet";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sweets[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($sweets, JSON_PRETTY_PRINT);
} else {
    echo "Товар не найден";
}

$conn->close();

?>
