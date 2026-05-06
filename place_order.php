<?php
// place_order.php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $stmt = $conn->prepare("INSERT INTO orders (customer_name, contact, address, product_id, quantity, order_date) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssii", $customer_name, $contact, $address, $product_id, $quantity);
    $stmt->execute();

    echo "Order placed successfully!";
    exit();
}
?>

<h2>Place Order</h2>
<form method="POST" action="">
    <input type="text" name="customer_name" placeholder="Customer Name" required><br><br>
    <input type="text" name="contact" placeholder="Contact" required><br><br>
    <input type="text" name="address" placeholder="Address" required><br><br>
    <input type="number" name="product_id" placeholder="Product ID" required><br><br>
    <input type="number" name="quantity" placeholder="Quantity" required><br><br>
    <button type="submit">Place Order</button>
</form>
