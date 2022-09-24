<?php 
// При отсутствии файла подключения перенаправляет на страницу установки
if (!file_exists("engine/connection.php")) {
    header('Location: http://'.$_SERVER['HTTP_HOST']."/engine/");
    exit();
}

session_start(); // Старт сессии (нужен для работы системы логина)

include "engine/functions.php"; // Загрузка функций для работы с БД

$data = get_artilces_data();
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
    <header>
        <a href="/" id="blog-logo" style="background-image: url('/engine/images/logo.jpg?v=<?= filemtime("engine/images/logo.jpg") ?>')"></a>
        <a href="/" id="blog-title"><?= get_setting('blog_title') ?></a>
        <div id="blog-subtitle"><?= get_setting('blog_subtitle') ?></div>
        <nav id="blog-menu">
            <ul>
                <?php if ($_SESSION['auth']) { include "engine/templates/editor_nav.html"; } ?>
                <li><a href="/calendar.php"><span class="material-icons">calendar_month</span></a></li>
                <?php if ($_SERVER['PHP_SELF'] == '/index.php') { echo '<li><div id="search"><input type="search" hidden><span class="material-icons">search</span></div></li>'; }?>
            </ul>
        </nav>
    </header> 
    <div id="article-list">
        <?php if ($data == "null" && $_SESSION['auth']) { echo '<p>Блог создан, но он пока пуст. <a href="new.php">Напишите новую статью</a>.</p>'; } ?>
        <?php if ($data == "null" && !$_SESSION['auth']) { echo '<p>В этом блоге еще нет статей.</p>'; } ?>
        <template id="template-article">
            <article>
                <section class="article-header">
                    <h1><a class="article-title"></a></h1>
                    <?php if ($_SESSION['auth']) { echo '<a class="article-edit"><span class="material-icons">edit</span></a>'; } ?>
                </section>
                <section class="article-body"></section>
                <section class="article-footer">
                    <div class="article-date"></div>
                    <div class="article-tags"></div>
                </section>
            </article>
        </template>
    </div> 
    <footer>        
        <span>Движок для блога Hedgehog</span>
        <span>© Кирилл и Даниил, 2022</span>
        <?php if (!$_SESSION['auth']) { echo '<span class="material-icons" id="btn-login" onclick="showAuth()">lock</span>';} ?>
    </footer>
    <?php include "modal_dialog.html"; ?>
</body>

<script>var articlesData = <?= $data ?>;</script>
<script src="engine/js/format_article.js"></script>
<script src="engine/js/article_list.js"></script>
<?php if (isset($_GET['q'])) { echo '<script>searchInput.value = "'.$_GET['q'].'"; searchInput.dispatchEvent(new Event("input")); btnSearch.dispatchEvent(new Event("click"));</script>'; } ?>

</html>