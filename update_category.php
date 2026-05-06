<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

$id    = $_POST['id'];
$name  = $_POST['name'];
$color = $_POST['color'];
$brief = $_POST['brief'];

$imageUpdated = false;
$image = '';

// ✅ Check if new image is uploaded
if (!empty($_FILES['image']['name'])) {
    $image = basename($_FILES['image']['name']);
    $tmp = $_FILES['image']['tmp_name'];
    $folder = "uploads/category/" . $image;

    if (move_uploaded_file($tmp, $folder)) {
        $imageUpdated = true;
    } else {
        echo "❌ Image upload failed.";
        exit();
    }
}

// ✅ Prepare SQL based on image update
if ($imageUpdated) {
    $stmt = $conn->prepare("UPDATE categories SET name=?, image=?, color=?, brief=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $image, $color, $brief, $id);
} else {
    $stmt = $conn->prepare("UPDATE categories SET name=?, color=?, brief=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $color, $brief, $id);
}

$stmt->execute();
$stmt->close();

// ✅ Redirect after success
header("Location: view_categories.php");
exit();
?>
