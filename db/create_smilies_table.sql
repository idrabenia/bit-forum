-- File contain SQL-code for create table `Smilies` in
-- database `bit_forum`. This table contain smile alias
-- and path to smile image.
-- author: Ilya Drobenya

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `bit_forum` DEFAULT CHARACTER SET 'utf8'
  COLLATE 'utf8_general_ci' ;
USE `bit_forum`;

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
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'Smilies aliases and paths to smilies images.';

-- -------------------------------------------------------
-- Insert standart smilies data into table
-- -------------------------------------------------------
TRUNCATE TABLE `bit_forum`.`smilies`;

-- Smile :?: have collision with :? and must be above of :?. 
INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':?:', '/images/smilies/icon_question.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':?', '/images/smilies/icon_confused.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':arrow:', '/images/smilies/icon_arrow.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':D', '/images/smilies/icon_biggrin.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES ('8)', '/images/smilies/icon_cool.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':cry:', '/images/smilies/icon_cry.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES ('8O', '/images/smilies/icon_eek.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':evil:', '/images/smilies/icon_evil.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':!:', '/images/smilies/icon_exclaim.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':(', '/images/smilies/icon_frown.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':idea:', '/images/smilies/icon_idea.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':lol:', '/images/smilies/icon_lol.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':x', '/images/smilies/icon_mad.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':mrgreen:', '/images/smilies/icon_mrgreen.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':|', '/images/smilies/icon_neutral.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':P', '/images/smilies/icon_razz.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':oops:', '/images/smilies/icon_redface.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':roll:', '/images/smilies/icon_rolleyes.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':)', '/images/smilies/icon_smile.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':o', '/images/smilies/icon_surprised.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (':twisted:', '/images/smilies/icon_twisted.gif');

INSERT INTO `bit_forum`.`smilies` (`smile_alias`, `smile_image_path`)
VALUES (';)', '/images/smilies/icon_wink.gif');

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;