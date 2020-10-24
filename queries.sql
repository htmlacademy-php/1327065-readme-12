-- заполняем таблицу пользователей
INSERT INTO users (timestamp_add, email, login, password, avatar_path)
VALUES (NOW(), 'larisa@gmail.com', 'Лариса', 'lariska777', 'userpic-larisa.jpg'),
       (NOW(), 'elvirka777@hotbox.ru', 'Эльвира', 'elvirka777', 'userpic-elvira.jpg'),
       (NOW(), 'marka777@mail.ru', 'Марк', 'marka777', 'userpic-mark.jpg'),
       (NOW(), 'petruha777@udaff.com', 'Петро', 'petruha777', 'userpic-petro.jpg'),
       (NOW(), 'tanuha777@gmail.com', 'Таня', 'tanuha777', 'userpic-tanya.jpg');

-- заполняем таблицу типов контента
INSERT INTO content_type (type, icon)
VALUES ('Цитата', 'quote'),
       ('Текст', 'text'),
       ('Фото', 'photo'),
       ('Видео', 'video'),
       ('Ссылка', 'link');

-- заполняем таблицу постов
INSERT INTO posts (timestamp_add, title, content_type, text_content, quote_author, image_content, video_content, link,
                   author_id)
VALUES (NOW() - INTERVAL 55 MINUTE, 'Цитата', 1, 'Борьба — Обязательное условие победы', 'Неизвестный Автор', '', '',
        '', 1),
       (NOW() - INTERVAL 12 HOUR, 'История компании Honda', 2,
        'Соичиро Хонда родился в 1906 году в семье кузнеца. Хотя его отец был мастером в своем деле, семья жила очень бедно. В попытках свести концы с концами Хонда–старший занялся починкой велосипедов, а Соичиро довольно рано стал ему в этом помогать. В школе дела у Соичиро шли не лучшим образом: он ненавидел заучивание и формальности. Окончив школу, Хонда отправился в Токио. Устроившись в фирму «Art Shokai», Хонда надеялся получить практические навыки и познакомиться с устройством автомобиля. Его надежды не оправдались: из–за возраста и небольшого опыта ему чаще поручали присмотреть за младшим сыном владельца фирмы, поубирать и приготовить еду.',
        '', '', '', '', 4),
       (NOW() - INTERVAL 6 DAY, 'Наконец, обработал фотки!', 3, '', '', 'rock-medium.jpg', '', '', 3),
       (NOW() - INTERVAL 3 WEEK, 'Моя мечта', 3, '', '', 'coast-medium.jpg', '', '', 2),
       (NOW() - INTERVAL 36 DAY, 'Лучшие курсы', 5, '', '', '', '', 'www.htmlacademy.ru', 5);

-- заполняем таблицу комментариев
INSERT INTO comments (timestamp_add, post_id, commentator_id, comment)
VALUES (NOW(), 1, 1, 'Пеши истчо!'),
       (NOW(), 2, 4, 'Привет хондоводам!'),
       (NOW(), 2, 4, 'У Хонды легендарные моторы конечно');

-- Примеры запросов
-- получить список постов для конкретного пользователя (на примере id = 3)
SELECT id, title
FROM posts
WHERE author_id = 3;

-- получить список постов с сортировкой по популярности и вместе с именами авторов и типом контента
SELECT id, title, content_type, author_id, view_count
FROM posts
ORDER BY view_count DESC;

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
