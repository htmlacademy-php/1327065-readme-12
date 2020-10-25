<?php
require_once 'functions.php'; // Подключаем файл с функциями
require_once 'data.php'; // Подключаем файл с данными

$connect_db = mysqli_connect("localhost", "root", "root", "readme");
mysqli_set_charset($connect_db, "utf8");

if (!$connect_db) {
    $error = mysqli_connect_error();
    print("Ошибка MySQL: " . $error);
} else {
    $query_content_type = "SELECT * FROM content_type";
    $result_content_type = mysqli_query($connect_db, $query_content_type);
    if ($result_content_type) {
        $content_type = mysqli_fetch_all($result_content_type, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connect_db);
        print("Ошибка MySQL: " . $error);
    }

    $query_posts_list = "SELECT * FROM posts JOIN users ON posts.author_id = users.id JOIN content_type ON posts.content_type = content_type.id ORDER BY view_count DESC";
    $result_posts_list = mysqli_query($connect_db, $query_posts_list);
    if (!$result_posts_list) {
        $error = mysqli_error($connect_db);
        print("Ошибка MySQL: " . $error);
    } else {
        $posts_list = mysqli_fetch_all($result_posts_list, MYSQLI_ASSOC);
    }
}


$layout_data = include_template('main', ['content_type' => $content_type, 'posts' => $posts_list]);
$layout = include_template('layout', ['page_title' => $page_title, 'layout_data' => $layout_data, 'is_auth' => $is_auth, 'user_name' => $user_name]);

print ($layout);

