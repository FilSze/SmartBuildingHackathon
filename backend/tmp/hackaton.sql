CREATE TABLE `Users` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` TEXT NOT NULL,
	`score` INT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Locks` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` TEXT NOT NULL,
	`open_time` json NOT NULL,
	PRIMARY KEY (`id`)
);



