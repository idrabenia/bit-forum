-- ------------------------------------------------------
-- File contain SQL-script for create table of
-- configurations
-- ------------------------------------------------------

CREATE TABLE IF NOT EXISTS `bit_forum`.`config`
(
	`param_name` VARCHAR(50) NOT NULL COMMENT 'Name of config parameter',
	`param_value` VARCHAR(50) NOT NULL COMMENT 'Value of config parameter.',
	`param_comment` TEXT COMMENT 'Comment for config parameter.',
	PRIMARY KEY (`param_name`)
) 
;

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
	('ADMINS_EMAIL', 'pivo_est@tut.by', 'Email администратора')
;