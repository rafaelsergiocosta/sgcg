-------------------------------------------------------------
-- DDL

DROP DATABASE sgcg;

CREATE DATABASE IF NOT EXISTS sgcg CHARACTER SET utf8 COLLATE utf8_general_ci;

use sgcg;

CREATE TABLE users (
	id INT NOT NULL auto_increment,
	name VARCHAR(100) NOT NULL,
	login VARCHAR(100) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	email VARCHAR(100) NOT NULL,
	birthDate DATE NOT NULL,
	score INT NOT NULL DEFAULT 0,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modified_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE categories (
	id INT NOT NULL auto_increment,
	name VARCHAR(255) NOT NULL,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modified_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE knowledge (
	id INT NOT NULL auto_increment,
	title VARCHAR(255) NOT NULL,
	user_id INT NOT NULL,
	category_id INT NOT NULL,
	slug VARCHAR(255) UNIQUE NOT NULL,
	keywords VARCHAR(255) NOT NULL,
	content TEXT NOT NULL,
	status TINYINT(1) NOT NULL,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modified_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gamification_scores (
	id INT NOT NULL auto_increment,
	description VARCHAR(255) NOT NULL,
	gameType ENUM('add', 'edit', 'like', 'share'),
	score INT NOT NULL,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modified_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-------------------------------------------------------------
-- DML

INSERT INTO sgcg.users (name, login, password, email, birthDate, created_at, modified_at)
VALUES('Teste', 'teste', '$2y$10$vCB5wJuXOzjnplpdk/SY1uYE21pScDinvjGQ5JNhtx1YUWofxSKYC', 'teste@teste.com', '1989-02-01', now(), now());