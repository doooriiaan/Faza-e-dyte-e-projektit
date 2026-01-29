-- 1️⃣ Krijo databazën nëse nuk ekziston
IF DB_ID('projekti') IS NULL
BEGIN
    CREATE DATABASE projekti;
END
GO

-- 2️⃣ Përdor databazën
USE projekti;
GO

-------------------------
-- 3️⃣ Tabela users
IF OBJECT_ID('users', 'U') IS NULL
BEGIN
    CREATE TABLE users (
        id INT IDENTITY(1,1) PRIMARY KEY,
        name NVARCHAR(100) NOT NULL,
        email NVARCHAR(100) UNIQUE NOT NULL,
        password NVARCHAR(255) NOT NULL,
        role NVARCHAR(10) DEFAULT 'user'
    );
END
GO

-- Fshi përdoruesin admin nëse ekziston për të mos pasur duplicate
DELETE FROM users WHERE email='dorian@example.com';
GO

-- Fut admin dhe një user test
INSERT INTO users (name, email, password, role)
VALUES 
('Dorian Krasniqi', 'dorian@example.com', '123456', 'admin'),
('Studenti 1', 'student1@example.com', 'password', 'user');
GO

-------------------------
-- 4️⃣ Tabela products
IF OBJECT_ID('products', 'U') IS NULL
BEGIN
    CREATE TABLE products (
        id INT IDENTITY(1,1) PRIMARY KEY,
        title NVARCHAR(255) NOT NULL,
        description NVARCHAR(MAX),
        price DECIMAL(10,2) DEFAULT 0,
        image NVARCHAR(255)
    );
END
ELSE
BEGIN
    -- Shto kolonën price nëse mungon
    IF COL_LENGTH('products','price') IS NULL
        ALTER TABLE products ADD price DECIMAL(10,2) DEFAULT 0;
END
GO

-- Fut produkte shembull
INSERT INTO products (title, description, price, image)
VALUES 
('Produkt 1', 'Përshkrimi i produktit 1', 120.00, 'product1.jpg'),
('Produkt 2', 'Përshkrimi i produktit 2', 250.00, 'product2.jpg');
GO

-------------------------
-- 5️⃣ Tabela news
IF OBJECT_ID('news', 'U') IS NULL
BEGIN
    CREATE TABLE news (
        id INT IDENTITY(1,1) PRIMARY KEY,
        title NVARCHAR(255) NOT NULL,
        content NVARCHAR(MAX),
        image NVARCHAR(255)
    );
END
GO

-- Fut lajme shembull
INSERT INTO news (title, content, image)
VALUES 
('Lajmi 1', 'Përmbajtja e lajmit 1', 'news1.jpg'),
('Lajmi 2', 'Përmbajtja e lajmit 2', 'news2.jpg');
GO

-------------------------
-- 6️⃣ Tabela about
IF OBJECT_ID('about', 'U') IS NULL
BEGIN
    CREATE TABLE about (
        id INT IDENTITY(1,1) PRIMARY KEY,
        title NVARCHAR(255) NOT NULL,
        content NVARCHAR(MAX),
        image NVARCHAR(255)
    );
END
GO

INSERT INTO about (title, content, image)
VALUES 
('About Us', 'Kjo përmbajtje vjen direkt nga SQL Server.', 'about1.jpg');
GO

-------------------------
-- 7️⃣ Tabela contact_messages
IF OBJECT_ID('contact_messages', 'U') IS NULL
BEGIN
    CREATE TABLE contact_messages (
        id INT IDENTITY(1,1) PRIMARY KEY,
        name NVARCHAR(100) NOT NULL,
        email NVARCHAR(100) NOT NULL,
        message NVARCHAR(MAX)
    );
END
GO

INSERT INTO contact_messages (name, email, message)
VALUES 
('Visitori 1', 'visitor1@example.com', 'Mesazhi i parë'),
('Visitori 2', 'visitor2@example.com', 'Mesazhi i dytë');
GO

-------------------------
-- 8️⃣ Tabela bookings
IF OBJECT_ID('bookings', 'U') IS NULL
BEGIN
    CREATE TABLE bookings (
        id INT IDENTITY(1,1) PRIMARY KEY,
        user_name NVARCHAR(100),
        room_type NVARCHAR(50),
        checkin DATE,
        checkout DATE,
        guests INT,
        total_amount DECIMAL(10,2)
    );
END
ELSE
BEGIN
    -- Shto kolonën total_amount nëse mungon
    IF COL_LENGTH('bookings','total_amount') IS NULL
        ALTER TABLE bookings ADD total_amount DECIMAL(10,2) DEFAULT 0;
END
GO

-- Fut bookings shembull
INSERT INTO bookings (user_name, room_type, checkin, checkout, guests, total_amount)
VALUES
('Dorian Krasniqi', 'Single', '2026-02-22', '2026-02-25', 2, 365.50),
('Studenti 1', 'Double', '2026-03-01', '2026-03-05', 3, 720.00);
GO
