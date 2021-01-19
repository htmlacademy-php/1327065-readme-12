<?php
require_once 'constants.php'; // Подключаем файл с константами
require_once 'functions.php'; // Подключаем файл с функциями
require_once 'helpers.php'; // Подключаем файл с встроенными функциями
require_once 'data.php'; // Подключаем файл с данными

// Получаем тип контента для вкладок (все типы)
$tabContentType = requestDataBase($connect, "SELECT id, type, icon FROM content_type");

// Выводим текущий тип постов
$current_type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_SPECIAL_CHARS);

// определям тип контента по умолчанию
if (!$current_type) {
    $current_type = 'text';
}

// сверяем запрос для визуализации выбора вкладки (не по умолчанию)
$getContentIndex = isset($current_type) ? $current_type : '';

// получаем определнный тип контента
$where = '';
if (isset($current_type)) {
    $where = "WHERE icon = '$current_type'";
}

// Возможно этот код вообще не нужен
$getContentType = requestDataBase($connect, "
    SELECT id, type, icon
    FROM content_type
    $where
    ");

// проверяем наличие выбранного типа контента
if (!$getContentType) {
    open_404_page($is_auth, $user_name);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST;
    $errors = [];

    // Узнаем тип поста методом POST
    $chooseType = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
    $ctid = define_content_type($connect, $chooseType);

    switch ($chooseType) {
        case 'photo':

            // валидация
//            $field = $_POST['photo-heading'];
//
//            $required_fields = ['title', ''];
//            foreach ($required_fields as $field) {
//                if (empty($_POST[$field])) {
//                    $errors[$field] = 'Поле не заполнено';
//                }
//            }

            // загрузка изображения
            $filename = uniqid() . '.jpg';

            if (!empty($_FILES['userpic-file-photo'])) {
                move_uploaded_file($_FILES['userpic-file-photo']['tmp_name'], 'uploads/' . $filename);
            }

            if (!empty($_POST['photo-url'])) {
                $url = $_POST['photo-url'];
                $path = 'uploads/' . $filename;
                file_put_contents($path, file_get_contents($url));
            }

            $data = [
                'title' => $_POST['photo-heading'],
                'image_content' => 'uploads/' . $filename,
                'hashtag' => $_POST['post-tags']
            ];
            $sql = "
                INSERT INTO posts (timestamp_add, title, image_content, author_id, content_type_id, hashtag)
                VALUES (NOW(), ?, ?, 1, $ctid, ?)
            ";
            break;

        case 'video':
            $data = [
                'title' => $_POST['video-heading'],
                'video_content' => $_POST['video-url'],
                'hashtag' => $_POST['post-tags']
            ];
            $sql = "
                INSERT INTO posts (timestamp_add, title, video_content, author_id, content_type_id, hashtag)
                VALUES (NOW(), ?, ?, 1, $ctid, ?)
            ";
            break;

        case 'text':
            $data = [
                'title' => $_POST['text-heading'],
                'text_content' => $_POST['post-text'],
                'hashtag' => $_POST['post-tags']
            ];
            $sql = "
                INSERT INTO posts (timestamp_add, title, text_content, author_id, content_type_id, hashtag)
                VALUES (NOW(), ?, ?, 1, $ctid, ?)
            ";
            break;

        case 'quote':
            $data = [
                'title' => $_POST['quote-heading'],
                'text_content' => $_POST['cite-text'],
                'quote_author' => $_POST['quote-author'],
                'hashtag' => $_POST['post-tags']
            ];
            $sql = "
                INSERT INTO posts (timestamp_add, title, text_content, quote_author, author_id, content_type_id, hashtag)
                VALUES (NOW(), ?, ?, ?, 1, $ctid, ?)
            ";
            break;

        case 'link':
            $data = [
                'title' => $_POST['link-heading'],
                'link_content' => $_POST['post-link'],
                'hashtag' => $_POST['post-tags']
            ];
            $sql = "
                INSERT INTO posts (timestamp_add, title, link_content, author_id, content_type_id, hashtag)
                VALUES (NOW(), ?, ?, 1, $ctid, ?)
            ";
            break;
    }


//    die('<pre>'.var_export($data, true));


    $stmt = db_get_prepare_stmt($connect, $sql, $data);
    $res = mysqli_stmt_execute($stmt);

    if ($res) {
        $post_id = mysqli_insert_id($connect);

        header("Location: post.php?id=" . $post_id);
    } else {
        $content = include_template('error.php', ['error' => mysqli_error($connect)]);
    }
}

$add_post = include_template('adding-post-' . $current_type . '.php', []);

$getContentPage = include_template('adding-post.php', [
    'tabType' => $tabContentType,
    'contentIndex' => $getContentIndex,
    'addPost' => $add_post
]);

$getLayout = include_template('layout.php', [
    'page_title' => 'ReadMe: Добавить публикацию',
    'contentPage' => $getContentPage,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print ($getLayout);







///**
// * render templates
// * Запрос GET для получения информации
// */
//function get_page()
//{
//} // сюда включая подвал с лэйаутом

///**
// * save data on post request
// * Запрос POST для записи информации
// */
//function save_data()
//{
//} // post page
