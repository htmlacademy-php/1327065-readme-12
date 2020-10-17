<?php

// Функция обрезания текста на главной странице. Обрезает слишком длинный текст и добавляет ссылку на полную страницу статьи
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

    // extract импортирует переменные из массива в текущую таблицу символов, вот только что за таблица символов такая, не использовать с непроверенными данными,поэтому применяем htmlspecialchars
    htmlspecialchars(extract($data));
    require_once $path;

    // Получить содержимое текущего буфера и удалить его
    return ob_get_clean();
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form(int $number, string $one, string $two, string $many): string
{
    $number = (int)$number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

// Функция работы с датой. Принимает unix timestamp и вовзвращает дату в человеческом виде
function show_date($timestamp, $format)
{
    $dt = date_create();
    $dt = date_timestamp_set($dt, $timestamp);

    $current_timestamp = time();
//    $format_timestamp = date_format($dt, "d.m.Y H:i");

    //преобразование формата даты
    if ($format === 'datetime_format') {
        $format_timestamp = date_format($dt, "d-m-Y H:i");
    } elseif ($format === 'title_format') {
        $format_timestamp = date_format($dt, "d.m.Y H:i");
    } elseif ($format === 'relative_format') {
        if ($timestamp + 3600 > $current_timestamp) { // до 60 минут
            $remaining_minutes = ceil(($current_timestamp - $timestamp) / 60);
            $format_timestamp = $remaining_minutes . get_noun_plural_form(
                    $remaining_minutes,
                    ' минута назад',
                    ' минуты назад',
                    ' минут назад'
            );
        } elseif ($timestamp + 3600 <= $current_timestamp && $timestamp + 86400 > $current_timestamp) { // от 60 минут до 24 часов
            $remaining_hours = ceil(($current_timestamp - $timestamp) / 3600);
            $format_timestamp = $remaining_hours . get_noun_plural_form(
                    $remaining_hours,
                    ' час назад',
                    ' часа назад',
                    ' часов назад'
            );
        } elseif ($timestamp + 86400 <= $current_timestamp && $timestamp + 604800 > $current_timestamp) { // от 24 часов но меньше 7 дней
            $remaining_days = ceil(($current_timestamp - $timestamp) / 86400);
            $format_timestamp = $remaining_days . get_noun_plural_form(
                    $remaining_days,
                    ' день назад',
                    ' дня назад',
                    ' дней назад'
            );
        } elseif ($timestamp + 604800 <= $current_timestamp && $timestamp + 3024000 > $current_timestamp) { // от 7 дней но меньше 5 недель
            $remaining_weeks = ceil(($current_timestamp - $timestamp) / 604800);
            $format_timestamp = $remaining_weeks . get_noun_plural_form(
                    $remaining_weeks,
                    ' неделя назад',
                    ' недели назад',
                    ' недель назад'
            );
        } elseif ($timestamp + 3024000 <= $current_timestamp) { // больше 5 недель
            $remaining_months = ceil(($current_timestamp - $timestamp) / 3024000);
            $format_timestamp = $remaining_months . get_noun_plural_form(
                    $remaining_months,
                    ' месяц назад',
                    ' месяца назад',
                    ' месяцев назад'
            );
        }
    }

    return $format_timestamp;
}


// Эмуляция даты и преобразование формата
function generate_random_date($current_timestamp)
{

    //эмуляция рандомной даты в заданном диапазоне
    $previous_timestamp = $current_timestamp - 36288; // 3628800; // 42 дня
    $random_timestamp = rand($previous_timestamp, $current_timestamp);

    return $random_timestamp;
}
