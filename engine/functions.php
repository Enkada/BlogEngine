<?php 

function load_settings() {
    include "connection.php";

    global $settings;
    $settings = array();
    $result = mysqli_query($connection, "SELECT * FROM blog_settings");

    while ($row = mysqli_fetch_assoc($result)) {
        $settings[$row['name']] = $row['value'];
    }

    mysqli_free_result($result);
    mysqli_close($connection);
}

// Автоматическая загрузка переменных настроек из БД
if (!defined('DISABLE_AUTO_SETTINGS_LOADING')) { load_settings(); } 

function get_setting($name) {
    global $settings;
    return $settings[$name];
}

// Получение списка статей
function get_artilces_data() {
    include "connection.php";

    $result = mysqli_query($connection, "SELECT * FROM blog_articles ORDER BY date DESC");

    while ($row = mysqli_fetch_assoc($result)) {
        $row['tags'] = json_decode($row['tags']);
        $data[] = $row;
    }

    mysqli_free_result($result);
    mysqli_close($connection);

    return json_encode($data);
}

// Получение инфромации об одной статье
function get_artilce_data($id) {
    include "engine/connection.php";

    // Получение информации о статье
    $data = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM blog_articles WHERE id = $id"));    
    extract($data);
    $months = array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
    $date = date_format(date_create($date), 'd ').$months[date_format(date_create($date), 'n') - 1].date_format(date_create($date), ', Y');
    $tags = json_decode($tags);   
    if (!empty($tags)) {
        foreach ($tags as $tag) { 
            $tag_list = $tag_list . "<a href='/?q=$tag' class='article-tag'>$tag</a>"; 
        }
    }

    // Получение комментариев
    $result = mysqli_query($connection, "SELECT * FROM blog_comments WHERE post = $id ORDER BY date DESC");

    while ($row = mysqli_fetch_assoc($result)) {
        $comments[] = $row; 
    }

    mysqli_free_result($result);
    mysqli_close($connection);

    return array ("id" => $id, "title" => $title, "text" => $text, "date" => $date, "tags" => $tag_list, "comments" => json_encode($comments));
}

function get_error_url($url, $error = 1, $name = 'error') {
    $url = str_replace('&'.$name.'='.$error, '', $url);
    $url = str_replace('?'.$name.'='.$error, '', $url); 

    $query = parse_url($url, PHP_URL_QUERY);

    if ($query) {
        $url .= '&'.$name.'='.$error;
    } else {
        $url .= '?'.$name.'='.$error;
    }

    return $url;
}

?>