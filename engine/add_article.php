<?php
if (!empty($_POST)) {
    include "connection.php";

    define('DISABLE_AUTO_SETTINGS_LOADING', 'true');
    include "functions.php";

    $query = sprintf("INSERT INTO blog_articles(title, text, date, tags) VALUES ('%s', '%s', '%s', '%s')", 
        mysqli_real_escape_string($connection, $_POST['title']),
        mysqli_real_escape_string($connection, $_POST['content']),
        mysqli_real_escape_string($connection, date('Y-m-d H:i:s')),
        mysqli_real_escape_string($connection, $_POST['tags'])    
    );    

    if (mysqli_query($connection, $query)) { 
        if (!empty($_FILES)) {
            $size = count($_FILES['attachments']['name']);
    
            for ($i = 0; $i < $size; $i++) { 
                if ($_FILES['attachments']['error'][$i] == 0) {
                    if (!move_uploaded_file($_FILES['attachments']['tmp_name'][$i], $_SERVER['DOCUMENT_ROOT'] ."/uploads/". $_FILES['attachments']['name'][$i])) { 
                        header('Location: '.get_error_url($_SERVER['HTTP_REFERER'], 12));
                    }
                }  
            }
        }

        header('Location: http://'.$_SERVER['HTTP_HOST']);
    }
    else {
        header('Location: '.get_error_url($_SERVER['HTTP_REFERER'], 9));
    }

    mysqli_close($connection);    
}
else {
    header('Location: http://'.$_SERVER['HTTP_HOST']);
}

?>