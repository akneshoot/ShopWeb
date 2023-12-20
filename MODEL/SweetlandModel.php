<?php
class SweetlandModel {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function getNewestSweets() {
        $sql = "SELECT * FROM `sweet` ORDER BY `sweetId` DESC LIMIT 6";
        $result = mysqli_query($this->con, $sql);

        $sweets = [];

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $sweets[] = $row;
            }
        }

        return $sweets;
    }

    public function getSpecialSweet() {
        $sql = "SELECT * FROM `sweet` WHERE sweetId = 5";
        $result = mysqli_query($this->con, $sql);

        $specialSweet = [];

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $specialSweet = $row;
            }
        }

        return $specialSweet;
    }
}
?>
