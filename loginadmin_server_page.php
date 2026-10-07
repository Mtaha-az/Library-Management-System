<?php
include("data_class.php");

$admin_email = trim($_POST['admin_email1'] ?? '');
$admin_password_reg = $_POST['admin_password_reg1'] ?? '';

if ($admin_email === '' || $admin_password_reg === '') {
    header("Location:index.php?msg=Please+enter+email+and+password");
    exit();
}

$obj = new data();
$obj->setconnection();
$obj->adminlogin($admin_email, $admin_password_reg);
?>