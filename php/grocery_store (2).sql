-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 19 2023 г., 09:57
-- Версия сервера: 10.4.28-MariaDB
-- Версия PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `grocery_store`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cancel_type`
--

CREATE TABLE `cancel_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `cancel_type`
--

INSERT INTO `cancel_type` (`id`, `name`) VALUES
(3, 'Испорченный товар'),
(2, 'Покупка'),
(1, 'Поступление/Приход'),
(6, 'Удаление товара');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(14, 'алкогольные напитки'),
(13, 'безалкогольные напитки'),
(8, 'бобовые'),
(12, 'кондитерские изделия'),
(6, 'крупы'),
(7, 'макаронные изделия'),
(3, 'молоко и молочные продукты'),
(17, 'мясо и птица'),
(20, 'название категории 1'),
(9, 'овощи'),
(18, 'овощи и зелень'),
(11, 'орехи и грибы'),
(1, 'рыбы и рыбопродукты'),
(16, 'сыры'),
(10, 'фрукты и ягоды'),
(15, 'чай и кофе'),
(4, 'яйца');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` bigint(20) NOT NULL,
  `name` varchar(512) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `who_login` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `quantity`, `category_id`, `who_login`) VALUES
(1, 'Макароны Makfa рифленые Витки', 'мука из твердых сортов пшеницы для макаронных изделий высшего сорта, вода питьевая. Без пищеевых добавок и красителей. Не содержит ГМО.', 71.00, 77, 7, 'marypank'),
(2, 'Макароны Шебекинские №202 Рожок полубублик', 'Мука из твердой пшеницы, вода питьевая. Содержит натуральный белок злаковых культур - глютен', 48.00, 14, 7, 'marypank'),
(3, 'Макаронные изделия Gusto di roma Fusilli Спирали 450', NULL, 60.00, 18, 7, NULL),
(4, 'Хлеб зерновой Сибирский пекарь мультизлаковый со льном', 'мука ржаная обдирная, ржаные хлопья, ячменные хлопья, пшеничные хлопья, овсяные хлопья, солод ржаной (проросшее зерно ржи), семена льна, патока ржаная, соль, дрожжи прессованные, вода.', 55.00, 10, NULL, NULL),
(5, 'Хлеб Harry\'s American Sandwich пшеничный с отрубями, 12 ломтиков', 'мука пшеничная хлебопекарная высший сорт, вода, отруби пшеничные, масло рапсовое рафинированное дезодорированное (R), масло подсолнечное рафинированное дезодорированное (S), сахар, улучшитель хлебопекарный (эмульгатор (моно- и диглицериды жирных кислот); консервант - пропионат кальция; мука пшеничная хлебопекарная, мука соевая полножирная, антиокислитель - кислота аскорбиновая, ферменты), клейковина пшеничная сухая, соль, спирт пищевой, дрожжи хлебопекарные.', 110.00, 5, NULL, NULL),
(6, 'Булочка Ремесленный хлеб с лимонной начинкой', 'мука пшеничная хлебопекарная высшего сорта, начинка лимонная (сахар, лимон, вода, загустители - крахмал кукурузный модифицированный, эмульгатор – целлюлоза, стабилизатор - ксантановая камедь, регуляторы кислотности: цитрат натрия, кислота лимонная; ароматизатор, консерванты - сорбат калия, бензоат натрия; краситель - куркумин), вода, сахар, маргарин (масла растительные, в том числе соевое, вода, эмульгаторы: эфиры полиглицерина и жирных кислот, моно - и диглицериды жирных кислот; соль, сахар, консервант - сорбат калия, регулятор кислотности - кислота лимонная, ароматизатор, краситель- бета-каротин, антиокислители: аскорбиновая кислота, альфа-токоферол), продукты яичные, дрожжи хлебопекарные прессованные, влагоудерживающий агент – глицерин, соль, улучшитель хлебопекарный (стабилизатор - карбонат кальция, эмульгатор- эфиры глицерина и диацетилвинной и жирных кислот, антиокислитель – аскорбиновая кислота), влагоудерживающий агент-ксантановая камедь, консерванты-сорбат калия, пропионат кальция', 17.00, 25, NULL, NULL),
(7, 'Сыр плавленый Фетакса 45% Hochland', 'сыр рассольный, сыр полутвердый, масло сливочное, концентрат молочного белка, пахта сухая, соль пищевая, желатин пищевой, стабилизаторы (каррагинан, камедь рожкового дерева, ксантановая камедь), регулятор кислотности лимонная кислота, эмульгатор цитраты натрия, вода питьевая.', 220.00, 7, 16, NULL),
(8, 'Кофе растворимый Nescafe Сlassic Crema ст/б 95г', '100% натуральный растворимый порошкообразный кофе.', 190.00, 23, 15, NULL),
(9, 'Кофе растворимый Nescafe Classic 130г', 'Кофе натуральный растворимый порошкообразный, кофе натуральный жареный молотый. 100% натуральный растворимый порошкообразный кофе.', 200.00, 11, 15, NULL),
(10, 'Чай черный-зеленый Grand Supreme байховый, малина-облепиха, 20 пак', 'чай черный, чай зеленый, облепиха дробленая, рябина красная дробленая, ароматизаторы облепиха, малина Чай черный-зеленый Grand Supreme байховый, малина-облепиха, 20 пак', 61.00, 12, 15, NULL),
(11, 'Чай черный Greenfield Golden Ceylon в пакетиках, 25шт.', 'Чай черный Greenfield Golden Ceylon в пакетиках, 25шт. Хранить в чистом, хорошо вентилируемом помещении без посторонних запахов с относительной влажностью воздуха не выше 70%.', 124.00, 14, 15, NULL),
(12, 'Сельдь Магнит филе-кусочки в масле', 'сельдь, масло подсолнечное рафинированное дезодорированное, соль, усилитель вкуса и аромата Е621, антиокислители (лимонная и аскорбиновая кислоты), регуляторы кислотности (Е575, Е331, Е451, Е450, Е327, яблочная кислота), декстроза, ароматизатор, консерванты (Е202, Е211)', 42.00, 31, 1, NULL),
(13, 'Форель слабосоленая филе-кусок 150г', 'форель филе-кусок, соль, пищевая добавка (регуляторы кислотности: цитрат натрия, ацетат натрия, лимонная кислота), консервант (бензоат натрия, сорбат калия).', 219.00, 9, 1, NULL),
(14, 'Макароны Щебекино Рожки', 'Вес: 450.0 г\r\nЖиры: 1.5 г\r\nСорт: Высший\r\nБелки: 13.0 г\r\nФорма: Рожки, улитки\r\nГруппа: А\r\nСостав: Мука из твердых сортов пшеницы, вода.\r\nДобавки: Без добавок\r\nВид муки: Пшеничная\r\nУглеводы: 72.0 г\r\nВремя варки: 9 мин\r\nВид упаковки: Пластиковый пакет\r\nКалорийность: 350.0 ккал\r\nСрок хранения: 2.0 г\r\nУсловия хранения: При температуре от +10°С до +30°С\r\nУсловия хранения после вскрытия упаковки: В чистых, сухих, хорошо проветриваемых, не зараженных вредителями помещениях\r\nКатегория продукта: Без категории\r\nОсобенности состава: Из твердых сортов пшеницы\r\nПримечание к составу: Содержит глютен.\r\nНаименование изделий: Рожки\r\nОсобенности упаковки: Флоу-пак\r\nМакаронные изделия Шебекинские были созданы нами как продукт, соответствующий лучшим образцам индустрии производства макарон. Весь опыт работы с итальянскими производителями макаронных изделий, включая аутсорсинг на итальянских фабриках, был использован для производства российских макарон, максимально приближенных к итальянским по качеству. В основу оптимального ассортимента Шебекинских была положена почти десятилетняя статистика продаж наиболее популярных в России итальянских и российских макаронных изделий. Сегодня Шебекинские — это прекрасные российские макароны из твердых сортов пшеницы, максимально приближенные к итальянским аналогам, как с точки зрения полноты ассортимента, так и с точки зрения качества продукта.', 47.00, 15, 7, NULL),
(15, 'Макароны Makfa рифленые Витки 2', 'Макаронные изделия Makfa Рожки рифленые, 450 г · Вес, в граммах: 450 · Вид: пшеница · Добавки: без добавок · Вид упаковки: пакет · Страна- Рф', 76.00, 44, 7, NULL),
(16, 'Напиток энергетический Gorilla', 'вода питьевая подготовленная, сахар, вкусоароматическая основа Gorilla Energy (вода, ароматизаторы, краситель сахарный колер IV E150d), витаминный премикс (витамины С, B7, B3, B6, B12), регуляторы кислотности (лимонная кислота и цитрат натрия 3-замещенный, мальтодекстрин,таурин, кофеин натуральный, L-карнитин.', 91.00, 13, 14, 'marypank'),
(22, 'Макароны Makfa рифленые Витки 2', 'sdadasdasd', 66.00, 28, 1, 'marypank'),
(32, 'Тест товар', 'Тест товар Тест товар', 76.00, 23, 13, 'marypank');

-- --------------------------------------------------------

--
-- Структура таблицы `products_quantity_his`
--

CREATE TABLE `products_quantity_his` (
  `hist_id` bigint(20) NOT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `old_val` int(11) DEFAULT NULL,
  `new_val` int(11) DEFAULT NULL,
  `cancel_type_text` varchar(255) DEFAULT NULL,
  `op_type` varchar(255) DEFAULT NULL,
  `who` varchar(255) DEFAULT NULL,
  `date_stamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `products_quantity_his`
