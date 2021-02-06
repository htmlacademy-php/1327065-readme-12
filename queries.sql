-- заполняем таблицу пользователей
INSERT INTO users (timestamp_add, email, login, password, avatar_path)
VALUES (NOW() - INTERVAL 6 MONTH, 'larisa@gmail.com', 'Лариса Роговая', 'lariska777', 'userpic-larisa.jpg'),
       (NOW() - INTERVAL 15 MONTH, 'elvirka777@hotbox.ru', 'Эльвира Хайпулинова', 'elvirka777', 'userpic-elvira.jpg'),
       (NOW() - INTERVAL 3 WEEK, 'marka777@mail.ru', 'Марк Смолов', 'marka777', 'userpic-mark.jpg'),
       (NOW() - INTERVAL 6 DAY, 'petruha777@udaff.com', 'Петр Демин', 'petruha777', 'userpic-petro.jpg'),
       (NOW() - INTERVAL 12 HOUR, 'tanuha777@gmail.com', 'Таня Фирсова', 'tanuha777', 'userpic-tanya.jpg');

-- заполняем таблицу типов контента
INSERT INTO content_type (type, icon)
VALUES ('Фото', 'photo'),
       ('Видео', 'video'),
       ('Текст', 'text'),
       ('Цитата', 'quote'),
       ('Ссылка', 'link');

-- заполняем таблицу постов
INSERT INTO posts (timestamp_add, title, content_type_id, text_content, quote_author, image_content, video_content,
                   link_content, author_id, show_count)
VALUES (NOW() - INTERVAL 55 MINUTE, 'Цитата', 4, 'Борьба — Обязательное условие победы', 'Неизвестный Автор', '', '',
        '', 1, 100),
       (NOW() - INTERVAL 12 HOUR, 'История компании Honda', 3,
        'Соичиро Хонда родился в 1906 году в семье кузнеца. Хотя его отец был мастером в своем деле, семья жила очень бедно. В попытках свести концы с концами Хонда–старший занялся починкой велосипедов, а Соичиро довольно рано стал ему в этом помогать. В школе дела у Соичиро шли не лучшим образом: он ненавидел заучивание и формальности. Окончив школу, Хонда отправился в Токио. Устроившись в фирму «Art Shokai», Хонда надеялся получить практические навыки и познакомиться с устройством автомобиля. Его надежды не оправдались: из–за возраста и небольшого опыта ему чаще поручали присмотреть за младшим сыном владельца фирмы, поубирать и приготовить еду.',
        '', '', '', '', 4, 10),
       (NOW() - INTERVAL 6 DAY, 'Наконец, обработал фотки!', 1, '', '', 'img/rock-medium.jpg', '', '', 3, 15),
       (NOW() - INTERVAL 3 WEEK, 'Моя мечта', 1, '', '', 'img/coast-medium.jpg', '', '', 2, 55),
       (NOW() - INTERVAL 36 DAY, 'Лучшие курсы', 5, '', '', '', '', 'www.htmlacademy.ru', 5, 1),
       (NOW() - INTERVAL 36 DAY, 'Saving image from PHP URL', 5, '', '', '', '', 'https://stackoverflow.com/questions/724391/saving-image-from-php-url', 4, 1),
       (NOW() - INTERVAL 55 MINUTE, '', 4, 'Где родился, там и пригодился', 'Народная мудрость', '', '',
        '', 5, 5),
       (NOW() - INTERVAL 36 DAY, 'PhpStorm. Настройка интерфейса. Визуальное оформление. Установка тем.', 2, '', '', '',
        'http://www.youtube.com/watch?v=ZlG9np2FSJ4', '', 4, 75),
       (NOW() - INTERVAL 2 DAY, '', 4, 'Тысячи людей живут без любви, но никто — без воды.', 'Xью Оден', '', '', '', 3,
        250),
       (NOW() - INTERVAL 25 MINUTE, 'Полезный пост про Байкал', 3,
        'Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.',
        '', '', '', '', 5, 120);

-- заполняем таблицу комментариев
INSERT INTO comments (timestamp_add, post_id, commentator_id, comment)
VALUES (NOW(), 1, 1, 'Пеши истчо!'),
       (NOW() - INTERVAL 12 HOUR, 3, 1, 'Красота!!!1!'),
       (NOW() - INTERVAL 2 DAY, 3, 1,
        'Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.'),
       (NOW(), 2, 4, 'Привет хондоводам!'),
       (NOW(), 2, 4, 'У Хонды легендарные моторы конечно');

-- заполняем таблицу подписок
INSERT INTO subscription (follower_id, influencer_id)
VALUES (1, 2),
       (1, 3),
       (2, 3),
       (1, 4),
       (2, 4),
       (3, 4),
       (4, 5),
       (3, 5),
       (2, 5),
       (1, 5),
       (3, 1);

-- заполняем таблицу лайков
INSERT INTO likes (post_id, user_id)
VALUES (1, 1),
       (1, 2),
       (1, 3),
       (1, 4),
       (6, 5),
       (2, 5),
       (2, 4),
       (2, 3),
       (3, 2),
       (4, 1),
       (5, 1);


-- Примеры запросов
-- получить список постов для конкретного пользователя (на примере id = 3)
SELECT id, title
FROM posts
WHERE author_id = 3;

-- получить список постов с сортировкой по популярности и вместе с именами авторов и типом контента
SELECT id, title, content_type_id, author_id, show_count
FROM posts
ORDER BY show_count DESC;

-- получить список комментариев для одного поста, в комментариях должен быть логин пользователя
SELECT comment, commentator_id
FROM comments
WHERE post_id = 2;

-- добавить лайк к посту
INSERT INTO likes (user_id, post_id)
VALUES (1, 2);

-- подписаться на пользователя
INSERT INTO subscription (follower_id, influencer_id)
VALUES (1, 2);

-- добавление текстовой записи (Данный вариант, говорят так себе)
INSERT INTO posts
SET timestamp_add   = NOW(),
    title           = ?,
    text_content    = ?,
    author_id       = 1,
    content_type_id = 3,
    hashtag         = ?;

-- добавление текстовой записи (альтернативный вариант)
INSERT INTO posts (timestamp_add, title, text_content, author_id, content_type_id, hashtag)
VALUES (NOW(), ?, ?, 1, 3, ?)
