<?php
// gjithmonë start session
session_start();

// include me path absolut (nuk prishet ma)
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/db.php';

// kontroll i thjeshtë nëse db s’është lidh
if (!isset($conn)) {
    die("Database connection error.");
}

// Produkte statike (për momentin)
$products = [
    [
        'name' => 'Ski Pass - Full Day',
        'price' => 50,
        'img' => 'images/ski_pass.jpg'
    ],
    [
        'name' => 'Snowboard Rental',
        'price' => 30,
        'img' => 'images/snowboard.jpg'
    ],
    [
        'name' => 'Winter Gloves',
        'price' => 15,
        'img' => 'images/gloves.jpg'
    ],
    [
        'name' => 'Mountain Photography Tour',
        'price' => 100,
        'img' => 'images/phototour.jpg'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Products - SnowLine Escape</title>

<style>
body {
    font-family: Arial, sans-serif;
    margin:0;
    background:#f0f4f8;
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
    max-width:1000px;
    margin:40px auto;
    padding:20px;
}
h1 {
    text-align:center;
    color:#0d3b66;
    margin-bottom:30px;
}
.cards {
    display:flex;
    flex-wrap:wrap;
    gap:20px;
    justify-content:center;
}
.card {
    background:#fff;
    border-radius:12px;
    padding:15px;
    width:220px;
    text-align:center;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
    transition:0.3s;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow:0 8px 20px rgba(0,0,0,0.15);
}
.card img {
    width:100%;
    border-radius:8px;
    margin-bottom:10px;
}
.card h3 {
    margin-bottom:10px;
    color:#0d3b66;
}
.card p {
    font-weight:bold;
    color:#ff6b6b;
    margin-bottom:10px;
}
.card button {
    background:#0d3b66;
    color:#fff;
    border:none;
    padding:8px 15px;
    border-radius:8px;
    cursor:pointer;
    transition:0.3s;
}
.card button:hover {
    background:#084175;
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
    <h1>Our Products</h1>

    <div class="cards">
        <?php foreach ($products as $prod): ?>
            <div class="card">
                <img src="<?= htmlspecialchars($prod['img']) ?>" alt="<?= htmlspecialchars($prod['name']) ?>">
                <h3><?= htmlspecialchars($prod['name']) ?></h3>
                <p>$<?= number_format($prod['price'], 2) ?></p>
                <button>Add to Cart</button>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
