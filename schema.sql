DROP
DATABASE IF EXISTS readme; -- только для обучения
CREATE
DATABASE readme
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;
USE
readme;

CREATE TABLE users
(
    id            INT AUTO_INCREMENT PRIMARY KEY UNIQUE, -- ауто инкремент автоматом гененрирует айди
    timestamp_add TIMESTAMP,
    email         VARCHAR(128) NOT NULL UNIQUE,
    login         VARCHAR(64)  NOT NULL UNIQUE,
    password      VARCHAR(64)  NOT NULL,
    avatar_path   VARCHAR(255),
    INDEX (login)
);

CREATE TABLE posts
(
    id              INT AUTO_INCREMENT PRIMARY KEY UNIQUE,
    timestamp_add   TIMESTAMP, -- DEFAULT CURRENT_TIMESTAMP NOT NULL потом добавь, на рабочую базу
    title           VARCHAR(128) NOT NULL,
    text_content    TEXT,      -- NOT NULL ?
    image_content   VARCHAR(255),
    video_content   VARCHAR(255),
    link_content    VARCHAR(255),
    quote_author    VARCHAR(255),
    show_count      INT,
    author_id       INT          NOT NULL,
    content_type_id INT,
    hashtag         VARCHAR(255),
    INDEX (title)
);

CREATE TABLE comments
(
    id             INT AUTO_INCREMENT PRIMARY KEY UNIQUE,
    timestamp_add  TIMESTAMP,
    post_id        INT NOT NULL,
    commentator_id INT NOT NULL,
    comment        TEXT
);

CREATE TABLE likes
(
    id      INT AUTO_INCREMENT PRIMARY KEY UNIQUE,
    user_id INT NOT NULL,
    post_id INT NOT NULL
);

CREATE TABLE subscription
(
    id            INT AUTO_INCREMENT PRIMARY KEY UNIQUE,
    follower_id   INT NOT NULL,
    influencer_id INT NOT NULL
);

CREATE TABLE messages
(
    id            INT AUTO_INCREMENT PRIMARY KEY UNIQUE,
    timestamp_add TIMESTAMP,
    content       VARCHAR(255),
    sender_id     INT NOT NULL,
    recipient_id  INT NOT NULL
);

CREATE TABLE hashtags
(
    id      INT AUTO_INCREMENT PRIMARY KEY UNIQUE,
    hashtag CHAR,
    INDEX (hashtag)
);

CREATE TABLE content_type
(
    id   INT AUTO_INCREMENT PRIMARY KEY UNIQUE,
    type VARCHAR(64),
    icon VARCHAR(64)
);
