<?php 
// При отсутствии файла подключения перенаправляет на страницу установки
if (!file_exists("engine/connection.php")) {
    header('Location: http://'.$_SERVER['HTTP_HOST']."/engine/");
    exit();
}

session_start(); // Старт сессии (нужен для работы системы логина)

include "engine/functions.php"; // Загрузка функций для работы с БД

$data = get_artilces_data();
$settings['blog_subtitle'] = "Календарь статей";
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
    <title><?= get_setting('blog_title') ?></title>
</head>

<body>
    <?php include "engine/templates/header.html" ?>  
    <div id="calendar"></div> 
    <div id="calendar-articles" style="display: none;">
        <div id="calendar-articles-date"></div>
        <div id="calendar-articles-list"></div>
    </div>
    <?php include "engine/templates/footer.html" ?>
</body>

<script>var articlesData = <?= $data ?>;</script>
<script src="engine/js/format_article.js"></script>
<script src="engine/js/calendar.js"></script>

</html>