CREATE SCHEMA `mvctest` ;

CREATE TABLE `mvctest`.`user` (
  `iduser` INT NOT NULL,
  `username` VARCHAR(45) NULL,
  `first_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `created` DATE NULL,
  PRIMARY KEY (`iduser`),
  UNIQUE INDEX `iduser_UNIQUE` (`iduser` ASC) VISIBLE,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE);

CREATE TABLE `mvctest`.`user_details` (
  `userID` INT NOT NULL,
  `address` VARCHAR(45) NOT NULL,
  `phone` VARCHAR(45) NOT NULL,
  `about` VARCHAR(45) NULL,
  UNIQUE INDEX `userID_UNIQUE` (`userID` ASC));
