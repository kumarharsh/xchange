SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `forex` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `forex`;

-- -----------------------------------------------------
-- Table `forex`.`userData`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `forex`.`userData` ;

CREATE  TABLE IF NOT EXISTS `forex`.`userData` (
  `username` VARCHAR(50) NOT NULL ,
  `password` VARCHAR(50) NOT NULL ,
  `accValUSD` DOUBLE NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `phone` VARCHAR(45) NOT NULL ,
  `college` VARCHAR(45) NOT NULL ,
  `transactions` LONGTEXT NULL ,
  `email` VARCHAR(50) NOT NULL ,
  `securityAnswer` TEXT NOT NULL ,
  `equity` DOUBLE NOT NULL ,
  PRIMARY KEY (`username`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `forex`.`transactions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `forex`.`transactions` ;

CREATE  TABLE IF NOT EXISTS `forex`.`transactions` (
  `transactionID` INT NOT NULL AUTO_INCREMENT ,
  `currencyName` VARCHAR(45) NOT NULL ,
  `type` VARCHAR(5) NOT NULL ,
  `noOfLots` INT NOT NULL ,
  `leverage` DOUBLE NULL ,
  `initPrice` DOUBLE NOT NULL ,
  `closePrice` DOUBLE NULL ,
  `date` VARCHAR(8) NOT NULL ,
  `username` VARCHAR(50) NOT NULL ,
  `active` INT NOT NULL DEFAULT 1 ,
  `principal` DOUBLE NOT NULL ,
  PRIMARY KEY (`transactionID`) ,
  INDEX `username` (`username` ASC) ,
  CONSTRAINT `username`
    FOREIGN KEY (`username` )
    REFERENCES `forex`.`userData` (`username` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
