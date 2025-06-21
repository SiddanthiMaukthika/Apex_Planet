<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>All Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

    <h2>All Posts</h2>
    <a class="btn btn-primary mb-3" href="add_posts.php">+ Add New Post</a>

    <!-- Search Bar -->
    <form method="GET" class="d-flex mb-3">
        <input class="form-control me-2" type="search" name="search" placeholder="Search posts..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>

    <?php
    // Pagination & Search Setup
    $limit = 5;
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $offset = ($page - 1) * $limit;
    $search = $_GET['search'] ?? '';
    $searchTerm = "%$search%";

    // Count total posts
    if ($search) {
        $countStmt = $pdo->prepare("SELECT COUNT(*) FROM posts WHERE title LIKE ? OR content LIKE ?");
        $countStmt->execute([$searchTerm, $searchTerm]);
    } else {
        $countStmt = $pdo->query("SELECT COUNT(*) FROM posts");
    }
    $totalPosts = $countStmt->fetchColumn();
    $totalPages = ceil($totalPosts / $limit);

    // Fetch posts for current page
    if ($search) {
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE ? OR content LIKE ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->bindValue(1, $searchTerm);
        $stmt->bindValue(2, $searchTerm);
        $stmt->bindValue(3, $limit, PDO::PARAM_INT);
        $stmt->bindValue(4, $offset, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Display Posts
    while ($row = $stmt->fetch()) {
        echo "<div class='card mb-3'>
                <div class='card-body'>
                    <h5 class='card-title'>" . htmlspecialchars($row['title']) . "</h5>
                    <p class='card-text'>" . nl2br(htmlspecialchars($row['content'])) . "</p>
                    <a href='edit_posts.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='delete_posts.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                </div>
              </div>";
    }

    // Pagination Links
    if ($totalPages > 1) {
        echo "<nav><ul class='pagination'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            $active = ($i == $page) ? "active" : "";
            echo "<li class='page-item $active'><a class='page-link' href='?page=$i&search=" . urlencode($search) . "'>$i</a></li>";
        }
        echo "</ul></nav>";
    }
    ?>

</div>
</body>
</html>
