DROP DATABASE readme -- только для обучения
CREATE DATABASE readme
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_cli

USE readme

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY UNIQUE, -- ауто инкремент автоматом гененрирует айди
  timestamp_add TIMESTAMP,
  email VARCHAR(128) NOT NULL UNIQUE,
  login VARCHAR(128) NOT NULL UNIQUE,
  password CHAR(64) NOT NULL,
  avatar_path CHAR,
  INDEX (login)
);

CREATE TABLE posts (
  post_id INT AUTO_INCREMENT PRIMARY KEY UNIQUE,
  timestamp_add TIMESTAMP,
  title CHAR NOT NULL,
  content VARCHAR,
  quote_author CHAR,
  image_path CHAR,
  video_path CHAR,
  link CHAR,
  view_count INT,
  author_id INT NOT NULL,
  content_type CHAR,
  hashtag CHAR,
  INDEX (title, content)
);

CREATE TABLE comments (
  comment_id INT AUTO_INCREMENT PRIMARY KEY UNIQUE,
  timestamp_add TIMESTAMP,
  post_id INT NOT NULL,
  author_id INT NOT NULL,
  comment VARCHAR,
  commentator_id INT NOT NULL -- в ТЗ почему-то отсутствует данное поле/связь
);

CREATE TABLE likes (
  id INT AUTO_INCREMENT PRIMARY KEY UNIQUE,
  user_id INT NOT NULL,
  post_id INT NOT NULL
);

CREATE TABLE subscription (
  id INT AUTO_INCREMENT PRIMARY KEY UNIQUE,
  follower_id INT NOT NULL,
  influencer_id INT NOT NULL
);

CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY UNIQUE,
  timestamp_add TIMESTAMP,
  content VARCHAR,
  sender_id INT NOT NULL,
  recipient_id INT NOT NULL
);

CREATE TABLE hashtags (
  id INT AUTO_INCREMENT PRIMARY KEY UNIQUE,
  hashtag CHAR,
  INDEX (hashtag)
);

CREATE TABLE content_type (
  id INT AUTO_INCREMENT PRIMARY KEY UNIQUE,
  type CHAR,
  icon CHAR
);
