<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

$order_count = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()['total'];
$product_count = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];
$category_count = $conn->query("SELECT COUNT(*) as total FROM categories")->fetch_assoc()['total'];
$news_count = $conn->query("SELECT COUNT(*) as total FROM news")->fetch_assoc()['total'];
$payfast_count = $conn->query("SELECT COUNT(*) as total FROM orders WHERE status='Paid'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - The Body Fragrances</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #222;
            color: white;
            padding: 20px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        header img {
            height: 50px;
        }
        header h1 {
            margin: 0;
            font-size: 24px;
        }
        .container {
            padding: 40px;
        }
        .summary {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 40px;
        }
        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            width: 220px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .card h3 {
            font-size: 28px;
            margin: 0;
            color: #333;
        }
        .card p {
            margin-top: 8px;
            color: #777;
        }
        .links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .links a {
            display: block;
            background-color: #fff;
            color: #007bff;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .links a:hover {
            background-color: #007bff;
            color: white;
        }
        .logout {
            color: #fff;
            font-size: 14px;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
    <div style="display: flex; align-items: center; gap: 20px;">
        <img src="logo.png" alt="Logo">
        <h1>The Body Fragrances - Admin Panel</h1>
    </div>
    <div>
        <p style="margin: 0; font-size: 14px;">Welcome, <?= htmlspecialchars($_SESSION['admin']) ?> | <a class="logout" href="logout.php">Logout</a></p>
    </div>
</header>

<div class="container">
    <div class="summary">
        <div class="card">
            <h3><?= $order_count ?></h3>
            <p>Total Orders</p>
        </div>
        <div class="card">
            <h3><?= $product_count ?></h3>
            <p>Total Products</p>
        </div>
        <div class="card">
            <h3><?= $category_count ?></h3>
            <p>Total Categories</p>
        </div>
        <div class="card">
            <h3><?= $news_count ?></h3>
            <p>Total News/Offers</p>
        </div>
        <div class="card">
            <h3><?= $payfast_count ?></h3>
            <p>PayFast Payments</p>
        </div>
    </div>

    <div class="links">
        <a href="add_category.php">➕ Add Category</a>
        <a href="view_categories.php">📂 View Categories</a>
        <a href="add_product.php">🧴 Add Product</a>
        <a href="view_products.php">📦 View Products</a>
        <a href="add_news.php">📰 Add News / Offer</a>
        <a href="view_news.php">📢 View News</a>
        <a href="view_orders.php">📋 View Orders</a>
        <a href="view_payfast_payments.php">💰 View PayFast Payments</a>
    </div>
</div>

</body>
</html>
