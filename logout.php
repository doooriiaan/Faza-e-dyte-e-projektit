<?php
session_start();

// Fshini të gjitha session variables
session_unset();
session_destroy();

// Mesazhi që do të shfaqet
$message = "You have been successfully logged out.";

// Ridrejto pas 3 sekondash te login.php
header("Refresh: 3; URL=login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Logout - SnowLine Escape</title>
<style>
body {
    font-family: Arial, sans-serif;
    background:#f0f4f8;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    margin:0;
}
.message-box {
    background:#fff;
    padding:30px 50px;
    border-radius:12px;
    text-align:center;
    box-shadow:0 6px 20px rgba(0,0,0,0.1);
}
.message-box h1 {
    color:#0d3b66;
    margin-bottom:15px;
}
.message-box p {
    color:#333;
    font-size:16px;
}
</style>
</head>
<body>

<div class="message-box">
    <h1>Logged Out</h1>
    <p><?= htmlspecialchars($message) ?></p>
    <p>You will be redirected to the login page in 3 seconds...</p>
</div>

</body>
</html>
