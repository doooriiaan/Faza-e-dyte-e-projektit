<?php
session_start();
require_once 'db.php'; // lidhet me databazën

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Kontrollo në DB nëse email ekziston
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            // Login i suksesshëm
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            header("Location: index.php");
            exit;
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - SnowLine Escape</title>
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
.login-box {
    background:#fff;
    padding:40px 50px;
    border-radius:12px;
    box-shadow:0 6px 20px rgba(0,0,0,0.1);
    width:350px;
}
.login-box h1 {
    text-align:center;
    color:#0d3b66;
    margin-bottom:25px;
}
.login-box input {
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:8px;
    font-size:14px;
}
.login-box button {
    width:100%;
    padding:12px;
    background:#ff6b6b;
    color:#fff;
    border:none;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}
.login-box button:hover {
    background:#e55a5a;
}
.error {
    background:#f8d7da;
    color:#721c24;
    padding:10px;
    border-radius:6px;
    margin-bottom:15px;
    text-align:center;
    border:1px solid #f5c6cb;
}
</style>
</head>
<body>

<div class="login-box">
    <h1>Login</h1>
    <?php if($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
