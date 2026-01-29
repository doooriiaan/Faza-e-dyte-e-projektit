<?php
class Auth {
    private $conn;

    public function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "projekti";

        // Lidhu me MySQL
        $this->conn = new mysqli($servername, $username, $password);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        // Krijo databazën nëse nuk ekziston
        $this->conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
        $this->conn->select_db($dbname);

        // Krijo tabelën users nëse nuk ekziston
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin','user') DEFAULT 'user'
        )";
        $this->conn->query($sql);

        // Shto një user test nëse tabela është bosh
        $result = $this->conn->query("SELECT COUNT(*) as count FROM users");
        $row = $result->fetch_assoc();
        if ($row['count'] == 0) {
            $this->conn->query("INSERT INTO users (name, email, password, role) VALUES 
                ('Dorian', 'dorian@example.com', '".password_hash("admin123456", PASSWORD_DEFAULT)."', 'admin')");
        }
    }

    // Funksioni login
    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            return true;
        }
        return false;
    }

    // Kontrollon nëse përdoruesi është loguar
    public function isLoggedIn() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']);
    }

    // Kontrollon nëse përdoruesi është admin
    public function isAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    // Merr emrin e përdoruesit
    public function getUserName() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_SESSION['user_id'])) {
            $stmt = $this->conn->prepare("SELECT name FROM users WHERE id = ?");
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            return $user['name'] ?? '';
        }
        return '';
    }
    
}
?>
