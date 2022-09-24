<?php

if (!empty($_POST)) {
    include "connection.php";

    define('DISABLE_AUTO_SETTINGS_LOADING', 'true');
    include "functions.php";

    date_default_timezone_set('Europe/Chisinau');

    $query = sprintf("INSERT INTO blog_comments(post, name, text, date) VALUES (%s, '%s', '%s', '%s')", 
        mysqli_real_escape_string($connection, $_POST['id']),
        mysqli_real_escape_string($connection, $_POST['name']),
        mysqli_real_escape_string($connection, $_POST['content']),
        mysqli_real_escape_string($connection, date('Y-m-d H:i:s'))    
    );

    if (mysqli_query($connection, $query)) { 
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    else {
        header('Location: '.get_error_url($_SERVER['HTTP_REFERER'], 11));
    }

    mysqli_close($connection);    
}
else {
    header('Location: http://'.$_SERVER['HTTP_HOST']);
}

?>