DROP TABLE IF EXISTS `personalized_content` ;
CREATE TABLE IF NOT EXISTS `personalized_content` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `contentName` VARCHAR(32) NOT NULL,
  `contentContent` LONGTEXT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;