<?php
require_once __DIR__ . "/config/db.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>About</title>
</head>
<body>

<h1>About Us</h1>

<?php
$result = $conn->query("SELECT * FROM about");
while ($row = $result->fetch_assoc()) {
    echo "<h2>{$row['title']}</h2>";
    echo "<p>{$row['content']}</p>";
}
?>

</body>
</html>
