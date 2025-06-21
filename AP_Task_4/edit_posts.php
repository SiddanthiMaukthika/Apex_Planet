<?php
include 'db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

$errors = [];

if (isset($_POST['update'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // ✅ Server-side validation
    if (empty($title)) {
        $errors[] = "Title is required.";
    } elseif (strlen($title) < 3) {
        $errors[] = "Title must be at least 3 characters.";
    }

    if (empty($content)) {
        $errors[] = "Content cannot be empty.";
    }

    if (count($errors) === 0) {
        // ✅ Update the post
        $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $stmt->execute([$title, $content, $id]);
        header("Location: index.php");
        exit;
    }
}
?>

<!-- ✅ Show any errors -->
<?php if (!empty($errors)): ?>
    <div style="color:red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- ✅ Edit Form with client-side validation -->
<form method="POST">
  <input type="text" name="title" value="<?= htmlspecialchars($_POST['title'] ?? $post['title']) ?>" required minlength="3"><br><br>
  <textarea name="content" required><?= htmlspecialchars($_POST['content'] ?? $post['content']) ?></textarea><br><br>
  <button type="submit" name="update">Update</button>
</form>
