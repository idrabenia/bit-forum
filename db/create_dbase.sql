-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 27 2010 г., 15:53
-- Версия сервера: 5.1.30
-- Версия PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

DROP DATABASE IF EXISTS `bit_forum`;
CREATE DATABASE `bit_forum`;
USE `bit_forum`;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `bit_forum`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ban`
--

CREATE TABLE IF NOT EXISTS `ban` (
  `ban_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'key',
  `ban_uid` int(11) NOT NULL COMMENT 'user id',
  `ban_ip` int(11) NOT NULL COMMENT 'ip address',
  `ban_description` text NOT NULL COMMENT 'the reason',
  `ban_start` int(11) NOT NULL COMMENT 'time start ban',
  `ban_stop` int(11) NOT NULL COMMENT 'time end ban',
  PRIMARY KEY (`ban_id`),
  KEY `ban_uid` (`ban_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `ban`
--


-- --------------------------------------------------------

--
-- Структура таблицы `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `param_name` varchar(50) NOT NULL COMMENT 'Name of config parameter',
  `param_value` varchar(50) NOT NULL COMMENT 'Value of config parameter.',
  `param_comment` text COMMENT 'Comment for config parameter.',
  PRIMARY KEY (`param_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `config`
--

INSERT INTO `config` (`param_name`, `param_value`, `param_comment`) VALUES
('ACCOUNT_ACTIVATION', 'NO_ACCOUNT_ACTIVATION', 'Тип активации аккаунта (NO_ACCOUNT_ACTIVATION, DISABLED_ACCOUNT_ACTIVATION, EMAIL_ACCOUNT_ACTIVATION)'),
('ADMINS_EMAIL', 'pivo_est@tut.by', 'Email администратора'),
('ENABLED_AVATARS', 'ENABLED_AVATARS', 'Включить аватары (ENABLED_AVATARS, DISABLED_AVATARS)'),
('IMAGES_PATH', '/images', 'Папка для хранения картинок'),
('MAX_LOGIN_SIZE', '60', 'Максимальный размер логина'),
('MAX_MESSAGE_SIZE', '600', 'Максимальный размер одного сообщения'),
('MAX_PASSWORD_SIZE', '60', 'Максимальный размер пароля'),
('MIN_LOGIN_SIZE', '3', 'Минимальный размер логина'),
('MIN_PASSWORD_SIZE', '3', 'Минимальный размер пароля'),
('PASSW_ACTION_TIME', '0', 'Время действия пароля (0 -- бесконечное)'),
('PASSW_COMPLEXITY', 'NO_PASSW_COMPLEX', 'Сложность пароля (NO_PASSW_COMPLEX, REGISTER_PASSW_COMPLEX,  DIGIT_PASSW_COMPLEX, DIGIT_REGISTER_PASSW_COMPLEX)');

-- --------------------------------------------------------

--
-- Структура таблицы `forums`
--

CREATE TABLE IF NOT EXISTS `forums` (
  `frm_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'forum id',
  `frm_moderator` int(11) NOT NULL COMMENT 'moderator id from users',
  `frm_title` text NOT NULL COMMENT 'Title of the chapter',
  `frm_description` text NOT NULL COMMENT 'Short description',
  PRIMARY KEY (`frm_id`),
  KEY `frm_moderator` (`frm_moderator`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `forums`
--

INSERT INTO `forums` (`frm_id`, `frm_moderator`, `frm_title`, `frm_description`) VALUES
(1, 1, 'Life', 'Few words about our life'),
(2, 1, 'Music', 'All about music');

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `pst_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'post id',
  `pst_sender` int(11) NOT NULL COMMENT 'post sender from users',
  `pst_topic` int(11) NOT NULL COMMENT 'topic where this post is from topics',
  `pst_time` time NOT NULL COMMENT 'time',
  `pst_text` text NOT NULL COMMENT 'text of post',
  PRIMARY KEY (`pst_id`),
  KEY `pst_sender` (`pst_sender`,`pst_topic`),
  KEY `pst_topic` (`pst_topic`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `post`
--

INSERT INTO `post` (`pst_id`, `pst_sender`, `pst_topic`, `pst_time`, `pst_text`) VALUES
(1, 1, 1, '00:00:00', 'Hard life Hard life Hard life Hard life Hard life Hard life Hard life Hard life Hard life Hard life '),
(2, 1, 1, '00:00:05', 'ggggggggggggggggggggggggggggg'),
(3, 1, 3, '00:00:06', 'fffffffffffffffffffffffffffffffffffffffffffffffffffffffffff');

-- --------------------------------------------------------

--
-- Структура таблицы `private_messages`
--

CREATE TABLE IF NOT EXISTS `private_messages` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'message id',
  `msg_sender` int(11) NOT NULL COMMENT 'message sender idv from users',
  `msg_receiver` int(11) NOT NULL COMMENT 'message receiver id from users',
  `msg_subject` text NOT NULL COMMENT 'message subject',
  `msg_text` text NOT NULL COMMENT 'message text',
  `msg_time` time NOT NULL COMMENT 'message time',
  PRIMARY KEY (`msg_id`),
  KEY `msg_sender` (`msg_sender`,`msg_receiver`),
  KEY `msg_receiver` (`msg_receiver`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `private_messages`
--

INSERT INTO `private_messages` (`msg_id`, `msg_sender`, `msg_receiver`, `msg_subject`, `msg_text`, `msg_time`) VALUES
(1, 1, 1, 'Registration', 'Hello, Gnome!', '00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `smilies`
--

CREATE TABLE IF NOT EXISTS `smilies` (
  `smile_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Indentifier of smile',
  `smile_alias` varchar(45) NOT NULL COMMENT 'Smile alias (Ex. :))',
  `smile_image_path` varchar(45) NOT NULL COMMENT 'Path to image file that contain current smile.',
  PRIMARY KEY (`smile_id`),
  UNIQUE KEY `smile_alias` (`smile_alias`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Smilies aliases and paths to smilies images.' AUTO_INCREMENT=23 ;

--
-- Дамп данных таблицы `smilies`
--

INSERT INTO `smilies` (`smile_id`, `smile_alias`, `smile_image_path`) VALUES
(1, ':?:', 'images/smilies/icon_question.gif'),
(2, ':?', 'images/smilies/icon_confused.gif'),
(3, ':arrow:', 'images/smilies/icon_arrow.gif'),
(4, ':D', 'images/smilies/icon_biggrin.gif'),
(5, '8)', 'images/smilies/icon_cool.gif'),
(6, ':cry:', 'images/smilies/icon_cry.gif'),
(7, '8O', 'images/smilies/icon_eek.gif'),
(8, ':evil:', 'images/smilies/icon_evil.gif'),
(9, ':!:', 'images/smilies/icon_exclaim.gif'),
(10, ':(', 'images/smilies/icon_frown.gif'),
(11, ':idea:', 'images/smilies/icon_idea.gif'),
(12, ':lol:', 'images/smilies/icon_lol.gif'),
(13, ':x', 'images/smilies/icon_mad.gif'),
(14, ':mrgreen:', 'images/smilies/icon_mrgreen.gif'),
(15, ':|', 'images/smilies/icon_neutral.gif'),
(16, ':P', 'images/smilies/icon_razz.gif'),
(17, ':oops:', 'images/smilies/icon_redface.gif'),
(18, ':roll:', 'images/smilies/icon_rolleyes.gif'),
(19, ':)', 'images/smilies/icon_smile.gif'),
(20, ':o', 'images/smilies/icon_surprised.gif'),
(21, ':twisted:', 'images/smilies/icon_twisted.gif'),
(22, ';)', 'images/smilies/icon_wink.gif');

-- --------------------------------------------------------

--
-- Структура таблицы `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `tpc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'topic id',
  `tpc_creator` int(11) NOT NULL COMMENT 'topic creator',
  `tpc_forum` int(11) NOT NULL COMMENT 'forum id from forums',
  `tpc_title` text NOT NULL COMMENT 'title of topic',
  PRIMARY KEY (`tpc_id`),
  KEY `tpc_moder` (`tpc_forum`),
  KEY `tpc_creator` (`tpc_creator`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `topics`
--

INSERT INTO `topics` (`tpc_id`, `tpc_creator`, `tpc_forum`, `tpc_title`) VALUES
(1, 1, 1, 'Hard life'),
(2, 1, 1, 'Life is good'),
(3, 1, 2, 'Hard&Heavy'),
(4, 1, 2, 'Rap');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User id',
  `usr_login` varchar(150) NOT NULL COMMENT 'User Name',
  `usr_registr_date` int(11) NOT NULL COMMENT 'Date of user registration',
  `usr_password_hash` varchar(200) NOT NULL,
  `usr_email` text NOT NULL,
  `usr_role` int(11) NOT NULL COMMENT 'Access status of user. 2 -- REGISTERED_USER, 3 -- ADMINISTRATOR.',
  `usr_security_salt` varchar(100) NOT NULL COMMENT 'Random string for add to hash. It mask hash.',
  `usr_icq` varchar(9) DEFAULT NULL COMMENT 'user''s icq number',
  `usr_url` text COMMENT 'personal page of user',
  `usr_first_name` text COMMENT 'user''s first name',
  `usr_last_name` text COMMENT 'user''s last name',
  `usr_mobile` text COMMENT 'user''s mobile phone number',
  `usr_interests` text COMMENT 'user''s interests, hobbies',
  `usr_about` text COMMENT 'few words about user',
  `usr_country` text COMMENT 'user''s country',
  PRIMARY KEY (`usr_id`),
  UNIQUE KEY `usr_login_ind` (`usr_login`) USING BTREE,
  UNIQUE KEY `usr_password_hash_ind` (`usr_password_hash`) USING BTREE,
  KEY `usr_id_ind` (`usr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='User information' AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`usr_id`, `usr_login`, `usr_registr_date`, `usr_password_hash`, `usr_email`, `usr_role`, `usr_security_salt`, `usr_icq`, `usr_url`, `usr_first_name`, `usr_last_name`, `usr_mobile`, `usr_interests`, `usr_about`, `usr_country`) VALUES
(1, 'root', 1286220180, 'a4de5937ba273624e21a9bb17ecf3ffb6711ba9e', '', 3, 'qkdu', '', '', '', '', '', '', '', ''),
(2, 'test1', 1262560462, 'eadc2450abde4fca24fee8f608d2857cd4147e88', '', 2, 'sdf', '', '', '', '', '', '', '', ''),
(3, 'new_login', 20021020, '123456787654321', 'email', 2, 'abc', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'new_logi', 2002102, '12345677654321', 'emai', 2, 'abc', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'in_login', 20021012, '1234567654321', 'emailo', 2, 'abc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `warning`
--

CREATE TABLE IF NOT EXISTS `warning` (
  `war_id` int(11) NOT NULL AUTO_INCREMENT,
  `war_uid` int(11) NOT NULL COMMENT 'user id',
  `war_comment` text NOT NULL,
  `war_start` int(11) NOT NULL,
  `war_end` int(11) NOT NULL,
  PRIMARY KEY (`war_id`),
  UNIQUE KEY `war_uid` (`war_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `warning`
--


--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `ban`
--
ALTER TABLE `ban`
  ADD CONSTRAINT `ban_ibfk_1` FOREIGN KEY (`ban_uid`) REFERENCES `users` (`usr_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `forums`
--
ALTER TABLE `forums`
  ADD CONSTRAINT `forums_ibfk_1` FOREIGN KEY (`frm_moderator`) REFERENCES `users` (`usr_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`pst_sender`) REFERENCES `users` (`usr_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`pst_topic`) REFERENCES `topics` (`tpc_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `private_messages`
--
ALTER TABLE `private_messages`
  ADD CONSTRAINT `private_messages_ibfk_1` FOREIGN KEY (`msg_sender`) REFERENCES `users` (`usr_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `private_messages_ibfk_2` FOREIGN KEY (`msg_receiver`) REFERENCES `users` (`usr_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`tpc_forum`) REFERENCES `forums` (`frm_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`tpc_creator`) REFERENCES `users` (`usr_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `warning`
--
ALTER TABLE `warning`
  ADD CONSTRAINT `warning_ibfk_1` FOREIGN KEY (`war_uid`) REFERENCES `users` (`usr_id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
  
  
/**
 * Procedure for register users at forum.
 * Example of usage:
 * CALL REGISTRATE_USER('test2', 'test2', 'test2@tut.by', 2)
 */

DELIMITER $$

DROP PROCEDURE IF EXISTS `bit_forum`.`REGISTRATE_USER` $$

/* Function for registrate user on forum */
CREATE PROCEDURE `bit_forum`.`REGISTRATE_USER` (
  IN login VARCHAR(150), IN passw VARCHAR(100),
  IN email TEXT, IN role INT)
  COMMENT 'Function for registrate user on forum'
BEGIN
  /* Generate password hash and security salt */
  DECLARE new_salt VARCHAR(100);
  DECLARE passw_hash VARCHAR(100);

  SET new_salt = SHA1( RAND() );
  SET passw_hash = SHA1( CONCAT(SHA1(passw), new_salt) );

  /* Insert new user data into database */
  INSERT INTO `users` (`usr_login`, `usr_registr_date`, `usr_password_hash`,
    `usr_email`, `usr_role`, `usr_security_salt`)
  VALUES
    (login, UNIX_TIMESTAMP(), passw_hash, email, role, new_salt);
END $$

DELIMITER ;