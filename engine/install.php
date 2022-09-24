<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

define('DISABLE_AUTO_SETTINGS_LOADING', 'true');
include "functions.php";

$error = 0;
if (!empty($_POST)) {	
	$server = $_POST['server'];
	$user = $_POST['user'];
	$password = $_POST['password'];
	$database = $_POST['database'];
	$blog_password = $_POST['blog-password'];

	$connection = null;

	// Создаем соединение с базой данных
	try {
		$connection = @mysqli_connect($server, $user, $password);
	} catch (mysqli_sql_exception $e) { $error = 1;	}

	// Проверяем соединение
	if ($connection) 
	{
		// Проверяем существует ли база данных
		$database_search = mysqli_fetch_array(mysqli_query($connection,"SHOW DATABASES LIKE '$database'"));

		// Смотрим на результат запроса
		if (empty ($database_search)) 
		{
			// Создаем базу если не существует
			if (!mysqli_query($connection, "CREATE DATABASE $database")) { $error = 2; }
		}
		else
		{
			// Удаляем старые таблицы если БД уже существует
			if (!mysqli_query($connection, "DROP TABLE IF EXISTS $database.blog_articles;") ||
				!mysqli_query($connection, "DROP TABLE IF EXISTS $database.blog_settings;") ||
				!mysqli_query($connection, "DROP TABLE IF EXISTS $database.blog_comments;")
			) { $error = 3; }
		}

		if ($error == 0) {
			// После создания базы или удаления таблиц создаем новые таблицы
			if (mysqli_query($connection, "CREATE TABLE $database.blog_settings (name varchar(255) unique, value varchar(255))") &&
				mysqli_query($connection, "CREATE TABLE $database.blog_articles (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, title varchar(255), text LONGTEXT, date DATETIME, tags varchar(255))") && 
				mysqli_query($connection, "CREATE TABLE $database.blog_comments (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, post INT, name varchar(255), text LONGTEXT, date DATETIME, FOREIGN KEY (post) REFERENCES $database.blog_articles (id))"
			)) {
				// Добавляем стартовые параметры
				if (mysqli_query($connection, 
					"
					INSERT INTO $database.blog_settings VALUES 
					('blog_title', 'Заголовок блога'),
					('blog_subtitle', 'Подзаголовок блога'),
					('blog_theme', 'light'),
					('blog_password', '$blog_password'),
					('db_name', '$database')
					"
				)) {
					// При отсутствии ошибок создаем файл соединения и перенаправляем на главную страницу
					file_put_contents("connection.php", "<?php \$connection = mysqli_connect('$server', '$user', '$password', '$database'); ?>");

					session_start();
					$_SESSION['auth'] = true;

					header('Location: http://'.$_SERVER['HTTP_HOST']);
				}
				else { $error = 5; }		
			} 
			else { $error = 4; } 
		}

		echo mysqli_error($connection);

		mysqli_close($connection);
	}
	else { $error = 1; }	
}

header('Location: '.get_error_url('http://'.$_SERVER['HTTP_HOST'].'/engine/', $error));

?>