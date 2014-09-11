--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.2
-- Dumped by pg_dump version 9.3.2
-- Started on 2014-09-11 09:49:51

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 7 (class 2615 OID 16386)
-- Name: main; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA main;


ALTER SCHEMA main OWNER TO postgres;

--
-- TOC entry 187 (class 3079 OID 11750)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2022 (class 0 OID 0)
-- Dependencies: 187
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = main, pg_catalog;

--
-- TOC entry 181 (class 1259 OID 24661)
-- Name: achievement_id; Type: SEQUENCE; Schema: main; Owner: postgres
--

CREATE SEQUENCE achievement_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE main.achievement_id OWNER TO postgres;

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
-- TOC entry 177 (class 1259 OID 24635)
-- Name: news_id; Type: SEQUENCE; Schema: main; Owner: postgres
--

CREATE SEQUENCE news_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE main.news_id OWNER TO postgres;

--
-- TOC entry 178 (class 1259 OID 24644)
-- Name: news; Type: TABLE; Schema: main; Owner: postgres; Tablespace: 
--

CREATE TABLE news (
    id integer DEFAULT nextval('news_id'::regclass) NOT NULL,
    subject character varying(128),
    text character varying(2048) NOT NULL,
    "time" time with time zone,
    category integer
);


ALTER TABLE main.news OWNER TO postgres;

--
-- TOC entry 179 (class 1259 OID 24653)
-- Name: news_category_id; Type: SEQUENCE; Schema: main; Owner: postgres
--

CREATE SEQUENCE news_category_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE main.news_category_id OWNER TO postgres;

--
-- TOC entry 180 (class 1259 OID 24655)
-- Name: news_categories; Type: TABLE; Schema: main; Owner: postgres; Tablespace: 
--

CREATE TABLE news_categories (
    id integer DEFAULT nextval('news_category_id'::regclass) NOT NULL,
    name character varying(128)
);


ALTER TABLE main.news_categories OWNER TO postgres;

--
-- TOC entry 176 (class 1259 OID 24606)
-- Name: project_id; Type: SEQUENCE; Schema: main; Owner: postgres
--

CREATE SEQUENCE project_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE main.project_id OWNER TO postgres;

--
-- TOC entry 173 (class 1259 OID 16405)
-- Name: projects; Type: TABLE; Schema: main; Owner: postgres; Tablespace: 
--

CREATE TABLE projects (
    id integer DEFAULT nextval('project_id'::regclass) NOT NULL,
    name character varying(25),
    description character varying(512),
    site_url character varying(128),
    banner_url character varying(128),
    owner integer NOT NULL,
    vk_group character varying(128),
    fb_public character varying(128),
    twitter_account character varying(128),
    forum_topic_id integer
);


ALTER TABLE main.projects OWNER TO postgres;

--
-- TOC entry 174 (class 1259 OID 16428)
-- Name: server_id; Type: SEQUENCE; Schema: main; Owner: postgres
--

CREATE SEQUENCE server_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE main.server_id OWNER TO postgres;

--
-- TOC entry 171 (class 1259 OID 16393)
-- Name: servers; Type: TABLE; Schema: main; Owner: postgres; Tablespace: 
--

CREATE TABLE servers (
    id integer DEFAULT nextval('server_id'::regclass) NOT NULL,
    name character varying(49),
    description character varying(512),
    project integer NOT NULL,
    map_url character varying(128),
    features character varying(512),
    address character varying(128) DEFAULT 'localhost'::character varying,
    port integer DEFAULT 25565 NOT NULL,
    plugins character varying(256),
    mods character varying(256),
    tags character varying(1024),
    video_trailer_url character varying(128)
);


ALTER TABLE main.servers OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 32810)
-- Name: servers_versions; Type: TABLE; Schema: main; Owner: postgres; Tablespace: 
--

CREATE TABLE servers_versions (
    name character varying
);


ALTER TABLE main.servers_versions OWNER TO postgres;

--
-- TOC entry 183 (class 1259 OID 32795)
-- Name: site_poll_id; Type: SEQUENCE; Schema: main; Owner: postgres
--

CREATE SEQUENCE site_poll_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE main.site_poll_id OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 32800)
-- Name: site_polls; Type: TABLE; Schema: main; Owner: postgres; Tablespace: 
--

CREATE TABLE site_polls (
    id integer DEFAULT nextval('site_poll_id'::regclass) NOT NULL,
    name character varying(128),
    description character varying(128),
    min_players integer
);


ALTER TABLE main.site_polls OWNER TO postgres;

--
-- TOC entry 185 (class 1259 OID 32804)
-- Name: site_polls_answers; Type: TABLE; Schema: main; Owner: postgres; Tablespace: 
--

CREATE TABLE site_polls_answers (
    poll_id integer,
    answer character varying
);


ALTER TABLE main.site_polls_answers OWNER TO postgres;

--
-- TOC entry 175 (class 1259 OID 24603)
-- Name: user_id; Type: SEQUENCE; Schema: main; Owner: postgres
--

CREATE SEQUENCE user_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE main.user_id OWNER TO postgres;

--
-- TOC entry 172 (class 1259 OID 16399)
-- Name: users; Type: TABLE; Schema: main; Owner: postgres; Tablespace: 
--

CREATE TABLE users (
    id integer DEFAULT nextval('user_id'::regclass) NOT NULL,
    name character varying(25),
    lastname character varying(25),
    login character varying(25),
    email character varying(25),
    salted_password character varying(128) NOT NULL
);


ALTER TABLE main.users OWNER TO postgres;

--
-- TOC entry 2023 (class 0 OID 0)
-- Dependencies: 172
-- Name: COLUMN users.name; Type: COMMENT; Schema: main; Owner: postgres
--