--

INSERT INTO `products_quantity_his` (`hist_id`, `product_id`, `product_name`, `old_val`, `new_val`, `cancel_type_text`, `op_type`, `who`, `date_stamp`) VALUES
(1, 29, NULL, NULL, 23, 'Поступление/Приход', 'CREATE', 'marypank', '2023-12-10 13:16:34'),
(3, 30, NULL, NULL, 15, 'Поступление/Приход', 'CREATE', 'marypank', '2023-12-10 13:27:07'),
(4, 31, NULL, NULL, 32, 'Поступление/Приход', 'CREATE', 'marypank', '2023-12-10 13:27:57'),
(5, 31, 'Панкова Мария', NULL, NULL, NULL, 'DELETE', 'marypank', '2023-12-10 13:27:59'),
(6, 22, NULL, 25, 23, 'Испорченный товар', 'UPDATE', 'marypank', '2023-12-10 13:33:47'),
(7, 22, NULL, 23, 27, 'Поступление/Приход', 'UPDATE', 'marypank', '2023-12-10 13:34:01'),
(8, 22, NULL, 27, 25, 'Испорченный товар', 'UPDATE', 'marypank', '2023-12-10 13:34:12'),
(9, 22, NULL, 25, 28, 'Поступление/Приход', 'UPDATE', 'marypank', '2023-12-10 14:37:26'),
(10, 20, NULL, 4, 2, 'Испорченный товар', 'UPDATE', 'marypank', '2023-12-10 14:38:36'),
(11, 20, NULL, 2, 7, 'Поступление/Приход', 'UPDATE', 'marypank', '2023-12-10 14:39:26'),
(12, 16, NULL, 12, 15, 'Поступление/Приход', 'UPDATE', 'marypank', '2023-12-10 14:49:19'),
(13, 20, NULL, 7, 12, 'Поступление/Приход', 'UPDATE', 'nshulga', '2023-12-10 15:26:24'),
(14, 20, 'dfsdfsdf', NULL, NULL, NULL, 'DELETE', 'nshulga', '2023-12-10 15:26:48'),
(15, 32, NULL, NULL, 12, 'Поступление/Приход', 'CREATE', 'marypank', '2023-12-10 16:26:57'),
(16, 32, NULL, 12, 17, 'Поступление/Приход', 'UPDATE', 'marypank', '2023-12-10 16:27:26'),
(17, 32, NULL, 17, 14, 'Испорченный товар', 'UPDATE', 'marypank', '2023-12-10 16:27:43'),
(18, 32, NULL, 14, 13, 'Покупка', 'UPDATE', 'marypank', '2023-12-10 16:27:58'),
(19, 1, NULL, 72, 81, 'Поступление/Приход', 'UPDATE', 'marypank', '2023-12-11 20:47:38'),
(20, 1, NULL, 81, 79, 'Покупка', 'UPDATE', 'marypank', '2023-12-11 20:47:43'),
(21, 1, NULL, 79, 78, 'Покупка', 'UPDATE', 'marypank', '2023-12-11 20:47:47'),
(22, 1, NULL, 78, 77, 'Испорченный товар', 'UPDATE', 'marypank', '2023-12-11 20:47:51'),
(23, 13, NULL, 10, 9, 'Покупка', 'UPDATE', 'marypank', '2023-12-11 20:47:59'),
(24, 16, NULL, 15, 13, 'Испорченный товар', 'UPDATE', 'marypank', '2023-12-11 20:48:10'),
(25, 11, NULL, 15, 14, 'Покупка', 'UPDATE', 'marypank', '2023-12-11 20:48:18'),
(26, 8, NULL, 14, 23, 'Поступление/Приход', 'UPDATE', 'marypank', '2023-12-11 20:48:25'),
(27, 32, NULL, 13, 23, 'Мария', 'UPDATE', 'marypank', '2023-12-11 21:00:41');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `full_name` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `access` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `user_name`, `full_name`, `password`, `access`) VALUES
(1, 'wromanova', 'Романова Виктория Дмитриевна', 'efcf2add0d1287210c0a4d3fc44a8884', 0),
(2, 'nshulga', 'Шульга Надежда Сергеевна', 'efcf2add0d1287210c0a4d3fc44a8884', 0),
(3, 'marypank', 'Панкова Мария Алексеевна', 'efcf2add0d1287210c0a4d3fc44a8884', 1),
(4, 'nshulga_2', 'Шульга Надежда Альметьенва', 'efcf2add0d1287210c0a4d3fc44a8884', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cancel_type`
--
ALTER TABLE `cancel_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `prod_login_fk` (`who_login`);

--
-- Индексы таблицы `products_quantity_his`
--
ALTER TABLE `products_quantity_his`
  ADD PRIMARY KEY (`hist_id`),
  ADD KEY `prod_his_login_fk` (`who`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cancel_type`
--
ALTER TABLE `cancel_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `products_quantity_his`
--
ALTER TABLE `products_quantity_his`
  MODIFY `hist_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `prod_login_fk` FOREIGN KEY (`who_login`) REFERENCES `users` (`user_name`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products_quantity_his`
--
ALTER TABLE `products_quantity_his`
  ADD CONSTRAINT `prod_his_login_fk` FOREIGN KEY (`who`) REFERENCES `users` (`user_name`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
