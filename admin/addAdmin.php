<?php
session_start();

if (!isset($_SESSION["adminsid"])) {
    header("Location: ../index.php?msg=Please+log+in+as+Admin");
    exit();
}

require_once __DIR__ . '/../includes/db.php';

$db = new db();
$db->setconnection();
$conn = $db->getConnection();

$name = trim($_POST['admin_name'] ?? '');
$email = trim($_POST['admin_email'] ?? '');
$password = $_POST['admin_password'] ?? '';
$confirm = $_POST['admin_confirm_password'] ?? '';

function backWithMessage($message) {
    header("Location: admin_service_dashboard.php?msg=" . urlencode($message));
    exit();
}

if ($name === '' || $email === '' || $password === '' || $confirm === '') {
    $db->closeConnection();
    backWithMessage('All admin fields are required');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@admin\.library$/i', $email)) {
    $db->closeConnection();
    backWithMessage('Admin email must end with @admin.library');
}

if (strlen($password) < 8) {
    $db->closeConnection();
    backWithMessage('Admin password must be at least 8 characters');
}

if ($password !== $confirm) {
    $db->closeConnection();
    backWithMessage('Admin passwords do not match');
}

$check = $conn->prepare("SELECT ID FROM admins WHERE admin_email = ? LIMIT 1");
$check->bind_param("s", $email);
$check->execute();
$exists = $check->get_result()->fetch_assoc();
$check->close();

if ($exists) {
    $db->closeConnection();
    backWithMessage('An admin with this email already exists');
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO admins(admin_email, admin_name, admin_password_reg) VALUES(?,?,?)");
$stmt->bind_param("sss", $email, $name, $hash);
$ok = $stmt->execute();
$stmt->close();
$db->closeConnection();

backWithMessage($ok ? 'Admin added successfully' : 'Unable to add admin');
?>
