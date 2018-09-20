CREATE TABLE IF NOT EXISTS `pf_category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64) NOT NULL,
  `color` VARCHAR(32) NOT NULL DEFAULT '#ffffff',
  `orderItem` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`));



CREATE TABLE IF NOT EXISTS `pf_item` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fkCategory` INT NULL,
  `place` VARCHAR(128) NULL,
  `dateItem` VARCHAR(45) NULL,
  `name` VARCHAR(45) NULL,
  `hat` TEXT NULL,
  `text` TEXT NULL,
  `imageThumbnail` INT NULL,
  `orderItem` INT NULL,
  `dateCreated` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fkPortfolioCategory_idx` (`fkCategory` ASC),
  CONSTRAINT `fkPortfolioCategory`
    FOREIGN KEY (`fkCategory`)
    REFERENCES `pf_category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE TABLE IF NOT EXISTS `pf_slideritem` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fkPortfolioItem` INT NULL,
  `fkMedia` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fkPortfolioItem_idx` (`fkPortfolioItem` ASC),
  CONSTRAINT `fkPortfolioItem`
    FOREIGN KEY (`fkPortfolioItem`)
    REFERENCES `pf_item` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE TABLE `pf_custom_properties` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64) NULL,
  `title` VARCHAR(128) NULL,
  `useAsFilter` TINYINT NULL DEFAULT 0,
  PRIMARY KEY (`id`));

CREATE TABLE `pf_cp_values` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fkItem` INT NOT NULL,
  `fkCustomProperty` INT NOT NULL,
  `value` TEXT NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `pf_cp_values`
ADD INDEX `forkItem_idx` (`fkItem` ASC),
ADD INDEX `forkCP_idx` (`fkCustomProperty` ASC);
ALTER TABLE `pf_cp_values`
ADD CONSTRAINT `forkItem`
  FOREIGN KEY (`fkItem`)
  REFERENCES `pf_item` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `forkCP`
  FOREIGN KEY (`fkCustomProperty`)
  REFERENCES `pf_custom_properties` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `pf_cp_values`
DROP FOREIGN KEY `forkCP`,
DROP FOREIGN KEY `forkItem`;
ALTER TABLE `pf_cp_values`
ADD CONSTRAINT `forkCP`
  FOREIGN KEY (`fkCustomProperty`)
  REFERENCES `pf_custom_properties` (`id`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION,
ADD CONSTRAINT `forkItem`
  FOREIGN KEY (`fkItem`)
  REFERENCES `pf_item` (`id`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION;

ALTER TABLE `pf_slideritem`
DROP FOREIGN KEY `fkPortfolioItem`;
ALTER TABLE `pf_slideritem`
ADD CONSTRAINT `fkPortfolioItem`
  FOREIGN KEY (`fkPortfolioItem`)
  REFERENCES `pf_item` (`id`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION;


ALTER TABLE `pf_custom_properties`
ADD COLUMN `propOrder` INT NULL DEFAULT 0 AFTER `useAsFilter`;




-- Create form
CALL `om_CreateForm`('portfolio', 'portfolio', 0, 1, 'Portfolio');

-- Create form entry
CALL `om_CreateFormEntry`('portfolio', 'display', 1, 'Omega\\Library\\Plugin\\Type\\DropDown', '{"default": 1,"options": {"1": "List","2": "Grid - 2", "3": "Grid - 3","4": "Grid - 4"}}', 'Display', 'How the portfolio is displayed in the page', 0);
