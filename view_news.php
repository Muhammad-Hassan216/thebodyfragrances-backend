<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

// Fetch news entries
$result = $conn->query("SELECT * FROM news ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All News / Offers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f9f9f9;
        }
        h2 {
            color: #222;
        }
        a.button {
            display: inline-block;
            margin-right: 10px;
            margin-bottom: 15px;
            padding: 8px 15px;
            background: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        a.button:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: #fff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            vertical-align: top;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        img {
            width: 100px;
            border-radius: 5px;
        }
        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .btn-edit {
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-edit:hover {
            background-color: #218838;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<h2>📰 All News / Offers</h2>

<a href="dashboard.php" class="button">⬅ Back to Dashboard</a>
<a href="add_news.php" class="button">➕ Add News</a>

<?php if ($result->num_rows > 0): ?>
<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Image</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['title']) ?></td>
        <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
        <td>
            <?php if (!empty($row['image'])): ?>
                <img src="uploads/news/<?= htmlspecialchars($row['image']) ?>" alt="News Image">
            <?php else: ?>
                No Image
            <?php endif; ?>
        </td>
        <td><?= $row['created_at'] ?></td>
        <td class="actions">
            <a href="edit_news.php?id=<?= $row['id'] ?>" class="btn-edit">✏️ Edit</a>
            <form method="post" action="delete_news.php" onsubmit="return confirm('Delete this news item?');">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button type="submit" class="btn-delete">🗑️ Delete</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>
<?php else: ?>
    <p><strong>No news found.</strong></p>
<?php endif; ?>

</body>
</html>
