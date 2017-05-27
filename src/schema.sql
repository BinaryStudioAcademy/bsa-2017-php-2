DROP TABLE IF EXISTS `bookings`;
DROP TABLE IF EXISTS `tickets`;
DROP TABLE IF EXISTS `users`;
CREATE TABLE `tickets` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) not null,
  `country` varchar(50) not null,
  `price` double not null,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;
CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) not null,
  `last_name` varchar(255) not null,
  `age` int(3) not null,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;
CREATE TABLE `bookings` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) not null,
  `ticket_id` int(11) not null,
  PRIMARY KEY (`id`),
  INDEX `bookings_user_idx` (`user_id` ASC) ,
  CONSTRAINT `bookings_user_idx`
    FOREIGN KEY (`user_id` )
    REFERENCES `users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  INDEX `bookings_ticket_idx` (`ticket_id` ASC) ,
  CONSTRAINT `bookings_ticket_idx`
    FOREIGN KEY (`ticket_id` )
    REFERENCES `tickets` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
