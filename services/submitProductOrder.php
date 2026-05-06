<?php
header('Content-Type: application/json');
include '../db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['product_order']) || !isset($data['product_order_detail'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data format']);
    exit;
}

$order = $data['product_order'];
$order_items = $data['product_order_detail'];

$order_code = 'ORD' . rand(1000, 9999);
$payment_method = 'PayFast'; // ✅ Hardcoded PayFast method

$stmt = $conn->prepare("INSERT INTO orders 
    (code, buyer, phone, address, email, comment, created_at, last_update, date_ship, serial, shipping, shipping_location, shipping_rate, status, tax, total_fees, payment_method) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("ssssssiiisssdddis",
    $order_code,
    $order['buyer'],
    $order['phone'],
    $order['address'],
    $order['email'],
    $order['comment'],
    $order['created_at'],
    $order['last_update'],
    $order['date_ship'],
    $order['serial'],
    $order['shipping'],
    $order['shipping_location'],
    $order['shipping_rate'],
    $order['status'],
    $order['tax'],
    $order['total_fees'],
    $payment_method
);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();

$itemStmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, price_item, amount) VALUES (?, ?, ?, ?, ?)");
foreach ($order_items as $item) {
    $itemStmt->bind_param("iisdi",
        $order_id,
        $item['product_id'],
        $item['product_name'],
        $item['price_item'],
        $item['amount']
    );
    $itemStmt->execute();
}
$itemStmt->close();

echo json_encode([
    'status' => 'success',
    'data' => [
        'code' => $order_code
    ]
]);
?>
