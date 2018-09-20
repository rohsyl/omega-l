CREATE TABLE IF NOT EXISTS  `pres_article` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fkMediaImage` INT,
  `fkMediaPres` INT,
  `fkMediaPanel` INT,
  `ref` INT NOT NULL,
  `name` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fkmediaimage_idx` (`fkMediaImage` ASC),
  INDEX `fkmediapres_idx` (`fkMediaPres` ASC),
  INDEX `fkmediapanel_idx` (`fkMediaPanel` ASC),
  CONSTRAINT `fkmediaImage`
    FOREIGN KEY (`fkMediaImage`)
    REFERENCES `om_media` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkmediaPres`
    FOREIGN KEY (`fkMediaPres`)
    REFERENCES `om_media` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkmediaPanel`
    FOREIGN KEY (`fkMediaPanel`)
    REFERENCES `om_media` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

CALL `om_CreateForm`('fichedepresentation', 'fichedepresentation', 0, 1, 'Fiche de presentation');
CALL `om_CreateFormEntry`('fichedepresentation', 'messageinfo', 1, 'Omega\\Library\\Plugin\\Type\\Alert', '{"type":"info","text":"Pour gérer les fiches de presentation, veuillez vous rendre à la page Plugins > Fiche de presentation"}', '', '', 0);
