<?php
// Include db or data_class
require_once 'db.php';
$db = new db();
$db->setconnection();
$conn = $db->getConnection();

// Retrieve form POST data
$ISBN   = $_POST['ISBN'];
$bookName   = $_POST['bookName'];
$authorName = $_POST['authorName'];
$price      = $_POST['price'];
$quantity   = $_POST['quantity'];

// Insert into your books table
$insertSQL = "INSERT INTO books (ISBN,bookName, authorName,price, quantity)
              VALUES ('$ISBN','$bookName', '$authorName', '$price', '$quantity')";

if($conn->query($insertSQL) === TRUE) {
   // success message, then redirect back to dashboard or something
   header("Location: admin_service_dashboard.php?msg=Book+Added");
} else {
   header("Location: admin_service_dashboard.php?msg=Error+Adding+Book");
}
?>