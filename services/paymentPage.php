<?php
// File: services/paymentPage.php

include '../db.php';

$code = $_GET['code'] ?? '';
if (!$code) {
    echo "❌ Invalid or missing payment code.";
    exit();
}

// Fetch the order
$stmt = $conn->prepare("SELECT * FROM orders WHERE code = ?");
$stmt->bind_param("s", $code);
$stmt->execute();
$orderResult = $stmt->get_result();

if ($orderResult->num_rows === 0) {
    echo "❌ No order found for this code.";
    exit();
}

$order = $orderResult->fetch_assoc();
$stmt->close();

// PayFast Sandbox Details
$merchant_id = "10040222";
$merchant_key = "931zodg52magy";
$return_url = "http://192.168.10.12/thebodyfragrances/services/paymentSuccess.php";
$cancel_url = "http://192.168.10.12/thebodyfragrances/services/paymentCancel.php";
$notify_url = "http://192.168.10.12/thebodyfragrances/services/paymentNotify.php";

// Force credit card page instead of wallet funds
$data = [
    'merchant_id'     => $merchant_id,
    'merchant_key'    => $merchant_key,
    'return_url'      => $return_url,
    'cancel_url'      => $cancel_url,
    'notify_url'      => $notify_url,
    'amount'          => number_format($order['total_fees'], 2, '.', ''),
    'item_name'       => "Order #" . $order['id'] . " - " . $order['buyer'],
    'name_first'      => $order['buyer'],
    'email_address'   => $order['email'],
    'm_payment_id'    => $order['code'], // ✅ Unique order code to trace it later
    'payment_method'  => 'cc' // 👈 Force credit card test page
];

// Redirect user to PayFast
$query = http_build_query($data);
header("Location: https://sandbox.payfast.co.za/eng/process?" . $query);
exit();
?>
