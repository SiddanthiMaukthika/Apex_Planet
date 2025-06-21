<?php include 'db.php'; ?>

<?php
$errors = [];

if (isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // ✅ Server-side validation
    if (empty($title)) {
        $errors[] = "Title is required.";
    } elseif (strlen($title) < 3) {
        $errors[] = "Title must be at least 3 characters.";
    }

    if (empty($content)) {
        $errors[] = "Content is required.";
    }

    if (count($errors) === 0) {
        // ✅ Insert into DB
        $stmt = $pdo->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $stmt->execute([$title, $content]);
        header("Location: index.php");
        exit;
    }
}
?>

<!-- ✅ Show errors if any -->
<?php if (!empty($errors)): ?>
    <div style="color:red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- ✅ Form with HTML5 client-side validation too -->
<form method="POST" action="">
  <input type="text" name="title" placeholder="Post Title" required minlength="3"><br><br>
  <textarea name="content" placeholder="Post Content" required></textarea><br><br>
  <button type="submit" name="submit">Add Post</button>
</form>
