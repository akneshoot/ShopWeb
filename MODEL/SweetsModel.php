<?php
class SweetsModel {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function getSweets($search_query, $sort_option, $category_filter) {
        $sql = "SELECT * FROM `your_table`"; 

        $result = mysqli_query($this->con, $sql);

        $sweets = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $sweetInfo = [
                'sweetId' => $row['sweetId'],
                'imagePath' => $row['imagePath'],
                'sweetName' => $row['sweetName'],
                'category' => $this->getCategoryName($row['id_category']),
                'maker' => $this->getMakerName($row['id_maker']),
                'weight' => $row['weight'],
                'price' => $row['price']
            ];

            $sweets[] = $sweetInfo;
        }

        return $sweets;
    }

    private function getCategoryName($categoryId) {
        $categoryQuery = "SELECT `category_name` FROM `category` WHERE `id_category` = $categoryId";
        $categoryResult = mysqli_query($this->con, $categoryQuery);
        $categoryRow = mysqli_fetch_assoc($categoryResult);
        return $categoryRow['category_name'];
    }

    private function getMakerName($makerId) {
        $makerQuery = "SELECT `maker_name` FROM `maker` WHERE `id_maker` = $makerId";
        $makerResult = mysqli_query($this->con, $makerQuery);
        $makerRow = mysqli_fetch_assoc($makerResult);
        return $makerRow['maker_name'];
    }
}
?>
