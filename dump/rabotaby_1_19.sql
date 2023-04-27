-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 06 2023 г., 16:52
-- Версия сервера: 10.4.27-MariaDB
-- Версия PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `nerabotaby`
--

-- --------------------------------------------------------

--
-- Структура таблицы `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `city`
--

INSERT INTO `city` (`id`, `title`) VALUES
(0, 'Город не указан'),
(1, 'Минск'),
(2, 'Брест'),
(3, 'Берлин'),
(4, 'Вена'),
(5, 'Сидней');

-- --------------------------------------------------------

--
-- Структура таблицы `education_type`
--

CREATE TABLE `education_type` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `education_type`
--

INSERT INTO `education_type` (`id`, `title`) VALUES
(1, 'общее среднее'),
(2, 'среднее специальное'),
(3, 'высшее');

-- --------------------------------------------------------

--
-- Структура таблицы `employment_type`
--

CREATE TABLE `employment_type` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `employment_type`
--

INSERT INTO `employment_type` (`id`, `title`) VALUES
(0, 'Режим работы не указан'),
(1, 'полдня'),
(2, 'целый день'),
(3, 'дистанционно');

-- --------------------------------------------------------

--
-- Структура таблицы `experience_type`
--

CREATE TABLE `experience_type` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `experience_type`
--

INSERT INTO `experience_type` (`id`, `title`) VALUES
(0, 'Опыт работы не указан'),
(1, 'Нет опыта'),
(2, '1 год'),
(3, 'От 1 до 3х лет'),
(4, 'Более 3хлет');

-- --------------------------------------------------------

--
-- Структура таблицы `job_category`
--

CREATE TABLE `job_category` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `job_category`
--

INSERT INTO `job_category` (`id`, `parent_id`, `title`) VALUES
(1, 0, 'Программист'),
(2, 0, 'Художник'),
(3, 1, 'Junior-frontend'),
(4, 1, 'Middle-frontend'),
(5, 2, 'Художник персонажей'),
(6, 5, 'Концепт-художник'),
(7, 5, 'Аниматор'),
(8, 2, 'Художник окружения'),
(9, 6, 'Художник человекоподобных монстров'),
(10, 0, 'Музыкант'),
(11, 0, 'Врач'),
(12, 10, 'Создатель музыки'),
(13, 10, 'Исполнитель музыки'),
(14, 12, 'Композитор'),
(15, 12, 'Аранжировщик'),
(16, 13, 'Гитарист'),
(17, 13, 'Басист'),
(18, 11, 'Нейрохирург'),
(19, 11, 'Ортопед'),
(20, 11, 'Кардиолог'),
(21, 2, '3D-моделлер'),
(22, 1, 'Геймдизайнер');

-- --------------------------------------------------------

--
-- Структура таблицы `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `resume_id` int(11) NOT NULL,
  `vacancy_id` int(11) NOT NULL,
  `request_status_id` int(11) NOT NULL,
  `request_type_id` int(11) NOT NULL,
  `date_sent` datetime DEFAULT NULL,
  `date_responded` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `request`
--

