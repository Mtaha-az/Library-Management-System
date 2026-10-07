<?php
session_start();

// Check student
if (!isset($_SESSION["studentsid"])) {
    header("Location: index.php?msg=Please+log+in+as+Student");
    exit();
}

require_once 'db.php';
$db = new db();
$db->setconnection();
$conn = $db->getConnection();

$studentID = $_SESSION["studentsid"];
$isbn      = trim($_POST['isbn'] ?? '');
$bookTitle = trim($_POST['bookTitle'] ?? '');

if ($isbn === '' || $bookTitle === '') {
    header("Location: student_dashboard.php?msg=Please+fill+in+fields");
    exit();
}

// Suppose you have a 'requests' table with columns: request_id (PK), student_id, isbn, book_name, status
// We'll default status to 'pending'
$isbnEsc      = $conn->real_escape_string($isbn);
$bookTitleEsc = $conn->real_escape_string($bookTitle);

$sql = "INSERT INTO requests (student_id, isbn, book_name, status)
        VALUES ('$studentID', '$isbnEsc', '$bookTitleEsc', 'pending')";

if ($conn->query($sql) === TRUE) {
    header("Location: student_dashboard.php?msg=Request+submitted");
    exit();
} else {
    header("Location: student_dashboard.php?msg=Error+submitting+request");
    exit();
}
?>