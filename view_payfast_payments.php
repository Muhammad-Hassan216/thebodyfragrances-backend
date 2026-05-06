<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

// Fetch only PayFast payments with status Paid
$sql = "SELECT * FROM orders WHERE payment_method = 'PayFast' AND status = 'Paid' ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>PayFast Payments - Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:hover {
            background: #f1f1f1;
        }
        a.back {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 15px;
            background: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        a.back:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<h2>💰 PayFast Received Payments</h2>
<a href="dashboard.php" class="back">⬅ Back to Dashboard</a>

<table>
    <tr>
        <th>Order Code</th>
        <th>Buyer</th>
        <th>Total Amount</th>
        <th>Status</th>
        <th>Date</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= htmlspecialchars($row['code']) ?></td>
        <td><?= htmlspecialchars($row['buyer']) ?></td>
        <td>Rs. <?= number_format($row['total_fees'], 2) ?></td>
        <td><?= htmlspecialchars($row['status']) ?></td>
        <td><?= htmlspecialchars($row['created_at']) ?></td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
