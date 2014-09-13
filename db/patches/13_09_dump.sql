--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.2
-- Dumped by pg_dump version 9.3.2
-- Started on 2014-09-13 12:41:04

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
-- TOC entry 195 (class 3079 OID 11750)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2061 (class 0 OID 0)
-- Dependencies: 195
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
-- TOC entry 192 (class 1259 OID 32837)
-- Name: forum_answer_id; Type: SEQUENCE; Schema: main; Owner: postgres
--

CREATE SEQUENCE forum_answer_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE main.forum_answer_id OWNER TO postgres;

--
-- TOC entry 193 (class 1259 OID 32839)
-- Name: forum_answers; Type: TABLE; Schema: main; Owner: postgres; Tablespace: 
--

CREATE TABLE forum_answers (
    id integer DEFAULT nextval('forum_answer_id'::regclass) NOT NULL,
    topic integer,
    author integer,
    message character varying(1024),
    "time" timestamp with time zone
);


ALTER TABLE main.forum_answers OWNER TO postgres;

--
-- TOC entry 2062 (class 0 OID 0)
-- Dependencies: 193
-- Name: COLUMN forum_answers.author; Type: COMMENT; Schema: main; Owner: postgres
--

COMMENT ON COLUMN forum_answers.author IS '
';


--
-- TOC entry 189 (class 1259 OID 32821)
-- Name: forum_category_id; Type: SEQUENCE; Schema: main; Owner: postgres
--

CREATE SEQUENCE forum_category_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE main.forum_category_id OWNER TO postgres;

--
-- TOC entry 190 (class 1259 OID 32826)
-- Name: forum_categories; Type: TABLE; Schema: main; Owner: postgres; Tablespace: 
--

CREATE TABLE forum_categories (
    id integer DEFAULT nextval('forum_category_id'::regclass) NOT NULL,
    name character varying(128),
    description character varying(256),
    parent_id integer
);


ALTER TABLE main.forum_categories OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 32819)
-- Name: forum_topic_id; Type: SEQUENCE; Schema: main; Owner: postgres
--

CREATE SEQUENCE forum_topic_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE main.forum_topic_id OWNER TO postgres;

--
-- TOC entry 191 (class 1259 OID 32830)
-- Name: forum_topics; Type: TABLE; Schema: main; Owner: postgres; Tablespace: 
--

CREATE TABLE forum_topics (
    id integer DEFAULT nextval('forum_topic_id'::regclass) NOT NULL,
    category integer,
    name character varying(128),
    description character varying(256),
    header_message character varying(1024),
    topic_starter integer,
    "time" time with time zone
);


ALTER TABLE main.forum_topics OWNER TO postgres;

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
-- TOC entry 194 (class 1259 OID 32846)
-- Name: servers_subscribers; Type: TABLE; Schema: main; Owner: postgres; Tablespace: 
--

CREATE TABLE servers_subscribers (
    server_id integer,
    user_id integer,
    nickname character varying(128)
);


ALTER TABLE main.servers_subscribers OWNER TO postgres;

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
-- TOC entry 187 (class 1259 OID 32816)
-- Name: site_team; Type: TABLE; Schema: main; Owner: postgres; Tablespace: 
--

CREATE TABLE site_team (
    user_id integer,
    post character varying(64)
);


ALTER TABLE main.site_team OWNER TO postgres;

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
-- TOC entry 2063 (class 0 OID 0)
-- Dependencies: 172
-- Name: COLUMN users.name; Type: COMMENT; Schema: main; Owner: postgres
--

COMMENT ON COLUMN users.name IS 'Имя пользователя';


--
-- TOC entry 2064 (class 0 OID 0)
-- Dependencies: 172
-- Name: COLUMN users.lastname; Type: COMMENT; Schema: main; Owner: postgres
--

COMMENT ON COLUMN users.lastname IS 'Фамилия пользователя';


--
-- TOC entry 2065 (class 0 OID 0)
-- Dependencies: 172
-- Name: COLUMN users.login; Type: COMMENT; Schema: main; Owner: postgres
--

COMMENT ON COLUMN users.login IS 'Логин пользователя';


--
-- TOC entry 2066 (class 0 OID 0)
-- Dependencies: 181
-- Name: achievement_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('achievement_id', 2, true);


--
-- TOC entry 2041 (class 0 OID 24663)
-- Dependencies: 182
-- Data for Name: achievements; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY achievements (id, name, description, points) FROM stdin;
1	Милости просим!	Регистрация на MCTop	1
2	Солидный пользователь	Подтверждение email на сайте	1
\.


--
-- TOC entry 2067 (class 0 OID 0)
-- Dependencies: 192
-- Name: forum_answer_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('forum_answer_id', 9, true);


--
-- TOC entry 2052 (class 0 OID 32839)
-- Dependencies: 193
-- Data for Name: forum_answers; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY forum_answers (id, topic, author, message, "time") FROM stdin;
1	1	1	test	\N
2	1	1	\N	2014-09-12 04:06:28+00
3	1	1	test	2014-09-12 04:07:16+00
4	1	1	test	2014-09-12 04:08:10+00
5	1	1	test	2014-09-12 04:08:17+00
6	1	1	test	2014-09-12 04:09:28+00
7	1	1	test	2014-09-12 04:09:38+00
8	1	1	huest	2014-09-12 04:10:03+00
9	1	1	test	2014-09-12 04:10:49+00
\.


--
-- TOC entry 2049 (class 0 OID 32826)
-- Dependencies: 190
-- Data for Name: forum_categories; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY forum_categories (id, name, description, parent_id) FROM stdin;
1	MCTop	Все о сервисе	0
\.


