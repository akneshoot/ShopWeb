<?php
$con = mysqli_connect("localhost", "root", "root", "sweetland");

if (!$con) {
    die("Ошибка подключения к базе данных");
}

require_once 'SweetsModel.php';

$sweetModel = new SweetsModel($con);

$search_query = mysqli_real_escape_string($con, $_POST['search_query']);
$sort_option = $_POST['sort_option'];
$category_filter = $_POST['category_filter'];

$sweets = $sweetModel->getSweets($search_query, $sort_option, $category_filter);

$response = ['sweets' => $sweets];

echo json_encode($response);

mysqli_close($con);
?>
