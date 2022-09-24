<?php 

if (!empty($_POST)) {
    include "connection.php";

    define('DISABLE_AUTO_SETTINGS_LOADING', 'true');
    include "functions.php";

    $query = sprintf("UPDATE blog_articles SET title = '%s', text = '%s', date = '%s', tags = '%s' WHERE id = %s", 
        mysqli_real_escape_string($connection, $_POST['title']),
        mysqli_real_escape_string($connection, $_POST['content']),
        mysqli_real_escape_string($connection, date('Y-m-d H:i:s')),
        mysqli_real_escape_string($connection, $_POST['tags']),
        mysqli_real_escape_string($connection, $_POST['id'])
    );

    $success = mysqli_query($connection, $query);
    mysqli_close($connection);  
    
    if (!empty($_FILES)) {
        $size = count($_FILES['attachments']['name']);

        for ($i = 0; $i < $size; $i++) { 
            if ($_FILES['attachments']['error'][$i] == 0) {
                if (!move_uploaded_file($_FILES['attachments']['tmp_name'][$i], "../uploads/".$_FILES['attachments']['name'][$i])) { 
                    header('Location: '.get_error_url($_SERVER['HTTP_REFERER'], 12));
                }
            }  
        }
    }

    if ($success) {          
        header('Location: http://'.$_SERVER['HTTP_HOST']."/post.php?id=".$_POST['id']);
    }
    else {
        header('Location: '.get_error_url($_SERVER['HTTP_REFERER'], 8));
    }    
}
else {
    header('Location: http://'.$_SERVER['HTTP_HOST']);
}

?>