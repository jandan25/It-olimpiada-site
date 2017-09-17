-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Май 14 2016 г., 15:46
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `olimp_bd`
--

-- --------------------------------------------------------

--
-- Структура таблицы `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `user` varchar(20) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `chat`
--

INSERT INTO `chat` (`id`, `message`, `user`, `time`) VALUES
(1, 'тест)', 'admin', '2016-04-30 11:57:17'),
(2, 'Все работает?)', 'admin', '2016-04-30 12:05:15'),
(3, 'да)', 'admin', '2016-04-30 12:05:19'),
(4, 'последнее сообщение внизу?)', 'admin', '2016-04-30 12:06:53'),
(5, 'отлично оно внизу)', 'admin', '2016-04-30 12:07:00'),
(6, 'убрал автосмайлик в конце', 'admin', '2016-04-30 12:07:31'),
(7, 'выфвыф', 'admin', '2016-04-30 23:00:09'),
(8, '123', 'admin', '2016-05-02 15:13:50'),
(9, 'Сообщение', 'admin', '2016-05-12 10:57:50');

-- --------------------------------------------------------

--
-- Структура таблицы `load`
--

CREATE TABLE IF NOT EXISTS `load` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `cat` int(11) NOT NULL,
  `read` int(11) NOT NULL,
  `download` int(11) NOT NULL,
  `added` varchar(20) NOT NULL,
  `text` mediumtext NOT NULL,
  `date` datetime NOT NULL,
  `active` int(11) NOT NULL,
  `dimg` int(11) NOT NULL,
  `dfile` int(11) NOT NULL,
  `time_present` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `load`
--

INSERT INTO `load` (`id`, `name`, `cat`, `read`, `download`, `added`, `text`, `date`, `active`, `dimg`, `dfile`, `time_present`) VALUES
(1, 'Разбор заданий с Google CTF 2016: Mobile', 1, 1, 0, 'Никита', 'Вчера закончились впервые организованные Google`ом соревнования по захвату флага — Google Capture The Flag 2016. Соревнования длились двое суток, за время которых нужно было выжать из предлагаемых тасков как можно больше флагов. Формат соревнования — task-based / jeopardy. <br>\r\n<br>\r\nКак заявил гугл, задания для этого CTF составляли люди, являющиеся сотрудниками команды безопасности гугла. Поэтому интерес к данным таскам, как и к первому GCTF в целом, был достаточно велик — всего зарегистрировалось ~2500 команд, из которых, однако, только 900 набрали хотя бы 5 очков на решении тасков (опустим ботов и немногочисленные попытки играть нечестно). Принять участие можно было любому желающему, начиная от rookie и любителей безопасности и заканчивая легендами отраслей. Кроме того, можно было участвовать и в одиночку.', '2016-05-02 23:02:17', 1, 1, 1, '09:00'),
(2, 'Что случилось с Google Maps?', 1, 2, 0, 'Дмитрий', 'Если вы часто пользуетесь картами Google Maps, то наверняка заметили изменения, которые произошли после редизайна примерно три года назад. Самое заметное, что стало гораздо меньше меток, карты как будто опустели.<br>\r\n<br>\r\nВот как выглядят окрестности Нью-Йорка, в сравнении с картой 2010 года.', '2016-05-02 23:02:35', 1, 1, 1, '09:30'),
(3, 'Дайджест интересных материалов из мира веб-разработки', 2, 0, 0, 'Алексей', 'Предлагаем вашему вниманию подборку с ссылками на полезные ресурсы, интересные материалы и IT-новости', '2016-05-02 23:03:01', 1, 1, 1, '10:00'),
(4, 'LinkedIn открывает мега-ЦОД в Сингапуре', 2, 1, 0, 'Виталий', 'Строительство и последующее обслуживание гипермасштабных серверных ферм требует огромных денежных вложений. Кроме того в реализации подобных масштабных комплексов понадобится найти проектируемую своими силами альтернативу стандартному серверному и вспомогательному оборудованию.<br>\r\n<br>\r\nИ тем ни менее, эта существенный минус в реализации подобных проектов не сравниться с последующими плюсами мега-ЦОД. Например, у владельцев серверных ферм появляется возможность сократить эксплуатационные расходы, используя оборудование, которое заточено под собственные нужды, без лишних энергопотребляющих компонентов. Само собой и «железо» может быть более экономным, закупленным у оптовика на максимально выгодных условиях. Таким образом получится снизить капитальные затраты. <br>\r\n<br>\r\nИзвестная социальная сеть LinkedIn на своем примере демонстрируют реализацию концепции мега-ЦОД.', '2016-05-02 23:03:19', 1, 1, 1, '10:30'),
(5, 'QA: Conference. Сибирь', 3, 2, 0, 'Петр', 'Три конференции позади и мы готовы идти дальше. Пока организаторы собирают отзывы, сортируют фотографии, а страна — отдыхает, у всех нас есть шанс записаться на будущую конференцию в Новосибирске. Что же нас ожидает на будущей конференции? <br>\r\n<br>\r\nГалина Галкина — Расчет категории риска – подход к управлению регрессионной ТМ<br>\r\nДарья Ефремова — FMEA — подход к тестированию с ретроспективой<br>\r\nСтанислав Сидристый — Грамотное использование Groovy/Geb при автоматизации тестирования Web-приложений на Java<br>\r\nКонстантин Нерадовский — Функциональный подход в разработке автотестов на Java<br>\r\nРоман Иовлев — Jedi Power of Model-based testing<br>\r\nРоман Иовлев — JDI — Future of UI Automation<br>\r\nАлексей Белёв и Михаил Мациевский — Автоматизация тестирования или как мы с нуля всё поднимали<br>\r\nАлександр Шиповалов — Чем пахнут ваши авто-тесты<br>\r\nАлександр Шиповалов — BDD — Золотая книжечка, столь же полезная, сколь и забавная..<br>\r\nЛеншмидт Анастасия и Орлов Артур — Автотесты: QA vs Dev<br>\r\n<br>\r\nПокупая билет, вы получаете:<br>\r\nВозможность получить запись докладов с Москвы и Питера<br>\r\nВозможность попасть на QA: Conference Новосибирск<br>\r\nПитание во время конференции', '2016-05-02 23:03:37', 1, 1, 1, '11:00'),
(6, 'HDD посвящается: усмиряем приложение, прожорливое на дисковое время', 3, 4, 0, 'Никита', 'Корень всех зол<br>\r\n<br>\r\nДолгое время у меня была проблема — система очень сильно тормозила после старта. У меня ноутбук с жёстким диском (HDD) и Ubuntu 14.04.<br>\r\nКак выяснилось, причина крылась в одной лишь программе — демоне Dropbox. Dropbox — это онлайновое файловое хранилище, а его демон — программка, синхронизирующая файлы, расположенные в определённой папке, с онлайн-хранилищем. На старте демон начинает считывать свой кэш. У меня он занимает не одну сотню мегабайт, а удалять его вручную не стоит — есть вероятность потерять данные. Учитывая, что у меня жёсткий диск — устройство с механическими частями — демон начинал потреблять время доступа к нему настолько, что пользоваться компьютером и запускать приложения становилось малореально, пока он не прогрузится. Убрать его из автозапуска и запускать вручную? Неприятное решение, у меня и так есть вещи, которые я на старте вынужден запускать сам (например, iotop, он без прав суперпользователя не запускается). Нужно было найти способ сделать приложение менее прожорливым именно на диск.<br>\r\nЧитать дальше →', '2016-05-02 23:04:40', 1, 1, 1, '11:30'),
(7, 'Мировая доля Android продолжает расти', 2, 1, 0, 'Никита', 'Уже в августе текущего года «Сбербанк» начнет бета-тестирование приложения, которое сочетает в себе функции мессенджера, платежной системы и торговой площадки, сообщает «Коммерсантъ». Данный сервис в первое время будет функционировать только в системе iOS.', '2016-05-12 12:54:02', 1, 1, 1, '12:00');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `cat` int(11) NOT NULL,
  `read` int(11) NOT NULL,
  `added` varchar(20) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `name`, `cat`, `read`, `added`, `text`, `date`, `active`) VALUES
