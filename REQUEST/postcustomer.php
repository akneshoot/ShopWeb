<?php
$host = "localhost";
$username = "root";
$password = "root";
$database = "sweetland"; 
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
    if (!isValidUsername($username)) {
        $response = array("status" => "error", "message" => "Invalid username");
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = array("status" => "error", "message" => "Invalid email format");
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    $emailParts = explode('@', $email);
    $domain = $emailParts[1];

    if ($emailParts[0] === '' || strlen($emailParts[0]) < 4 || !in_array($domain, ['gmail.com', 'mail.ru', 'yandex.ru'])) {
        $response = array("status" => "error", "message" => "Invalid email format. Minimum 4 characters before the domain, and valid domain options are: gmail.com, mail.ru, yandex.ru");
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    if (!isValidPassword($password)) {
        $response = array("status" => "error", "message" => "Invalid password");
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO customer (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        $response = array("status" => "success", "message" => "User added successfully");
    } else {
        $response = array("status" => "error", "message" => "Failed to add user");
    }
    $stmt->close();
    header('Content-Type: application/json');
    echo json_encode($response);
}
$conn->close();

?>
