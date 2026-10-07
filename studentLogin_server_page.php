<?php
// login_server_page.php
include("data_class.php");

$studentID   = $_POST['studentID'];
$studentPassword = $_POST['studentPassword'];

// Basic empty check
if ($studentID=='null' || $studentPassword=='null') {
    header("Location: index.php?msg=Please+enter+both+email+and+password");
    exit();
}
else{
    // Create data object, set connection
$obj = new data();
$obj->setconnection();

// Attempt student login
$obj->studentLogin($studentID, $studentPassword);
}

?>