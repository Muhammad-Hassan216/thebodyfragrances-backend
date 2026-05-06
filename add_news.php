<?php
session_start();
include 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
        $message = "❌ Please upload a valid image.";
    } else {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $folder = "uploads/news/" . basename($image);

        if (move_uploaded_file($tmp, $folder)) {
            // INSERT into database
            $stmt = $conn->prepare("INSERT INTO news (title, description, image) VALUES (?, ?, ?)");
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("sss", $title, $description, $image);

            if ($stmt->execute()) {
                $message = "✅ News added successfully.";
                // Optional: redirect to view page
                // header("Location: view_news.php");
                // exit();
            } else {
                $message = "❌ Failed to insert into database. Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $message = "❌ Failed to move uploaded image.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add News</title>
</head>
<body>
    <h2>📰 Add News</h2>
    <a href="dashboard.php">⬅ Back to Dashboard</a><br><br>

    <?php if (!empty($message)) echo "<p><strong>$message</strong></p>"; ?>

    <form method="post" enctype="multipart/form-data">
        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" rows="4" required></textarea><br><br>

        <label>Image:</label><br>
        <input type="file" name="image" accept="image/*" required><br><br>

        <button type="submit">Add News</button>
    </form>
</body>
</html>
