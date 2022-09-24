<?php 
session_start(); // Старт сессии (нужен для работы системы логина)

// Проверка наличия файла соединения и статуса редактора
if (!file_exists("engine/connection.php") || !$_SESSION['auth']) {
    header('Location: http://'.$_SERVER['HTTP_HOST']);
    exit();
}

include "engine/functions.php";
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="engine/style.css">
    <link rel="stylesheet" href="engine/themes/<?= get_setting('blog_theme') ?>.css">
    <title>Настройки</title>
</head>

<body>
    <?php include "engine/templates/header.html" ?>  
    <?php include "engine/templates/settings.html" ?>    
    <?php include "engine/templates/footer.html" ?>  
</body>

<script src="/engine/js/settings.js"></script>

</html>