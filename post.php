<?php 
// При отсутствии файла подключения перенаправляет на страницу установки
if (!file_exists("engine/connection.php")) {
    header('Location: http://'.$_SERVER['HTTP_HOST']."/engine/");
    exit();
}

session_start(); // Старт сессии (нужен для работы системы логина)

include "engine/functions.php";

if (!empty($_GET) && isset($_GET['id'])) {
    $article = get_artilce_data($_GET['id']);
}

$settings['blog_subtitle'] = "Просмотр статьи";
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
    <title><?= $article['title'] ?></title>
</head>

<body>
    <?php include "engine/templates/header.html" ?>  
    <div id="article-single">
        <article>
            <section class="article-header">
                <h1><a class="article-title"><?= $article['title'] ?></a></h1>
                <?php if ($_SESSION['auth']) { echo '<a class="article-edit" href="edit.php?id='.$article['id'].'"><span class="material-icons">edit</span></a>'; } ?>
            </section>
            <section class="article-body"><?= $article['text']  ?></section>
            <section class="article-footer">
                <div class="article-date"><?= $article['date']  ?></div>
                <div class="article-tags"><?= $article['tags'] ?></div>
            </section>
        </article>
    </div>
    <?php include "engine/templates/comments.html" ?>
    <?php include "engine/templates/footer.html" ?>
</body>

<script>var commentsData = <?= $article['comments'] ?>;</script>
<script src="engine/js/format_article.js"></script>
<script>
    const articleBody = document.querySelector('.article-body');
    articleBody.innerHTML = formatArticleText(articleBody.innerHTML);
</script>
<script src="/engine/js/comments.js"></script>

</html>