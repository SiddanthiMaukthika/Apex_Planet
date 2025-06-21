<?php
session_start();
include 'db.php';
?>

<form method="POST">
  <input type="text" name="username" required placeholder="Username"><br>
  <input type="password" name="password" required placeholder="Password"><br>
  <button type="submit" name="login">Login</button>
</form>

<?php
if (isset($_POST['login'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user'] = $user['username'];
        echo "Login successful!";
    } else {
        echo "Invalid credentials!";
    }
}
?>
