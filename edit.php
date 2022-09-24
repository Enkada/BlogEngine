<?php 
session_start(); // Старт сессии (нужен для работы системы логина)

// Проверка наличия файла соединения и статуса редактора
if (!file_exists("engine/connection.php") || !$_SESSION['auth']) {
    header('Location: http://'.$_SERVER['HTTP_HOST']);
    exit();
}

include "engine/functions.php";

if (!empty($_GET) && isset($_GET['id']) && $_GET['id'] != "") {
    include "engine/connection.php";

    $id = $_GET['id'];

    $data = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM blog_articles WHERE id = $id"));
    
    extract($data);
    //$tags = json_decode($tags);
    if (empty($tags)) { $tags = "[]"; }  

    mysqli_close($connection);
}
else {
    header('Location: http://'.$_SERVER['HTTP_HOST']);
}

foreach (scandir("uploads") as $file) {
    if (!in_array(trim($file), array('.', '..'))) {
        $attachments[] = $file;
    }
}
$attachments = json_encode($attachments);
$settings['blog_subtitle'] = "Редактирование";
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
    <title>Редактирование</title>

    <script>tagList = <?= $tags ?>;</script>
    <script>galleryAttachments = <?= $attachments ?>;</script>
</head>

<body>
    <?php include "engine/templates/header.html" ?>  

    <form action="engine/edit_article.php" id="form-settings" method="POST" enctype="multipart/form-data">
        <label for="id" hidden>ID</label>
        <input type="hidden" name="id" value="<?= $id ?>" hidden>

        <?php include "engine/templates/article_form.html" ?> 

        <button type="submit">Сохранить изменения</button>
    </form>

    <div id="btn-delete-article"><span>Удалить статью</span><span class="material-icons">delete</span></div>

    <?php include "engine/templates/footer.html" ?>      
</body>

<script>updateTags();</script>


<script>
var btnDelete = document.querySelector('#btn-delete-article');
btnDelete.addEventListener('click', () => {
    showYesNoDialog("Удаление статьи", "Вы действительно хотите удалить данную статью?", "engine/delete_article.php?id=<?= $id ?>");
});
</script>

</html>