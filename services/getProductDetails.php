<?php
header('Content-Type: application/json');
include '../db.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Product ID is required']);
    exit;
}

$id = $_GET['id'];

// Fetch product from DB
$stmt = $conn->prepare("SELECT p.*, c.name as category_name 
                        FROM products p 
                        JOIN categories c ON p.category_id = c.id 
                        WHERE p.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $product = [
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

    echo json_encode(['status' => 'success', 'product' => $product]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Product not found']);
}
?>
