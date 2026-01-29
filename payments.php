<?php
require_once 'auth_check.php';
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $room_type = $_POST['room_type'] ?? '';
    $check_in = $_POST['check_in'] ?? '';
    $check_out = $_POST['check_out'] ?? '';
    $guests = (int) ($_POST['guests'] ?? 1);

    $check_in_date = new DateTime($check_in);
    $check_out_date = new DateTime($check_out);
    $interval = $check_in_date->diff($check_out_date);
    $nights = max(1, $interval->days);

    $prices = ['Single'=>50, 'Double'=>80, 'Suite'=>120];
    $price_per_night = $prices[$room_type] ?? 0;
    $total_amount = $price_per_night * $nights;

    // Save booking
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, room_type, check_in, check_out, guests, total_amount, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("isssid", $user_id, $room_type, $check_in, $check_out, $guests, $total_amount);
    $stmt->execute();
    $stmt->close();
} else {
    header("Location: hotel.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Confirmation - SnowLine Escape</title>
<style>
body {
    font-family: Arial, sans-serif;
    margin:0;
    background: linear-gradient(to bottom, #f0f4f8, #d9e2ec);
    color: #333;
}
.container {
    max-width:500px;
    margin:80px auto;
    padding:30px;
    background:#fff;
    border-radius:15px;
    box-shadow:0 8px 20px rgba(0,0,0,0.15);
    text-align:center;
}
h1 {
    color:#0d3b66;
    font-size:28px;
    margin-bottom:15px;
}
p {
    font-size:16px;
    margin-bottom:20px;
}
ul {
    text-align:left;
    padding-left:20px;
    margin-bottom:25px;
}
li {
    margin-bottom:10px;
}
button {
    background:#ff6b6b;
    color:#fff;
    border:none;
    padding:12px 25px;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}
button:hover {
    background:#e55a5a;
}
.success-icon {
    font-size:50px;
    color:#28a745;
    margin-bottom:15px;
}
</style>
</head>
<body>

<div class="container">
    <div class="success-icon">✅</div>
    <h1>Booking Confirmed!</h1>
    <p>Thank you, <?= htmlspecialchars($_SESSION['user_name']) ?>! Your booking has been successfully recorded.</p>

    <ul>
        <li><strong>Room Type:</strong> <?= htmlspecialchars($room_type) ?></li>
        <li><strong>Check-in:</strong> <?= htmlspecialchars($check_in) ?></li>
        <li><strong>Check-out:</strong> <?= htmlspecialchars($check_out) ?></li>
        <li><strong>Guests:</strong> <?= htmlspecialchars($guests) ?></li>
        <li><strong>Total Amount:</strong> $<?= number_format($total_amount,2) ?></li>
    </ul>

    <button onclick="window.location.href='hotel.php'">Back to Hotel</button>
</div>

</body>
</html>
