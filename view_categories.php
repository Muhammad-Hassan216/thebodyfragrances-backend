<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';
$result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>

<h2>📂 All Categories</h2>
<a href="dashboard.php">⬅ Back to Dashboard</a> |
<a href="add_category.php">➕ Add New Category</a>
<br><br>

<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%;">
    <tr style="background-color: #f2f2f2;">
        <th>ID</th>
        <th>Name</th>
        <th>Image</th>
        <th>Color</th>
        <th>Brief</th>
        <th>Actions</th> <!-- Changed from Delete -->
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td>
                <?php if (!empty($row['image'])) { ?>
                    <img src="uploads/category/<?= htmlspecialchars($row['image']) ?>" width="80">
                <?php } else { echo "No Image"; } ?>
            </td>
            <td>
                <span style="background: <?= htmlspecialchars($row['color']) ?>; padding: 6px 12px; border-radius: 5px; color: #fff;">
                    <?= htmlspecialchars($row['color']) ?>
                </span>
            </td>
            <td><?= htmlspecialchars($row['brief']) ?></td>
            <td>
                <a href="edit_category.php?id=<?= $row['id'] ?>" style="margin-right: 10px;">✏️ Edit</a>
                <form method="post" action="delete_category.php" style="display:inline;" onsubmit="return confirm('Delete this category?');">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit">🗑 Delete</button>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>
