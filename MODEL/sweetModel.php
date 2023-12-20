<?php
class SweetModel {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function checkStock($sweetId, $quantity) {
        $checkStockQuery = "SELECT `stock` FROM `sweet` WHERE `sweetId` = $sweetId";
        $stockResult = mysqli_query($this->con, $checkStockQuery);

        if ($stockResult) {
            $stockRow = mysqli_fetch_assoc($stockResult);
            $stock = $stockRow['stock'];

            return $stock >= $quantity;
        }

        return false;
    }

    public function checkCart($userEmail, $sweetId) {
        $checkCartQuery = "SELECT * FROM `order` WHERE `customerEmail` = '$userEmail' AND `sweetId` = $sweetId";
        $cartResult = mysqli_query($this->con, $checkCartQuery);

        return mysqli_num_rows($cartResult) === 0;
    }

    public function addOrder($userEmail, $sweetId, $quantity) {
        $sql = "SELECT price FROM `sweet` WHERE `sweetId` = $sweetId";
        $result = mysqli_query($this->con, $sql);
        $row = mysqli_fetch_assoc($result);
        $price = $row['price'];
        $totalPrice = $price * $quantity;

        $sql1 = "INSERT INTO `order` (`orderId`, `payment`, `customerEmail`, `sweetId`, `quantity`) 
                 VALUES (NULL, '$totalPrice', '$userEmail', '$sweetId', '$quantity')";

        return mysqli_query($this->con, $sql1);
    }
}
?>
