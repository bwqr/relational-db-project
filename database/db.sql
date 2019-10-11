-- -----------------------------------------------------
-- Schema sota
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sota
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sota` DEFAULT CHARACTER SET utf8 ;
CREATE USER IF NOT EXISTS 'sota'@'127.0.0.1' IDENTIFIED BY 'toor';
GRANT ALL PRIVILEGES ON sota.* TO 'sota'@'127.0.0.1';
USE `sota` ;

-- -----------------------------------------------------
-- Table `sota`.`Author`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sota`.`author` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `surname` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `sota`.`Paper`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sota`.`paper` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(500) NULL UNIQUE,
  `abstract` TEXT NULL,
  `result` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sota`.`Topic`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sota`.`topic` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL UNIQUE ,
  `result` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sota`.`Paper_has_Author`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sota`.`paper_has_author` (
  `paper_id` INT NOT NULL,
  `author_id` INT NOT NULL,
  PRIMARY KEY (`paper_id`, `author_id`),
  CONSTRAINT `fk_Paper_has_Author_Paper`
    FOREIGN KEY (`paper_id`)
    REFERENCES `sota`.`paper` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Paper_has_Author_Author1`
    FOREIGN KEY (`author_id`)
    REFERENCES `sota`.`author` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_Paper_has_Author_Author1_idx` ON `sota`.`paper_has_author` (`author_id` ASC) LOCK=DEFAULT ;

CREATE INDEX `fk_Paper_has_Author_paper_idx` ON `sota`.`paper_has_author` (`paper_id` ASC) LOCK=DEFAULT ;


-- -----------------------------------------------------
-- Table `sota`.`Paper_has_Topic`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sota`.`paper_has_topic` (
  `paper_id` INT NOT NULL,
  `topic_id` INT NOT NULL,
  PRIMARY KEY (`paper_id`, `topic_id`),
  CONSTRAINT `fk_Paper_has_Topic_Paper1`
    FOREIGN KEY (`paper_id`)
    REFERENCES `sota`.`paper` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Paper_has_Topic_Topic1`
    FOREIGN KEY (`topic_id`)
    REFERENCES `sota`.`topic` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_Paper_has_Topic_Topic1_idx` ON `sota`.`paper_has_topic` (`topic_id` ASC) LOCK=DEFAULT ;

CREATE INDEX `fk_Paper_has_Topic_Paper1_idx` ON `sota`.`paper_has_topic` (`paper_id` ASC) LOCK=DEFAULT ;

CREATE OR REPLACE DEFINER = CURRENT_USER PROCEDURE sota.COAUTHORS (IN searchname VARCHAR(45), IN searchsurname VARCHAR(45))
BEGIN
    SELECT DISTINCT au1.* FROM author AS au1
                          JOIN paper_has_author AS pha1
                               ON pha1.author_id = au1.id
                          join paper_has_author AS pha2
                               ON pha2.paper_id = pha1.paper_id AND pha2.author_id != au1.id
                          join author AS au2
                               ON pha2.author_id = au2.id
    WHERE au2.name = searchname AND au2.surname = searchsurname;
END;

CREATE TRIGGER sota.paper_has_topic_insert
AFTER INSERT
    ON paper_has_topic FOR EACH ROW
BEGIN

    DECLARE paper_result INT;

    SELECT result FROM paper WHERE id = NEW.paper_id INTO paper_result;

    UPDATE topic SET result = result + paper_result WHERE id = NEW.topic_id;

END;

CREATE TRIGGER sota.paper_has_topic_delete
BEFORE DELETE
    ON paper_has_topic FOR EACH ROW
BEGIN

    DECLARE paper_result INT;

    SELECT result FROM paper WHERE id = OLD.paper_id INTO paper_result;

    UPDATE topic SET result = result - paper_result WHERE id = OLD.topic_id;

END;

CREATE TRIGGER sota.paper_delete
BEFORE DELETE
    ON paper FOR EACH ROW
BEGIN

    UPDATE topic SET result = result - OLD.result WHERE id IN (
        SELECT topic_id FROM paper_has_topic WHERE paper_id = OLD.id
        );

END;

