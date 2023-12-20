
<?php
session_start();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог сладостей</title>
    <link rel="icon" type="image/png" href="../Images/favicon.png">
    <link rel="stylesheet" href="../web/sweetlandstyle.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        h2 {
            margin-left: 350px;
            font-size: 30px;
        }
       
        input[type="submit"] {
                            
                            
                            height: 30px;
                            width: 200px;
                        }
    </style>
</head>

<body>
<div class="header">	
	<div class="container">
	<div class="navbar">
		<div class="logo">
			<a href="../VIEW/sweetland.php"><img src="../Images/SweetLand - Logo (Black).png" width="125px"></a>
		</div>
		
		<nav>
			<ul id="MenuItems">
				<li><a href="../VIEW/sweetland.php">Домашняя страница</a></li>
				<li><a href="../VIEW/sweets.php">Сладости</a></li>
				<li><a href="../VIEW/about-us.php">О сладостях</a></li>
				
			<?php if(isset($_SESSION["userName"])){ ?><li><a href="..//CONTROLLER/logout.php">Выйти</a></li> <?php } ?>
			</ul>
			
		</nav>
		<a href="../VIEW/cart.php"><img src="../Images/cart.png" width="30px" height="30px"></a>
		</div>
    

    

    <div class="small-container">
        <div class="row row-2">
            
        <h2>Каталог сладостей</h2>
        <form method="post" action="">
            <input type="text" name="search_query" placeholder="Поиск">
            <select name="sort_option">
                <option value="default">Без сортировки</option>
                <option value="price down">Отсортировать по цене начиная с дешевого</option>
                <option value="price up">Отсортировать по цене начиная с дорогого</option>
                <option value="name start">Отсортировать по имени с начала алфавита</option>
                <option value="name finish">Отсортировать по имени с конца алфавита</option>
                <option value="sort category">Сортировать по категории</option>
            </select>

            <?php
            $con = mysqli_connect("localhost", "root", "root", "sweetland");

            if (!$con) {
                die("Ошибка");
            }

            $category_query = "SELECT * FROM `category`";
            $category_result = mysqli_query($con, $category_query);
            ?>

            <select name="category_filter">
                <option value="all">Все категории</option>
                <?php
                while ($category = mysqli_fetch_assoc($category_result)) {
                    echo "<option value='{$category['category_name']}'>{$category['category_name']}</option>";
                }
                ?>
            </select>

            <?php mysqli_free_result($category_result); ?>

            <input type="submit" name="submit" value="Поиск">
        </form>
        </div>

        <div class="row">
            <?php
            if (isset($_POST['submit'])) {
                $sort_option = $_POST['sort_option'];
                $category_filter = $_POST['category_filter'];
                $search_query = mysqli_real_escape_string($con, $_POST['search_query']);

                switch ($sort_option) {
                    case 'price down':
                        $sql = "SELECT * FROM `sweet` ORDER BY `price` ASC";
                        break;
                    case 'price up':
                        $sql = "SELECT * FROM `sweet` ORDER BY `price` DESC";
                        break;
                    case 'name start':
                        $sql = "SELECT * FROM `sweet` ORDER BY `sweetName` ASC";
                        break;
                    case 'name finish':
                        $sql = "SELECT * FROM `sweet` ORDER BY `sweetName` DESC";
                        break;
                    case 'sort category':
                        if ($category_filter != 'all') {
                            $category_id_query = "SELECT `id_category` FROM `category` WHERE `category_name` = '$category_filter'";
                            $category_id_result = mysqli_query($con, $category_id_query);
                            $category_id = mysqli_fetch_assoc($category_id_result)['id_category'];
                            mysqli_free_result($category_id_result);

                            $sql = "SELECT * FROM `sweet` WHERE `id_category` = $category_id";
                        } else {
                            $sql = "SELECT * FROM `sweet`";
                        }
                        break;
                    default:
                        $sql = "SELECT * FROM `sweet` WHERE `sweetName` LIKE '%$search_query%'";
                }
            } else {
                $sql = "SELECT * FROM `sweet`";
            }

            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-4">
                        <a href="sweet-details.php?id=<?php echo $row['sweetId']; ?>"><img src="<?php echo $row['imagePath']; ?>"></a>
                        <h4><?php echo $row['sweetName']; ?>
                            <p>Категория: <?php echo getCategoryName($con, $row['id_category']); ?></p>
                            <p>Производитель: <?php echo getMakerName($con, $row['id_maker']); ?></p>
                            <p>Вес: <?php echo $row['weight']; ?> г.</p>
                            <h4><?php echo $row['price']; ?> Руб.</h4>
                    </div>
            <?php
                }
            } else {
                ?>
                <div style="margin-left: 120px; margin-top: 120px; margin-bottom:220px; font-size: 30px">
                    <p>Извините, но такого товара у нас нет(</p>
                <?php
            }
            
        
            mysqli_close($con);

            function getCategoryName($con, $categoryId)
            {
                $categoryQuery = "SELECT `category_name` FROM `category` WHERE `id_category` = $categoryId";
                $categoryResult = mysqli_query($con, $categoryQuery);
                $categoryRow = mysqli_fetch_assoc($categoryResult);
                return $categoryRow['category_name'];
            }

            function getMakerName($con, $makerId)
            {
                $makerQuery = "SELECT `maker_name` FROM `maker` WHERE `id_maker` = $makerId";
                $makerResult = mysqli_query($con, $makerQuery);
                $makerRow = mysqli_fetch_assoc($makerResult);
                return $makerRow['maker_name'];
            }
            ?>

        </div>

        <br>
    </div>
    </div>

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-2">
                    <img src="../Images/sweetLand - Logo (White).png">
                    <p>Наша цель состоит в том, чтобы постоянно доставлять вам удовольствие и
                        <br> помогать извлекать пользу из сладких моментов.</p>
                </div>
            </div>
            <hr>
        </div>
    </div>
    <script>
        document.getElementById("searchForm").addEventListener("submit", function (event) {
            event.preventDefault();

            var formData = new FormData(this);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "SweetsController.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    displaySweets(response.sweets);
                }
            };

            xhr.send(new URLSearchParams(formData).toString());
        });

        function displaySweets(sweets) {
            var sweetsContainer = document.getElementById("sweetsContainer");
            sweetsContainer.innerHTML = ""; 

            sweets.forEach(function (sweet) {
                var sweetHtml = `
                    <div class="col-4">
                        <a href="sweet-details.php?id=${sweet.sweetId}"><img src="${sweet.imagePath}"></a>
                        <h4>${sweet.sweetName}</h4>
                        <p>Категория: ${sweet.category}</p>
                        <p>Производитель: ${sweet.maker}</p>
                        <p>Вес: ${sweet.weight} г.</p>
                        <h4>${sweet.price} Руб.</h4>
                    </div>
                `;
                sweetsContainer.innerHTML += sweetHtml;
            });
        }
    </script>
</body>

</html>
