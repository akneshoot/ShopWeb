<?php session_start();?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Если книги, то BookLand</title>
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
				<h1>Любите книги?<br>Мы вам о них немного раскажем!</h1>
				<p>Книгопечатание утверждалось в Европе с большим трудом, против него то и дело восставали переписчики книг, боясь, что его распространение лишит их работы. Но все-таки прогресс было не остановить.<br>
					<br>
					В эпоху кризиса католической церкви, с началом реформации, печатные памфлеты против папы Римского разлетались как горячие пирожки.<br>
					<br>
					Огромной популярностью стали пользоваться и предсказания астрологов. А с ростом всеобщей грамотности, появлением школ и университетов появился и огромный спрос на книги, которые благодаря бумаге и книгопечатанию стали гораздо более дешевыми и доступными.<br>
					<br>
					Книжное дело, будто бы пережив спячку в средневековье, когда в ходу были одни лишь религиозные, церковные книги, возродилось с новой силой.<br><br>
					
					Вновь пишутся и печатаются светские книги: и утопические романы и научные трактаты по медицине и астрономии и даже кулинарные книги.
					<br><br>
			</div>
			<div class="col-2">
				<img src="Images/Up Last.png">
			</div>
		</div>
	</div>
</div>
	
	<!-----------------------footer--------------------------->
	
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
	
		</body>
</html>