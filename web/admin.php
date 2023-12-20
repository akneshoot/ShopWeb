<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ панель</title>
    <link rel="icon" type="image/png" href="../Images/favicon.png">
    <style>
        body {
            background-color: #edeae5;
        }

        .form1, .form2 {
            margin-left: 35%;
            border: solid #1f6521 2px;
            width: 25%;
            padding: 2%;
            margin-top: 80px;

        }

        input[type="text"] {
            font-family: Calibri, "Calibri Light";
            width: 70%;
            height: 40px;
            border: groove 0.5px;
            border-radius: 0;
            border-color: #1f6521;
            
        }

        label {
            font-size: 15pt
        }

        h2 {
            margin-left: 750px;
            font-size: 30px;
        }

        h1 {
            margin-left: 750px;
            font-size: 30px;
            margin-bottom: 5px;
            margin-top: 40px;
        }

        
        table {
            margin: 140px;
            width: 1500px;
            height: 500px;
            margin-top: -150px;
            border: solid #1f6521 2px;
            
            

        }


        .add {
            flex-basis: 70%;
        }

        #order-table {
            flex-basis: 50%;
            margin-top: -250px;
        }
        input[type="submit"] {
                            
                            margin-right: 50px;
                            
                            cursor: pointer; 
                            color: #1f6521; 
                            font-size: 14px; 
                        }
    </style>
</head>

