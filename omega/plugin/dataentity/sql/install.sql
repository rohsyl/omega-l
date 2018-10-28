CREATE TABLE IF NOT EXISTS `dataentity_views` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fkForm` INT NOT NULL,
  `name` VARCHAR(64) NOT NULL,
  `view` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Form_idx_view` (`fkForm` ASC),
  CONSTRAINT `fk_Form`
    FOREIGN KEY (`fkForm`)
    REFERENCES `om_form` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE TABLE IF NOT EXISTS  `dataentity_datas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fkForm` INT NOT NULL,
  `values` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_form_idx_data` (`fkForm` ASC),
  CONSTRAINT `fk_form1_data`
    FOREIGN KEY (`fkForm`)
    REFERENCES `om_form` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


CREATE TABLE `dataentity_layouts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(32) NOT NULL,
  `view` TEXT NOT NULL,
  PRIMARY KEY (`id`));


CALL `om_CreateForm`('dataentity', 'dataentity', 1, 1, 'Data Entity');
CALL `om_CreateFormEntry`('dataentity', 'title', 1, 'Omega\\Utils\\Plugin\\Type\\TextSimple', '{}', 'Title', '', 0);
CALL `om_CreateFormEntry`('dataentity', 'layout', 2, 'Omega\\Utils\\Plugin\\Type\\DropDown', '{"model" : "Omega\\\\Plugin\\\\Dataentity\\\\Library\\\\Type\\\\Model\\\\LayoutDropDownModel"}', 'Layout', 'Choose a layout that will be used to display selected entites', 0);
CALL `om_CreateFormEntry`('dataentity', 'entities', 3, 'Omega\\Plugin\\Dataentity\\Library\\Type\\DataEntityChooser', '{}', 'Entities', 'Choose entites that will be displayed', 0);