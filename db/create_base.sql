-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 14 2010 г., 10:03
-- Версия сервера: 5.1.30
-- Версия PHP: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- База данных: `forumdb`
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
(2, 2, 1, '00:00:05', 'ggggggggggggggggggggggggggggg'),
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
(1, 1, 2, 'Registration', 'Hello, Gnome!', '00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `properties`
--

CREATE TABLE IF NOT EXISTS `properties` (
  `pr_property` text NOT NULL,
  `pr_value` text NOT NULL,
  `pr_comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `properties`
--


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
  KEY `tpc_creator` (`tpc_creator`),
  KEY `tpc_creator_2` (`tpc_creator`),
  KEY `tpc_creator_3` (`tpc_creator`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `topics`
--

INSERT INTO `topics` (`tpc_id`, `tpc_creator`, `tpc_forum`, `tpc_title`) VALUES
(1, 1, 1, 'Hard life'),
(2, 1, 1, 'Life is good'),
(3, 2, 2, 'Hard&Heavy'),
(4, 1, 2, 'Rap');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User id',
  `u_name` text NOT NULL COMMENT 'User Name',
  `u_password` text NOT NULL,
  `u_email` text NOT NULL,
  PRIMARY KEY (`u_id`),
  KEY `u_id` (`u_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='User information' AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`u_id`, `u_name`, `u_password`, `u_email`) VALUES
(1, 'admin', 'password', 'admin@tut.by'),
(2, 'Gnome', 'password', 'gnome@gmail.com');

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
  ADD CONSTRAINT `ban_ibfk_1` FOREIGN KEY (`ban_uid`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `forums`
--
ALTER TABLE `forums`
  ADD CONSTRAINT `forums_ibfk_1` FOREIGN KEY (`frm_moderator`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`pst_sender`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`pst_topic`) REFERENCES `topics` (`tpc_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `private_messages`
--
ALTER TABLE `private_messages`
  ADD CONSTRAINT `private_messages_ibfk_1` FOREIGN KEY (`msg_sender`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `private_messages_ibfk_2` FOREIGN KEY (`msg_receiver`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`tpc_forum`) REFERENCES `forums` (`frm_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`tpc_creator`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `warning`
--
ALTER TABLE `warning`
  ADD CONSTRAINT `warning_ibfk_1` FOREIGN KEY (`war_uid`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;