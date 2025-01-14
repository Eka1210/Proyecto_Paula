-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema ventas_paula
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `products` ;

CREATE TABLE IF NOT EXISTS `products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `description` VARCHAR(45) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `cantidad` INT NULL DEFAULT NULL,
  `imagen` VARCHAR(255) NULL DEFAULT NULL,
  `encargo` TINYINT(3) UNSIGNED ZEROFILL NOT NULL DEFAULT '000',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `productID_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 18
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `promotions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `promotions` ;

CREATE TABLE IF NOT EXISTS `promotions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(50) NOT NULL,
  `percentage` DECIMAL(10,2) NOT NULL,
  `active` TINYINT NOT NULL,
  `start_time` DATETIME NOT NULL,
  `end_time` DATETIME NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `promotionID_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `productXpromotion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `productXpromotion` ;

CREATE TABLE IF NOT EXISTS `productXpromotion` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `productID` INT NOT NULL,
  `promotionID` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_productXpromotion_products_idx` (`productID` ASC) VISIBLE,
  INDEX `fk_productXpromotion_promotions1_idx` (`promotionID` ASC) VISIBLE,
  CONSTRAINT `fk_productXpromotion_products`
    FOREIGN KEY (`productID`)
    REFERENCES `ventas_paula`.`products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_productXpromotion_promotions1`
    FOREIGN KEY (`promotionID`)
    REFERENCES `ventas_paula`.`promotions` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventorylog`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `inventorylog` ;

CREATE TABLE IF NOT EXISTS `inventorylog` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `action` VARCHAR(45) NOT NULL,
  `quantity` INT NOT NULL,
  `old_value` INT NOT NULL,
  `new_value` INT NOT NULL,
  `date` DATETIME NOT NULL,
  `productID` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_inventorylog_products1_idx` (`productID` ASC) VISIBLE,
  CONSTRAINT `fk_inventorylog_products1`
    FOREIGN KEY (`productID`)
    REFERENCES `ventas_paula`.`products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users` ;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `create_time` DATETIME NULL DEFAULT NULL COMMENT 'Create Time',
  `username` VARCHAR(255) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `admin` TINYINT NOT NULL DEFAULT '0',
  `verified` TINYINT NOT NULL DEFAULT '0',
  `token` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `deliverymethods`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `deliverymethods` ;

CREATE TABLE IF NOT EXISTS `deliverymethods` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `create_time` DATETIME NULL DEFAULT NULL COMMENT 'Create Time',
  `name` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `cost` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `paymentmethods`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `paymentmethods` ;

CREATE TABLE IF NOT EXISTS `paymentmethods` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `create_time` DATETIME NULL DEFAULT NULL COMMENT 'Create Time',
  `name` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `cart`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cart` ;

CREATE TABLE IF NOT EXISTS `cart` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `userId` INT NOT NULL,
  `active` TINYINT NOT NULL,
  `paymentID` INT NULL DEFAULT NULL,
  `deliveryID` INT NULL DEFAULT NULL,
  `status` VARCHAR(255) NOT NULL DEFAULT 'Pendiente',
  `deliveryD` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `cartID_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_cart_users1_idx` (`userId` ASC) VISIBLE,
  INDEX `paymentID` (`paymentID` ASC) VISIBLE,
  INDEX `deliveryID` (`deliveryID` ASC) VISIBLE,
  CONSTRAINT `cart_ibfk_1`
    FOREIGN KEY (`userId`)
    REFERENCES `users` (`id`),
  CONSTRAINT `cart_ibfk_3`
    FOREIGN KEY (`deliveryID`)
    REFERENCES `deliverymethods` (`id`),
  CONSTRAINT `cart_ibfk_4`
    FOREIGN KEY (`paymentID`)
    REFERENCES `paymentmethods` (`id`)
    ON DELETE SET NULL)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `categories` ;

CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `categoriesxproduct`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `categoriesxproduct` ;

