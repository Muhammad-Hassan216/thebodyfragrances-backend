<?php
header('Content-Type: application/json');
include '../db.php';

// Fetch featured news (or all news if no "featured" column)
$sql = "SELECT id, title, image FROM news ORDER BY id DESC LIMIT 10";
$result = $conn->query($sql);

$news = [];

while ($row = $result->fetch_assoc()) {
    $news[] = [
        'title' => $row['title'],
        'image' => $row['image']
    ];
}

echo json_encode([
    'status' => 'success',
    'news_infos' => $news
]);
