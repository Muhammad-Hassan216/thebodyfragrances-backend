<?php
// File: services/paymentNotify.php

include '../db.php';

// 1. Get all POST data
$data = $_POST;

// 2. Log raw IPN for debugging
file_put_contents("payfast_notification_log.txt", date("Y-m-d H:i:s") . "\n" . print_r($data, true) . "\n\n", FILE_APPEND);

// 3. Check required fields
if (!isset($data['m_payment_id']) || !isset($data['payment_status'])) {
    http_response_code(400);
    exit("Missing fields");
}

// 4. Only process if payment is complete
if ($data['payment_status'] !== 'COMPLETE') {
    http_response_code(200);
    exit("Ignored - Payment not completed");
}

// 5. Optional: Validate that the IPN is genuinely from PayFast
// -- This step is skipped for localhost/testing (recommended only in production with internet)
// -- For production: validate signature & post back to https://sandbox.payfast.co.za/eng/query/validate

$orderCode = $data['m_payment_id'];

// 6. Update order as Paid
$stmt = $conn->prepare("UPDATE orders SET status = 'Paid', payment_method = 'PayFast' WHERE code = ?");
$stmt->bind_param("s", $orderCode);
$stmt->execute();
$stmt->close();

// 7. Log success
file_put_contents("payfast_notification_log.txt", "✅ Order {$orderCode} marked as Paid\n", FILE_APPEND);

http_response_code(200); // Required
echo "OK";
?>
