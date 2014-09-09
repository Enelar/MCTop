CREATE SEQUENCE main.achievement_id
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 2
  CACHE 1;
ALTER TABLE main.achievement_id
  OWNER TO postgres;


--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.2
-- Dumped by pg_dump version 9.3.2
-- Started on 2014-09-09 12:04:22

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = main, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 182 (class 1259 OID 24663)
-- Name: achievements; Type: TABLE; Schema: main; Owner: postgres; Tablespace:
--

CREATE TABLE achievements (
    id integer DEFAULT nextval('achievement_id'::regclass) NOT NULL,
    name character varying(128) NOT NULL,
    description character varying(128) NOT NULL,
    points integer
);


ALTER TABLE main.achievements OWNER TO postgres;

--
-- TOC entry 1959 (class 0 OID 24663)
-- Dependencies: 182
-- Data for Name: achievements; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY achievements (id, name, description, points) FROM stdin;
1	Милости просим!	Регистрация на MCTop	1
2	Солидный пользователь	Подтверждение email на сайте	1
\.


-- Completed on 2014-09-09 12:04:22

--
-- PostgreSQL database dump complete
--

