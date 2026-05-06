<?php
include 'db.php';

$title = $_POST['title'];
$description = $_POST['description'];

$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];
$folder = "uploads/news/" . $image;
move_uploaded_file($tmp, $folder);

$stmt = $conn->prepare("INSERT INTO news (title, description, image) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $title, $description, $image);
$stmt->execute();

header("Location: view_news.php");
