<?php 
session_start(); // Старт сессии (нужен для работы системы логина)

// Проверка наличия файла соединения и статуса редактора
if (!file_exists("engine/connection.php") || !$_SESSION['auth']) {
    header('Location: http://'.$_SERVER['HTTP_HOST']);
    exit();
}

include "engine/functions.php";

foreach (scandir("uploads") as $file) {
    if (!in_array(trim($file), array('.', '..'))) {
        $attachments[] = $file;
    }
}
$attachments = json_encode($attachments);
$settings['blog_subtitle'] = "Новая статья";
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="engine/style.css">
    <link rel="stylesheet" href="engine/themes/<?= get_setting('blog_theme') ?>.css">
    <title>Новая статья</title>

    <script>var galleryAttachments = <?= $attachments ?>;</script>
</head>

<body>
    <?php include "engine/templates/header.html" ?>  

    <form action="engine/add_article.php" id="form-settings" method="POST" enctype="multipart/form-data">        
        <?php include "engine/templates/article_form.html" ?> 
        <button type="submit">Создать</button>
    </form>

    <?php include "engine/templates/footer.html" ?>      
</body>

</html>