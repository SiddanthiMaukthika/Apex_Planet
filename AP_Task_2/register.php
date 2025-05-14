<?php include 'db.php'; ?>
<form method="POST">
  <input type="text" name="username" placeholder="Username" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <button type="submit" name="register">Register</button>
</form>

<?php
if (isset($_POST['register'])) {
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$_POST['username'], $hash]);
    echo "User registered!";
}
?>
