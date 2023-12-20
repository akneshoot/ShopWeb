<?php

header("Content-Type: application/json");
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sweetland";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);

    $sweetIdToDelete = isset($data['sweetId']) ? intval($data['sweetId']) : 0;

    if ($sweetIdToDelete > 0) {
        $sql = "DELETE FROM sweet WHERE sweetId = $sweetIdToDelete";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "Sweet deleted successfully"));
        } else {
            echo json_encode(array("error" => "Error deleting sweet: " . $conn->error));
        }
    } else {
        echo json_encode(array("error" => "Invalid or missing sweetId parameter"));
    }
} else {
    echo json_encode(array("error" => "Invalid request method"));
}

$conn->close();
?>
