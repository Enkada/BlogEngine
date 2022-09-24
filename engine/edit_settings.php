<?php

if (!empty($_POST) || !empty($_FILES)) {    
    include "connection.php";

    define('DISABLE_AUTO_SETTINGS_LOADING', 'true');
    include "functions.php";

    $error == 0;

    foreach ($_POST as $key => $value) {
        if (get_setting($key) != $value && $key != 'logo') {            
            if (!mysqli_query($connection, "UPDATE blog_settings SET value = '$value' WHERE name = '$key'")) { $error = 7; }            
        }
    }

    mysqli_close($connection);

    $logo = $_FILES['logo'];
    if ($logo['error'] == 0) {
        if (!move_uploaded_file($logo['tmp_name'], "images/logo.jpg")) { $error = 6; }
    }    


    if ($error != 0) {
        header('Location: '.get_error_url('http://'.$_SERVER['HTTP_HOST'].'/settings.php', $error));
    }
    else {
        header('Location: http://'.$_SERVER['HTTP_HOST']);
    }
} else {
    header('Location: http://'.$_SERVER['HTTP_HOST']);
}

?>