<?php include 'db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();
?>

<form method="POST">
  <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>"><br>
  <textarea name="content"><?= htmlspecialchars($post['content']) ?></textarea><br>
  <button type="submit" name="update">Update</button>
</form>

<?php
if (isset($_POST['update'])) {
    $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
    $stmt->execute([$_POST['title'], $_POST['content'], $id]);
    header("Location: index.php");
}
?>
