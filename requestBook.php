<?php
session_start();

if (!isset($_SESSION["studentsid"])) {
    header("Location: index.php?msg=Please+log+in+as+Student");
    exit();
}

require_once 'db.php';
$db = new db();
$db->setconnection();
$conn = $db->getConnection();

$studentID = $_SESSION["studentsid"];
$isbn = trim($_POST['isbn'] ?? '');
$bookTitle = trim($_POST['bookTitle'] ?? '');

if ($isbn === '' || $bookTitle === '') {
    header("Location: student_dashboard.php?msg=Please+fill+in+fields");
    exit();
}

$stmt = $conn->prepare("INSERT INTO requests (student_id, isbn, book_name, status) VALUES (?, ?, ?, 'pending')");
$stmt->bind_param("sss", $studentID, $isbn, $bookTitle);

if ($stmt->execute()) {
    header("Location: student_dashboard.php?msg=Request+submitted");
} else {
    header("Location: student_dashboard.php?msg=Error+submitting+request");
}

$stmt->close();
$db->closeConnection();
exit();
?>