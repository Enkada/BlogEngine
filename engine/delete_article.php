<?php 
session_start(); // Старт сессии (нужен для работы системы логина)

// Проверка наличия файла соединения и статуса редактора
if (!file_exists("connection.php") || !$_SESSION['auth']) {
    header('Location: http://'.$_SERVER['HTTP_HOST']);
    exit();
}

if (!empty($_GET) && isset($_GET['id'])) {    
    include "connection.php";

    define('DISABLE_AUTO_SETTINGS_LOADING', 'true');
    include "functions.php";

    $id = $_GET['id'];

    $success = mysqli_query($connection, "DELETE FROM blog_comments WHERE post = $id") && mysqli_query($connection, "DELETE FROM blog_articles WHERE id = $id");
    mysqli_close($connection);    

    if ($success) {
        header('Location: http://'.$_SERVER['HTTP_HOST']);
    } 
    else {
        header('Location: '.get_error_url($_SERVER['HTTP_REFERER'], 10));
    }
} else {
    header('Location: http://'.$_SERVER['HTTP_HOST']);
}

?>