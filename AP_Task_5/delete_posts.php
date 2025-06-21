<?php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'db.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
$stmt->execute([$id]);
header("Location: index.php");
?>
