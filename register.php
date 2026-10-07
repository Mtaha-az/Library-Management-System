<?php
require_once 'db.php';

$db = new db();
$db->setconnection();
$conn = $db->getConnection();

$admin_name = trim($_POST['admin_name'] ?? '');
$admin_email = trim($_POST['admin_email'] ?? '');
$admin_password_reg = $_POST['admin_password_reg'] ?? '';
$admin_confirm_password = $_POST['admin_confirm_password'] ?? '';

if ($admin_name === '' || $admin_email === '' || $admin_password_reg === '') {
    header("Location: index.php?msg=All+fields+are+required");
    exit();
}

if (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
    header("Location: index.php?msg=Invalid+email+format");
    exit();
}

if (!preg_match('/@admin\.library$/', $admin_email)) {
    header("Location: index.php?msg=Invalid+email+domain");
    exit();
}

if ($admin_password_reg !== $admin_confirm_password) {
    header("Location: index.php?msg2=Passwords+do+not+match");
    exit();
}

$hashedPassword = password_hash($admin_password_reg, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO admins (admin_email, admin_name, admin_password_reg) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $admin_email, $admin_name, $hashedPassword);

if ($stmt->execute()) {
    header("Location: index.php?msg1=Registered+Successfully");
} else {
    header("Location: index.php?msg=Unable+to+register");
}

$stmt->close();
$db->closeConnection();
exit();
?>