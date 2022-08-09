-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 08 2017 г., 07:45
-- Версия сервера: 5.5.53
-- Версия PHP: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `volunteersrnd_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `address` text NOT NULL,
  `module` int(11) NOT NULL,
  `added` varchar(20) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL,
  `response` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `address`, `module`, `added`, `text`, `date`, `response`) VALUES
(1, 'test-sozdaniya-novosti', 1, 'skri11', 'Тест', '2017-07-21 15:39:11', 0),
(2, 'test-sozdaniya-novosti', 1, 'skri11', 'Тест №2', '2017-07-21 16:55:46', 0),
(3, 'test-sozdaniya-novosti', 1, 'skri11', 'Что-то не то...', '2017-08-17 10:14:46', 0),
(4, 'test-sozdaniya-novosti', 1, 'skri11', 'Хмммм....', '2017-08-17 10:22:20', 0),
(5, 'mnogo-teksta', 1, 'skri11', 'Очень длинный комментарий, прям очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень. Много-много текста, текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст. Приличное количество символов. Длинный-длинный комментарий, такой большой, что страшно.', '2017-08-17 11:19:02', 0),
(6, 'test-sozdaniya-novosti', 1, 'skri11', 'Тест......', '2017-08-17 12:35:04', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `added` varchar(20) NOT NULL,
  `place` text NOT NULL,
  `text` text NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `address` text NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `events`
--

INSERT INTO `events` (`id`, `name`, `added`, `place`, `text`, `date_start`, `date_end`, `address`, `active`) VALUES
(1, 'Первое тестовое мероприятие', 'skri11', 'Где-то в Ростове-на-Дону', '<p>Сегодня случится НИЧЕГО!</p>', '2017-08-30 10:59:24', '2017-08-31 10:29:00', 'pervoe_testovoe_meropriyatie', 2),
(2, 'Второе тестовое мероприятие', 'skri11', 'Где-то в Ростове-на-Дону', '<p>Завтра случится НИЧЕГО!</p>', '2017-09-01 10:59:24', '2017-09-09 11:27:35', 'vtoroe_testovoe_meropriyatie', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `cat` int(4) NOT NULL,
  `read` int(11) NOT NULL,
  `added` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `name`, `cat`, `read`, `added`, `text`, `date`, `address`, `active`) VALUES
(1, '0', 1, 2, 'developer', '<p>Хмм....</p>', '2017-04-07 15:42:17', '1', 2),
(3, 'Тест', 1, 1, 'developer', '<p>Текст.</p>', '2017-04-07 15:45:36', '3', 2),
(4, 'Тест', 1, 5, 'developer', '<p>Текст.</p>', '2017-04-07 15:45:36', '4', 2),
(5, 'Тест', 1, 2, 'developer', '<p>Текст.</p>', '2017-04-07 15:45:36', '5', 2),
(6, 'Тест', 1, 3, 'developer', '<p>Текст.</p>', '2017-04-07 15:45:36', '6', 2),
(7, 'fxxhjfjdвваа', 1, 0, 'skri11', '<p>пыррывоов</p>', '2017-05-09 21:24:31', '0', 2),
(8, 'ПРоово5окру', 1, 5, 'skri11', '<p>фпфырпмы</p>', '2017-05-09 21:26:24', 'proovo5okru', 2),
(9, 'Эксперемент с изображением', 1, 2, 'skri11', '<p>&lt;p&gt;Картинка&lt;/p&gt;<br>\n&lt;img src=&quot;https://pp.userapi.com/c638621/v638621783/3de5e/FoGPFIT_DFw.jpg&quot;&gt;</p>', '2017-05-09 21:30:15', 'eksperement-s-izobrajeniem', 2),
(10, 'Эксперемент с изображением №2', 1, 3, 'skri11', '<p>Картинка</p>\n<p><img src=\"https://pp.userapi.com/c638621/v638621783/3de5e/FoGPFIT_DFw.jpg\"></p>', '2017-05-09 21:31:21', 'eksperement-s-izobrajeniem-2', 2),
(11, 'Эксперемент с изображением №3', 3, 5, 'skri11', '<p></p>', '2017-05-09 21:48:48', 'eksperement-s-izobrajeniem-3', 2),
(12, 'ЭсИ4', 3, 4, 'skri11', '<p>0</p>', '2017-05-09 21:54:12', 'esi4', 2),
(13, 'Уффф....', 2, 8, 'skri11', '<p><img src=\"https://pp.userapi.com/c638621/v638621783/3de5e/FoGPFIT_DFw.jpg\"></p><p>Текстик.</p>', '2017-05-09 21:59:26', 'ufff', 2),
(14, 'Повторяющийся заголовок', 2, 7, 'skri11', '<p><img src=\"https://upload.wikimedia.org/wikipedia/ru/0/07/%D0%9F%D0%B0%D0%BC%D1%8F%D1%82%D0%BD%D0%B8%D0%BA_%D0%92%D0%BE%D0%B8%D0%BD%D0%B0%D0%BC-%D0%BE%D1%81%D0%B2%D0%BE%D0%B1%D0%BE%D0%B4%D0%B8%D1%82%D0%B5%D0%BB%D1%8F%D0%BC_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%A0%D0%BE%D1%81%D1%82%D0%BE%D0%B2%D0%B0-%D0%BD%D0%B0_%D0%94%D0%BE%D0%BD.jpg\" /></p>\r\n<p>Текст</p>', '2017-05-18 14:46:11', 'povtoryayushchiysya-zagolovok', 1),
(44, 'Повторяющийся заголовок', 1, 11, 'skri11', '<p><img src=\"https://upload.wikimedia.org/wikipedia/ru/0/07/%D0%9F%D0%B0%D0%BC%D1%8F%D1%82%D0%BD%D0%B8%D0%BA_%D0%92%D0%BE%D0%B8%D0%BD%D0%B0%D0%BC-%D0%BE%D1%81%D0%B2%D0%BE%D0%B1%D0%BE%D0%B4%D0%B8%D1%82%D0%B5%D0%BB%D1%8F%D0%BC_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%A0%D0%BE%D1%81%D1%82%D0%BE%D0%B2%D0%B0-%D0%BD%D0%B0_%D0%94%D0%BE%D0%BD.jpg\" /></p>\n<p>Текст.</p>', '2017-05-18 16:31:48', 'povtoryayushchiysya-zagolovok2', 0),
(40, 'Повторяющийся заголовок', 1, 8, 'skri11', '<p><img src=\"https://upload.wikimedia.org/wikipedia/ru/0/07/%D0%9F%D0%B0%D0%BC%D1%8F%D1%82%D0%BD%D0%B8%D0%BA_%D0%92%D0%BE%D0%B8%D0%BD%D0%B0%D0%BC-%D0%BE%D1%81%D0%B2%D0%BE%D0%B1%D0%BE%D0%B4%D0%B8%D1%82%D0%B5%D0%BB%D1%8F%D0%BC_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%A0%D0%BE%D1%81%D1%82%D0%BE%D0%B2%D0%B0-%D0%BD%D0%B0_%D0%94%D0%BE%D0%BD.jpg\" /></p>\n<p>Текст.</p>\n<table>\n<tbody>\n<tr>\n<td>Допустим текст</td>\n<td>Злой, сбивающий столку текст</td>\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n</tr>\n<tr>\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n</tr>\n<tr>\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n</tr>\n<tr>\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n</tr>\n<tr>\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n</tr>\n</tbody>\n</table>', '2017-05-18 16:19:36', 'povtoryayushchiysya-zagolovok1', 2),
(45, 'Много текста', 3, 25, 'skri11', '<p><img src=\"http://nesiditsa.ru/wp-content/uploads/2015/03/Panorama2.jpg\"></p> <p>Очень длинный текст, прям очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень очень. Много-много текста, текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст. Приличное количество символов. Длинный-длинный текст, такой большой, что страшно.</p>', '2017-06-08 16:09:38', 'mnogo-teksta', 2),
(48, 'Тест создания новости 2.0', 1, 19, 'skri11', '<p>Какой-то текст...</p>\r\n<p><img src=\"http://миамир.рф/uploadedfiles/1-092016/images/rostov-na-dony.jpg\" alt=\"\" width=\"700\" height=\"342\" /></p>', '2017-07-13 15:48:14', 'test-sozdaniya-novosti', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `participants`
--

CREATE TABLE `participants` (
  `id` int(11) NOT NULL,
  `user` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `date` datetime NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `participants`
--

INSERT INTO `participants` (`id`, `user`, `address`, `date`, `active`) VALUES
(5, 'skri11', 'vtoroe_testovoe_meropriyatie', '2017-08-31 20:53:12', 0),
(6, 'skri11', 'pervoe_testovoe_meropriyatie', '2017-08-31 23:07:33', 0),
(7, 'Fall', 'vtoroe_testovoe_meropriyatie', '2017-08-31 13:20:37', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `patronymic` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `work` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `regdate` datetime NOT NULL,
  `avatar` int(11) NOT NULL,
  `active` int(1) NOT NULL,
  `group` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `name`, `surname`, `patronymic`, `work`, `email`, `regdate`, `avatar`, `active`, `group`) VALUES
(8, 'skri11', '15c702c7f206cbca16849129c6e99937', 'Андрей', 'Скрипкин', 'Алексеевич', 'МАОУ Лицей 33', 'andrey.skri2011@yandex.ru', '2017-02-14 14:17:48', 1, 1, 2),
(9, 'Fall', '70608483e7fc363241057f2b76f28b1c', 'Александр', 'Марков', '', '', 'fals.blood@yandex.ru', '2017-02-19 12:08:35', 0, 1, 1),
(13, 'test', '69efb78fc03bb73229ce2ab1ab436f38', 'Андрей', 'Скрипкин', '', '', 'once.skri@yandex.ru', '2017-04-01 21:36:21', 0, 1, 0),
(14, 'MrsPanda', 'd50136cada1628c19279ccec33ec728f', 'Анастасия', 'Прокопенко', '', 'ДБК', 'pronastya205@mail.ru', '2017-05-13 21:23:06', 0, 1, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
