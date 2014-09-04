CREATE DATABASE mctop
  WITH ENCODING='UTF8'
       OWNER=postgres
       CONNECTION LIMIT=-1;

CREATE SCHEMA main;

/*
  //todo Разобраться, будет ли работать команда выше, для создания схемы в db: mctop
 */


/*
  ----------------------- Сообщество MCTop ---------------------
 */

CREATE TABLE main.users
(
   id integer PRIMARY KEY DEFAULT nextval('main.users'),
   name character varying(25),
   lastname character varying(25),
   login character varying(25),
   email character varying(25),
   salted_password character varying(128)
)
WITH (
  OIDS = FALSE
)
;
COMMENT ON COLUMN main.users.name IS 'Имя пользователя';
COMMENT ON COLUMN main.users.lastname IS 'Фамилия пользователя';
COMMENT ON COLUMN main.users.login IS 'Логин пользователя';

/*
  ----------------------- Проекты рейтинга -----------------------
 */

 CREATE TABLE main.projects
(
   id integer PRIMARY KEY DEFAULT nextval('main.projects'),
   name character varying(25) NOT NULL,
   description character NOT NULL,
   site_url character varying(128) NOT NULL,
   banner_url character varying(128) NOT NULL
)
WITH (
  OIDS = FALSE
)
;


/*
  ----------------------- Сервера рейтинга -----------------------
 */

CREATE TABLE main.servers
(
   id integer PRIMARY KEY DEFAULT nextval('main.servers'),
   name character varying(49) NOT NULL,
   description character NOT NULL,
   project integer NOT NULL,
   map_url character varying(128),
   features character NOT NULL
)
WITH (
  OIDS = FALSE
)
;
COMMENT ON COLUMN main.users.name IS 'Название сервера';
COMMENT ON COLUMN main.users.description IS 'Основная информация о сервере';
COMMENT ON COLUMN main.users.project IS 'id проекта, за которым закреплен сервер';
COMMENT ON COLUMN main.users.map_url IS 'Ссылка на dynmap - карту сервера';
COMMENT ON COLUMN main.users.features IS 'Преимущества сервера перед другими';
COMMENT ON TABLE main.users
  IS 'Таблица для хранения данных, о пользователях MCTop';
