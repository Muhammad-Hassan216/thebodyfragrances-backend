<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid news ID.";
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$news = $stmt->get_result()->fetch_assoc();
?>

<h2>✏️ Edit News</h2>
<a href="view_news.php">⬅ Back to News</a><br><br>

<form method="post" action="update_news.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $news['id'] ?>">

    <label>Title:</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($news['title']) ?>" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="4" required><?= htmlspecialchars($news['description']) ?></textarea><br><br>

    <label>Current Image:</label><br>
    <img src="uploads/news/<?= $news['image'] ?>" width="120"><br><br>

    <label>Change Image (optional):</label><br>
    <input type="file" name="image" accept="image/*"><br><br>

    <button type="submit">Update News</button>
</form>
