<?php include 'db.php'; ?>
<form method="POST" action="">
  <input type="text" name="title" placeholder="Post Title" required><br>
  <textarea name="content" placeholder="Post Content" required></textarea><br>
  <button type="submit" name="submit">Add Post</button>
</form>

<?php
if (isset($_POST['submit'])) {
    $stmt = $pdo->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
    $stmt->execute([$_POST['title'], $_POST['content']]);
    header("Location: index.php");
}
?>
