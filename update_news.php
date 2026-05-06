<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Handle optional image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $folder = "uploads/news/" . basename($image);
        move_uploaded_file($tmp, $folder);

        // Update with image
        $stmt = $conn->prepare("UPDATE news SET title = ?, description = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $description, $image, $id);
    } else {
        // Update without changing image
        $stmt = $conn->prepare("UPDATE news SET title = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $description, $id);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: view_news.php");
    exit();
}
?>
