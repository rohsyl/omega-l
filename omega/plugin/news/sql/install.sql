
CREATE TABLE news_post(
  id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  title VARCHAR(64),
  fkMedia INT NULL DEFAULT NULL,
  fkUser INT NOT NULL,
  brief LONGTEXT,
  text LONGTEXT,
  archived BOOLEAN DEFAULT FALSE,
  published_at TIMESTAMP NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  deleted_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE `news_category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64) NOT NULL,
  `slug` VARCHAR(64) NOT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  deleted_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `news_post_category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fkPost` INT NOT NULL,
  `fkCategory` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `unqique` (`fkPost` ASC, `fkCategory` ASC),
  INDEX `fk_category_idx` (`fkCategory` ASC),
  CONSTRAINT `fk_category`
    FOREIGN KEY (`fkCategory`)
    REFERENCES `news_category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fl_post`
    FOREIGN KEY (`fkPost`)
    REFERENCES `news_post` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);



-- Create form
CALL `om_CreateForm`('news', 'news', 1, 1, 'News');

-- Create form entry
CALL `om_CreateFormEntry`('news', 'count', 1, 'Omega\\Utils\\Plugin\\Type\\TextSimple', '{}', 'Number of post displayed', 'By default all posts are displayed', 0);
CALL `om_CreateFormEntry`('news', 'categories', 2, 'Omega\\Utils\\Plugin\\Type\\CheckBoxes', '{"model":"OmegaPlugin\\\\News\\\\Model\\\\CheckBoxesCategoriesModel"}', 'Categories', '', 0);