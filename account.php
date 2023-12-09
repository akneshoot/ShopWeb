<?php session_start();?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Аккаунт</title>
	<link rel="stylesheet" href="sweetlandstyle.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	
<div class="header">
	<div class="container">
	<div class="navbar">
		<div class="logo">
			<a href="sweetland.php"><img src="Images/SweetLand - Logo (Black).png" width="125px"></a>
		</div>
		
		<nav>
			<ul id="MenuItems">
				<li><a href="sweetland.php">Домашняя страница</a></li>
				<li><a href="sweets.php">Сладости</a></li>
				<li><a href="about-us.php">О сладостях</a></li>
			<?php if(isset($_SESSION["userName"])){ ?><li><a href="logout.php">Выйти</a></li> <?php } ?>
			</ul>
		</nav>
		<a href="cart.php"><img src="Images/cart.png" width="30px" height="30px"></a>

		</div>
	
	</div>
</div>


	
	
	
	<div class="account-page">
		<div class="container">
			<div class="row">
				<div class="col-2">
					<img src="Images/candy.png" width="100%">
				</div>
				<div class="col-2">
					<div class="form-container">
						<div class="form-btn">
							<span onclick="login()">Вход</span>
							<span onclick="register()">Регистрация</span>
							<hr id="Indicator">
						</div>
						
						<form action="account.php" method="POST" id="LoginForm">
							<input type="text" placeholder="Email" name="email1">
							<input type="password" placeholder="Password" name="password1">
							<button type="submit" class="btn" name="loginSubmit">Войти</button>
						</form>
						
						<form action="account.php" method="POST" id="RegForm">
							<input type="text" placeholder="Username" name="username">
							<input type="email" placeholder="Email" name="email">
							<input type="password" placeholder="Password" name="password">
							<button type="submit" class="btn" name="regSubmit">Зарегистрироваться</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	
	</div>
    <?php 


session_start();

function isValidUsername($username) {
    return strlen($username) >= 4 && !preg_match('/[!|?]/', $username);
}

function isValidPassword($password) {
    return strlen($password) >= 8 && preg_match('/\d/', $password) && preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);
}

if (isset($_POST["regSubmit"])) {
    $userName = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["error" => "Incorrect mail format"]);
        exit;
    }

    $emailParts = explode('@', $email);
    $domain = $emailParts[1];

    if ($emailParts[0] === '' || strlen($emailParts[0]) < 4 || !in_array($domain, ['gmail.com', 'mail.ru', 'yandex.ru'])) {
        echo json_encode(["error" => "Incorrect mail format"]);
        exit;
    }

    if (!isValidUsername($userName) || !isValidPassword($password)) {
        echo json_encode(["error" => "Invalid username or password format"]);
        exit;
    }

    $con = mysqli_connect("localhost", "root", "root", "sweetland");

    if (!$con) {
        die(json_encode(["error" => "Connection error"]));
    }

    $checkEmailQuery = "SELECT * FROM `customer` WHERE `email` = '$email'";
    $checkEmailResult = mysqli_query($con, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        echo json_encode(["error" => "Email already exists"]);
        exit;
    }

    // Proceed with registration if the email is not found
    $sql = "SELECT registerFunction('$userName', '$email', '$password') AS newCustomerId";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $newCustomerId = $row["newCustomerId"];
        echo json_encode(["newCustomerId" => $newCustomerId]);
        header('Location: account.php');
    } else {
        echo json_encode(["error" => "Registration error"]);
    }

    mysqli_close($con);
}


if (isset($_POST["loginSubmit"])) {
    $userName1 = $_POST["email1"];
    $password1 = $_POST["password1"];

    $con = mysqli_connect("localhost", "root", "root", "sweetland");

    if (!isValidPassword($password1)) {
        echo json_encode(["error" => "Invalid password format"]);
        exit;
    }

    $sql = "CALL loginProcedure('$userName1', '$password1')";
    $results = mysqli_query($con, $sql);

    if (mysqli_num_rows($results) > 0) {
        $_SESSION["userName"] = $userName1;
		header('Location: sweetland.php');
       
        if ($userName1 == 'admin@gmail.com') {
            header('Location: admin.php');
        }
    } else {
        echo json_encode(["error" => "The entered data is incorrect"]);
    }

    mysqli_close($con);
}
?>


	


	
	<div class="footer">
		<div class="container">
			<div class="row">
				<div class="footer-col-2">
					<img src="Images/SweetLand - Logo (White).png">
					<p>Наша цель состоит в том, чтобы постоянно доставлять вам удовольствие и
						<br> помогать извлекать пользу из сладких моментов.</p>
				</div>
				
		
			</div>
			<hr>
		</div>
	</div>
	
	
	
	

	
	<script>
		var LoginForm = document.getElementById("LoginForm");
		var RegForm = document.getElementById("RegForm");
		var Indicator = document.getElementById("Indicator");
		
			function register(){
				RegForm.style.transform = "translateX(0px)";
				LoginForm.style.transform = "translateX(0px)";
				Indicator.style.transform = "translateX(100px)";
			}
		
			function login(){
				RegForm.style.transform = "translateX(300px)";
				LoginForm.style.transform = "translateX(300px)";
				Indicator.style.transform = "translateX(0px)";
			}
	</script>


</body>
</html>