INSERT INTO `request` (`id`, `resume_id`, `vacancy_id`, `request_status_id`, `request_type_id`, `date_sent`, `date_responded`) VALUES
(53, 28, 1, 1, 1, '2023-04-03 17:04:55', NULL),
(54, 28, 6, 1, 1, '2023-04-03 17:05:17', NULL),
(57, 28, 4, 3, 2, '2023-04-04 08:48:33', '2023-04-04 11:02:21'),
(58, 28, 11, 3, 2, '2023-04-04 09:05:48', '2023-04-04 11:02:27'),
(59, 28, 17, 3, 2, '2023-04-04 09:05:53', '2023-04-04 10:47:23'),
(60, 28, 3, 2, 2, '2023-04-04 09:06:30', '2023-04-04 10:47:45'),
(61, 28, 2, 2, 2, '2023-04-04 09:06:34', '2023-04-04 10:47:51'),
(62, 28, 4, 1, 1, '2023-04-04 11:03:06', NULL),
(63, 28, 11, 1, 1, '2023-04-04 20:28:45', NULL),
(64, 28, 16, 1, 1, '2023-04-04 20:29:16', NULL),
(65, 30, 16, 1, 1, '2023-04-05 09:47:54', NULL),
(66, 30, 11, 3, 1, '2023-04-05 09:48:03', '2023-04-06 08:03:01'),
(67, 30, 2, 3, 1, '2023-04-05 09:48:29', '2023-04-06 08:03:02'),
(70, 1, 2, 3, 2, '2023-04-05 12:01:00', '2023-04-06 08:00:28'),
(71, 1, 3, 2, 2, '2023-04-05 12:01:17', '2023-04-06 08:00:31'),
(72, 24, 2, 2, 2, '2023-04-05 12:04:53', '2023-04-05 12:06:39'),
(73, 24, 3, 2, 2, '2023-04-05 12:04:59', '2023-04-05 12:06:52'),
(74, 24, 18, 3, 2, '2023-04-05 12:05:03', '2023-04-05 12:06:55'),
(75, 24, 4, 1, 1, '2023-04-05 12:08:05', NULL),
(76, 24, 4, 1, 1, '2023-04-05 12:08:07', NULL),
(77, 24, 11, 1, 1, '2023-04-05 12:11:58', NULL),
(78, 31, 16, 1, 1, '2023-04-05 13:59:25', NULL),
(79, 31, 4, 1, 1, '2023-04-05 13:59:45', NULL),
(80, 1, 25, 2, 2, '2023-04-05 18:49:34', '2023-04-06 08:44:24'),
(81, 1, 24, 1, 2, '2023-04-05 18:49:40', NULL),
(82, 28, 25, 1, 2, '2023-04-05 18:59:26', NULL),
(83, 28, 24, 1, 2, '2023-04-05 18:59:36', NULL),
(84, 28, 18, 1, 2, '2023-04-06 08:05:05', NULL),
(85, 1, 18, 1, 2, '2023-04-06 08:16:19', NULL),
(86, 4, 20, 1, 1, '2023-04-06 08:58:25', NULL),
(87, 4, 22, 1, 1, '2023-04-06 08:58:33', NULL),
(88, 4, 11, 1, 1, '2023-04-06 08:58:51', NULL),
(89, 4, 25, 1, 1, '2023-04-06 09:08:25', NULL),
(90, 31, 24, 1, 2, '2023-04-06 09:10:01', NULL),
(91, 32, 24, 1, 1, '2023-04-06 16:22:26', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `request_status`
--

CREATE TABLE `request_status` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `request_status`
--

INSERT INTO `request_status` (`id`, `title`) VALUES
(1, 'в рассмотрении'),
(2, 'принят'),
(3, 'отклонен');

-- --------------------------------------------------------

--
-- Структура таблицы `request_type`
--

CREATE TABLE `request_type` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `request_type`
--

INSERT INTO `request_type` (`id`, `title`) VALUES
(1, 'от работника работодателю'),
(2, 'от работодателя работнику');

-- --------------------------------------------------------

--
-- Структура таблицы `resume`
--

CREATE TABLE `resume` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `employment_type_id` int(11) DEFAULT NULL,
  `experience_type_id` int(11) DEFAULT NULL,
  `job_category_id` int(11) NOT NULL,
  `salary_type_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `resume`
--

INSERT INTO `resume` (`id`, `user_id`, `city_id`, `employment_type_id`, `experience_type_id`, `job_category_id`, `salary_type_id`, `description`, `name`) VALUES
(1, 2, 1, 1, 3, 1, 2, 'Разрабатываю интерфейс для доступа к урокам на симуляторах и обрабатываю результаты их прохождения. Для этого разработал плагин на PHP, который интегрируется в СДО Moodle через API этой платформы и обменивается данными с симуляторами по HTTP. Плагином поддерживается LTI, что делает его и точкой доступа к симуляторам из других СДО.\n\nВеб-интерфейс доступа к симуляторам в виде отдельного плагина позволяет установить его на любой СДО Moodle в автоматическом режиме. Поддержка LTI предоставляет заказчикам (30 вузов) возможность начать урок на симуляторе из привычной им СДО Blackboard.', 'Everything developer'),
(3, 4, 3, 3, 3, 2, 3, 'Мы - LoveCat, сеть приютов бездомных кошек. Наша', 'Everything developer'),
(4, 5, 4, 1, 1, 1, 1, 'Мы - LoveCat, сеть приютов бездомных кошек. Наша', 'Everything developer'),
(12, 21, 1, 1, 1, 1, 1, 'Мы - LoveCat, сеть приютов бездомных кошек. Наша', 'smth developer'),
(13, 22, 2, 2, 2, 2, 2, 'Мы - LoveCat, сеть приютов бездомных кошек. Наша', 'smth developer'),
(14, 23, 1, 1, 1, 1, 1, 'Мы - LoveCat, сеть приютов бездомных кошек. Наша', 'smth developer'),
(15, 24, NULL, NULL, NULL, 1, 1, 'Мы - LoveCat, сеть приютов бездомных кошек. Наша', 'smth developer'),
(16, 26, 1, 1, 1, 1, 1, '', 'smth developer'),
(17, 27, 1, 1, 1, 1, 1, '', 'smth developer'),
(18, 28, 1, 1, 1, 1, 1, 'smth developersmth developersmth developer', 'smth developer'),
(19, 29, 1, 1, 1, 1, 1, '', 'smth developer'),
(20, 30, 1, 1, 1, 1, 1, '', 'smth developer'),
(21, 31, 0, 0, 0, 0, 0, '', 'smth developer'),
(22, 33, 1, 1, 1, 0, 1, '', 'smth developer'),
(23, 34, 1, 1, 1, 0, 1, '', 'smth developer'),
(24, 35, 0, 2, 2, 1, 2, 'smth developersmth developersmth developersmth developersmth developersmth developer', 'smth developersmth developer'),
(25, 36, 1, 1, 1, 0, 1, 'Резюме без описания', 'Резюме без названия'),
(26, 37, 1, 1, 1, 0, 1, 'Резюме без описания', 'Резюме без названия'),
(28, 39, 1, 2, 2, 7, 5, 'Резюме без описанияfsvbvsDAAxcvfsdsxc x', 'Резюме без названия'),
(29, 42, 1, 1, 1, 1, 1, 'Резюме без описания', 'Резюме без названия'),
(30, 43, 3, 1, 3, 9, 2, 'Бр бр денг бр бр денг еееееее', 'Супергитаристбасит'),
(31, 45, 1, 1, 1, 9, 3, 'ГИТАРИСТ ГИТАРИСТ ГИТАРИСТ ГИТАРИСТ ГИТАРИСТ ГИТАРИСТ ГИТАРИСТ ГИТАРИСТ ГИТАРИСТ', 'Гитарист гитарист гитарист'),
(32, 47, 1, 0, 3, 1, 3, 'Резюме без описания', 'Резюме без названия'),
(33, 48, 1, 1, 1, 1, 1, 'Резюме без описания', 'Резюме без названия'),
(34, 49, 1, 1, 1, 1, 1, 'Резюме без описания', 'Резюме без названия');

-- --------------------------------------------------------

--
-- Структура таблицы `resume_skill`
--

CREATE TABLE `resume_skill` (
  `id` int(11) NOT NULL,
  `resume_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `resume_skill`
--

INSERT INTO `resume_skill` (`id`, `resume_id`, `skill_id`) VALUES
(3, 4, 1),
(4, 4, 3),
(72, 3, 8),
(73, 3, 1),
(81, 24, 1),
(82, 24, 4),
(83, 24, 8),
(84, 28, 1),
(85, 28, 9),
(87, 30, 3),
(89, 31, 8),
(90, 1, 1),
(91, 1, 4),
(92, 1, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `salary_type`
--

CREATE TABLE `salary_type` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `salary_type`
--

INSERT INTO `salary_type` (`id`, `title`) VALUES
(0, 'Зарплата не указана'),
(1, 'до 100 долларов'),
(2, 'от 100 до 300 долларов'),
(3, 'от 300 до 500 долларов'),
(4, 'от 500 до 1000 долларов'),
(5, 'более 10000 долларов');

-- --------------------------------------------------------

--
-- Структура таблицы `skill`
--

CREATE TABLE `skill` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `skill`
--

INSERT INTO `skill` (`id`, `title`) VALUES
(1, 'C#'),
(2, '3dsMax'),
(3, 'Blender'),
(4, 'php'),
(5, 'Unity'),
(6, 'UnrealEngine'),
(7, 'C'),
(8, 'C++'),
(9, 'Bootstrap'),
(10, 'Работа с медицинским оборудованием'),
(11, 'Динамическое наблюдение амбулаторных пациентов\r\nСоставление плана лечения'),
(12, 'Ведение медицинской документации'),
(13, 'Осмотр пациентов, сбор анамнеза'),
(14, 'умение сочинять музыку'),
(15, 'знание гармонии, полифонии, инструментовки, анализа форм'),
(16, 'умение играть по нотам'),
(17, 'Знание анатомии'),
(18, 'Знание перспективы'),
(19, 'Знание цветовой теории'),
(20, 'JavaScript'),
(21, 'Ruby'),
(22, 'Java'),
(23, 'UI/UX'),
(24, 'Figma');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_type_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_login` varchar(255) NOT NULL,
  `about` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `inst` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `user_type_id`, `name`, `user_password`, `user_login`, `about`, `phone`, `email`, `inst`) VALUES
(1, 2, 'EPAM', 'epam123', 'epam123', 'Ищу интересную работу, где буду зарабатывать много денег. Мое хобби - есть людей.', '375 29 111 11 11', 'epam@gmail.com', ''),
(2, 1, 'Игорь Игорев', 'igor123', 'igor123', 'Ищу интересную работу, где буду зарабатывать много денег. Мое хобби - есть людей.', '375 29 111 11 11', 'some_chel@gmail.com', ''),
(3, 1, 'Петя Петев', 'petya123', 'petya123', 'Ищу интересную работу, где буду зарабатывать много денег. Мое хобби - есть людей.', '375 29 111 11 11', 'some_chel@gmail.com', ''),
(4, 1, 'Кирилл Кириллов', 'kirill123', 'kirill123', 'Ищу интересную работу, где буду зарабатывать много денег. Мое хобби - есть людей.', '375 29 111 11 11', 'some_chel@gmail.com', ''),
(5, 1, 'Миша Мишев мишевич', 'misha123', 'misha123', 'Ищу интересную работу, где буду зарабатывать много денег. Мое хобби - есть людей.', '375 29 111 11 11', 'some_chel@gmail.com', ''),
(6, 2, 'Saber Group', 'saber123', 'saber123', 'Saber Interactive — американская компания по изданию и разработке компьютерных игр с основным офисом в Форт-Лодердейл, Флорида.', '375 29 111 11 11', 'some_chel@gmail.com', ''),
(13, 1, 'Петя Петин', 'petya123', 'petya123', 'Ищу интересную работу, где буду зарабатывать много денег. Мое хобби - есть людей.', '375 29 111 11 11', 'some_chel@gmail.com', ''),
(16, 1, 'Стас Стасов', 'stas123', 'stas123', 'Ищу интересную работу, где буду зарабатывать много денег. Мое хобби - есть людей.', '375 29 111 11 11', 'some_chel@gmail.com', ''),
(35, 1, 'Бог бог бог', 'bog123', 'bog123', 'Я бог, ищу работу где много много денег.', '111 11 111 11 11', 'bog@gmail.com', ''),
(39, 1, 'Грушев Груш Грушевич', 'grysh123', 'grysh123', 'Я грушевый груш груш, ищу работу', '222 22 222 22 22', 'aaa@gmail.com', ''),
(42, 1, 'Иван Иван Иван', 'hgfdsdfg', 'hgfdsfdgh', 'Описание о себе', '111 11 111 11 11', 'aaa@gmail.com', ''),
(43, 1, 'Яблок Яблокович Яблоков', 'yabl123', 'yabl123', 'Описание о себе', '111 11 111 11 11', 'yablok@gmail.com', ''),
(44, 2, 'wargaming', 'war123', 'war123', 'Wargaming — частная компания, издатель и разработчик компьютерных игр преимущественно free-to-play ММО-жанра и околоигровых сервисов для разных платформ.', '111 11 111 11 11', 'war@gmail.com', ''),
(45, 1, 'Лимон Лимонов Лимонович', 'limon123', 'limon123', 'Описание о себе', '555 55 555 55 55', 'limon@gmail.com', ''),
(46, 2, 'Metallica', 'metla123', 'metla123', 'Описание о себе', '000 00 000 00 00', 'metla@gmail.com', ''),
(47, 1, 'Василий Васильевич', 'vas123', 'vas123', 'Описание о себе', '777 77 77 777 77 77', 'vas@gmail.com', ''),
(48, 1, 'Алексей Алексеев', 'alex123', 'alex123', 'Описание о себе', '444 44 444 44', 'alex@gmail.com', ''),
(49, 1, 'Чел Челов Человечкин', 'chel123', 'chel123', 'Описание о себе', '888 88 888 88 88', 'chel@gmail.com', '');

-- --------------------------------------------------------

--
-- Структура таблицы `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `user_type`
--

INSERT INTO `user_type` (`id`, `title`) VALUES
(1, 'работник'),
(2, 'работодатель');

-- --------------------------------------------------------

--
-- Структура таблицы `vacancy`
--

CREATE TABLE `vacancy` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `employment_type_id` int(11) DEFAULT NULL,
  `experience_type_id` int(11) DEFAULT NULL,
  `job_category_id` int(11) NOT NULL,
  `salary_type_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `vacancy`
--

INSERT INTO `vacancy` (`id`, `user_id`, `city_id`, `employment_type_id`, `experience_type_id`, `job_category_id`, `salary_type_id`, `description`, `name`) VALUES
(1, 6, 3, 2, 2, 3, 3, 'Программист JavaScript – разработчик, применяющий для написания кода мультипарадигменный язык программирования (преимущественно сценарный) JavaScript. Использование JS позволяет сделать продукт более динамичным и интересным. Кстати, недавно центр профориентации ПрофГид разработал точный тест на профориентацию, который сам расскажет, какие профессии вам подходят, даст заключение о вашем типе личности и интеллекте. ', 'javascript frontend developer'),
(2, 1, 5, 2, 2, 1, 3, 'Тестировщик анализирует, выполняет тестирование по сценариям и придумывает, где еще можно найти ошибки. Если он находит такие ошибки (а находит обязательно — в этом его работа) он пишет об этом специальный отчет, по которому программисты устраняют ошибки.', 'Тестировщик'),
(3, 1, 1, 2, 4, 1, 4, 'Разработка игр — популярная сфера. Люди, которые присматриваются к геймдеву, считают, что это интересное и увлекательно. Не стану их разубеждать. Но часто те парни и девушки, которые любят играть и мечтают о собственном проекте, обнаруживают, что делать игры не так интересно, как в них играть. \nЭто человек, который пишет код игры. В наше время набрали высокую популярность отличные бесплатные игровые движки: Unreal, Unity и другие. Также можно написать свой движок, для этого предостаточно инструментов.', 'unity senior developer'),
(4, 6, 1, 1, 1, 2, 2, '3D-моделлер — это специалист, который на основе реальных и выдуманных объектов, строит их визуальные модели с проработкой каждой детали: от размеров и изгибов, до всех шероховатостей и изъянов моделируемого объекта. Задача 3D-моделлера заключается в создании максимально схожей с эскизом модели.', 'Blender modeller'),
(5, 6, 4, 3, 3, 1, 3, 'Программист Java (Java Developer) создает приложения разной сложности, используя один из самых распространенных языков программирования «Джава» (Java). Он не только пишет программный код, но и занимается внедрением, тестированием, русификацией программ, модификацией кода. \nНа текущий момент львиная доля продуктов, которые разрабатываются на Java, – это enterprise-решения для больших и мелких компаний. Это всегда бэкенд-часть, которая необходима для вычисления и хранения каких-либо данных, а также для их обработки и передачи по запросу либо на фронтенд, если, допустим, это какой-то сайт, либо в другие системы. Видеоигры программисты на Джаве пишут сейчас, только если мы говорим про Android, ну и, конечно, же Minecraft. Самый большой плюс Java – это его кроссплатформенность, т. е. продукты, которые были написаны на Java, могут быть запущены на любой операционной системе без перекомпиляции и адаптации к каждой операционной системе (в отличии от того же C++).', 'Java MIDDLE DEVELOPER'),
(6, 6, 4, 3, 3, 1, 2, 'Full-stack Developer — это разработчик, который принимает непосредственное участие во всех этапах разработки веб-приложений — от создания клиентской части (визуальная часть + пользовательская логика) до реализации серверной (базы данных, серверная архитектура, программная логика). Какой стек технологий и языков находится в распоряжении данного специалиста? Если говорить о FrontEnd составляющей (клиентская сторона), то она у всех примерно одинакова:\n\nязык верстки HTML и язык стилей CSS;\nязыки программирования JavaScript и TypeScript;\nпрепроцессоры SASS и LESS;\nбиблиотека jQuery;\nфреймворк Bootstrap;\nAngular/React/Vue.js;\nтехнологии DOM, AJAX, JSON;\nнавыки адаптивной и кроссбраузерной верстки.\n\nТеперь разберемся с ответвлениями в бекенде, которые указывают на популярные языки и технологии, использующиеся во время реализации серверной стороны разрабатываемых веб-приложений.\n\nNode.js Full-stack Developer\n\nBackEnd составляющая (серверная сторона) может иметь различную начинку, в отличии от FrontEnd. Если говорить о Node.js Full-stack разработчике, то в качестве основного языка выступает JavaScript, а сам стек следующий:  \n\nплатформа Node.js;\nфреймворк Express.js;\nпакетные менеджеры npm, yarn;\nWeb Sockets;\nпонимание REST API;\nдругие специализированные технологии.', 'Fullstack developer'),
(11, 6, 1, 1, 4, 1, 3, 'Главной задачей системного администратора является улучшение и модернизация информационной инфраструктуры компании. Также специалисту необходимо следить за работоспособностью данной инфраструктуры и своевременно реагировать на возникшие проблемы.\nВ небольших компаниях должность сисадмина порой подразумевает выполнение обязанностей так называемого «эникейщика». В дополнение к прямым обязанностям системного администратора придётся заправлять картриджи, переустанавливать Windows, заниматься закупкой техники, взаимодействовать с провайдерами и многое другое. Говоря проще, сисадмин нужен, чтобы внедрить «вот эту штуку», подготовить рабочую среду для пользователя/разработчика/клиента и, в конце концов, для того, чтоб «всё работало».', 'Системный администратор'),
(16, 6, 2, 1, 1, 9, 2, 'Концепт-художник – это специалист, который создает виртуальный дизайн и разрабатывает виртуальный образ мира, героя, общей среды или дополненной реальности на начальном этапе разработки проекта. Работать такие дизайнеры персонажей могут и в офисе, и на фрилансе. Находить новые интересные заказы можно на специальных биржах.\nВ основном, концепт арт художник ведет свою деятельность в сфере кино, игр и виртуальной реальности.', 'Концепт- художник монстров'),
(17, 6, 1, 1, 1, 7, 4, '3D-аниматор создает в трехмерной графике компьютерные персонажи и среду для игровой, художественной, рекламной анимации. Его главная задача — «оживить» действующие лица, сделать их движения максимально естественными и в целом обеспечить реалистичное движение моделей и объектов.', 'аниматор 3д-моделей'),
(18, 1, 4, 2, 2, 4, 5, 'Frontend-разработчик — это специалист, который занимается разработкой пользовательского интерфейса, то есть той части сайта или приложения, которую видят посетители страницы. Главная задача фронтенд разработчика — перевести готовый дизайн-макет в код так, чтобы все работало правильно.\nВ зависимости от проекта, компании и профессионализма, могут быть разные задачи:\nверстка приложения с помощью HTML/CSS;\nразработка логики компонента или приложения;\nпродумывание архитектуры приложения;\nпоиск и оценка решений;\nчтение документации (в том числе на английском);\nрефакторинг и оптимизация текущего функционала;\nнастройка и оптимизация сборки проекта;\nверстка email;\nдругие задачи.', 'Дизайнер интерфейса'),
(19, 44, 1, 2, 4, 22, 5, 'Геймдизайнер — это человек, который проектирует игровой процесс, задумывая и проектируя правила и структуру игры. Команды разработчиков обычно имеют ведущего геймдизайнера, который координирует работу других геймдизайнеров.\nОни являются теми, кто лучше других имеет понимание того, какой будет игра. Одна из задач геймдизайнера — это продумывать, как будет идти повествование в игре, продумывать диалоги, комментарии, кат-сцены, упаковку игры при продаже, подсказки и так далее[17][18][19]. В крупных проектах часто бывают отдельные геймдизайнеры для различных частей игры, например, геймдизайнер игровых механик, пользовательского интерфейса, персонажей, диалогов и т. д.', 'Game architect developer'),
(20, 44, 3, 0, 4, 22, 4, 'Это QA-специалист, который выявляет баги в компьютерных играх до того, как они попадут к конечным пользователям. Это стандартный, но крайне важный этап разработки игры, который влияет на коммерческий успех. Ведь если игрок в первые часы знакомства с игрой сталкивается с ошибками, это значительно снижает интерес к игре.\n\nСтоит различать следующие понятия: геймер и тестировщик игр. Цель тестировщика – найти ошибки в программном коде, которые могут негативно отразиться на игровом процессе. Геймер же находится по другую сторону и взаимодействует с уже готовым программным продуктом. Но геймерский опыт может сильно помочь тестировщику, ведь позволит оценить игровой процесс более глубоко.', 'Game tester junior trainee'),
(21, 44, 0, 2, 0, 5, 5, 'PROJECT MANAGER SENIOR PROJECT MANAGER SENIOR PROJECT MANAGER SENIOR', 'project manager senior'),
(22, 44, 1, 3, 3, 4, 3, '3DMAX AND BLENDER MODELLER 3DMAX AND BLENDER MODELLER 3DMAX AND BLENDER MODELLER', '3dmax and blender modeller'),
(23, 44, 0, 3, 3, 9, 3, 'Художник – это творческий работник, который создает художественные картины, образы, изображения и графику, предназначенные для эстетического восприятия окружающего мира. В профессии художника существует несколько направлений. Такой мастер может писать большие галерейные полотна, картины для музейных и выставочных композиций различного содержания – портреты, пейзажи, сюжетные и исторические композиции. Также художники занимаются оформлением печатных изданий, рисуют иллюстрации к литературным произведениям, участвуют в оформлении журналов и учебной литературы. Также художники работают в рекламных агентствах, занимаются оформлением общественных пространств, культурно-исторических локаций или работают в сфере анимации и кино, WEB-дизайна и на электронных площадках. В современном понимании художником считается человек, который имеет талант в сфере изобразительного искусства и реализует свой творческий потенциал с использованием классических и высокотехнологичных методов создания изображений.', 'Художник монстров'),
(24, 46, 0, 0, 0, 17, 0, 'Нам все время не везло с басистами', 'Новый басист'),
(25, 46, 0, 0, 3, 15, 3, 'Аранжировщик – это профессиональный музыкант, который владеет множеством музыкальных инструментов и обладает композиторскими навыками. Обычно он получает заказы на работу от композиторов или продюсеров. К аранжировщику обращаются и начинающие певцы, не знающие нот, которые могут просто напеть ему свою мелодию.', 'Аранжировщик');

-- --------------------------------------------------------

--
-- Структура таблицы `vacancy_skill`
--

CREATE TABLE `vacancy_skill` (
  `id` int(11) NOT NULL,
  `vacancy_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `vacancy_skill`
--

INSERT INTO `vacancy_skill` (`id`, `vacancy_id`, `skill_id`) VALUES
(14, 6, 1),
(17, 1, 1),
(23, 5, 8),
(24, 5, 6),
(29, 8, 9),
(34, 12, 8),
(35, 12, 2),
(36, 15, 8),
(37, 15, 4),
(38, 15, 1),
(39, 14, 8),
(42, 19, 4),
(43, 19, 5),
(44, 19, 8),
(45, 24, 15),
(46, 24, 16),
(47, 25, 15),
(48, 25, 16),
(49, 17, 17),
(50, 17, 18),
(51, 1, 20),
(52, 1, 21),
(53, 5, 22),
(54, 4, 5),
(55, 4, 3),
(56, 6, 20),
(57, 16, 17),
(58, 16, 19),
(59, 2, 8),
(60, 2, 1),
(61, 2, 7),
(62, 3, 1),
(63, 3, 3),
(64, 3, 2),
(65, 3, 5),
(66, 18, 19),
(67, 18, 23),
(68, 18, 24),
(69, 20, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `education_type`
--
ALTER TABLE `education_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `employment_type`
--
ALTER TABLE `employment_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `experience_type`
--
ALTER TABLE `experience_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `job_category`
--
ALTER TABLE `job_category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_status_id` (`request_status_id`),
  ADD KEY `request_type_id` (`request_type_id`),
  ADD KEY `resume_id` (`resume_id`),
  ADD KEY `vacancy_id` (`vacancy_id`);

--
-- Индексы таблицы `request_status`
--
ALTER TABLE `request_status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `request_type`
--
ALTER TABLE `request_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `resume`
--
ALTER TABLE `resume`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `employment_type_id` (`employment_type_id`),
  ADD KEY `job_category_id` (`job_category_id`),
  ADD KEY `salary_type_id` (`salary_type_id`),
  ADD KEY `experience_type_id` (`experience_type_id`);

--
-- Индексы таблицы `resume_skill`
--
ALTER TABLE `resume_skill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resume_id` (`resume_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- Индексы таблицы `salary_type`
--
ALTER TABLE `salary_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_type_id` (`user_type_id`);

--
-- Индексы таблицы `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `vacancy`
--
ALTER TABLE `vacancy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `job_category_id` (`job_category_id`),
  ADD KEY `experience_type_id` (`experience_type_id`),
  ADD KEY `employment_type_id` (`employment_type_id`),
  ADD KEY `salary_type_id` (`salary_type_id`);

--
-- Индексы таблицы `vacancy_skill`
--
ALTER TABLE `vacancy_skill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vacancy_id` (`vacancy_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `education_type`
--
ALTER TABLE `education_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `employment_type`
--
ALTER TABLE `employment_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `experience_type`
--
ALTER TABLE `experience_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `job_category`
--
ALTER TABLE `job_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT для таблицы `request_status`
--
ALTER TABLE `request_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `request_type`
--
ALTER TABLE `request_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `resume`
--
ALTER TABLE `resume`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT для таблицы `resume_skill`
--
ALTER TABLE `resume_skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT для таблицы `salary_type`
--
ALTER TABLE `salary_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `skill`
--
ALTER TABLE `skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT для таблицы `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `vacancy`
--
ALTER TABLE `vacancy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `vacancy_skill`
--
ALTER TABLE `vacancy_skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`request_status_id`) REFERENCES `request_status` (`id`),
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`request_type_id`) REFERENCES `request_type` (`id`),
  ADD CONSTRAINT `request_ibfk_3` FOREIGN KEY (`resume_id`) REFERENCES `resume` (`id`),
  ADD CONSTRAINT `request_ibfk_4` FOREIGN KEY (`vacancy_id`) REFERENCES `vacancy` (`id`);

--
-- Ограничения внешнего ключа таблицы `resume_skill`
--
ALTER TABLE `resume_skill`
  ADD CONSTRAINT `resume_skill_ibfk_1` FOREIGN KEY (`resume_id`) REFERENCES `resume` (`id`),
  ADD CONSTRAINT `resume_skill_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
