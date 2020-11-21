<?php
require_once 'constants.php'; // Подключаем файл с константами
require_once 'functions.php'; // Подключаем файл с функциями
require_once 'data.php'; // Подключаем файл с данными

// Выводим пост
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
$getPostShow = requestDataBase($requestPostShow, 'all');

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
$getLikesCount = requestDataBase($requestLikesCount, 'num');

// Считаем комментарии
$requestCommentsCount = "
    SELECT c.id
    FROM comments c
    JOIN posts p ON p.id = c.post_id
    $where
    ";
$getCommentsCount = requestDataBase($requestCommentsCount, 'num');

// Вычисляем Автора поста по айпи
$requestAuthorId = "
    SELECT p.author_id
    FROM posts p
    WHERE p.id = $current_post_id
    ";
$getAuthorId = requestDataBase($requestAuthorId, 'row');

// Считаем количество постов Автора поста
$requestPostsCount = "
    SELECT p.id
    FROM posts p
    WHERE p.author_id = $getAuthorId
    ";
$getPostsCount = requestDataBase($requestPostsCount, 'num');

// Считаем количество подписчиков Автора поста
$requestSubscribersCount = "
    SELECT s.follower_id
    FROM subscription s
    WHERE s.influencer_id = $getAuthorId
    ";
$getSubscribersCount = requestDataBase($requestSubscribersCount, 'num');


$getPostQuote = include_template('post-quote', ['postShow' => $getPostShow]);
$getPostText = include_template('post-text', ['postShow' => $getPostShow]);
$getPostPhoto = include_template('post-photo', ['postShow' => $getPostShow]);
$getPostVideo = include_template('post-video', ['postShow' => $getPostShow]);
$getPostLink = include_template('post-link', ['postShow' => $getPostShow]);


$getContentPage = include_template('post', [
    'postShow' => $getPostShow,
    'authorPostsCount' => $getPostsCount,
    'authorSubscribersCount' => $getSubscribersCount,
    'likesCount' => $getLikesCount,
    'commentsCount' => $getCommentsCount,
    'postPhoto' => $getPostPhoto,
    'postVideo' => $getPostVideo,
    'postText' => $getPostText,
    'postQuote' => $getPostQuote,
    'postLink' => $getPostLink
]);

$getLayout = include_template('layout', [
    'page_title' => $page_title,
    'contentPage' => $getContentPage,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print ($getLayout);
