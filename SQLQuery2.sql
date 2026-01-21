-- Krijo databazën
CREATE DATABASE IF NOT EXISTS projekti;

-- Përdore databazën
USE projekti;

-- Tabela users
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  role ENUM('admin','user') DEFAULT 'user'
);

-- Tabela products
CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  description TEXT,
  image VARCHAR(255)
);

-- Tabela news
CREATE TABLE IF NOT EXISTS news (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  content TEXT,
  image VARCHAR(255)
);

-- Tabela about
CREATE TABLE IF NOT EXISTS about (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  content TEXT,
  image VARCHAR(255)
);

-- Tabela contact_messages
CREATE TABLE IF NOT EXISTS contact_messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  message TEXT
);

-- Të dhëna fillestare për about
INSERT INTO about (title, content, image)
VALUES (
  'About Us',
  'Kjo permbajtje vjen direkt nga databaza MySQL.',
  'about1.jpg'
);
