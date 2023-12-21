<?php
$host = "localhost";
$username = "root";
$password = "root";
$database = "sweetland"; 
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

function isValidUsername($username) {
    return strlen($username) >= 4 && !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $username);
}

function isValidPassword($password) {
    return strlen($password) >= 8 && preg_match('/\d/', $password) && preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    $username = $data['username'];
    $email = $data['email'];
    $password = $data['password'];
    $checkEmailQuery = "SELECT * FROM `customer` WHERE `email` = '$email'";
    $resultEmail = $conn->query($checkEmailQuery);

    if ($resultEmail->num_rows > 0) {
        $response = array("status" => "error", "message" => "Пользователь с таким email уже существует");
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    if (!isValidUsername($username)) {
        $response = array("status" => "error", "message" => "Неверное имя пользователя");
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = array("status" => "error", "message" => "Неверный формат электронной почты");
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    $emailParts = explode('@', $email);
    $domain = $emailParts[1];

    if ($emailParts[0] === '' || strlen($emailParts[0]) < 4 || !in_array($domain, ['gmail.com', 'mail.ru', 'yandex.ru'])) {
        $response = array("status" => "error", "message" => "Неверный формат электронной почты. Минимум 4 символа перед доменом. Допустимые варианты домена: gmail.com, mail.ru, yandex.ru.");
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    if (!isValidPassword($password)) {
        $response = array("status" => "error", "message" => "Неверный пароль");
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO customer (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        $response = array("status" => "success", "message" => "Пользователь успешно добавлен");
    } else {
        $response = array("status" => "error", "message" => "Не удалось добавить пользователя");
    }
    $stmt->close();
    header('Content-Type: application/json');
    echo json_encode($response);
}
$conn->close();

?>