<body>
    <div class="add">
        <h2>Добавить товар</h2>
        <link rel="stylesheet" href="../web/sweetlandstyle.css">
        <div class="form1">
            <form action="admin.php" method="post" enctype="multipart/form-data">
                <label for="s-name">Название :</label><br>
                <input type="text" id="s-name" name="sname"><br>
                <label for="stock">Количество :</label><br>
                <input type="text" id="stock" name="stock"><br><br>
                <label for="category">Категория :</label><br>
                <select id="category" name="category">
                    <?php
                    $con = mysqli_connect("localhost", "root", "root", "sweetland");
                    $sqlCategories = "SELECT * FROM `category`";
                    $resultCategories = mysqli_query($con, $sqlCategories);
                    while ($rowCategory = mysqli_fetch_assoc($resultCategories)) {
                        echo '<option value="' . $rowCategory['category_name'] . '">' . $rowCategory['category_name'] . '</option>';
                    }
                    mysqli_close($con);
                    ?>
                </select><br><br>
                <label for="maker">Производитель :</label><br>
                <select id="maker" name="maker">
                    <?php
                    $con = mysqli_connect("localhost", "root", "root", "sweetland");
                    $sqlMakers = "SELECT * FROM `maker`";
                    $resultMakers = mysqli_query($con, $sqlMakers);
                    while ($rowMaker = mysqli_fetch_assoc($resultMakers)) {
                        echo '<option value="' . $rowMaker['maker_name'] . '">' . $rowMaker['maker_name'] . '</option>';
                    }
                    ?>
                    <option value="new_maker">Добавить нового производителя</option>
                </select><br><br>

                <label for="new_maker">Имя нового производителя:</label><br>
                <input type="text" id="new_maker" name="new_maker" style="display:none;"><br><br>

                <script>
                    document.getElementById('maker').addEventListener('change', function() {
                        var newMakerInput = document.getElementById('new_maker');
                        newMakerInput.style.display = (this.value === 'new_maker') ? 'block' : 'none';
                    });
                </script>
                <label for="description">Описание :</label><br>
                <input type="text" id="description" name="description"><br><br>
                <label for="price">Стоимость :</label><br>
                <input type="text" id="price" name="price"><br><br>
                <label for="weight">Граммовка :</label><br>
                <input type="text" id="weight" name="weight"><br><br>
                <label for="image">Картинка :</label><br>
                <input type="file" name="fileImage" id="multiImage_file" />
                <br><br>
                <input type="submit" name="btnSubmit" class="button" id="btnSubmit" value="Добавить">
                <input type="submit" name="btnExit" class="button" id="btnExit" value="Выйти">
                
            </form>
        </div>
    </div>

    </div>
    <?php
    if (isset($_POST["btnExit"])) {
        header("Location: ../CONTROLLER/logout.php");
    }
    if (isset($_POST["btnSubmit"])) {
        $sName = $_POST["sname"];
        $stock = $_POST["stock"];
        $price = $_POST["price"];
        $weight = $_POST["weight"];
        $categoryOption = $_POST["category"];
        $makerOption = $_POST["maker"];
        $description = $_POST["description"];

        if ($makerOption === 'new_maker') {
            $newMakerName = $_POST["new_maker"];
            $sqlNewMaker = "INSERT INTO `maker` (`maker_name`) VALUES ('$newMakerName')";
            mysqli_query($con, $sqlNewMaker);

            $idMaker = mysqli_insert_id($con);
        } else {
            $selectedMaker = $_POST["maker"];
            $sqlMaker = "SELECT `id_maker` FROM `maker` WHERE `maker_name` = '$selectedMaker'";
            $resultMaker = mysqli_query($con, $sqlMaker);
            $rowMaker = mysqli_fetch_assoc($resultMaker);
            $idMaker = $rowMaker['id_maker'];
        }

        $image = "uploads/" . basename($_FILES["fileImage"]["name"]);
        move_uploaded_file($_FILES["fileImage"]["tmp_name"], $image);

        $con =
            mysqli_connect("localhost", "root", "root", "sweetland");
        if (!$con) {
            die("Ошибка");
        }
        $sqlCategory = "SELECT `id_category` FROM `category` WHERE `category_name` = '$categoryOption'";
        $resultCategory = mysqli_query($con, $sqlCategory);
        $rowCategory = mysqli_fetch_assoc($resultCategory);
        $idCategory = $rowCategory['id_category'];

        $sql = "INSERT INTO `sweet` (`sweetId`, `sweetName`, `stock`, `id_maker`, `id_category`, `imagePath`, `price`, `description`, `weight`) VALUES (NULL, '$sName', '$stock', '$idMaker', '$idCategory', '$image', '$price', '$description', '$weight')";

        mysqli_query($con, $sql);
        mysqli_close($con);
        header('Location: ../web/admin.php');
    }

    if (isset($_POST["btnEdit"])) {
        $sweetIdToEdit = $_POST["sweetIdToEdit"];
    ?>
        <div class="form2">
            <form action="admin.php" method="post">
                <label for="newPrice">Новая цена:</label>
                <input type="text" id="newPrice" name="newPrice" required><br>
                <label for="newStock">Новое количество:</label>
                <input type="text" id="newStock" name="newStock" required>
                <input type="hidden" name="sweetIdToEdit" value="<?php echo $sweetIdToEdit; ?>">
                <input type="submit" name="btnChange" value="Изменить">
            </form>
        </div><?php }


	if(isset($_POST["btnChange"]))
	{
    	$sweetIdToEdit = $_POST["sweetIdToEdit"];
    	$newPrice = $_POST["newPrice"];
        $newStock = $_POST["newStock"];
    	$con = mysqli_connect("localhost", "root", "root", "sweetland");
    	if(!$con)
    	{
        	die("Ошибка");
    	}
    	$sqlPreviousPrice = "SELECT `price` FROM `sweet` WHERE `sweetId` = $sweetIdToEdit";
    	$resultPreviousPrice = mysqli_query($con, $sqlPreviousPrice);
    	$rowPreviousPrice = mysqli_fetch_assoc($resultPreviousPrice);
    	$previousPrice = $rowPreviousPrice['price'];
		$sqlUpdatePrice = "UPDATE `sweet` SET `price` = $newPrice WHERE `sweetId` = $sweetIdToEdit";
		mysqli_query($con, $sqlUpdatePrice);
        $sqlUpdateStock = "UPDATE `sweet` SET `stock` = $newStock WHERE `sweetId` = $sweetIdToEdit";
        mysqli_query($con, $sqlUpdateStock);
		mysqli_close($con);
		header('Location: ../web/admin.php');
	}
	
	
    ?>
	

    <div class="tables">
        <h1>Товары и заказы</h1>
        <table id="table">
            <tr>
                <th>Название</th>
                <th>Количество</th>
                <th>Цена</th>
                <th>Производитель</th>
                <th>Категория</th>
                <th>Граммовка</th>

            </tr>
            <?php
            $con = mysqli_connect("localhost", "root", "root", "sweetland");

            if (!$con) {
                die("Ошибка");
            }

            $sql = "SELECT sweet.*, category.category_name, maker.maker_name FROM `sweet` INNER JOIN `category` ON sweet.id_category = category.id_category INNER JOIN `maker` ON sweet.id_maker = maker.id_maker";
            $result = mysqli_query($con, $sql);


            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <tr>
                        <td><?php echo $row['sweetName']; ?></td>
                        <td><?php echo $row['stock']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['maker_name']; ?></td>
                        <td><?php echo $row['category_name']; ?></td>
                        <td><?php echo $row['weight']; ?></td>
                        <td>
                            <form action="admin.php" method="post">
                                <input type="hidden" name="sweetIdToDelete" value="<?php echo $row['sweetId']; ?>">
                                <input type="submit" name="btnDeleteSweet" value="Удалить">
                            </form>
                        </td>
						<td>
							<form action="admin.php" method="post">
								<input type="hidden" name="sweetIdToEdit" value="<?php echo $row['sweetId']; ?>">
								<input type="submit" name="btnEdit" value="Изменить">
							</form>
						</td>
                    </tr><br>
                    

            <?php
                }
            }

            if (isset($_POST["btnDeleteSweet"])) {
                $sweetIdToDelete = $_POST["sweetIdToDelete"];

                $con = mysqli_connect("localhost", "root", "root", "sweetland");
                if (!$con) {
                    die("Ошибка");
                }

                $sql = "DELETE FROM `sweet` WHERE `sweetId` = $sweetIdToDelete";
                mysqli_query($con, $sql);

                mysqli_close($con);
                header('Location: ../web/admin.php');
            }
            ?>
        </table>
        <table id="order-table">
            <tr>
                <th>Дата заказа</th>
                <th>Оплата</th>
                <th>Почта заказчика</th>
                <th>Название сладости</th>
                <th>Количество</th>

            </tr>
            <?php

            $con = mysqli_connect("localhost", "root", "root", "sweetland");

            if (!$con) {
                die("Ошибка");
            }

            $sql = "SELECT `order`.`orderDate`, `order`.`payment`, `order`.`customerEmail`, `sweet`.`sweetName`, `order`.`quantity`
                    FROM `order`
                    JOIN `sweet` ON `order`.`sweetId` = `sweet`.`sweetId`";

            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['orderDate']; ?></td>
                        <td><?php echo $row['payment']; ?></td>
                        <td><?php echo $row['customerEmail']; ?></td>
                        <td><?php echo $row['sweetName']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                    </tr><br>
                    <?php
                }
            }

            mysqli_close($con);
        ?>

        </table>
    </div>
</body>

</html>