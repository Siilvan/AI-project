CREATE DATABASE recipes_db;

USE recipes_db;

CREATE TABLE recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dish_name VARCHAR(255) NOT NULL,
    ingredients TEXT NOT NULL,
    instructions TEXT NOT NULL
);