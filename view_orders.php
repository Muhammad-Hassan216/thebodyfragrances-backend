<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

$search = $_GET['search'] ?? '';

// ✅ Use correct table: order_items instead of order_details
$sql = "SELECT o.*, oi.product_name, oi.amount 
        FROM orders o
        LEFT JOIN order_items oi ON o.id = oi.order_id
        WHERE o.buyer LIKE '%$search%' 
           OR o.phone LIKE '%$search%' 
           OR oi.product_name LIKE '%$search%'
        ORDER BY o.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Orders</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h2 { color: #333; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        table th, table td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #f5f5f5; }
        form.inline { display: inline; }
        select { padding: 5px; }
        input[type="text"] { padding: 6px; width: 300px; }
        button { padding: 6px 10px; }
    </style>
</head>
<body>

<h2>📋 All Orders</h2>
<a href="dashboard.php">⬅ Back to Dashboard</a>

<!-- 🔍 Search Filter -->
<form method="get" style="margin-top: 15px;">
    <input type="text" name="search" placeholder="Search by buyer, phone or product" value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Search</button>
</form>

<!-- 📦 Orders Table -->
<table>
    <tr>
        <th>Order ID</th>
        <th>Buyer</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Address</th>
        <th>Product</th>
        <th>Qty</th>
        <th>Status</th>
        <th>Delete</th>
    </tr>
    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['buyer']) ?></td>
        <td><?= htmlspecialchars($row['phone']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= nl2br(htmlspecialchars($row['address'])) ?></td>
        <td><?= htmlspecialchars($row['product_name']) ?></td>
        <td><?= $row['amount'] ?></td>

        <!-- 🔄 Status Dropdown -->
        <td>
            <form method="post" action="update_order_status.php" class="inline">
                <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                <select name="status" onchange="this.form.submit()">
                    <option value="WAITING" <?= $row['status'] == 'WAITING' ? 'selected' : '' ?>>WAITING</option>
                    <option value="SHIPPED" <?= $row['status'] == 'SHIPPED' ? 'selected' : '' ?>>SHIPPED</option>
                    <option value="DELIVERED" <?= $row['status'] == 'DELIVERED' ? 'selected' : '' ?>>DELIVERED</option>
                </select>
            </form>
        </td>

        <!-- ❌ Delete -->
        <td>
            <form method="post" action="delete_order.php" class="inline" onsubmit="return confirm('Are you sure?');">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button type="submit">🗑 Delete</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
