<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sweetland"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['user_email'])) {
        $userEmail = $_GET['user_email'];

        $query = "SELECT * FROM `order` WHERE `customerEmail` = '$userEmail'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $cartItems = array();

            while ($row = $result->fetch_assoc()) {
                $cartItems[] = $row;
            }

            echo json_encode($cartItems);
        } else {
            echo json_encode(array('message' => 'No items in the shopping cart for this user.'));
        }
    } else {
        echo json_encode(array('message' => 'Invalid request. Please provide a user email.'));
    }
}
$conn->close();
?>
