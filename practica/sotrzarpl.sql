-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 15 2021 г., 16:25
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `lab5rubd`
--

-- --------------------------------------------------------

--
-- Структура таблицы `otdel`
--

CREATE TABLE IF NOT EXISTS `otdel` (
  `id_otd` smallint(6) NOT NULL AUTO_INCREMENT,
  `otd_boss` varchar(20) NOT NULL,
  `otd_sotr_zarp` decimal(10,2) NOT NULL,
  `otd_razm` smallint(6) NOT NULL,
  PRIMARY KEY (`id_otd`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `otdel`
--

INSERT INTO `otdel` (`id_otd`, `otd_boss`, `otd_sotr_zarp`, `otd_razm`) VALUES
(1, 'нет руководителя', '0.00', 0),
(2, 'нет руководителя', '0.00', 0),
(3, 'нет руководителя', '0.00', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `sotr`
--

CREATE TABLE IF NOT EXISTS `sotr` (
  `id_sotr` smallint(6) NOT NULL AUTO_INCREMENT,
  `fam_im` char(30) NOT NULL,
  `zarp_sotr` decimal(10,2) NOT NULL,
  `n_otdel_sotr` smallint(6) NOT NULL,
  PRIMARY KEY (`id_sotr`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
