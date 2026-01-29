<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once __DIR__.'/classes/Auth.php';
$auth = new Auth();

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

$message='';

// LOGIN
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['login'])){
    $email=$_POST['email'] ?? '';
    $password=$_POST['password'] ?? '';
    if($auth->login($email,$password)){
        header("Location:index.php"); exit;
    } else {
        $message="Login failed!";
    }
}

// LOGOUT
if(isset($_GET['logout'])){
    session_destroy();
    header("Location:index.php"); exit;
}

// ADD PRODUCT (ADMIN)
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['add_product']) && $auth->isAdmin()){
    $name=$_POST['name'] ?? '';
    $desc=$_POST['description'] ?? '';
    $price=$_POST['price'] ?? 0;

    // ✅ Shtojmë parametër të katërt null për të shmangur errorin
    if(!$auth->addProduct($name, $desc, $price, null)){
        $message="Failed to add product!";
    }
}

// DELETE PRODUCT
if(isset($_GET['delete_product']) && $auth->isAdmin()){
    $auth->deleteProduct((int)$_GET['delete_product']);
    header("Location:index.php"); exit;
}

// ADD USER
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['add_user']) && $auth->isAdmin()){
    $name=$_POST['name'] ?? '';
    $email=$_POST['email'] ?? '';
    $password=$_POST['password'] ?? '';
    $role=$_POST['role'] ?? 'user';

    if(!$auth->addUser($name,$email,$password,$role)){
        $message="Failed to add user!";
    }
}

// DELETE USER
if(isset($_GET['delete_user']) && $auth->isAdmin()){
    $auth->deleteUser((int)$_GET['delete_user']);
    header("Location:index.php"); exit;
}

$loggedIn = $auth->isLoggedIn();
$products = $loggedIn ? $auth->getProducts() : [];
$users = ($loggedIn && $auth->isAdmin()) ? $auth->getUsers() : [];
?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<style>
body{font-family:sans-serif;background:#f0f2f5;margin:0}
.container{max-width:1200px;margin:20px auto;padding:20px}
.card{background:#fff;padding:15px;border-radius:10px;box-shadow:0 4px 8px rgba(0,0,0,.1)}
.cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:20px}
.price{color:green;font-weight:bold}
.logout{background:red;color:#fff;padding:8px 12px;text-decoration:none;border-radius:5px}
.del{color:red;font-size:12px;text-decoration:none}
form{background:#fff;padding:15px;border-radius:10px;margin:20px 0}
input,textarea,select,button{width:100%;padding:8px;margin-bottom:10px}
</style>
</head>
<body>
<div class="container">

<?php if(!$loggedIn): ?>
    <h2>Login</h2>
    <?php if($message) echo "<p>$message</p>"; ?>
    <form method="POST">
        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Password">
        <button name="login">Login</button>
    </form>

<?php else: ?>
    <h2>Welcome <?= htmlspecialchars($auth->getUserName()) ?> (<?= $_SESSION['user_role'] ?>)</h2>
    <a href="?logout=1" class="logout">Logout</a>

    <h3>Products</h3>
    <div class="cards">
        <?php foreach($products as $p): ?>
        <div class="card">
            <h4><?= htmlspecialchars($p['name']) ?></h4>
            <p><?= htmlspecialchars($p['description']) ?></p>
            <p class="price">$<?= number_format($p['price'],2) ?></p>
            <?php if($auth->isAdmin()): ?>
                <a class="del" href="?delete_product=<?= $p['id'] ?>">Delete</a>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if($auth->isAdmin()): ?>
    <form method="POST">
        <h3>Add Product</h3>
        <input type="text" name="name" required placeholder="Name">
        <textarea name="description" placeholder="Description"></textarea>
        <input type="number" step="0.01" name="price" required placeholder="Price">
        <button name="add_product">Add</button>
    </form>

    <h3>Users</h3>
    <div class="cards">
        <?php foreach($users as $u): ?>
        <div class="card">
            <h4><?= htmlspecialchars($u['name']) ?></h4>
            <p><?= htmlspecialchars($u['email']) ?></p>
            <p>Role: <?= $u['role'] ?></p>
            <a class="del" href="?delete_user=<?= $u['id'] ?>">Delete</a>
        </div>
        <?php endforeach; ?>
    </div>

    <form method="POST">
        <h3>Add User</h3>
        <input name="name" required placeholder="Name">
        <input type="email" name="email" required placeholder="Email">
        <input name="password" required placeholder="Password">
        <select name="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button name="add_user">Add User</button>
    </form>
    <?php endif; ?>

<?php endif; ?>

</div>
</body>
</html>
