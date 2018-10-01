USE `ecommerce1` ;

CREATE TABLE `categories` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`category` VARCHAR(45) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `category_UNIQUE` (`category` ASC) 
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `categories` (category) VALUES ('Common Attacks'), ('Database Security'), ('General Web Security'), ('JavaScript Security'), ('PHP Security'), ('PDF Guides');

CREATE TABLE `pages` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`categories_id` SMALLINT UNSIGNED NOT NULL,
	`title` VARCHAR(100) NOT NULL,
	`description` TINYTEXT NOT NULL,
	`content` LONGTEXT NULL,
	`date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX `date_created` (`date_created` ASC),
	INDEX `fk_pages_categories_idx` (`categories_id` ASC),
	CONSTRAINT `fk_pages_categories`
		FOREIGN KEY (`categories_id`)
		REFERENCES `categories` (`id`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pages` (categories_id, title, description, content, date_created) VALUES 
(1, 'This is a Common Attack Article!', 'This is the description. This is the description. This is the description. This is the description.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eu scelerisque erat. Praesent vestibulum dui sit amet purus pretium condimentum. Fusce hendrerit, risus vel ultrices varius, est risus vulputate diam, sed blandit arcu leo id justo. Phasellus vel mauris eleifend, pharetra turpis et, dictum enim. Vivamus in orci et metus dictum lobortis sed consequat quam. Nam tempor, nisi vel ultricies mollis, ante risus maximus massa, at gravida arcu sem at turpis. Duis diam turpis, tristique a leo sed, gravida luctus mauris. Mauris congue metus nisl, in cursus elit semper ac. Vestibulum non sapien dui.</p>
<p>Vivamus at vulputate leo. Praesent a feugiat massa, facilisis bibendum libero. Fusce hendrerit ex ut sem mollis imperdiet a nec ex. Pellentesque nibh purus, feugiat facilisis suscipit vitae, fringilla a tellus. Aliquam in consequat eros, a laoreet risus. Duis a turpis eget magna semper varius. Praesent mattis mattis cursus. Etiam vel odio commodo, gravida diam non, rutrum diam. Vestibulum eu nulla erat. Etiam tristique pulvinar lectus, in fermentum neque maximus ut. Nunc iaculis nisi tempor lacinia cursus. Curabitur metus nisl, tincidunt vitae turpis quis, convallis volutpat est. Vivamus vel lacus sit amet ex lobortis consequat.</p>
<p>Nulla augue leo, rhoncus at urna nec, elementum pellentesque sem. Sed dignissim sapien id ligula commodo, eu pellentesque neque semper. Donec ac arcu vitae eros ornare tempus a nec dolor. Curabitur imperdiet sapien arcu, eget varius dui iaculis et. Vestibulum fermentum nisi magna, at posuere massa interdum eu. Nullam vel semper dui. Cras faucibus tristique dictum. Mauris non enim quis ex viverra tempor vitae ut leo. Pellentesque faucibus hendrerit maximus.</p>
<p>Fusce sodales orci arcu, nec ornare diam luctus in. Sed vestibulum tortor risus, sit amet fermentum velit facilisis non. Nunc interdum quis enim ac gravida. Donec et purus aliquet, fringilla lacus quis, convallis justo. Maecenas egestas nunc eu lacus hendrerit ultricies ut ac felis. Nam mauris libero, iaculis quis malesuada vitae, maximus non risus. Nullam eu metus tempus, tincidunt enim vel, lacinia ante. Integer sollicitudin ipsum nec nibh porta, at cursus lectus cursus. Curabitur vulputate sem eu massa ultrices, sed suscipit felis rhoncus.</p>
<p>Fusce urna tellus, semper vitae aliquam ac, viverra sed sapien. In a enim dignissim, commodo justo a, mattis magna. Fusce maximus cursus mi, vel tempus tellus elementum ut. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam gravida enim quam, non interdum massa finibus sed. Donec sodales suscipit felis. Etiam et est ac nibh commodo feugiat non ut purus. Vivamus eget sem at ex tincidunt imperdiet.</p>', NOW()+100000),
(1, 'This is Another Common Attack Article!', 'This is the description. This is the description. This is the description. This is the description.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eu scelerisque erat. Praesent vestibulum dui sit amet purus pretium condimentum. Fusce hendrerit, risus vel ultrices varius, est risus vulputate diam, sed blandit arcu leo id justo. Phasellus vel mauris eleifend, pharetra turpis et, dictum enim. Vivamus in orci et metus dictum lobortis sed consequat quam. Nam tempor, nisi vel ultricies mollis, ante risus maximus massa, at gravida arcu sem at turpis. Duis diam turpis, tristique a leo sed, gravida luctus mauris. Mauris congue metus nisl, in cursus elit semper ac. Vestibulum non sapien dui.</p>
<p>Vivamus at vulputate leo. Praesent a feugiat massa, facilisis bibendum libero. Fusce hendrerit ex ut sem mollis imperdiet a nec ex. Pellentesque nibh purus, feugiat facilisis suscipit vitae, fringilla a tellus. Aliquam in consequat eros, a laoreet risus. Duis a turpis eget magna semper varius. Praesent mattis mattis cursus. Etiam vel odio commodo, gravida diam non, rutrum diam. Vestibulum eu nulla erat. Etiam tristique pulvinar lectus, in fermentum neque maximus ut. Nunc iaculis nisi tempor lacinia cursus. Curabitur metus nisl, tincidunt vitae turpis quis, convallis volutpat est. Vivamus vel lacus sit amet ex lobortis consequat.</p>
<p>Nulla augue leo, rhoncus at urna nec, elementum pellentesque sem. Sed dignissim sapien id ligula commodo, eu pellentesque neque semper. Donec ac arcu vitae eros ornare tempus a nec dolor. Curabitur imperdiet sapien arcu, eget varius dui iaculis et. Vestibulum fermentum nisi magna, at posuere massa interdum eu. Nullam vel semper dui. Cras faucibus tristique dictum. Mauris non enim quis ex viverra tempor vitae ut leo. Pellentesque faucibus hendrerit maximus.</p>
<p>Fusce sodales orci arcu, nec ornare diam luctus in. Sed vestibulum tortor risus, sit amet fermentum velit facilisis non. Nunc interdum quis enim ac gravida. Donec et purus aliquet, fringilla lacus quis, convallis justo. Maecenas egestas nunc eu lacus hendrerit ultricies ut ac felis. Nam mauris libero, iaculis quis malesuada vitae, maximus non risus. Nullam eu metus tempus, tincidunt enim vel, lacinia ante. Integer sollicitudin ipsum nec nibh porta, at cursus lectus cursus. Curabitur vulputate sem eu massa ultrices, sed suscipit felis rhoncus.</p>
<p>Fusce urna tellus, semper vitae aliquam ac, viverra sed sapien. In a enim dignissim, commodo justo a, mattis magna. Fusce maximus cursus mi, vel tempus tellus elementum ut. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam gravida enim quam, non interdum massa finibus sed. Donec sodales suscipit felis. Etiam et est ac nibh commodo feugiat non ut purus. Vivamus eget sem at ex tincidunt imperdiet.</p>', NOW()+400000),
(2, 'This is a Databases Security Article!', 'This is the description. This is the description. This is the description. This is the description.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eu scelerisque erat. Praesent vestibulum dui sit amet purus pretium condimentum. Fusce hendrerit, risus vel ultrices varius, est risus vulputate diam, sed blandit arcu leo id justo. Phasellus vel mauris eleifend, pharetra turpis et, dictum enim. Vivamus in orci et metus dictum lobortis sed consequat quam. Nam tempor, nisi vel ultricies mollis, ante risus maximus massa, at gravida arcu sem at turpis. Duis diam turpis, tristique a leo sed, gravida luctus mauris. Mauris congue metus nisl, in cursus elit semper ac. Vestibulum non sapien dui.</p>
<p>Vivamus at vulputate leo. Praesent a feugiat massa, facilisis bibendum libero. Fusce hendrerit ex ut sem mollis imperdiet a nec ex. Pellentesque nibh purus, feugiat facilisis suscipit vitae, fringilla a tellus. Aliquam in consequat eros, a laoreet risus. Duis a turpis eget magna semper varius. Praesent mattis mattis cursus. Etiam vel odio commodo, gravida diam non, rutrum diam. Vestibulum eu nulla erat. Etiam tristique pulvinar lectus, in fermentum neque maximus ut. Nunc iaculis nisi tempor lacinia cursus. Curabitur metus nisl, tincidunt vitae turpis quis, convallis volutpat est. Vivamus vel lacus sit amet ex lobortis consequat.</p>
<p>Nulla augue leo, rhoncus at urna nec, elementum pellentesque sem. Sed dignissim sapien id ligula commodo, eu pellentesque neque semper. Donec ac arcu vitae eros ornare tempus a nec dolor. Curabitur imperdiet sapien arcu, eget varius dui iaculis et. Vestibulum fermentum nisi magna, at posuere massa interdum eu. Nullam vel semper dui. Cras faucibus tristique dictum. Mauris non enim quis ex viverra tempor vitae ut leo. Pellentesque faucibus hendrerit maximus.</p>
<p>Fusce sodales orci arcu, nec ornare diam luctus in. Sed vestibulum tortor risus, sit amet fermentum velit facilisis non. Nunc interdum quis enim ac gravida. Donec et purus aliquet, fringilla lacus quis, convallis justo. Maecenas egestas nunc eu lacus hendrerit ultricies ut ac felis. Nam mauris libero, iaculis quis malesuada vitae, maximus non risus. Nullam eu metus tempus, tincidunt enim vel, lacinia ante. Integer sollicitudin ipsum nec nibh porta, at cursus lectus cursus. Curabitur vulputate sem eu massa ultrices, sed suscipit felis rhoncus.</p>
<p>Fusce urna tellus, semper vitae aliquam ac, viverra sed sapien. In a enim dignissim, commodo justo a, mattis magna. Fusce maximus cursus mi, vel tempus tellus elementum ut. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam gravida enim quam, non interdum massa finibus sed. Donec sodales suscipit felis. Etiam et est ac nibh commodo feugiat non ut purus. Vivamus eget sem at ex tincidunt imperdiet.</p>', NOW()-1000000),
(5, 'This is a PHP Security Article!', 'This is the description. This is the description. This is the description. This is the description.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eu scelerisque erat. Praesent vestibulum dui sit amet purus pretium condimentum. Fusce hendrerit, risus vel ultrices varius, est risus vulputate diam, sed blandit arcu leo id justo. Phasellus vel mauris eleifend, pharetra turpis et, dictum enim. Vivamus in orci et metus dictum lobortis sed consequat quam. Nam tempor, nisi vel ultricies mollis, ante risus maximus massa, at gravida arcu sem at turpis. Duis diam turpis, tristique a leo sed, gravida luctus mauris. Mauris congue metus nisl, in cursus elit semper ac. Vestibulum non sapien dui.</p>
<p>Vivamus at vulputate leo. Praesent a feugiat massa, facilisis bibendum libero. Fusce hendrerit ex ut sem mollis imperdiet a nec ex. Pellentesque nibh purus, feugiat facilisis suscipit vitae, fringilla a tellus. Aliquam in consequat eros, a laoreet risus. Duis a turpis eget magna semper varius. Praesent mattis mattis cursus. Etiam vel odio commodo, gravida diam non, rutrum diam. Vestibulum eu nulla erat. Etiam tristique pulvinar lectus, in fermentum neque maximus ut. Nunc iaculis nisi tempor lacinia cursus. Curabitur metus nisl, tincidunt vitae turpis quis, convallis volutpat est. Vivamus vel lacus sit amet ex lobortis consequat.</p>
<p>Nulla augue leo, rhoncus at urna nec, elementum pellentesque sem. Sed dignissim sapien id ligula commodo, eu pellentesque neque semper. Donec ac arcu vitae eros ornare tempus a nec dolor. Curabitur imperdiet sapien arcu, eget varius dui iaculis et. Vestibulum fermentum nisi magna, at posuere massa interdum eu. Nullam vel semper dui. Cras faucibus tristique dictum. Mauris non enim quis ex viverra tempor vitae ut leo. Pellentesque faucibus hendrerit maximus.</p>
<p>Fusce sodales orci arcu, nec ornare diam luctus in. Sed vestibulum tortor risus, sit amet fermentum velit facilisis non. Nunc interdum quis enim ac gravida. Donec et purus aliquet, fringilla lacus quis, convallis justo. Maecenas egestas nunc eu lacus hendrerit ultricies ut ac felis. Nam mauris libero, iaculis quis malesuada vitae, maximus non risus. Nullam eu metus tempus, tincidunt enim vel, lacinia ante. Integer sollicitudin ipsum nec nibh porta, at cursus lectus cursus. Curabitur vulputate sem eu massa ultrices, sed suscipit felis rhoncus.</p>
<p>Fusce urna tellus, semper vitae aliquam ac, viverra sed sapien. In a enim dignissim, commodo justo a, mattis magna. Fusce maximus cursus mi, vel tempus tellus elementum ut. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam gravida enim quam, non interdum massa finibus sed. Donec sodales suscipit felis. Etiam et est ac nibh commodo feugiat non ut purus. Vivamus eget sem at ex tincidunt imperdiet.</p>', NOW()+1000000);

CREATE TABLE `pdfs` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(100) NOT NULL,
	`description` TINYTEXT NOT NULL,
	`tmp_name` CHAR(63) NOT NULL,
	`file_name` VARCHAR(100) NOT NULL,
	`size` MEDIUMINT UNSIGNED NOT NULL,
	`date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `tmp_name_UNIQUE` (`tmp_name` ASC),
	INDEX `date_created` (`date_created` ASC) 
) ENGINE = InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`type` ENUM('member','admin') NOT NULL DEFAULT 'member',
	`username` VARCHAR(45) NOT NULL,
	`email` VARCHAR(80) NOT NULL,
	`pass` VARCHAR(255) NOT NULL,
	`first_name` VARCHAR(45) NOT NULL,
	`last_name` VARCHAR(45) NOT NULL,
	`date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`date_expires` DATE NOT NULL,
	`date_modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `username_UNIQUE` (`username` ASC),
	UNIQUE INDEX `email_UNIQUE` (`email` ASC),
	INDEX `login` (`email` ASC, `pass` ASC)
) ENGINE = InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `orders` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`users_id` INT UNSIGNED NOT NULL,
	`transaction_id` VARCHAR(45) NOT NULL,
	`payment_status` VARCHAR(45) NOT NULL,
	`payment_amount` INT UNSIGNED NOT NULL,
	`date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX `date_created` (`date_created` ASC),
	INDEX `transaction_id` (`transaction_id` ASC),
	CONSTRAINT `fk_orders_users1`
		FOREIGN KEY (`users_id`)
		REFERENCES `users` (`id`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- BONUS TABLES!
--

-- --------------------------------------------------------

CREATE TABLE history (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`user_id` INT UNSIGNED NOT NULL,
`type` ENUM('page', 'pdf'),
`item_id` INT UNSIGNED DEFAULT NULL,
`date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
KEY (`type`, `item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE favorite_pages (
`user_id` INT UNSIGNED NOT NULL,
`page_id` MEDIUMINT UNSIGNED NOT NULL,
`date_created` TIMESTAMP  NOT NULL,
PRIMARY KEY (`user_id`, `page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE page_ratings (
`user_id` INT UNSIGNED NOT NULL,
`page_id` MEDIUMINT UNSIGNED NOT NULL,
`rating` TINYINT UNSIGNED NOT NULL,
`date_created` TIMESTAMP  NOT NULL,
PRIMARY KEY (`user_id`, `page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE notes (
`user_id` INT UNSIGNED NOT NULL,
`page_id` INT UNSIGNED NOT NULL,
`note` TEXT NOT NULL,
`date_updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`user_id`, `page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE access_tokens (
`user_id` INT UNSIGNED NOT NULL,
`token` CHAR(64) NOT NULL,
`date_expires` DATETIME NOT NULL,
PRIMARY KEY (`user_id`),
UNIQUE (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE recommendations (
`page_a` INT UNSIGNED NOT NULL,
`page_b` INT UNSIGNED NOT NULL,
PRIMARY KEY (`page_a`, `page_b`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE pages_categories (
`page_id` INT UNSIGNED NOT NULL,
`category_id` SMALLINT UNSIGNED NOT NULL,
PRIMARY KEY (`page_id`, `category_id`)
);

CREATE TABLE user_types (
`id` SMALLINT UNSIGNED NOT NULL,
`type` VARCHAR(20) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
