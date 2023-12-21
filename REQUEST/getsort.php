<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "sweetland";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["category_id"])) {
        $categoryId = $_GET["category_id"];

        $sql = "SELECT * FROM sweet WHERE id_category = $categoryId";
        $result = $conn->query($sql);

        if ($result !== false) {
            if ($result->num_rows > 0) {
                $products = array();

                while ($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }

                echo json_encode($products);
            } else {
                echo json_encode(array("error" => "В указанной категории товаров не найдено"));
            }
        } else {
            echo json_encode(array("error" => "Ошибка запроса к базе данных"));
        }
    } else {
        echo json_encode(array("error" => "Отсутствует параметр category_id."));
    }
}

$conn->close();

?>
