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

$add_post = include_template('adding-post-' . $current_type . '.php', []);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST;
    $files = [];
    $errors = [];

    // Узнаем тип поста методом POST
    $chooseType = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
    $ctid = define_content_type($connect, $chooseType);

    $fields_list = [
        'photo-heading' => 'Заголовок',
        'photo-url' => 'Ссылка из интернета',
        'photo-tags' => 'Теги',
        'userpic-file-photo' => 'Выбор фото',
        'video-heading' => 'Заголовок',
        'video-url' => 'Ссылка YouTube',
        'video-tags' => 'Теги',
        'text-heading' => 'Заголовок',
        'post-text' => 'Текст поста',
        'post-tags' => 'Теги',
        'quote-heading' => 'Заголовок',
        'cite-text' => 'Текст цитаты',
        'quote-author' => 'Автор',
        'cite-tags' => 'Теги',
        'link-heading' => 'Заголовок',
        'post-link' => 'Ссылка',
        'link-tags' => 'Теги'
    ];

    switch ($chooseType) {
        case 'photo':
            // Валидация полей категории "Фото"
            $required_fields = ['photo-heading', 'photo-url', 'photo-tags'];

            if (!empty($_FILES['userpic-file-photo']['name'])) {
                unset($required_fields[1]);
            }

            $errors = check_field($required_fields, $fields_list);

            if (!empty($_FILES['userpic-file-photo']['name'])) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $file_name = $_FILES['userpic-file-photo']['tmp_name'];
                $file_size = $_FILES['userpic-file-photo']['size'];

                $file_type = finfo_file($finfo, $file_name);

                if ($file_type !== 'image/gif' || $file_type !== 'image/jpeg' || $file_type !== 'image/pjpeg' || $file_type !== 'image/png') {
                    $errors['userpic-file-photo'] = "Выбор фото. Загрузите изображение в формате JPEG / PNG или GIF";
                }

                if ($file_size > 52428800) {
                    $errors['userpic-file-photo'] = "Выбор фото. Максимальный размер файла: 50 МБ";
                }
            }

            // загрузка изображения
            $filename = uniqid() . '.jpg';

            if (!empty($_POST['photo-url']) && $errors === NULL) {
                $url = $_POST['photo-url'];
                $path = 'uploads/' . $filename;
                file_put_contents($path, file_get_contents($url));
            }

            if (!empty($_FILES['userpic-file-photo']['name']) && $errors === NULL) {
                move_uploaded_file($_FILES['userpic-file-photo']['tmp_name'], 'uploads/' . $filename);
            }

            $data = [
                'title' => $_POST['photo-heading'],
                'image_content' => 'uploads/' . $filename,
                'hashtag' => $_POST['photo-tags']
            ];

            $sql = "
                INSERT INTO posts (timestamp_add, title, image_content, author_id, content_type_id, hashtag)
                VALUES (NOW(), ?, ?, 1, $ctid, ?)
            ";
            break;

        case 'video':
            // Валидация полей категории "Видео"
            $required_fields = ['video-heading', 'video-url', 'video-tags'];
            $errors = check_field($required_fields, $fields_list);

            $data = [
                'title' => $_POST['video-heading'],
                'video_content' => $_POST['video-url'],
                'hashtag' => $_POST['video-tags']
            ];
            $sql = "
                INSERT INTO posts (timestamp_add, title, video_content, author_id, content_type_id, hashtag)
                VALUES (NOW(), ?, ?, 1, $ctid, ?)
            ";
            break;

        case 'text':
            // Валидация полей категории "Текст"
            $required_fields = ['text-heading', 'post-text', 'post-tags'];
            $errors = check_field($required_fields, $fields_list);

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
            // Валидация полей категории "Цитата"
            $required_fields = ['quote-heading', 'cite-text', 'quote-author', 'cite-tags'];
            $errors = check_field($required_fields, $fields_list);

            $data = [
                'title' => $_POST['quote-heading'],
                'text_content' => $_POST['cite-text'],
                'quote_author' => $_POST['quote-author'],
                'hashtag' => $_POST['cite-tags']
            ];
            $sql = "
                INSERT INTO posts (timestamp_add, title, text_content, quote_author, author_id, content_type_id, hashtag)
                VALUES (NOW(), ?, ?, ?, 1, $ctid, ?)
            ";
            break;

        case 'link':
            // Валидация полей категории "Ссылка"
            $required_fields = ['link-heading', 'post-link', 'link-tags'];
            $errors = check_field($required_fields, $fields_list);

            $data = [
                'title' => $_POST['link-heading'],
                'link_content' => $_POST['post-link'],
                'hashtag' => $_POST['link-tags']
            ];

            $sql = "
                INSERT INTO posts (timestamp_add, title, link_content, author_id, content_type_id, hashtag)
                VALUES (NOW(), ?, ?, 1, $ctid, ?)
            ";
            break;
    }

    if (count($errors)) {
        $add_post = include_template('adding-post-' . $current_type . '.php', [
            'dataValues' => $data,
            'displayErrors' => $errors
        ]);

        $getContentPage = include_template('adding-post.php', [
            'tabType' => $tabContentType,
            'contentIndex' => $getContentIndex,
            'addPost' => $add_post
        ]);

    } else {
        $stmt = db_get_prepare_stmt($connect, $sql, $data);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $post_id = mysqli_insert_id($connect);

            header("Location: post.php?id=" . $post_id);
        } else {
            $content = include_template('error.php', ['error' => mysqli_error($connect)]);
        }
    }
}

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
