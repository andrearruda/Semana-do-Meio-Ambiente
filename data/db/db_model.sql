-- MySQL Script generated by MySQL Workbench
-- 05/10/16 10:35:56
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema semanadomeioambiente
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema semanadomeioambiente
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `semanadomeioambiente` DEFAULT CHARACTER SET utf8 ;
USE `semanadomeioambiente` ;

-- -----------------------------------------------------
-- Table `semanadomeioambiente`.`role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `semanadomeioambiente`.`role` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `parent_id` INT(11) NULL DEFAULT NULL,
  `roleId` VARCHAR(255) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `UNIQ_57698A6AB8C2FD88` (`roleId` ASC),
  INDEX `IDX_57698A6A727ACA70` (`parent_id` ASC),
  CONSTRAINT `FK_57698A6A727ACA70`
    FOREIGN KEY (`parent_id`)
    REFERENCES `semanadomeioambiente`.`role` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `semanadomeioambiente`.`unit`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `semanadomeioambiente`.`unit` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `initials` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `semanadomeioambiente`.`staff`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `semanadomeioambiente`.`staff` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `unit_id` INT NOT NULL,
  `name` VARCHAR(25) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `departament` VARCHAR(40) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_staff_unit1_idx` (`unit_id` ASC),
  CONSTRAINT `fk_staff_unit1`
    FOREIGN KEY (`unit_id`)
    REFERENCES `semanadomeioambiente`.`unit` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `semanadomeioambiente`.`message`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `semanadomeioambiente`.`message` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `description` VARCHAR(140) NOT NULL,
  `image` VARCHAR(45) NOT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_message_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_message_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `semanadomeioambiente`.`staff` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `semanadomeioambiente`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `semanadomeioambiente`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `email` VARCHAR(255) CHARACTER SET 'utf8' NOT NULL,
  `displayName` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `password` VARCHAR(128) CHARACTER SET 'utf8' NOT NULL,
  `state` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `UNIQ_1483A5E9E7927C74` (`email` ASC),
  UNIQUE INDEX `UNIQ_1483A5E9F85E0677` (`username` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `semanadomeioambiente`.`users_roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `semanadomeioambiente`.`users_roles` (
  `user_id` INT(11) NOT NULL,
  `role_id` INT(11) NOT NULL,
  PRIMARY KEY (`user_id`, `role_id`),
  INDEX `IDX_51498A8EA76ED395` (`user_id` ASC),
  INDEX `IDX_51498A8ED60322AC` (`role_id` ASC),
  CONSTRAINT `FK_51498A8ED60322AC`
    FOREIGN KEY (`role_id`)
    REFERENCES `semanadomeioambiente`.`role` (`id`),
  CONSTRAINT `FK_51498A8EA76ED395`
    FOREIGN KEY (`user_id`)
    REFERENCES `semanadomeioambiente`.`users` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;