<?php
require_once 'auth_check.php';
require_once 'db.php';

// Për dërgimin e mesazheve (opsionale, mund ta shtosh DB më vonë)
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    // Për momentin thjesht shfaq mesazh konfirmimi, mund ta ruash në DB më vonë
    $success = "Thank you, ".htmlspecialchars($name)."! Your message has been sent successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us - SnowLine Escape</title>
<style>
body {
    font-family: Arial, sans-serif;
    margin:0;
    background: #f0f4f8;
    color:#333;
}
nav {
    background:#0d3b66;
    padding:12px;
    text-align:center;
}
nav a {
    color:#fff;
    margin:0 12px;
    text-decoration:none;
    font-weight:bold;
}
nav a:hover {
    color:#ff6b6b;
}
.container {
    max-width:500px;
    margin:60px auto;
    padding:30px;
    background:#fff;
    border-radius:15px;
    box-shadow:0 8px 20px rgba(0,0,0,0.1);
}
h1 {
    text-align:center;
    color:#0d3b66;
    margin-bottom:20px;
}
input, textarea {
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:8px;
    font-size:14px;
}
button {
    background:#ff6b6b;
    color:#fff;
    border:none;
    padding:12px 20px;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}
button:hover {
    background:#e55a5a;
}
.success {
    background:#d4edda;
    color:#155724;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
    text-align:center;
    border:1px solid #c3e6cb;
}
</style>
</head>
<body>

<nav>
    <a href="index.php">Home</a>
    <a href="hotel.php">Hotel</a>
    <a href="news.php">News</a>
    <a href="products.php">Products</a>
    <a href="payments.php">Payments</a>
    <a href="contacts.php">Contact</a>
    <a href="logout.php">Logout</a>
</nav>

<div class="container">
    <h1>Contact Us</h1>

    <?php if($success): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" action="contacts.php">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <input type="text" name="subject" placeholder="Subject" required>
        <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
        <button type="submit">Send Message</button>
    </form>
</div>

</body>
</html>

