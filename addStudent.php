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

$studentName = trim($_POST['studentName'] ?? '');
$studentID = trim($_POST['studentID'] ?? '');
$studentEmail = trim($_POST['studentEmail'] ?? '');
$studentPassword = $_POST['studentPassword'] ?? '';
$degree = trim($_POST['degree'] ?? '');

if ($studentName === '' || $studentID === '' || $studentEmail === '' || $studentPassword === '' || $degree === '') {
    header("Location: admin_service_dashboard.php?msg=All+fields+are+required");
    exit();
}

if (!filter_var($studentEmail, FILTER_VALIDATE_EMAIL)) {
    header("Location: admin_service_dashboard.php?msg=Invalid+email+address");
    exit();
}

$hashedPassword = password_hash($studentPassword, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO students (studentID, studentName, studentEmail, studentPassword, degree) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $studentID, $studentName, $studentEmail, $hashedPassword, $degree);

if ($stmt->execute()) {
    header("Location: admin_service_dashboard.php?msg=Student+added+successfully");
} else {
    header("Location: admin_service_dashboard.php?msg=Error+adding+student");
}

$stmt->close();
$db->closeConnection();
exit();
?>