<?php
require_once '../BackEnd/db.php';
?>
<!DOCTYPE html>
<html>
<head><title>About</title></head>
<body>
<?php include 'navbar.php'; ?>
<h1>About Our Hotel</h1>
<?php
$res = $conn->query("SELECT * FROM about");
while($row = $res->fetch_assoc()){
echo "<p>{$row['content']}</p>";
}
?>
</body>
</html>
