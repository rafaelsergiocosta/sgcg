<?php


use Phinx\Migration\AbstractMigration;

class InitialDdl extends AbstractMigration
{
    public function up()
    {
        $this->query("
            CREATE TABLE IF NOT EXISTS users (
                id INT NOT NULL auto_increment,
                name VARCHAR(100) NOT NULL,
                login VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                email VARCHAR(100) NOT NULL,
                birthDate DATE NOT NULL,
                score INT NOT NULL DEFAULT 0,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                modified_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                deleted_at DATETIME,
                PRIMARY KEY(id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS categories (
                id INT NOT NULL auto_increment,
                name VARCHAR(255) NOT NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                modified_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                deleted_at DATETIME,
                PRIMARY KEY(id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS knowledge (
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
                deleted_at DATETIME,
                PRIMARY KEY(id),
                FOREIGN KEY(user_id) REFERENCES users(id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS gamification_scores (
                id INT NOT NULL auto_increment,
                description VARCHAR(255) NOT NULL,
                gameType ENUM('add', 'edit', 'like', 'share'),
                score INT NOT NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                modified_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                deleted_at DATETIME,
                PRIMARY KEY(id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }
}
