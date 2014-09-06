--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.2
-- Dumped by pg_dump version 9.3.2
-- Started on 2014-09-06 11:30:26

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

SET search_path = main, pg_catalog;

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

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 173 (class 1259 OID 16405)
-- Name: projects; Type: TABLE; Schema: main; Owner: postgres; Tablespace: 
--

CREATE TABLE projects (
    id integer DEFAULT nextval('project_id'::regclass) NOT NULL,
    name character varying(25) NOT NULL,
    description character varying(512) NOT NULL,
    site_url character varying(128) NOT NULL,
    banner_url character varying(128) NOT NULL,
    owner integer NOT NULL
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
    name character varying(49) NOT NULL,
    description character varying(512) NOT NULL,
    project integer NOT NULL,
    map_url character varying(128),
    features character varying(512) NOT NULL,
    address character varying(128) DEFAULT 'localhost'::character varying NOT NULL,
    port integer DEFAULT 25565 NOT NULL
);


ALTER TABLE main.servers OWNER TO postgres;

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
-- TOC entry 1966 (class 0 OID 0)
-- Dependencies: 172
-- Name: COLUMN users.name; Type: COMMENT; Schema: main; Owner: postgres
--

COMMENT ON COLUMN users.name IS 'Имя пользователя';


--
-- TOC entry 1967 (class 0 OID 0)
-- Dependencies: 172
-- Name: COLUMN users.lastname; Type: COMMENT; Schema: main; Owner: postgres
--

COMMENT ON COLUMN users.lastname IS 'Фамилия пользователя';


--
-- TOC entry 1968 (class 0 OID 0)
-- Dependencies: 172
-- Name: COLUMN users.login; Type: COMMENT; Schema: main; Owner: postgres
--

COMMENT ON COLUMN users.login IS 'Логин пользователя';


--
-- TOC entry 1969 (class 0 OID 0)
-- Dependencies: 176
-- Name: project_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('project_id', 1, true);


--
-- TOC entry 1958 (class 0 OID 16405)
-- Dependencies: 173
-- Data for Name: projects; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY projects (id, name, description, site_url, banner_url, owner) FROM stdin;
1	Ilya test	Desktop!	http://mctop.ru/	http://mctop.ru/static/files/project_1/banner.png	1
\.


--
-- TOC entry 1970 (class 0 OID 0)
-- Dependencies: 174
-- Name: server_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('server_id', 1, true);


--
-- TOC entry 1956 (class 0 OID 16393)
-- Dependencies: 171
-- Data for Name: servers; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY servers (id, name, description, project, map_url, features, address, port) FROM stdin;
1	Enelar Company	Hello Gods	1	http://mctop.im/map	Ахуенная тачка, MCTop style uptime сервера	localhost1	25565
\.


--
-- TOC entry 1971 (class 0 OID 0)
-- Dependencies: 175
-- Name: user_id; Type: SEQUENCE SET; Schema: main; Owner: postgres
--

SELECT pg_catalog.setval('user_id', 1, true);


--
-- TOC entry 1957 (class 0 OID 16399)
-- Dependencies: 172
-- Data for Name: users; Type: TABLE DATA; Schema: main; Owner: postgres
--

COPY users (id, name, lastname, login, email, salted_password) FROM stdin;
1	\N	\N	i	\N	1fbbd73f10342a1fa04f629fe5ca0d3e
\.


--
-- TOC entry 1848 (class 2606 OID 16410)
-- Name: projects_pkey; Type: CONSTRAINT; Schema: main; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY projects
    ADD CONSTRAINT projects_pkey PRIMARY KEY (id);


--
-- TOC entry 1844 (class 2606 OID 16398)
-- Name: servers_pkey; Type: CONSTRAINT; Schema: main; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY servers
    ADD CONSTRAINT servers_pkey PRIMARY KEY (id);


--
-- TOC entry 1846 (class 2606 OID 16404)
-- Name: users_pkey; Type: CONSTRAINT; Schema: main; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


-- Completed on 2014-09-06 11:30:26

--
-- PostgreSQL database dump complete
--

