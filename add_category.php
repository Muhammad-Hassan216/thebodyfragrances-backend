<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Category</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input, textarea { width: 300px; padding: 8px; margin-bottom: 10px; }
        label { display: block; margin-top: 10px; }
        button { padding: 10px 20px; }
    </style>
</head>
<body>

<h2>Add New Category</h2>
<a href="dashboard.php">⬅ Back to Dashboard</a>
<br><br>

<form method="post" action="save_category.php" enctype="multipart/form-data">
    <label>Category Name:</label>
    <input type="text" name="name" placeholder="Enter category name" required><br>

    <label>Select Icon Image:</label>
    <input type="file" name="image" required><br>

    <label>Color (e.g., #FF5733):</label>
    <input type="text" name="color" value="#FFFFFF" required><br>

    <label>Brief Description:</label>
    <textarea name="brief" placeholder="Write a short description..."></textarea><br>

    <button type="submit">Add Category</button>
</form>

</body>
</html>
