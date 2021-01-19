<?php
// Доступ к БД
$connect = mysqli_connect("localhost", "root", "root", "readme");

// Заголовок
$page_title = 'ReadMe: Популярное';

// Дата и время
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU'); // устанавливаем в качестве дефолтной локали Россию и Русский язык

// Авторизация
$is_auth = rand(0, 1); // рандомная авторизация
$user_name = 'Угон Харлеев'; // Имя пользователя
