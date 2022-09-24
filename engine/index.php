<?php 
if (file_exists("connection.php")) {
    header('Location: http://'.$_SERVER['HTTP_HOST']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Установка</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<header>
		<img src="images/logo.jpg" alt="Логотип блога" id="blog-logo">
		<div id="blog-title">Hedgehog</div>
		<div id="blog-subtitle">Установка</div>
	</header> 

	<form action="install.php" id="form-settings" method="POST">
		<label for="server">Сервер</label>
		<input type="text" name="server" value="localhost" required>
		<label for="user">Логин</label>
		<input type="text" name="user" value="root" required>
		<label for="password">Пароль</label>
		<input type="password" name="password" value="">
		<label for="database">Название БД</label>
		<input type="text" name="database" required>
		<label for="blog-password">Пароль для входа в блог</label>
		<input type="password" name="blog-password" required>
		<button type="submit">Начать ведение блога</button>
	</form>

	<?php include "templates/modal_dialog.html"; ?>
</body>
</html>

