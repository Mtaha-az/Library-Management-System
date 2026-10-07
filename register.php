<?php
require_once 'db.php';
$db = new db();
$db->setconnection();
$conn = $db->getConnection();

$admin_name=$_POST['admin_name'];
$admin_email=$_POST['admin_email'];
$admin_password_reg=$_POST['admin_password_reg'];
$admin_confirm_password = $_POST['admin_confirm_password'];

// Validate email format and domain
if (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
    header("Location: index.php?msg=Invalid email format. Please use a valid email.");
    exit();
}
if (!preg_match('/@admin\.library$/', $admin_email)) {
    header("Location: index.php?msg=Invalid email domain.");
    exit();
}

// Validate passwords match
if ($admin_password_reg !== $admin_confirm_password) {
    header("Location: index.php?msg2=Passwords do not match. Please try again.");
    exit();
}

$admin_password_reg=md5($admin_password_reg);
$sql = "INSERT INTO admins(admin_email,admin_name,admin_password_reg)
       VALUES('$admin_email','$admin_name','$admin_password_reg')";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php?msg1=Registered Successfully");
    exit(); 
} else {
    header("Location: index.php?msg=Error: Unable to register. Please try again.");
}

$db->closeConnection();
?>