COMMENT ON COLUMN users.name IS 'Имя пользователя';


--
-- TOC entry 2024 (class 0 OID 0)
-- Dependencies: 172
-- Name: COLUMN users.lastname; Type: COMMENT; Schema: main; Owner: postgres
--

COMMENT ON COLUMN users.lastname IS 'Фамилия пользователя';


--
-- TOC entry 2025 (class 0 OID 0)
-- Dependencies: 172
-- Name: COLUMN users.login; Type: COMMENT; Schema: main; Owner: postgres
--

COMMENT ON COLUMN users.login IS 'Логин пользователя';


--
-- TOC entry 2026 (class 0 OID 0)
-- Dependencies: 181
-- Name: achievement_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('achievement_id', 2, true);


--
-- TOC entry 2010 (class 0 OID 24663)
-- Dependencies: 182
-- Data for Name: achievements; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY achievements (id, name, description, points) FROM stdin;
1	Милости просим!	Регистрация на MCTop	1
2	Солидный пользователь	Подтверждение email на сайте	1
\.


--
-- TOC entry 2006 (class 0 OID 24644)
-- Dependencies: 178
-- Data for Name: news; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY news (id, subject, text, "time", category) FROM stdin;
1	Тема	Текст	\N	1
\.


--
-- TOC entry 2008 (class 0 OID 24655)
-- Dependencies: 180
-- Data for Name: news_categories; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY news_categories (id, name) FROM stdin;
1	MCTop
2	Minecraft
3	Блог разработчиков
\.


--
-- TOC entry 2027 (class 0 OID 0)
-- Dependencies: 179
-- Name: news_category_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('news_category_id', 3, true);


--
-- TOC entry 2028 (class 0 OID 0)
-- Dependencies: 177
-- Name: news_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('news_id', 1, true);


--
-- TOC entry 2029 (class 0 OID 0)
-- Dependencies: 176
-- Name: project_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('project_id', 2, true);


--
-- TOC entry 2001 (class 0 OID 16405)
-- Dependencies: 173
-- Data for Name: projects; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY projects (id, name, description, site_url, banner_url, owner, vk_group, fb_public, twitter_account, forum_topic_id) FROM stdin;
2	пв	пв	http://mctop.im	\N	1	\N	\N	\N	\N
1	Ilya test	Desktop!	http://mctop.ru/	http://mctop.ru/static/files/project_1/banner.png	1	http://vk.com/mctop	\N	\N	\N
\.


--
-- TOC entry 2030 (class 0 OID 0)
-- Dependencies: 174
-- Name: server_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('server_id', 4, true);


--
-- TOC entry 1999 (class 0 OID 16393)
-- Dependencies: 171
-- Data for Name: servers; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY servers (id, name, description, project, map_url, features, address, port, plugins, mods, tags, video_trailer_url) FROM stdin;
1	Enelar Company	Hello Gods	1	http://mctop.im/map	Ахуенная тачка, MCTop style uptime сервера	localhost1	25565	\N	\N	\N	\N
3	не	понимаю	1	http://mctop.ru	их нет	localhost	25565	\N	\N	\N	\N
4	Хорош!	авыа	2	\N	\N	localhost	25565	\N	\N	\N	\N
\.


--
-- TOC entry 2014 (class 0 OID 32810)
-- Dependencies: 186
-- Data for Name: servers_versions; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY servers_versions (name) FROM stdin;
1.6.4
\.


--
-- TOC entry 2031 (class 0 OID 0)
-- Dependencies: 183
-- Name: site_poll_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('site_poll_id', 1, false);


--
-- TOC entry 2012 (class 0 OID 32800)
-- Dependencies: 184
-- Data for Name: site_polls; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY site_polls (id, name, description, min_players) FROM stdin;
\.


--
-- TOC entry 2013 (class 0 OID 32804)
-- Dependencies: 185
-- Data for Name: site_polls_answers; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY site_polls_answers (poll_id, answer) FROM stdin;
\.


--
-- TOC entry 2032 (class 0 OID 0)
-- Dependencies: 175
-- Name: user_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('user_id', 1, true);


--
-- TOC entry 2000 (class 0 OID 16399)
-- Dependencies: 172
-- Data for Name: users; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY users (id, name, lastname, login, email, salted_password) FROM stdin;
1	Ilya	Vorozhbit	i	\N	1fbbd73f10342a1fa04f629fe5ca0d3e
\.


--
-- TOC entry 1891 (class 2606 OID 24660)
-- Name: news_categories_pkey; Type: CONSTRAINT; Schema: main; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY news_categories
    ADD CONSTRAINT news_categories_pkey PRIMARY KEY (id);


--
-- TOC entry 1889 (class 2606 OID 24652)
-- Name: news_pkey; Type: CONSTRAINT; Schema: main; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY news
    ADD CONSTRAINT news_pkey PRIMARY KEY (id);


--
-- TOC entry 1887 (class 2606 OID 16410)
-- Name: projects_pkey; Type: CONSTRAINT; Schema: main; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY projects
    ADD CONSTRAINT projects_pkey PRIMARY KEY (id);


--
-- TOC entry 1883 (class 2606 OID 16398)
-- Name: servers_pkey; Type: CONSTRAINT; Schema: main; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY servers
    ADD CONSTRAINT servers_pkey PRIMARY KEY (id);


--
-- TOC entry 1885 (class 2606 OID 16404)
-- Name: users_pkey; Type: CONSTRAINT; Schema: main; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 2021 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2014-09-11 09:49:51

--
-- PostgreSQL database dump complete
--