(2, 'Соцсеть «Одноклассники» запустила прероллы в мобильной видеорекламе', 1, 1, 'admin', 'В российской социальной сети &quot;Одноклассники&quot; уже официально запущен совершенно новый формат видеорекламы для мобильной версии сайта, именуемый прероллами.', '2016-05-02 21:58:34', 1),
(3, 'Китайская компания Doogee откроет склады смартфонов в РФ', 3, 3, 'admin', 'Китайская компания Doogee, занимающаяся выпуском бюджетных смартфонов, фаблетов, планшетов и прочих девайсов, откроет склад на территории России. По словам представителей шеньдженьской фирмы, на принятие данного решения повлиял резкий рост спроса на технику бренда.', '2016-05-02 21:59:29', 1),
(4, 'Статистика: Количество игроманов в России за 15 лет выросло на 20%', 2, 5, 'admin', 'Если 15 лет назад число граждан, посещавших парикмахеров и стилистов составляло 2%, то сейчас уже почти треть россиян регулярно консультируется у стилистов и пользуется услугами парикмахеров. Аналогичная картина и по посещениям ресторанов: 4% пятнадцать лет назад против 23% в настоящее время.', '2016-05-02 21:59:59', 1),
(5, '«Сбербанк» планирует запустить мессенджер для денежных переводов', 3, 0, 'admin', 'Уже в августе текущего года «Сбербанк» начнет бета-тестирование приложения, которое сочетает в себе функции мессенджера, платежной системы и торговой площадки, сообщает «Коммерсантъ». Данный сервис в первое время будет функционировать только в системе iOS.', '2016-05-12 12:42:22', 1),
(6, 'Мировая доля Android продолжает расти', 1, 0, 'admin', 'Судя по последним данным аналитической компании Kantar Worldpanel, мировая доля мобильной операционной системы Android продолжает расти, что приводит к сокращению пропорции устройств на базе iOS на рынке мобильных платформ.', '2016-05-12 12:42:42', 1),
(7, 'Инсайдерам доступна сборка 14342 Windows 10', 3, 0, 'admin', 'Microsoft опубликовала для участников программы предварительного тестирования Windows Insider новую сборку ветки Redstone, сборка 14342 доступна для скачивания инсайдерам на быстром цикле тестирования.', '2016-05-12 12:43:02', 1),
(8, 'Microsoft вдвое увеличила минимум памяти для Windows 10 Mobile', 3, 0, 'admin', 'Microsoft без лишнего шума изменила минимальные требования к аппаратной платформе для смартфонов на Windows 10 Mobile. Теперь аппарат под управлением этой ОС должен иметь по крайней мере 1 Гб оперативной и 8 Гб флэш-памяти.', '2016-05-12 12:43:16', 1),
(9, 'В браузере Opera появился режим экономии заряда батареи', 3, 0, 'admin', 'Компания Opera сообщила о выходе тестовой версии для разработчиков десктопного браузера Opera 39, в которой появилась одна весьма полезная возможность для пользователей ноутбуков — режим экономии заряда аккумулятора.', '2016-05-12 12:43:33', 1),
(10, 'Абоненты Tele2 могут управлять банковскими сервисами с телефона', 2, 0, 'admin', 'Напомним, ранее для абонентов Tele2, являющихся клиентами «Альфа-Банка», был запущен новый способ подключения услуги «Автоплатеж». Теперь пользователи могут настроить опцию автоматического пополнения баланса мобильного телефона с банковской карты через личный кабинет интернет-банка «Альфа-Клик».', '2016-05-12 12:43:45', 1),
(11, 'Tele2 начинает продажи собственного смартфона в Красноярском крае', 1, 0, 'admin', 'Tele2, альтернативный оператор мобильной связи, объявляет о старте продаж 3G-смартфонов под собственным брендом в Красноярском крае. Устройство получило название Tele2 Mini и стало первым брендированным смартфоном оператора.', '2016-05-12 12:43:59', 1),
(12, 'В приложении Google Camera появится поддержка RAW-режима', 3, 0, 'admin', 'Поддержка режима RAW появилась в Android приблизительно два года назад, и она используется некоторыми приложениями и смартфонами.', '2016-05-12 12:44:13', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `regdate` datetime NOT NULL,
  `email` varchar(50) NOT NULL,
  `country` int(11) NOT NULL,
  `avatar` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `group` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `name`, `regdate`, `email`, `country`, `avatar`, `active`, `group`) VALUES
