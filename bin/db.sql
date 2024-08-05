CREATE TABLE `type` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `label` VARCHAR(20)
);

INSERT INTO `type` (`label`)
VALUES
("green"), ("black"), ("white"), ("oolong"),
("yellow"), ("pu'erh"), ("tisane"), ("blended");

CREATE TABLE `tea` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(50),
    `type_id` INT,
    CONSTRAINT FK_TeaType FOREIGN KEY (`type_id`)
    REFERENCES `type`(`id`)
);

CREATE TABLE `form` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `label` VARCHAR(10)
);

INSERT INTO `form` (`label`)
VALUES
("loose"), ("bagged"), ("cake"), ("sample");

CREATE TABLE `vendor` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(50),
    `location` VARCHAR(50)
);

CREATE TABLE `order` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `date_of_purchase` DATETIME,
    `vendor_id` INT,
    `shipping_costs` DECIMAL(10,2),
    `additional_costs` DECIMAL(10,2),
    CONSTRAINT FK_OrderVendor FOREIGN KEY (`vendor_id`)
    REFERENCES `vendor`(`id`)
);

CREATE TABLE `order_item` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `order_id` INT,
    `tea_id` INT,
    `amount_in_grams` INT,
    `price_paid` DECIMAL(10,2),
    `form_id` INT,
    `origin` VARCHAR(50),
    `is_empty` BOOLEAN DEFAULT 0,
    CONSTRAINT FK_ItemOrder FOREIGN KEY (`order_id`)
    REFERENCES `order`(`id`),
    CONSTRAINT FK_ItemTea FOREIGN KEY (`tea_id`)
    REFERENCES `tea`(`id`),
    CONSTRAINT FK_ItemForm FOREIGN KEY (`form_id`)
    REFERENCES `form`(`id`)
);

CREATE TABLE `session` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `datetime` DATETIME,
    `order_item_id` INT,
    `nr_of_steepings` INT,
    `nr_of_participants` INT,
    `amount_of_tea` INT,
    `comments` VARCHAR(1000),
    CONSTRAINT FK_SessionItem FOREIGN KEY (`order_item_id`)
    REFERENCES `order_item`(`id`)
);