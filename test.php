<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Target the order submission PHP script
$url = "http://localhost/thebodyfragrances/services/submitProductOrder.php";

// 🛒 Dummy test order data
$data = [
    "product_order" => [
        "address" => "123 Testing Street",
        "buyer" => "Test User",
        "comment" => "Test order from test.php",
        "created_at" => time(),
        "last_update" => time(),
        "date_ship" => time(),
        "email" => "testuser@example.com",
        "phone" => "03001234567",
        "serial" => "test_serial_code",
        "shipping" => "",
        "shipping_location" => "",
        "shipping_rate" => 0.0,
        "status" => "WAITING",
        "tax" => 11.0,
        "total_fees" => 999.99
    ],
    "product_order_detail" => [
        [
            "amount" => 2,
            "price_item" => 499.99,
            "product_id" => 101,
            "product_name" => "Test Product A"
        ],
        [
            "amount" => 1,
            "price_item" => 999.99,
            "product_id" => 102,
            "product_name" => "Test Product B"
        ]
    ]
];

// 🧠 cURL to send POST request
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Security: secure_code'
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
} else {
    echo "<h2>✅ Response from submitProductOrder.php:</h2>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
}

curl_close($ch);
?>
