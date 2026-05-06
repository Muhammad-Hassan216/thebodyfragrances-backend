<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

// Get data from POST
$name = $_POST['name'] ?? '';
$color = $_POST['color'] ?? '#FFFFFF';
$brief = $_POST['brief'] ?? '';

// Handle image upload
$image = $_FILES['image']['name'] ?? '';
$tmp = $_FILES['image']['tmp_name'] ?? '';

if ($image && $tmp) {
    $folder = "uploads/category/" . $image;
    move_uploaded_file($tmp, $folder);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO categories (name, image, color, brief) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $image, $color, $brief);
    $stmt->execute();

    header("Location: view_categories.php");
    exit();
} else {
    echo "❌ Image upload failed or missing data.";
}
?>
