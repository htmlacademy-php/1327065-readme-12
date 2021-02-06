<?php
require_once 'constants.php'; // Подключаем файл с константами
require_once 'functions.php'; // Подключаем файл с функциями
require_once 'helpers.php'; // Подключаем файл с встроенными функциями
require_once 'data.php'; // Подключаем файл с данными

// id поста
$current_post_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$where = '';
if (isset($current_post_id)) {
    $where = "WHERE p.id = '$current_post_id'";
}

$requestPostShow = "
    SELECT p.*, ct.icon, u.avatar_path, u.login
    FROM posts p
    JOIN users u ON p.author_id = u.id
    JOIN content_type ct ON p.content_type_id = ct.id
    $where
    ";
$getPostShow = requestDataBase($connect, $requestPostShow);

// Тип поста
$postType = $getPostShow[0]['icon'];

//Пост с видео
$show_video = NULL;
switch ($postType) {
    case 'video':
        $show_video = embed_youtube_video($getPostShow[0]['video_content']);
        break;
}

if (!$getPostShow) {
    open_404_page($is_auth, $user_name);
}

// Считаем лайки
$requestLikesCount = "
    SELECT l.post_id
    FROM likes l
    JOIN posts p ON p.id = l.post_id
    $where
    ";
$getLikesCount = requestDataBase($connect, $requestLikesCount, 'num');

// Считаем комментарии
$requestCommentsCount = "
    SELECT c.id
    FROM comments c
    JOIN posts p ON p.id = c.post_id
    $where
    ";
$getCommentsCount = requestDataBase($connect, $requestCommentsCount, 'num');

// Вычисляем Автора поста по айпи
$requestAuthorId = "
    SELECT p.author_id
    FROM posts p
    WHERE p.id = $current_post_id
    ";
$getAuthorId = requestDataBase($connect, $requestAuthorId, 'row');

// Считаем количество постов Автора поста
$requestPostsCount = "
    SELECT p.id
    FROM posts p
    WHERE p.author_id = $getAuthorId
    ";
$getPostsCount = requestDataBase($connect, $requestPostsCount, 'num');

// Считаем количество подписчиков Автора поста
$requestSubscribersCount = "
    SELECT s.follower_id
    FROM subscription s
    WHERE s.influencer_id = $getAuthorId
    ";
$getSubscribersCount = requestDataBase($connect, $requestSubscribersCount, 'num');

$show_post = include_template('post-' . $postType . '.php', [
    'postShow' => $getPostShow,
    'videoShow' => $show_video
]);

$getContentPage = include_template('post.php', [
    'postShow' => $getPostShow,
    'authorPostsCount' => $getPostsCount,
    'authorSubscribersCount' => $getSubscribersCount,
    'likesCount' => $getLikesCount,
    'commentsCount' => $getCommentsCount,
    'showPost' => $show_post
]);

$getLayout = include_template('layout.php', [
    'page_title' => $page_title,
    'contentPage' => $getContentPage,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print ($getLayout);
