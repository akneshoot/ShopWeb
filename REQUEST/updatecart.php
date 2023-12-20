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

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['customerEmail']) && isset($data['sweetId']) && isset($data['quantity'])) {
        $customerEmail = $data['customerEmail'];
        $sweetId = $data['sweetId'];
        $quantity = $data['quantity'];
        $checkStockQuery = "SELECT `stock` FROM `sweet` WHERE `sweetId` = ?";
        $checkStockStmt = $conn->prepare($checkStockQuery);
        $checkStockStmt->bind_param("i", $sweetId);
        $checkStockStmt->execute();
        $checkStockStmt->bind_result($availableStock);
        $checkStockStmt->fetch();
        $checkStockStmt->close();

        if ($quantity > $availableStock) {
            $response = array('status' => 'error', 'message' => 'Requested quantity exceeds available stock');
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
                $response = array('status' => 'success', 'message' => 'Quantity updated successfully');
            } else {
                $conn->rollback();
                $response = array('status' => 'error', 'message' => 'Failed to update quantity');
            }
            $updateQuantityStmt->close();
            $decreaseStockStmt->close();
            $conn->autocommit(true);
        }
    } else {
        $response = array('status' => 'error', 'message' => 'Missing required parameters');
    }
    echo json_encode($response);
}

$conn->close();
?>
