CREATE DATABASE charter;

USE charter;

CREATE TABLE users (
	id INT PRIMARY KEY AUTO_INCREMENT,
	/*
		type:
		0 - user
		1 - admin
	*/
	`type` INT,
	username VARCHAR(30),
	email VARCHAR(80),
	pass VARBINARY(32),
	first_name VARCHAR(20),
	last_name VARCHAR(40),
	date_expires DATE,
	date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	date_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);