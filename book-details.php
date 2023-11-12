<?php session_start();

if(!isset($_SESSION["userName"]))
{
	header('Location:account.php');
}?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Book Details</title>
	<link rel="stylesheet" href="booklandstyle.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	
	
	<div class="container">
		<div class="navbar">
		<div class="logo">
			<a href="bookland.php"><img src="Images/BookLand - Logo (Black).png" width="125px"></a>
		</div>
		
		<nav>
			<ul id="MenuItems">
				<li><a href="bookland.php">Домашняя страница</a></li>
				<li><a href="books.php">Книги</a></li>
				<li><a href="about-us.php">О книгах</a></li>
				<li><a href="account.php">Аккаунт</a></li>
			<?php if(isset($_SESSION["userName"])){ ?><li><a href="logout.php">Выйти</a></li> <?php } ?>
			</ul>
		</nav>
			<a href="cart.php"><img src="Images/cart.png" width="30px" height="30px"></a>
			<img src="Images/menu.png" class="menu-icon" onclick="menutoggle()">
		</div>
	
	</div>

	
	<?php
			$con = mysqli_connect("localhost", "root", "root", "bookland");

			if (!$con) {
				die("Извините, произошла какая-то проблема ");
			}

			$sql = "SELECT * FROM `book`,customer WHERE bookId = '" . $_GET['id'] . "' ";
			

			$result = mysqli_query($con, $sql);
			if (mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result)


			?>
	
	<div class="small-container single-product">
		<div class="row">
			<div class="col-2">
				<img src="<?php echo $row['imagePath']; ?>" width="70%">
			</div>
			<div class="col-2">
				<p><?php echo $row['genre']; ?></p>
				<h1><?php echo $row['bookName']; ?></h1>
				<h4><?php echo $row['price']; ?> Руб.</h4>
				<form action="book-details.php?id=<?php echo $row['bookId']; ?>" method="post">
				<input type="number" value="1" name="qua">
				
				<input type="submit" value="Купить" name="buy" id="check">
				</form>
				<h3>Подробнее о книге</h3>
				<br>
				<p><?php echo $row['description']; ?> </p>
			</div>
		</div>
	</div>
	
	<?php
	if(isset($_POST["buy"]))
	{
		
		$qua=$_POST["qua"];
		$con1 = 
			mysqli_connect("localhost","root","root","bookland");
		if(!$con1)
		{
			die("Извините, произошла какая-то проблема");
		}
		$sql1 = "INSERT INTO `order` (`orderId`, `payment`, `customerEmail`, `bookId`,`quantity`) VALUES (NULL, '".$row['price']*$qua."', '".$row['email']."', '".$row['bookId']."', '".$qua."');";
		
			?>
			<script>alert("Товар добавлен")</script>
			
			
			
				
			<?php
			mysqli_query($con1,$sql1);
            
			
		mysqli_close($con1);
		
	
	
	
	}
	
			}
		?>


	
	<div class="footer">
		<div class="container">
			<div class="row">
				<div class="footer-col-2">
					<img src="Images/BookLand - Logo (White).png">
					<p>Наша цель состоит в том, чтобы постоянно доставлять вам удовольствие и
						<br> помогать извлекать пользу из книг.</p>
				</div>
				
		
			</div>
			<hr>
		</div>
	</div>
	
	
	<script>
		var MenuItems = document.getElementById("MenuItems");
		MenuItems.style.maxHeight= "0px";
		
			
		function menutoggle(){
			if(MenuItems.style.maxHeight == "0px")
				{
					MenuItems.style.maxHeight = "200px";
				}
			else
				{
					MenuItems.style.maxHeight = "0px";
				}
		} 
		
	</script>


</body>
</html>
