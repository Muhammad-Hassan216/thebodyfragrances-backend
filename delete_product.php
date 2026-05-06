
// ✅ delete_product.php
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';
$id = $_POST['id'];
$conn->query("DELETE FROM products WHERE id = $id");
header("Location: view_products.php");
?>