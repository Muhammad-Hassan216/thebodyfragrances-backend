// ✅ update_product.php
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$price_discount = $_POST['price_discount'];
$stock = $_POST['stock'];
$status = $_POST['status'];
$category_id = $_POST['category_id'];

if (!empty($_FILES['image']['name'])) {
    $image = basename($_FILES['image']['name']);
    $tmp = $_FILES['image']['tmp_name'];
    $folder = "uploads/product/" . $image;

    if (move_uploaded_file($tmp, $folder)) {
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, price_discount=?, stock=?, status=?, image=?, category_id=? WHERE id=?");
        $stmt->bind_param("ssddiisii", $name, $description, $price, $price_discount, $stock, $status, $image, $category_id, $id);
    } else {
        echo "❌ Failed to upload image.";
        exit();
    }
} else {
    $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, price_discount=?, stock=?, status=?, category_id=? WHERE id=?");
    $stmt->bind_param("ssddisii", $name, $description, $price, $price_discount, $stock, $status, $category_id, $id);
}

$stmt->execute();
$stmt->close();

header("Location: view_products.php");
exit();
?>