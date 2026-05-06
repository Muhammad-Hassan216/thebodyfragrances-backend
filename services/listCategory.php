<?php
header('Content-Type: application/json');
include '../db.php';

$sql = "SELECT * FROM categories ORDER BY id DESC";
$result = $conn->query($sql);

$categories = [];

while ($row = $result->fetch_assoc()) {
    $categories[] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'icon' => $row['image'], // Android is expecting this as icon
        'color' => $row['color'] ?? '#FFFFFF', // fallback if not present
        'brief' => $row['brief'] ?? ''         // fallback if not present
    ];
}

echo json_encode([
    'status' => 'success',
    'categories' => $categories
]);
?>
