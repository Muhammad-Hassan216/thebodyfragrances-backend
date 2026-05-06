<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

// Collect and sanitize form inputs
$name           = $_POST['name'] ?? '';
$description    = $_POST['description'] ?? '';
$price          = $_POST['price'] ?? 0;
$price_discount = $_POST['price_discount'] ?? 0;
$stock          = $_POST['stock'] ?? 0;
$status         = $_POST['status'] ?? 'Available';
$category_id    = $_POST['category_id'] ?? 0;

// Handle uploaded image
$image = $_FILES['image']['name'] ?? '';
$tmp   = $_FILES['image']['tmp_name'] ?? '';
$folder = "uploads/product/" . basename($image);

// ✅ Validate required fields
if (empty($name) || empty($description) || empty($price) || empty($image) || $category_id == 0) {
    echo "❌ Please fill all required fields.";
    exit();
}

// ✅ Move image to upload folder and insert into database
if (!empty($image)) {
    if (move_uploaded_file($tmp, $folder)) {

        // ✅ Insert product into DB
        $stmt = $conn->prepare("INSERT INTO products 
            (name, description, price, price_discount, stock, status, image, category_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssddiisi", $name, $description, $price, $price_discount, $stock, $status, $image, $category_id);
        $stmt->execute();
        $stmt->close();

        // ✅ Redirect to product listing
        header("Location: view_products.php");
        exit();
    } else {
        echo "❌ Failed to upload image.";
    }
} else {
    echo "❌ No image selected.";
}
?>
