CREATE TABLE IF NOT EXISTS `alb_section` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name_simple` VARCHAR(32) NOT NULL,
  `name_full` VARCHAR(64) NOT NULL,
  `image` INT NOT NULL,
  `reaOrder` INT NOT NULL,
  `description` TEXT NOT NULL,
  PRIMARY KEY (`id`));


CREATE TABLE IF NOT EXISTS  `alb_album` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(32) NOT NULL,
  `date` DATETIME NOT NULL,
  `fkSection` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fkCategory_idx` (`fkSection` ASC),
  CONSTRAINT `fksection`
    FOREIGN KEY (`fkSection`)
    REFERENCES `alb_section` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


CREATE TABLE IF NOT EXISTS  `alb_image` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fkMedia` INT NOT NULL,
  `fkAlbum` INT NOT NULL,
  `imgOrder` INT NOT NULL,
  `pathCopyright` TEXT NULL,
  PRIMARY KEY (`id`),
  INDEX `fkmedia_idx` (`fkMedia` ASC),
  INDEX `fkitem_idx` (`fkAlbum` ASC),
  CONSTRAINT `fkmedia`
    FOREIGN KEY (`fkMedia`)
    REFERENCES `om_media` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkalbum`
    FOREIGN KEY (`fkAlbum`)
    REFERENCES `alb_album` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)



CALL `om_CreateForm`('imagealbum', 'imagealbum', 0, 1, 'Image album');
CALL `om_CreateFormEntry`('imagealbum', 'messageinfo', 1, 'Omega\\Library\\Plugin\\Type\\Alert', '{"type":"info","text":"Pour gérer les albums, veuillez vous rendre à la page Plugins > Image Album"}', '', '', 0);