CREATE TABLE IF NOT EXISTS `categoriesxproduct` (
  `categoryID` INT NOT NULL,
  `productID` INT NOT NULL,
  INDEX `categoryID` (`categoryID` ASC) VISIBLE,
  INDEX `productID` (`productID` ASC) VISIBLE,
  CONSTRAINT `categoriesxproduct_ibfk_1`
    FOREIGN KEY (`categoryID`)
    REFERENCES `categories` (`id`),
  CONSTRAINT `categoriesxproduct_ibfk_2`
    FOREIGN KEY (`productID`)
    REFERENCES `products` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `clients`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `clients` ;

CREATE TABLE IF NOT EXISTS `clients` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(30) NOT NULL,
  `surname` VARCHAR(30) NOT NULL,
  `birthday` VARCHAR(10) NULL DEFAULT NULL,
  `phone` VARCHAR(50) NOT NULL,
  `zipCode` VARCHAR(10) NULL DEFAULT NULL,
  `address` VARCHAR(155) NULL DEFAULT NULL,
  `marketing` TINYINT NOT NULL,
  `userID` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `userID_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `userID` (`userID` ASC) VISIBLE,
  CONSTRAINT `clients_ibfk_1`
    FOREIGN KEY (`userID`)
    REFERENCES `users` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `options`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `options` ;

CREATE TABLE IF NOT EXISTS `options` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 19
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `optionsxproduct`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `optionsxproduct` ;

CREATE TABLE IF NOT EXISTS `optionsxproduct` (
  `optionID` INT NOT NULL,
  `productID` INT NOT NULL,
  `value` JSON NOT NULL,
  INDEX `optionID` (`optionID` ASC) VISIBLE,
  INDEX `productID` (`productID` ASC) VISIBLE,
  CONSTRAINT `optionsxproduct_ibfk_1`
    FOREIGN KEY (`optionID`)
    REFERENCES `options` (`id`),
  CONSTRAINT `optionsxproduct_ibfk_2`
    FOREIGN KEY (`productID`)
    REFERENCES `products` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `productsxcart`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `productsxcart` ;

CREATE TABLE IF NOT EXISTS `productsxcart` (
  `cartID` INT NOT NULL,
  `productID` INT NOT NULL,
  `quantity` INT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  INDEX `fk_cart_has_products_products1_idx` (`productID` ASC) VISIBLE,
  INDEX `fk_cart_has_products_cart1_idx` (`cartID` ASC) VISIBLE,
  CONSTRAINT `fk_cart_has_products_cart1`
    FOREIGN KEY (`cartID`)
    REFERENCES `cart` (`id`),
  CONSTRAINT `fk_cart_has_products_products1`
    FOREIGN KEY (`productID`)
    REFERENCES `products` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `sales`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sales` ;

CREATE TABLE IF NOT EXISTS `sales` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(100) NOT NULL,
  `monto` DECIMAL(10,2) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `discount` DECIMAL(10,2) NULL DEFAULT NULL,
  `userId` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `ventasID_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_sales_users1_idx` (`userId` ASC) VISIBLE,
  CONSTRAINT `fk_sales_users1`
    FOREIGN KEY (`userId`)
    REFERENCES `clients` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `productsxsale`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `productsxsale` ;

CREATE TABLE IF NOT EXISTS `productsxsale` (
  `salesID` INT NOT NULL,
  `productID` INT NOT NULL,
  `quantity` INT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`salesID`, `productID`),
  INDEX `fk_sales_has_products_products1_idx` (`productID` ASC) VISIBLE,
  INDEX `fk_sales_has_products_sales1_idx` (`salesID` ASC) VISIBLE,
  CONSTRAINT `fk_sales_has_products_products1`
    FOREIGN KEY (`productID`)
    REFERENCES `products` (`id`),
  CONSTRAINT `fk_sales_has_products_sales1`
    FOREIGN KEY (`salesID`)
    REFERENCES `sales` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `review`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `review` ;

CREATE TABLE IF NOT EXISTS `review` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `create_time` DATETIME NULL DEFAULT NULL COMMENT 'Create Time',
  `review` VARCHAR(255) NOT NULL,
  `productID` INT NOT NULL,
  `rating` FLOAT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `productID` (`productID` ASC) VISIBLE,
  CONSTRAINT `review_ibfk_1`
    FOREIGN KEY (`productID`)
    REFERENCES `products` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `wishlist`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wishlist` ;

CREATE TABLE IF NOT EXISTS `wishlist` (
  `create_time` DATETIME NULL DEFAULT NULL COMMENT 'Create Time',
  `userID` INT NOT NULL,
  `productID` INT NOT NULL,
  INDEX `userID` (`userID` ASC) VISIBLE,
  INDEX `productID` (`productID` ASC) VISIBLE,
  CONSTRAINT `wishlist_ibfk_1`
    FOREIGN KEY (`userID`)
    REFERENCES `users` (`id`),
  CONSTRAINT `wishlist_ibfk_2`
    FOREIGN KEY (`productID`)
    REFERENCES `products` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
