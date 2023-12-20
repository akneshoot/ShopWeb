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
            die("Connection failed: " . $conn->connect_error);
        }
        $stmt = $conn->prepare("DELETE FROM `order` WHERE `customerEmail` = ? AND `sweetId` = ?");
        $stmt->bind_param("si", $data['customerEmail'], $data['sweetId']);
        if ($stmt->execute()) {
            $response = array('success' => true, 'message' => 'Product deleted from the cart');
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => 'Failed to delete product from the cart');
            echo json_encode($response);
        }
        $stmt->close();
        $conn->close();
    } else {
        $response = array('success' => false, 'message' => 'Invalid data provided');
        echo json_encode($response);
    }
} else {
    http_response_code(405); 
    echo json_encode(array('error' => 'Invalid request method'));
}

?>
