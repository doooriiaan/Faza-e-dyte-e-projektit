<?php

class Auth {

    private $conn;

    public function __construct() {

        $servername = "localhost";
        $username   = "root";
        $password   = "";
        $dbname     = "projekti";

        // Lidhja me MySQL
        $this->conn = new mysqli($servername, $username, $password);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        // Krijo databazën nëse s’egziston
        $this->conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
        $this->conn->select_db($dbname);

        // ===============================
        // USERS TABLE
        // ===============================
        $this->conn->query("
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role ENUM('admin','user') DEFAULT 'user'
            )
        ");

        // Shto admin default nëse tabela bosh
        $res = $this->conn->query("SELECT COUNT(*) AS c FROM users");
        $row = $res->fetch_assoc();
        if ($row['c'] == 0) {
            $pass = password_hash("admin123456", PASSWORD_DEFAULT);
            $this->conn->query("
                INSERT INTO users (name,email,password,role)
                VALUES ('Admin','admin@example.com','$pass','admin')
            ");
        }

        // ===============================
        // PRODUCTS TABLE
        // ===============================
        $this->conn->query("
            CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(150) NOT NULL,
                description TEXT,
                price DECIMAL(10,2),
                image VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");

        // ===============================
        // NEWS TABLE
        // ===============================
        $this->conn->query("
            CREATE TABLE IF NOT EXISTS news (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                image VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    // ===============================
    // LOGIN / LOGOUT
    // ===============================
    public function login($email, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            return true;
        }
        return false;
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
    }

    public function isLoggedIn() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return isset($_SESSION['user_id']);
    }

    public function isAdmin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    public function getUserName() {
        if (!$this->isLoggedIn()) return '';
        $id = $_SESSION['user_id'];
        $stmt = $this->conn->prepare("SELECT name FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $u = $stmt->get_result()->fetch_assoc();
        return $u['name'] ?? '';
    }

    // ===============================
    // USERS
    // ===============================
    public function getUsers() {
        return $this->conn->query("SELECT * FROM users")->fetch_all(MYSQLI_ASSOC);
    }

    public function addUser($name,$email,$password,$role) {
        if (!$this->isAdmin()) return false;
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare(
            "INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)"
        );
        $stmt->bind_param("ssss",$name,$email,$hash,$role);
        return $stmt->execute();
    }

    public function deleteUser($id) {
        if (!$this->isAdmin()) return false;
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i",$id);
        return $stmt->execute();
    }

    // ===============================
    // PRODUCTS
    // ===============================
    public function getProducts() {
        return $this->conn
            ->query("SELECT * FROM products ORDER BY created_at DESC")
            ->fetch_all(MYSQLI_ASSOC);
    }

    public function addProduct($name,$desc,$price,$image) {
        if (!$this->isAdmin()) return false;
        $stmt = $this->conn->prepare(
            "INSERT INTO products (name,description,price,image) VALUES (?,?,?,?)"
        );
        $stmt->bind_param("ssds",$name,$desc,$price,$image);
        return $stmt->execute();
    }

    public function deleteProduct($id) {
        if (!$this->isAdmin()) return false;
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id=?");
        $stmt->bind_param("i",$id);
        return $stmt->execute();
    }

    // ===============================
    // NEWS
    // ===============================
    public function getNews() {
        return $this->conn
            ->query("SELECT * FROM news ORDER BY created_at DESC")
            ->fetch_all(MYSQLI_ASSOC);
    }

    public function addNews($title,$content,$image) {
        if (!$this->isAdmin()) return false;
        $stmt = $this->conn->prepare(
            "INSERT INTO news (title,content,image) VALUES (?,?,?)"
        );
        $stmt->bind_param("sss",$title,$content,$image);
        return $stmt->execute();
    }

    public function deleteNews($id) {
        if (!$this->isAdmin()) return false;
        $stmt = $this->conn->prepare("DELETE FROM news WHERE id=?");
        $stmt->bind_param("i",$id);
        return $stmt->execute();
    }
}
