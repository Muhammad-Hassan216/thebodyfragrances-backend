<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

if (!isset($_GET['id'])) {
    echo "Invalid category ID.";
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$category = $stmt->get_result()->fetch_assoc();
?>

<h2>✏️ Edit Category</h2>
<a href="view_categories.php">⬅ Back to Categories</a>
<br><br>

<form method="post" action="update_category.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $category['id'] ?>">

    <label>Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" required><br><br>

    <label>Current Image:</label><br>
    <?php if (!empty($category['image'])): ?>
        <img src="uploads/category/<?= htmlspecialchars($category['image']) ?>" width="100"><br>
    <?php endif; ?>
    <label>Change Image (optional):</label><br>
    <input type="file" name="image"><br><br>

    <label>Color (e.g. #FF5733):</label><br>
    <input type="text" name="color" value="<?= htmlspecialchars($category['color']) ?>" required><br><br>

    <label>Brief:</label><br>
    <textarea name="brief" rows="3"><?= htmlspecialchars($category['brief']) ?></textarea><br><br>

    <button type="submit">Update Category</button>
</form>
