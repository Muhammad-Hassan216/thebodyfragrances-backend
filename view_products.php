<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

$sql = "SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        ORDER BY p.id DESC";

$result = $conn->query($sql);
?>

<h2>📦 All Products</h2>
<a href="dashboard.php">⬅ Back to Dashboard</a> | 
<a href="add_product.php">➕ Add Product</a>
<br><br>

<table border="1" cellpadding="10" cellspacing="0">
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Description</th>
    <th>Price</th>
    <th>Discount</th>
    <th>Stock</th>
    <th>Status</th>
    <th>Image</th>
    <th>Category</th>
    <th>Action</th>
  </tr>

  <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['description']) ?></td>
      <td><?= number_format($row['price'], 2) ?></td>
      <td><?= number_format($row['price_discount'], 2) ?></td>
      <td><?= $row['stock'] ?></td>
      <td><?= $row['status'] ?></td>
      <td>
        <?php if (!empty($row['image'])): ?>
          <img src="uploads/product/<?= $row['image'] ?>" width="80">
        <?php else: ?>
          No image
        <?php endif; ?>
      </td>
      <td><?= $row['category_name'] ?></td>
      <td>
        <a href="edit_product.php?id=<?= $row['id'] ?>">Edit</a> |
        <form method="post" action="delete_product.php" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <button type="submit">Delete</button>
        </form>
      </td>
    </tr>
  <?php } ?>
</table>
