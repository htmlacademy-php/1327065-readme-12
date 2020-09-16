<?php
require_once 'functions.php'; // Подключаем файл с функциями
require_once 'data.php'; // Подключаем файл с данными

$layout_data = include_template('main', ['posts' => $posts]);
$layout = include_template('layout', ['page_title' => $page_title, 'layout_data' => $layout_data, 'is_auth' => $is_auth, 'user_name' => $user_name]);

print ($layout);

