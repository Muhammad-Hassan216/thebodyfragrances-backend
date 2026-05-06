<?php
header('Content-Type: application/json');
include '../db.php';

// How many products to return (default 100)
$count = isset($_GET['count']) ? intval($_GET['count']) : 100;

// Fetch products with category name
$sql = "SELECT p.*, c.name as category_name FROM products p 
        JOIN categories c ON p.category_id = c.id 
        ORDER BY p.id DESC LIMIT $count";

$result = $conn->query($sql);
$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = [
        'id' => (int)$row['id'],
        'name' => htmlspecialchars($row['name']),
        'description' => htmlspecialchars($row['description']),
        'price' => (float)$row['price'],
        'price_discount' => (float)$row['price_discount'],
        'stock' => (int)$row['stock'],
        'status' => $row['status'],
        'category_id' => (int)$row['category_id'],
        'category_name' => $row['category_name'],
        'image' => $row['image'],
        'image_url' => "http://localhost/thebodyfragrances/uploads/product/" . $row['image']
    ];
}

echo json_encode([
    'status' => 'success',
    'products' => $products
]);
?>
