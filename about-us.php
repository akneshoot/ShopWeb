<?php session_start();?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>О сладостях</title>
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
		<div class="row">
			<div class="col-2">
				<h1>Любите сладости?<br>Мы вам о них немного расскажем!</h1>
				<p>Первые конфеты, несмотря на название, появились не в Риме, а в Египте. Там во время торжественных выездов фараона слуги бросали в толпу встречающих специально изготовленный деликатес - финики, сваренные в меду.</p>
				<br><p>В других странах Востока роль сладких подарков играли сушеные абрикосы, инжир и орехи с медом и пряностями.</p>
				<br><p>В канун нашей эры в Европу из Индии проник сахар, что вызвало настоящую революцию в кондитерской отрасли. Засахаренные фрукты стали не только любимым лакомством, но и лекарством - знаменитый врач Гален рекомендовал их при расстройстве желудка и нервных болезнях.</p>
				<br><p>На пирах римских богачей подавались глазированные фрукты и миндаль с добавлением мака, аниса и кунжута.
				Заморский сахар стоил дорого, поэтому бедняки по-прежнему заменяли его медом.</p>
				<br><p>На римской свадьбе хозяин дома бросал в толпу гостей конфеты - считалось, что поймавших их ждет счастье, и нередко за обладание сладким кусочком начиналась драка.
				В средневековой Италии этот обычай сохранился, но вместо сладостей гостей осыпали разноцветными кусочками бумаги с прежним названием - конфетти.</p><br><br><br><br>
			</div>
			<div class="col-2">
				<img src="Images/candy.png">
			</div>
		</div>
	</div>
</div>
	
	
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
	
		</body>
</html>