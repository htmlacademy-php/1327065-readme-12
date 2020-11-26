<?php
require_once 'constants.php'; // Подключаем файл с константами
require_once 'functions.php'; // Подключаем файл с функциями
require_once 'data.php'; // Подключаем файл с данными

// вывод закладок с типом контента на страницу популярных постов
$requestContentType = "SELECT id, type, icon FROM content_type";
$getContentType = requestDataBase($requestContentType, 'all');


// Вывод постов. Популярное. // Фильтрация вывода постов
$get_tab_param = filter_input(INPUT_GET, 'tab');

$where = '';
if (isset($get_tab_param)) {
    $where = "WHERE p.content_type_id = '$get_tab_param'";
}

$requestShowContent = "
        SELECT p.*, ct.icon, u.avatar_path, u.login
        FROM posts p
        JOIN users u ON p.author_id = u.id
        JOIN content_type ct ON p.content_type_id = ct.id
        $where
--        ORDER BY $sort_field DESC // заготовка для сортировки
        LIMIT 6
        ";
$getContentShow = requestDataBase($requestShowContent, 'all');

// Заготовка сортировки вывода постов, пока оставить
//    $sort_field = 'show_count';
//    $sort = filter_input(INPUT_GET, 'sort');
//    if ($sort == 'new') {
//        $sort_field = 'timestamp_add';
//    }
//die (var_export($_GET['id']));

// сверяем запрос для визуализации выбора вкладки
$getContentIndex = isset($get_tab_param) ? $get_tab_param : '';

$getContentPage = include_template('main', [
    'contentType' => $getContentType,
    'contentShow' => $getContentShow,
    'contentIndex' => $getContentIndex
]);

$getLayout = include_template('layout', [
    'page_title' => $page_title,
    'contentPage' => $getContentPage,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print ($getLayout);

