<?php include 'db.php'; ?>

<?php
$errors = [];

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // ✅ Server-side validation
    if (empty($username)) {
        $errors[] = "Username is required.";
    } elseif (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    // ✅ If no errors, proceed to register
    if (count($errors) === 0) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hash]);
        echo "<p style='color:green;'>User registered!</p>";
    }
}
?>

<!-- 🔴 Show validation errors -->
<?php if (!empty($errors)): ?>
    <div style="color:red;">
        <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- ✅ Registration Form with HTML5 validation -->
<form method="POST">
  <input type="text" name="username" placeholder="Username" required minlength="3"
         value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"><br><br>
  <input type="password" name="password" placeholder="Password" required minlength="6"><br><br>
  <button type="submit" name="register">Register</button>
</form>
