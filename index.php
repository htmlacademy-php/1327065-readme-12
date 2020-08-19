<?php
$is_auth = rand(0, 1);

// двумерный массив с типами постов
$posts = [
    [
        'title' => 'Цитата',
        'type' => 'post-quote',
        'content' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
        'author' => 'Лариса',
        'avatar' => 'userpic-larisa-small.jpg',
    ],
    [
        'title' => 'История компании Honda',
        'type' => 'post-text',
        'content' => 'Соичиро Хонда родился в 1906 году в семье кузнеца. Хотя его отец был мастером в своем деле, семья жила очень бедно. В попытках свести концы с концами Хонда–старший занялся починкой велосипедов, а Соичиро довольно рано стал ему в этом помогать. В школе дела у Соичиро шли не лучшим образом: он ненавидел заучивание и формальности. Окончив школу, Хонда отправился в Токио. Устроившись в фирму «Art Shokai», Хонда надеялся получить практические навыки и познакомиться с устройством автомобиля. Его надежды не оправдались: из–за возраста и небольшого опыта ему чаще поручали присмотреть за младшим сыном владельца фирмы, поубирать и приготовить еду.',
        'author' => 'Владик',
        'avatar' => 'userpic.jpg',
    ],
    [
        'title' => 'Наконец, обработал фотки!',
        'type' => 'post-photo',
        'content' => 'rock-medium.jpg',
        'author' => 'Виктор',
        'avatar' => 'userpic-mark.jpg',
    ],
    [
        'title' => 'Моя мечта',
        'type' => 'post-photo',
        'content' => 'coast-medium.jpg',
        'author' => 'Лариса',
        'avatar' => 'userpic-larisa-small.jpg',
    ],
    [
        'title' => 'Лучшие курсы',
        'type' => 'post-link',
        'content' => 'www.htmlacademy.ru',
        'author' => 'Владик',
        'avatar' => 'userpic.jpg',
    ],
];

$user_name = 'Угон Харлеев'; // укажите здесь ваше имя



// Функция обрезания текста на главной странице. Обрезает слишком длинный текст и добавляет ссылку на полную страницу статьи
function cut_text($text, $symbols = 300) {
    if (mb_strlen($text) > $symbols) {
        // разбиваем текст на слова при помощи пробелов
        $gap_count = explode(" ", $text); // текст как массив, без пробелов
        // вводим переменные для цикла
        $text_length = 0;
        $i = 0;
        // запускаем цикл для перебора массива для подсчета общего количества символов в словах
        while ($text_length < $symbols) {
            $text_length += mb_strlen($gap_count[$i]); //счетчик длины слов
            $i++;
        }
        // склеиваем массив снова
        $text = implode(" ", array_slice($gap_count, 0, $i)) . '... <a class="post-text__more-link" href="#">Читать далее</a>';
    }
    return $text;
}

// Функция-шаблонизатор
function include_template($path, array $data = [])
{
    $path = 'templates/' . $path . '.php';

    // проверка наличия файла и доступа к нему
    if (!is_readable($path)) {
        return 'Шаблон не найден: [' . $path . ']';
    }

    // Включение буферизации вывода
    ob_start();

    // Импортирует переменные из массива в текущую таблицу символов, вот только что за таблица символов такая, не использовать с непроверенными данными,поэтому применяем htmlspecialchars
    htmlspecialchars(extract($data));
    require_once $path;

    // Получить содержимое текущего буфера и удалить его
    return ob_get_clean();
}



$layout_data = include_template('main', ['posts' => $posts]);
$layout = include_template('layout', ['page_title' => $page_title, 'layout_data' => $layout_data, 'is_auth' => $is_auth]);

print ($layout);

