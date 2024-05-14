CREATE DATABASE test_db DEFAULT CHARACTER SET 'utf8' DEFAULT COLLATE 'utf8_general_ci';

USE test_db;

CREATE TABLE yeticave_users
(
  id          INT AUTO_INCREMENT PRIMARY KEY,
  date_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  email       VARCHAR(256) NOT NULL UNIQUE,
  name        VARCHAR(128) NOT NULL,
  password    VARCHAR(256) NOT NULL,
  contact     VARCHAR(256)
);

CREATE TABLE yeticave_categories
(
  id   SMALLINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(128) NOT NULL UNIQUE,
  code VARCHAR(128) NOT NULL UNIQUE
);

CREATE TABLE yeticave_lots
(
  id          INT AUTO_INCREMENT PRIMARY KEY,
  date_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  title       VARCHAR(128)                       NOT NULL,
  description TEXT                               NOT NULL,
  image       VARCHAR(300)                       NOT NULL,
  price       MEDIUMINT                          NOT NULL,
  finish_date DATETIME                           NOT NULL,
  step        SMALLINT                           NOT NULL,
  user_id     INT                                NOT NULL,
  winner_id   INT,
  category_id SMALLINT                           NOT NULL/*,
  FOREIGN KEY (user_id) REFERENCES yeticave_users (id),
  FOREIGN KEY (winner_id) REFERENCES yeticave_users (id),
  FOREIGN KEY (category_id) REFERENCES yeticave_categories (id)*/
);

CREATE TABLE yeticave_bets
(
  id          INT AUTO_INCREMENT PRIMARY KEY,
  date_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  price       INT NOT NULL,
  user_id     INT NOT NULL,
  lot_id      INT NOT NULL/*,
  FOREIGN KEY (user_id) REFERENCES yeticave_users (id),
  FOREIGN KEY (lot_id) REFERENCES yeticave_lots (id)*/
);

CREATE FULLTEXT INDEX lots_ft ON yeticave_lots (title, description);


