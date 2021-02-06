<?php
/**
 * Функция обрезания текста.
 * Используется при выводе списка постов.
 * Обрезает слишком длинный текст и добавляет ссылку на полную страницу статьи
 *
 * @param $text
 * @param int $symbols
 * @return string
 */
function cut_text($text, $symbols = 300)
{
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

/**
 * Функция работы с датой. Принимает unix timestamp и вовзвращает дату в "человеческом" виде
 *
 * @param $timestamp
 * @param $format
 * @return false|string
 */
function show_date($time, $format)
{
    $timestamp = strtotime($time);
    $dt = date_create();
    $dt = date_timestamp_set($dt, $timestamp);
    $current_timestamp = time();

    //преобразование формата даты
    switch ($format) {
        case 'datetime_format':
            $format_timestamp = date_format($dt, DATETIME_FORMAT);
            break;
        case 'title_format':
            $format_timestamp = date_format($dt, TITLE_FORMAT);
            break;
        case 'relative_format':
            if ($timestamp + SIXTY_MINUTES > $current_timestamp) { // до 60 минут
                $remaining_minutes = ceil(($current_timestamp - $timestamp) / SIXTY_SECONDS);
                $format_timestamp = $remaining_minutes . get_noun_plural_form(
                        $remaining_minutes,
                        ' минута',
                        ' минуты',
                        ' минут'
                    );
            } elseif ($timestamp + SIXTY_MINUTES <= $current_timestamp && $timestamp + TWENTY_FOUR_HOURS > $current_timestamp) { // от 60 минут до 24 часов
                $remaining_hours = ceil(($current_timestamp - $timestamp) / SIXTY_MINUTES);
                $format_timestamp = $remaining_hours . get_noun_plural_form(
                        $remaining_hours,
                        ' час',
                        ' часа',
                        ' часов'
                    );
            } elseif ($timestamp + TWENTY_FOUR_HOURS <= $current_timestamp && $timestamp + SEVEN_DAYS > $current_timestamp) { // от 24 часов но меньше 7 дней
                $remaining_days = ceil(($current_timestamp - $timestamp) / TWENTY_FOUR_HOURS);
                $format_timestamp = $remaining_days . get_noun_plural_form(
                        $remaining_days,
                        ' день',
                        ' дня',
                        ' дней'
                    );
            } elseif ($timestamp + SEVEN_DAYS <= $current_timestamp && $timestamp + FIVE_WEEKS > $current_timestamp) { // от 7 дней но меньше 5 недель
                $remaining_weeks = ceil(($current_timestamp - $timestamp) / SEVEN_DAYS);
                $format_timestamp = $remaining_weeks . get_noun_plural_form(
                        $remaining_weeks,
                        ' неделя',
                        ' недели',
                        ' недель'
                    );
            } elseif ($timestamp + FIVE_WEEKS <= $current_timestamp) { // больше 5 недель
                $remaining_months = ceil(($current_timestamp - $timestamp) / FIVE_WEEKS);
                $format_timestamp = $remaining_months . get_noun_plural_form(
                        $remaining_months,
                        ' месяц',
                        ' месяца',
                        ' месяцев'
                    );
            }
            break;
    }

    return $format_timestamp;
}

/**
 * Функция выполняющая запросы к БД
 * @param $connect - Ресурс соединения
 * @param $sql -  запрос к БД
 * @param string $type - тип данных
 * @return array|int|mixed
 */
function requestDataBase($connect, $sql, $type = 'all')
{
    mysqli_set_charset($connect, "utf8");

    if (!$connect) {
        $error = mysqli_connect_error();
        $answerDataBase = print("Ошибка MySQL: " . $error);
    } else {

        if ($result = mysqli_query($connect, $sql)) {
            switch ($type) {
                case 'all':
                    $answerDataBase = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    break;
                case 'row':
                    $answerDataBase = mysqli_fetch_row($result)[0];
                    break;
                case 'num':
                    $answerDataBase = mysqli_num_rows($result);
                    break;
            }
        } else {
            $error = mysqli_error($connect);
            $answerDataBase = print("Ошибка MySQL: " . $error);
        }
    }
    return $answerDataBase;
}

/**
 * Вызов ошибки 404
 * @param $is_auth
 * @param $user_name
 */
function open_404_page($is_auth, $user_name)
{
    $getPage404 = include_template('page-404.php');
    $getLayout = include_template('layout.php', [
        'page_title' => 'ReadMe: Страница не найдена',
        'contentPage' => $getPage404,
        'is_auth' => $is_auth,
        'user_name' => $user_name
    ]);

    print ($getLayout);
    http_response_code(404);
    die();
}

/**
 *
 */
function addingPost()
{

}

/**
 * Возвращает id типа контента
 * @param $connect - соединение
 * @param $content_type - массив с типом контента
 * @return mixed
 */
function define_content_type($connect, $content_type)
{
    $where = '';
    if (isset($content_type)) {
        $where = "WHERE icon = '$content_type'";
    }

    $content_type_id = requestDataBase($connect, "
                SELECT id, type, icon
                FROM content_type
                $where
                ");

    return $content_type_id[0]['id'];
}

/**
 * Получаем значения из запроса
 * @param $data - массив с данными
 * @param $name - имя ключа
 * @return mixed|string
 */
function getPostVal($data, $name)
{
    return $data[$name] ?? "";
}

/**
 * Проверяет поля на заполнение. А также проверяет ссылку
 * @param $required_fields
 * @param $fields_list
 * @return array
 */
function check_field($required_fields, $fields_list)
{
    //Проверка формата URL-адресов, без кириллицы
    if (in_array('post-link', $required_fields)) {
        if (!filter_var($_POST['post-link'], FILTER_VALIDATE_URL)) {
            $errors['post-link'] = 'Ссылка. Введенное значение не является ссылкой';
        }
    }

    if (in_array('photo-url', $required_fields)) {
        if (!filter_var($_POST['photo-url'], FILTER_VALIDATE_URL)) {
            $errors['photo-url'] = 'Ссылка из интернета. Введенное значение не является ссылкой';
        }
    }

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = $fields_list[$field] . '. Это поле должно быть заполнено.';
        }
    }
//    die('<pre>' . var_export($errors, true));
    return $errors;
}