(1, 'admin', '339dfa6c304829ecb33ac6104c559097', 'Никита', '2016-04-27 09:59:07', 'admin@ya.ru', 2, 1, 1, 2),
(2, 'test1', '45ffc4be54ac49073abed354099fad4a', 'Тест', '2016-04-27 11:05:03', 'test@wwe.ru', 1, 0, 0, 0),
(7, 'demid', '7a88f621b1a545ded2dced85cd714dd2', 'Никита', '2016-04-27 19:55:04', 'demidov4800@yandex.ru', 2, 0, 0, 0),
(8, 'popop', '7de68c373b6720b18487355f22324f73', 'Попоп', '2016-04-27 20:11:03', 'rere@rere.ru', 2, 0, 0, 0),
(9, 'test2', 'f7dee4bb704bcbee19d12c12cbf34dfb', 'тестдва', '2016-04-27 20:17:04', 'test@wwee.ru', 2, 0, 0, 0),
(10, 'test3', '03747e80bcabd5ffc79dc87d7c94eaa6', 'тесттри', '2016-04-27 20:19:49', 'test3@wwe.ru', 1, 0, 0, 0),
(11, 'test4', '3dda831a148b361a9c6fde6d7425a066', 'тестче', '2016-04-27 20:24:52', 'test4@wwe.ru', 0, 0, 0, 0),
(12, 'test5', 'ac2ae02d472a85246b4fd75851ed928f', 'тестп', '2016-04-27 20:46:34', 'test5@wwe.ru', 1, 0, 0, 0),
(13, 'kupik99', '0eeccd5c84568eea301c83a45dd3a12a', 'Купик', '2016-04-27 20:48:37', 'kupik99@yandex.ru', 1, 0, 1, 0),
(14, 'gerbert', 'accc1de71e230f4cfb79d071c8001392', 'Герберт', '2016-04-28 20:23:21', 'gerbert@gmail.com', 2, 1, 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;