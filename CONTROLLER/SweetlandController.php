<?php
session_start();
require_once '../MODEL/SweetlandModel.php';

$con = mysqli_connect("localhost", "root", "root", "sweetland");

if (!$con) {
    die("Ошибка подключения к базе данных");
}

$sweetModel = new SweetlandModel($con);

function getNewestSweets() {
    global $sweetModel;
    return $sweetModel->getNewestSweets();
}

function getSpecialSweet() {
    global $sweetModel;
    return $sweetModel->getSpecialSweet();
}
?>
