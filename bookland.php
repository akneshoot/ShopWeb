<?php session_start();?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>BookLand</title>
	<link rel="stylesheet" href="booklandstyle.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	
<div class="header">	
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
		<div class="row">
			<div class="col-2">
				<h1>Книги - Это Уникальное<br>Портативное Волшебство!</h1>
				<p>Приобрести привычку к чтению - значит<br>извлечь пользу почти из всех жизненных невзгод.</p>
				<a href="books.php" class="btn">Перейти к каталогу &#8594;</a>
			</div>
			<div class="col-2">
				<img src="Images/Up Last.png">
			</div>
		</div>
	</div>
</div>
	

<!------------------featured categories-------------------->
	
	<div class="categories">
		<div class="small-container">
			<div class="row">
				<?php
	    
	        
			 $con=mysqli_connect("localhost","root","root","bookland");
			 
			 if(!$con)    
			 {
				 die("Sorry ,Technical error ");
			 }
			 
			 $sql="SELECT * FROM `book` limit 3" ;
	
	         $result = mysqli_query($con,$sql);
	
	         if(mysqli_num_rows($result)>0)
			 {
				 while($row=mysqli_fetch_assoc($result))
				 {
					
					 ?>
			
		
				<div class="col-3">
					<a href="book-details.php?id=<?php echo $row['bookId']?>"><img src="<?php echo $row['imagePath']; ?>"></a>
				</div>
					<?php
					 
					 
					}
				}
				
					  mysqli_close($con);
	   
					 ?>
			
			</div>
		</div>

	</div>
	
<!-----------------------offer------------------------->

	<div class="offer">
		<div class="small-container">
			<div class="row">
				<?php
	    
	        
			 $con=mysqli_connect("localhost","root","root","bookland");
			 
			 if(!$con)    
			 {
				 die("Sorry ,Technical error ");
			 }
			 
			 $sql="SELECT * FROM `book` WHERE bookName = 'Oxford Dictionary'" ;
	
	         $result = mysqli_query($con,$sql);
	
	         if(mysqli_num_rows($result)>0)
			 {
				 while($row=mysqli_fetch_assoc($result))
				 {
					
					 ?>
			
				<div class="col-2">
					<img src="<?php echo $row['imagePath'] ?>" class="offer-img">
				</div>
				<div class="col-2">
					<p>Доступно исключительно в BookLand</p>
					<h1>Oxford Dictionary</h1>
					<small>Новое 8-е издание Оксфордского словаря отличается новым стилем и внешним видом с совместимым дизайном.<br></small>
					<a href="book-details.php?id=<?php echo $row['bookId'] ?>" class="btn">Купить сейчас &#8594;</a>
				</div>
			</div>
		</div>
	</div>
		<?php
					 
					 
					}
				}
				
					  mysqli_close($con);
	   
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
