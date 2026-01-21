<?php
require_once __DIR__ . "/config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    $stmt = $conn->prepare("INSERT INTO contact_messages (name,email,message) VALUES (?,?,?)");
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact</title>
</head>
<body>

<h1>Contact Us</h1>

<form method="post">
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <textarea name="message" placeholder="Message" required></textarea><br>
    <button type="submit">Send</button>
</form>

</body>
</html>
