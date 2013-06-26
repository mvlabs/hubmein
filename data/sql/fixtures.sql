
--
-- Data for Name: event; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO event VALUES (1, 1, 'PhpDay 2013', 'The italian PHP conference', '2013-05-17 00:00:00', '2013-05-18 00:00:00', 'Verona', 'San Marco Hotel', 180, 'http://2013.phpday.it/');
INSERT INTO event VALUES (2, 1, 'JsDay 2013', 'The most used language, the most needed conference', '2013-05-15 00:00:00', '2013-05-16 00:00:00', 'Verona', 'Hotel San Marco', 180, 'http://2013.jsday.it/');

--
-- Name: event_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--
SELECT pg_catalog.setval('event_id_seq', 5, true);