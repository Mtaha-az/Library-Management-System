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

$stmt = $conn->prepare("SELECT request_id, student_id, isbn, book_name, status FROM requests WHERE student_id = ?");
$stmt->bind_param("s", $studentID);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Requests</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { text-align: center; margin-bottom: 20px; }
        .requests-container { width: 80%; max-width: 1200px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; }
        .book-box { flex: 0 0 40%; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); background-color: rgba(255,255,255,0.8); padding: 15px; margin-bottom: 10px; }
        .book-box p { margin-bottom: 10px; line-height: 1.5; }
        @media (max-width: 768px) { .book-box { flex: 0 0 100%; } }
        .error { color: red; text-align: center; margin-top: 10px; }
        button { display: block; margin: 20px auto; padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; }
    </style>
</head>
<body>
    <h1>Book Requests</h1>

    <?php if ($result->num_rows > 0): ?>
        <div class="requests-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="book-box">
                    <p><strong>Request ID:</strong> <?php echo htmlspecialchars($row['request_id']); ?></p>
                    <p><strong>Student ID:</strong> <?php echo htmlspecialchars($row['student_id']); ?></p>
                    <p><strong>ISBN:</strong> <?php echo htmlspecialchars($row['isbn']); ?></p>
                    <p><strong>Book Name:</strong> <?php echo htmlspecialchars($row['book_name']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($row['status']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="error">No book requests found.</p>
    <?php endif; ?>

    <?php $stmt->close(); $db->closeConnection(); ?>
    <button onclick="window.location.href='student_dashboard.php'">Back to Student Dashboard</button>
</body>
</html>