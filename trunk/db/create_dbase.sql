
DROP SCHEMA IF EXISTS `bit_forum`;
CREATE SCHEMA`bit_forum` DEFAULT CHARACTER SET utf8 ;
USE `bit_forum`;

-- -----------------------------------------------------
-- Table `bit_forum`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bit_forum`.`users` (
  `usr_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'User id' ,
  `usr_login` VARCHAR(150) NOT NULL COMMENT 'User Name' ,
  `usr_registr_date` INT NOT NULL COMMENT 'Date of user registration', 
  `usr_password_hash` TEXT NOT NULL ,
  `usr_email` TEXT NOT NULL ,
  `usr_role` INT NOT NULL COMMENT 'Access status of user. 1-- GUEST, 2 -- REGISTERED_USER, 3 -- ADMINISTRATOR.' ,
  `usr_security_salt` VARCHAR(100) NOT NULL COMMENT 'Random string for add to hash. It mask hash.' ,
  PRIMARY KEY (`usr_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
COMMENT = 'User information';

CREATE INDEX `usr_id_ind` ON `bit_forum`.`users` (`usr_id` ASC) ;

CREATE UNIQUE INDEX `usr_login_ind` USING BTREE ON `bit_forum`.`users` (`usr_login` ASC) ;


-- Create admin account with login='root' password='' 
INSERT INTO `bit_forum`.`users` (`usr_login`, `usr_registr_date`, `usr_email`, 
    `usr_password_hash`, `usr_role`, `usr_security_salt`)
VALUES 
  ('root', UNIX_TIMESTAMP('2010-10-04 22:23:00'), '', SHA1( CONCAT(SHA1(''), 'qkdu') ), 3, 'qkdu')
;

-- -----------------------------------------------------
-- Table `bit_forum`.`ban`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bit_forum`.`ban` (
  `ban_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'key' ,
  `ban_uid` INT(11) NOT NULL COMMENT 'user id' ,
  `ban_ip` INT(11) NOT NULL COMMENT 'ip address' ,
  `ban_description` TEXT NOT NULL COMMENT 'the reason' ,
  `ban_start` INT(11) NOT NULL COMMENT 'time start ban' ,
  `ban_stop` INT(11) NOT NULL COMMENT 'time end ban' ,
  PRIMARY KEY (`ban_id`) ,
  CONSTRAINT `ban_ibfk_1`
    FOREIGN KEY (`ban_uid` )
    REFERENCES `bit_forum`.`users` (`usr_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `ban_uid` ON `bit_forum`.`ban` (`ban_uid` ASC) ;


-- -----------------------------------------------------
-- Table `bit_forum`.`forums`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bit_forum`.`forums` (
  `frm_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'forum id' ,
  `frm_moderator` INT(11) NOT NULL COMMENT 'moderator id from users' ,
  `frm_title` TEXT NOT NULL COMMENT 'Title of the chapter' ,
  `frm_description` TEXT NOT NULL COMMENT 'Short description' ,
  PRIMARY KEY (`frm_id`) ,
  CONSTRAINT `forums_ibfk_1`
    FOREIGN KEY (`frm_moderator` )
    REFERENCES `bit_forum`.`users` (`usr_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
ROW_FORMAT = COMPACT;

CREATE INDEX `frm_moderator` ON `bit_forum`.`forums` (`frm_moderator` ASC) ;

--
--    `forums`
--
INSERT INTO `forums` (`frm_id`, `frm_moderator`, `frm_title`, `frm_description`) VALUES
(1, 1, 'Life', 'Few words about our life'),
(2, 1, 'Music', 'All about music');


-- -----------------------------------------------------
-- Table `bit_forum`.`topics`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bit_forum`.`topics` (
  `tpc_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'topic id' ,
  `tpc_creator` INT(11) NOT NULL COMMENT 'topic creator' ,
  `tpc_forum` INT(11) NOT NULL COMMENT 'forum id from forums' ,
  `tpc_title` TEXT NOT NULL COMMENT 'title of topic' ,
  PRIMARY KEY (`tpc_id`) ,
  CONSTRAINT `topics_ibfk_1`
    FOREIGN KEY (`tpc_forum` )
    REFERENCES `bit_forum`.`forums` (`frm_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `topics_ibfk_2`
    FOREIGN KEY (`tpc_creator` )
    REFERENCES `bit_forum`.`users` (`usr_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `tpc_moder` ON `bit_forum`.`topics` (`tpc_forum` ASC) ;
CREATE INDEX `tpc_creator` ON `bit_forum`.`topics` (`tpc_creator` ASC) ;

--
--    `topics`
--
INSERT INTO `topics` (`tpc_id`, `tpc_creator`, `tpc_forum`, `tpc_title`) VALUES
(1, 1, 1, 'Hard life'),
(2, 1, 1, 'Life is good'),
(3, 1, 2, 'Hard&Heavy'),
(4, 1, 2, 'Rap');


-- -----------------------------------------------------
-- Table `bit_forum`.`post`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bit_forum`.`post` (
  `pst_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'post id' ,
  `pst_sender` INT(11) NOT NULL COMMENT 'post sender from users' ,
  `pst_topic` INT(11) NOT NULL COMMENT 'topic where this post is from topics' ,
  `pst_time` TIME NOT NULL COMMENT 'time' ,
  `pst_text` TEXT NOT NULL COMMENT 'text of post' ,
  PRIMARY KEY (`pst_id`) ,
  CONSTRAINT `post_ibfk_1`
    FOREIGN KEY (`pst_sender` )
    REFERENCES `bit_forum`.`users` (`usr_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `post_ibfk_2`
    FOREIGN KEY (`pst_topic` )
    REFERENCES `bit_forum`.`topics` (`tpc_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `pst_sender` ON `bit_forum`.`post` (`pst_sender` ASC, `pst_topic` ASC) ;

CREATE INDEX `pst_topic` ON `bit_forum`.`post` (`pst_topic` ASC) ;

--
--    `post`
--
INSERT INTO `post` (`pst_id`, `pst_sender`, `pst_topic`, `pst_time`, `pst_text`) VALUES
(1, 1, 1, '00:00:00', 'Hard life Hard life Hard life Hard life Hard life Hard life Hard life Hard life Hard life Hard life '),
(2, 1, 1, '00:00:05', 'ggggggggggggggggggggggggggggg'),
(3, 1, 3, '00:00:06', 'fffffffffffffffffffffffffffffffffffffffffffffffffffffffffff');


-- -----------------------------------------------------
-- Table `bit_forum`.`private_messages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bit_forum`.`private_messages` (
  `msg_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'message id' ,
  `msg_sender` INT(11) NOT NULL COMMENT 'message sender idv from users' ,
  `msg_receiver` INT(11) NOT NULL COMMENT 'message receiver id from users' ,
  `msg_subject` TEXT NOT NULL COMMENT 'message subject' ,
  `msg_text` TEXT NOT NULL COMMENT 'message text' ,
  `msg_time` TIME NOT NULL COMMENT 'message time' ,
  PRIMARY KEY (`msg_id`) ,
  CONSTRAINT `private_messages_ibfk_1`
    FOREIGN KEY (`msg_sender` )
    REFERENCES `bit_forum`.`users` (`usr_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `private_messages_ibfk_2`
    FOREIGN KEY (`msg_receiver` )
    REFERENCES `bit_forum`.`users` (`usr_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `msg_sender` ON `bit_forum`.`private_messages` (`msg_sender` ASC, `msg_receiver` ASC) ;

CREATE INDEX `msg_receiver` ON `bit_forum`.`private_messages` (`msg_receiver` ASC) ;

--
--    `private_messages`
--
INSERT INTO `private_messages` (`msg_id`, `msg_sender`, `msg_receiver`, `msg_subject`, `msg_text`, `msg_time`) VALUES
(1, 1, 1, 'Registration', 'Hello, Gnome!', '00:00:00');


-- -----------------------------------------------------
-- Table `bit_forum`.`properties`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bit_forum`.`config` (
  `param_name` VARCHAR(50) NOT NULL COMMENT 'Name of config parameter',
  `param_value` VARCHAR(50) NOT NULL COMMENT 'Value of config parameter.',
  `param_comment` TEXT COMMENT 'Comment for config parameter.',
  PRIMARY KEY (`param_name`) 
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- Insert default data in configuration table
TRUNCATE TABLE `bit_forum`.`config`;

INSERT INTO `bit_forum`.`config` (`param_name`, `param_value`,
        `param_comment`) VALUES 
    ('MIN_LOGIN_SIZE', '3', 'Минимальный размер логина'),
    ('MAX_LOGIN_SIZE', '60', 'Максимальный размер логина'),
    ('MIN_PASSWORD_SIZE', '3', 'Минимальный размер пароля'),
    ('MAX_PASSWORD_SIZE', '60', 'Максимальный размер пароля'),
    ('ACCOUNT_ACTIVATION', 'NO_ACCOUNT_ACTIVATION', 
        'Тип активации аккаунта (NO_ACCOUNT_ACTIVATION, '
        'DISABLED_ACCOUNT_ACTIVATION, EMAIL_ACCOUNT_ACTIVATION)'),
    ('PASSW_ACTION_TIME', '0', 'Время действия пароля (0 -- бесконечное)'),
    ('PASSW_COMPLEXITY', 'NO_PASSW_COMPLEX', 
        'Сложность пароля (NO_PASSW_COMPLEX, REGISTER_PASSW_COMPLEX, '
        ' DIGIT_PASSW_COMPLEX, DIGIT_REGISTER_PASSW_COMPLEX)'),
    ('ENABLED_AVATARS', 'ENABLED_AVATARS', 
        'Включить аватары (ENABLED_AVATARS, DISABLED_AVATARS)'),
    ('IMAGES_PATH', '/images', 'Папка для хранения картинок'),
    ('ADMINS_EMAIL', 'pivo_est@tut.by', 'Email администратора'),
    ('MAX_MESSAGE_SIZE', '600', 'Максимальный размер одного сообщения')
;


-- -----------------------------------------------------
-- Table `bit_forum`.`warning`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bit_forum`.`warning` (
  `war_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `war_uid` INT(11) NOT NULL COMMENT 'user id' ,
  `war_comment` TEXT NOT NULL ,
  `war_start` INT(11) NOT NULL ,
  `war_end` INT(11) NOT NULL ,
  PRIMARY KEY (`war_id`) ,
  CONSTRAINT `warning_ibfk_1`
    FOREIGN KEY (`war_uid` )
    REFERENCES `bit_forum`.`users` (`usr_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;

CREATE UNIQUE INDEX `war_uid` ON `bit_forum`.`warning` (`war_uid` ASC) ;


-- -----------------------------------------------------
-- Table `bit_forum`.`smilies`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bit_forum`.`smilies` (
  `smile_id` INT UNSIGNED NOT NULL AUTO_INCREMENT
    COMMENT 'Indentifier of smile' ,
  `smile_alias` VARCHAR(45) CHARACTER SET 'utf8'
    COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Smile alias (Ex. :))' ,
  `smile_image_path` VARCHAR(45) CHARACTER SET 'utf8'
    COLLATE 'utf8_general_ci' NOT NULL
    COMMENT 'Path to image file that contain current smile.' ,
  PRIMARY KEY (`smile_id`) ,
  UNIQUE INDEX `smile_alias` USING BTREE (`smile_alias` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'Smilies aliases and paths to smilies images.';

-- -------------------------------------------------------
-- Insert standart smilies data into table
-- -------------------------------------------------------
TRUNCATE TABLE `bit_forum`.`smilies`;

-- Smile :?: have collision with :? and must be above of :?. 
INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':?:', 'images/smilies/icon_question.gif'),
       (':?', 'images/smilies/icon_confused.gif'),
       (':arrow:', 'images/smilies/icon_arrow.gif'),
       (':D', 'images/smilies/icon_biggrin.gif'),
       ('8)', 'images/smilies/icon_cool.gif'),
       (':cry:', 'images/smilies/icon_cry.gif'),
       ('8O', 'images/smilies/icon_eek.gif'),
       (':evil:', 'images/smilies/icon_evil.gif'),
       (':!:', 'images/smilies/icon_exclaim.gif'),
       (':(', 'images/smilies/icon_frown.gif'),
       (':idea:', 'images/smilies/icon_idea.gif'),
       (':lol:', 'images/smilies/icon_lol.gif'),
       (':x', 'images/smilies/icon_mad.gif'),
       (':mrgreen:', 'images/smilies/icon_mrgreen.gif'),
       (':|', 'images/smilies/icon_neutral.gif'),
       (':P', 'images/smilies/icon_razz.gif'),
       (':oops:', 'images/smilies/icon_redface.gif'),
       (':roll:', 'images/smilies/icon_rolleyes.gif'),
       (':)', 'images/smilies/icon_smile.gif'),
       (':o', 'images/smilies/icon_surprised.gif'),
       (':twisted:', 'images/smilies/icon_twisted.gif'),
       (';)', 'images/smilies/icon_wink.gif')
;
