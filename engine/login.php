<?php
session_start();

include "functions.php";

$url = str_replace("&auth=0", "", $_SERVER['HTTP_REFERER']);
$url = str_replace("?auth=0", "", $url); 

// Проверка введенного пароля
if (!empty($_POST) && isset($_POST['password'])) {
    if ($_POST['password'] == get_setting('blog_password')) {       
        $_SESSION['auth'] = true;
    }
    else {
        $query = parse_url($url, PHP_URL_QUERY);

        if ($query) {
            $param .= '&auth=0';
        } else {
            $param .= '?auth=0';
        }
    }
}

header('Location: '.$url.$param);

?>