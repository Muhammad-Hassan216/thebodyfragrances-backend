// ✅ edit_product.php
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

if (!isset($_GET['id'])) {
    echo "Invalid product ID.";
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

$categories = $conn->query("SELECT * FROM categories");
?>

<h2>Edit Product</h2>
<a href="view_products.php">⬅ Back to Products</a><br><br>

<form method="post" action="update_product.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $product['id'] ?>">

    <label>Name:</label><br>
    <input type="text" name="name" value="<?= $product['name'] ?>" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" required><?= $product['description'] ?></textarea><br><br>

    <label>Price:</label><br>
    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required><br><br>

    <label>Discount Price:</label><br>
    <input type="number" step="0.01" name="price_discount" value="<?= $product['price_discount'] ?>"><br><br>

    <label>Stock:</label><br>
    <input type="number" name="stock" value="<?= $product['stock'] ?>" required><br><br>

    <label>Status:</label><br>
    <select name="status">
        <option value="Available" <?= $product['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
        <option value="Out of Stock" <?= $product['status'] == 'Out of Stock' ? 'selected' : '' ?>>Out of Stock</option>
    </select><br><br>

    <label>Category:</label><br>
    <select name="category_id">
        <?php while ($cat = $categories->fetch_assoc()) { ?>
            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                <?= $cat['name'] ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Current Image:</label><br>
    <img src="uploads/product/<?= $product['image'] ?>" width="100"><br><br>

    <label>Change Image (optional):</label><br>
    <input type="file" name="image"><br><br>

    <button type="submit">Update Product</button>
</form>