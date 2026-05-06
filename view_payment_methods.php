<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}
include 'db.php';

$result = $conn->query("SELECT * FROM payment_methods ORDER BY id DESC");
?>

<!-- HTML CONTENT as previously provided -->
