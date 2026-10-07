<?php
session_start();

if (!isset($_SESSION["adminsid"])) {
    header("Location: index.php?msg=Please+log+in+as+Admin");
    exit();
}

require_once 'db.php';
$db = new db();
$db->setconnection();
$conn = $db->getConnection();

$ISBN = trim($_POST['ISBN'] ?? '');
$bookName = trim($_POST['bookName'] ?? '');
$authorName = trim($_POST['authorName'] ?? '');
$price = (int)($_POST['price'] ?? 0);
$quantity = (int)($_POST['quantity'] ?? 0);

if ($ISBN === '' || $bookName === '' || $authorName === '' || $price < 0 || $quantity < 0) {
    header("Location: admin_service_dashboard.php?msg=Invalid+book+details");
    exit();
}

$stmt = $conn->prepare("INSERT INTO books (ISBN, bookName, authorName, price, quantity) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssii", $ISBN, $bookName, $authorName, $price, $quantity);

if ($stmt->execute()) {
    header("Location: admin_service_dashboard.php?msg=Book+Added");
} else {
    header("Location: admin_service_dashboard.php?msg=Error+Adding+Book");
}

$stmt->close();
$db->closeConnection();
exit();
?>