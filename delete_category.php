<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

if (!isset($_POST['id'])) {
    echo "Invalid request.";
    exit();
}

$id = $_POST['id'];

// Use prepared statement for safety
$stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: view_categories.php");
    exit();
} else {
    echo "Failed to delete category. It may be in use by other data.";
}
?>
