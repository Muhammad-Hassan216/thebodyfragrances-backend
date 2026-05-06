<h2>Add New Product</h2>
<a href="dashboard.php">⬅ Back</a><br><br>

<form method="post" action="save_product.php" enctype="multipart/form-data">
  <label>Name:</label><br>
  <input type="text" name="name" required><br><br>

  <label>Description:</label><br>
  <textarea name="description" required></textarea><br><br>

  <label>Price:</label><br>
  <input type="number" step="0.01" name="price" required><br><br>

  <label>Discount Price:</label><br>
  <input type="number" step="0.01" name="price_discount"><br><br>

  <label>Stock:</label><br>
  <input type="number" name="stock" required><br><br>

  <label>Status:</label><br>
  <select name="status">
    <option value="Available">Available</option>
    <option value="Out of Stock">Out of Stock</option>
  </select><br><br>

  <label>Category:</label><br>
  <select name="category_id" required>
    <?php
    include 'db.php';
    $cats = $conn->query("SELECT * FROM categories");
    while ($cat = $cats->fetch_assoc()) {
      echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
    }
    ?>
  </select><br><br>

  <label>Image:</label><br>
  <input type="file" name="image" accept="image/*" required><br><br>

  <button type="submit">Add Product</button>
</form>
