<?php
session_start();

if (!isset($_SESSION["studentsid"])) {
    header("Location: ../index.php?msg=Please+log+in+as+Student");
    exit();
}

require_once __DIR__ . '/../includes/db.php';

$db = new db();
$db->setconnection();
$conn = $db->getConnection();

$studentID = $_SESSION["studentsid"];
$isbn = trim($_POST['isbn'] ?? '');

if ($isbn === '') {
    $db->closeConnection();
    header("Location: student_dashboard.php?msg=Please+select+a+book");
    exit();
}

// ISBN is the only book value accepted from the request button.
// The title and availability are always read from the database.
$bookStmt = $conn->prepare("SELECT bookName, quantity FROM books WHERE ISBN = ? LIMIT 1");
$bookStmt->bind_param("s", $isbn);
$bookStmt->execute();
$book = $bookStmt->get_result()->fetch_assoc();
$bookStmt->close();

if (!$book) {
    $db->closeConnection();
    header("Location: student_dashboard.php?msg=Invalid+book+selection");
    exit();
}

if ((int) $book['quantity'] <= 0) {
    $db->closeConnection();
    header("Location: student_dashboard.php?msg=This+book+is+currently+unavailable");
    exit();
}

$bookTitle = $book['bookName'];

$stmt = $conn->prepare("INSERT INTO requests(student_id,isbn,book_name,status) VALUES(?,?,?,'pending')");
$stmt->bind_param("sss", $studentID, $isbn, $bookTitle);
$ok = $stmt->execute();

$stmt->close();
$db->closeConnection();

header("Location: bookforrequest.php?msg=" . ($ok ? "Request+submitted" : "Error+submitting+request"));
exit();
?>