<?php
include("data_class.php");

$studentID = trim($_POST['studentID'] ?? '');
$studentPassword = $_POST['studentPassword'] ?? '';

if ($studentID === '' || $studentPassword === '') {
    header("Location: index.php?msg=Please+enter+both+student+ID+and+password");
    exit();
}

$obj = new data();
$obj->setconnection();
$obj->studentLogin($studentID, $studentPassword);
?>