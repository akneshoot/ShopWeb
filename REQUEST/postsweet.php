<?php
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    if (isset($data['sweetName']) && isset($data['stock']) && isset($data['id_maker']) && isset($data['id_category']) && isset($data['imagePath']) && isset($data['price']) && isset($data['description']) && isset($data['weight'])) {
        $db_host = 'localhost';
        $db_user = 'root';
        $db_pass = 'root';
        $db_name = 'sweetland';
        
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sweetName = $conn->real_escape_string($data['sweetName']);
        $stock = (int)$data['stock'];
        $id_maker = (int)$data['id_maker'];
        $id_category = (int)$data['id_category'];
        $imagePath = $conn->real_escape_string($data['imagePath']);
        $price = (float)$data['price'];
        $description = $conn->real_escape_string($data['description']);
        $weight = (int)$data['weight'];
        
        $query = "INSERT INTO sweet (sweetName, stock, id_maker, id_category, imagePath, price, description, weight) VALUES ('$sweetName', $stock, $id_maker, $id_category, '$imagePath', $price, '$description', $weight)";
        
        if ($conn->query($query) === TRUE) {
            $response = array('status' => 'success', 'message' => 'Sweet added successfully');
        } else {
            $response = array('status' => 'error', 'message' => 'Error adding sweet: ' . $conn->error);
        }
        
        $conn->close();
    } else {
        $response = array('status' => 'error', 'message' => 'Missing required fields');
    }
} else {
    $response = array('status' => 'error', 'message' => 'Invalid request method');
}

echo json_encode($response);
?>
