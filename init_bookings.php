<?php
require_once 'db.php';

$sql = "CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    room_type VARCHAR(50),
    check_in DATE,
    check_out DATE,
    guests INT,
    total_amount DECIMAL(10,2),
    status VARCHAR(20) DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabela 'bookings' u krijua ose ekziston tashmë!";
} else {
    echo "Gabim: " . $conn->error;
}
?>
