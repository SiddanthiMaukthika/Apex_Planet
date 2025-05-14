<?php include 'db.php'; ?>
<h2>All Posts</h2>
<a href="add_posts.php">+ Add New Post</a><br><br>

<?php
$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
while ($row = $stmt->fetch()) {
    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
    echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
    echo "<a href='edit_posts.php?id=" . $row['id'] . "'>Edit</a> | ";
    echo "<a href='delete_posts.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a><hr>";
}
?>
