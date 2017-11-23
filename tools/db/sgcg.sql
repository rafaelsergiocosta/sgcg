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
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	modified_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-------------------------------------------------------------
-- DML

INSERT INTO sgcg.users (name, login, password, created_at, modified_at)
VALUES('Teste', 'teste', '$2y$10$vCB5wJuXOzjnplpdk/SY1uYE21pScDinvjGQ5JNhtx1YUWofxSKYC', now(), now());