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
$bookTitle = trim($_POST['bookTitle'] ?? '');

if ($isbn === '' || $bookTitle === '') {
    header("Location: student_dashboard.php?msg=Please+fill+in+fields");
    exit();
}

// Never trust the submitted book title. The ISBN is the primary key for books,
// so look up the real book record and use its stored title for the request.
$bookStmt = $conn->prepare("SELECT bookName, quantity FROM books WHERE ISBN = ? LIMIT 1");
$bookStmt->bind_param("s", $isbn);
$bookStmt->execute();
$book = $bookStmt->get_result()->fetch_assoc();
$bookStmt->close();

if (!$book) {
    $db->closeConnection();
    header("Location: student_dashboard.php?msg=Invalid+ISBN.+Book+not+found");
    exit();
}

if ((int) $book['quantity'] <= 0) {
    $db->closeConnection();
    header("Location: student_dashboard.php?msg=This+book+is+currently+unavailable");
    exit();
}

$correctBookTitle = $book['bookName'];

// If the form was altered or a mismatched title was submitted, reject it.
if (strcasecmp($bookTitle, $correctBookTitle) !== 0) {
    $db->closeConnection();
    header("Location: student_dashboard.php?msg=ISBN+and+book+name+do+not+match");
    exit();
}

$stmt = $conn->prepare("INSERT INTO requests(student_id,isbn,book_name,status) VALUES(?,?,?,'pending')");
$stmt->bind_param("sss", $studentID, $isbn, $correctBookTitle);
$ok = $stmt->execute();

$stmt->close();
$db->closeConnection();

header("Location: student_dashboard.php?msg=" . ($ok ? "Request+submitted" : "Error+submitting+request"));
exit();
?>