--
-- TOC entry 2068 (class 0 OID 0)
-- Dependencies: 189
-- Name: forum_category_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('forum_category_id', 1, true);


--
-- TOC entry 2069 (class 0 OID 0)
-- Dependencies: 188
-- Name: forum_topic_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('forum_topic_id', 1, true);


--
-- TOC entry 2050 (class 0 OID 32830)
-- Dependencies: 191
-- Data for Name: forum_topics; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY forum_topics (id, category, name, description, header_message, topic_starter, "time") FROM stdin;
1	1	Test topc	Hello	Good game	1	\N
\.


--
-- TOC entry 2037 (class 0 OID 24644)
-- Dependencies: 178
-- Data for Name: news; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY news (id, subject, text, "time", category) FROM stdin;
1	Тема	Текст	\N	1
\.


--
-- TOC entry 2039 (class 0 OID 24655)
-- Dependencies: 180
-- Data for Name: news_categories; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY news_categories (id, name) FROM stdin;
1	MCTop
2	Minecraft
3	Блог разработчиков
\.


--
-- TOC entry 2070 (class 0 OID 0)
-- Dependencies: 179
-- Name: news_category_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('news_category_id', 3, true);


--
-- TOC entry 2071 (class 0 OID 0)
-- Dependencies: 177
-- Name: news_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('news_id', 1, true);


--
-- TOC entry 2072 (class 0 OID 0)
-- Dependencies: 176
-- Name: project_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('project_id', 2, true);


--
-- TOC entry 2032 (class 0 OID 16405)
-- Dependencies: 173
-- Data for Name: projects; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY projects (id, name, description, site_url, banner_url, owner, vk_group, fb_public, twitter_account, forum_topic_id) FROM stdin;
2	пв	пв	http://mctop.im	\N	1	\N	\N	\N	\N
1	Ilya test	Desktop!	http://mctop.ru/	http://mctop.ru/static/files/project_1/banner.png	1	http://vk.com/mctop	\N	\N	\N
\.


--
-- TOC entry 2073 (class 0 OID 0)
-- Dependencies: 174
-- Name: server_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('server_id', 4, true);


--
-- TOC entry 2030 (class 0 OID 16393)
-- Dependencies: 171
-- Data for Name: servers; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY servers (id, name, description, project, map_url, features, address, port, plugins, mods, tags, video_trailer_url) FROM stdin;
1	Enelar Company	Hello Gods	1	http://mctop.im/map	Ахуенная тачка, MCTop style uptime сервера	localhost1	25565	\N	\N	\N	\N
3	не	понимаю	1	http://mctop.ru	их нет	localhost	25565	\N	\N	\N	\N
4	Хорош!	авыа	2	\N	\N	localhost	25565	\N	\N	\N	\N
\.


--
-- TOC entry 2053 (class 0 OID 32846)
-- Dependencies: 194
-- Data for Name: servers_subscribers; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY servers_subscribers (server_id, user_id, nickname) FROM stdin;
4	1	Medvedkoo
1	1	Ilya
\.


--
-- TOC entry 2045 (class 0 OID 32810)
-- Dependencies: 186
-- Data for Name: servers_versions; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY servers_versions (name) FROM stdin;
1.6.4
\.


--
-- TOC entry 2074 (class 0 OID 0)
-- Dependencies: 183
-- Name: site_poll_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('site_poll_id', 1, false);


--
-- TOC entry 2043 (class 0 OID 32800)
-- Dependencies: 184
-- Data for Name: site_polls; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY site_polls (id, name, description, min_players) FROM stdin;
\.


--
-- TOC entry 2044 (class 0 OID 32804)
-- Dependencies: 185
-- Data for Name: site_polls_answers; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY site_polls_answers (poll_id, answer) FROM stdin;
\.


--
-- TOC entry 2046 (class 0 OID 32816)
-- Dependencies: 187
-- Data for Name: site_team; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY site_team (user_id, post) FROM stdin;
1	Основатель MCTop
\.


--
-- TOC entry 2075 (class 0 OID 0)
-- Dependencies: 175
-- Name: user_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('user_id', 1, true);


--
-- TOC entry 2031 (class 0 OID 16399)
-- Dependencies: 172
-- Data for Name: users; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY users (id, name, lastname, login, email, salted_password) FROM stdin;
1	Ilya	Vorozhbit	i	\N	1fbbd73f10342a1fa04f629fe5ca0d3e
\.


--
-- TOC entry 1922 (class 2606 OID 24660)
-- Name: news_categories_pkey; Type: CONSTRAINT; Schema: main; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY news_categories
    ADD CONSTRAINT news_categories_pkey PRIMARY KEY (id);


--
-- TOC entry 1920 (class 2606 OID 24652)
-- Name: news_pkey; Type: CONSTRAINT; Schema: main; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY news
    ADD CONSTRAINT news_pkey PRIMARY KEY (id);


--
-- TOC entry 1918 (class 2606 OID 16410)
-- Name: projects_pkey; Type: CONSTRAINT; Schema: main; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY projects
    ADD CONSTRAINT projects_pkey PRIMARY KEY (id);


--
-- TOC entry 1914 (class 2606 OID 16398)
-- Name: servers_pkey; Type: CONSTRAINT; Schema: main; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY servers
    ADD CONSTRAINT servers_pkey PRIMARY KEY (id);


--
-- TOC entry 1916 (class 2606 OID 16404)
-- Name: users_pkey; Type: CONSTRAINT; Schema: main; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 2060 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2014-09-13 12:41:05

--
-- PostgreSQL database dump complete
--

