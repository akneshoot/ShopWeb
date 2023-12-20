<?php
class SweetModel {
    private $conn;

    public function __construct($servername, $username, $password, $dbname) {
        $this->conn = new mysqli($servername, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die("Ошибка подключения: " . $this->conn->connect_error);
        }
    }

    public function deleteSweetFromOrder($orderId) {
        $deleteSql = "DELETE FROM `order` WHERE `orderId` = '$orderId'";
        
        if ($this->conn->query($deleteSql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function updateOrderQuantity($orderId, $quantity) {
        $orderInfoSql = "SELECT `sweetId`, `quantity` FROM `order` WHERE `orderId` = '$orderId'";
        $orderInfoResult = $this->conn->query($orderInfoSql);

        if ($orderInfoResult->num_rows > 0) {
            $orderInfo = $orderInfoResult->fetch_assoc();
            $sweetId = $orderInfo['sweetId'];
            $oldQuantity = $orderInfo['quantity'];

            $stockSql = "SELECT `stock` FROM `sweet` WHERE `sweetId` = '$sweetId'";
            $stockResult = $this->conn->query($stockSql);

            if ($stockResult->num_rows > 0) {
                $currentStock = $stockResult->fetch_assoc()['stock'];
                if ($quantity <= $currentStock + $oldQuantity) {
                    $updateOrderSql = "UPDATE `order` SET `quantity` = '$quantity' WHERE `orderId` = '$orderId'";
                    $this->conn->query($updateOrderSql);
                    $newStock = $currentStock - ($quantity - $oldQuantity);
                    $updateStockSql = "UPDATE `sweet` SET `stock` = '$newStock' WHERE `sweetId` = '$sweetId'";
                    $this->conn->query($updateStockSql);

                    return true;
                } else {
                    return false;
                }
            }
        }

        return false;
    }
}
?>
