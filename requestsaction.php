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

$msg = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['request_id'], $_POST['status'])) {
    $request_id = (int)$_POST['request_id'];
    $status = $_POST['status'];

    if (!in_array($status, ['Approved', 'Declined'], true)) {
        $msg = "Invalid request status.";
    } else {
        $stmt = $conn->prepare("UPDATE requests SET status = ? WHERE request_id = ?");
        $stmt->bind_param("si", $status, $request_id);
        $stmt->execute();
        $msg = $stmt->affected_rows > 0 ? "Status updated successfully!" : "No request was updated.";
        $stmt->close();
    }
}

$sql = "SELECT request_id, student_id, isbn, book_name, status
        FROM requests
        ORDER BY CASE WHEN status NOT IN ('Approved', 'Declined') THEN 0 ELSE 1 END, request_id ASC";
$result = $conn->query($sql);

if (!$result) {
    die("Unable to load requests.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Requests</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { text-align: center; }
        .requests-container { width: 80%; max-width: 1200px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; }
        .book-box { flex: 0 0 45%; box-sizing: border-box; margin-bottom: 20px; padding: 15px; text-align: center; border: 1px solid #ccc; border-radius: 5px; background: linear-gradient(to bottom, #f9f9f9, #e9e9e9); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        @media (max-width: 768px) { .book-box { flex: 0 0 100%; } }
        .error { color: red; text-align: center; }
        .success { color: green; text-align: center; }
        .button { padding: 8px 12px; margin: 5px; cursor: pointer; border: none; border-radius: 4px; }
        .approve { background-color: green; color: white; }
        .decline { background-color: red; color: white; }
        .status { font-weight: bold; }
        .back-btn { display: block; margin: 20px auto 0 auto; padding: 10px 20px; cursor: pointer; background-color: #007bff; color: #fff; border: none; border-radius: 4px; text-decoration: none; text-align: center; }
    </style>
</head>
<body>
<h1>Book Requests</h1>

<?php if ($msg !== null): ?>
    <p class="success"><?php echo htmlspecialchars($msg); ?></p>
<?php endif; ?>

<div class="requests-container">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="book-box">
                <p><strong>Request ID:</strong> <?php echo htmlspecialchars($row['request_id']); ?></p>
                <p><strong>Student ID:</strong> <?php echo htmlspecialchars($row['student_id']); ?></p>
                <p><strong>ISBN:</strong> <?php echo htmlspecialchars($row['isbn']); ?></p>
                <p><strong>Book Name:</strong> <?php echo htmlspecialchars($row['book_name']); ?></p>
                <p><strong>Status:</strong> <span class="status"><?php echo htmlspecialchars($row['status']); ?></span></p>

                <?php if ($row['status'] !== 'Approved' && $row['status'] !== 'Declined'): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="request_id" value="<?php echo (int)$row['request_id']; ?>">
                        <button class="button approve" name="status" value="Approved">Approve</button>
                        <button class="button decline" name="status" value="Declined">Decline</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="error">No book requests found.</p>
    <?php endif; ?>
</div>

<button class="back-btn" onclick="window.location.href='admin_service_dashboard.php'">Back to Dashboard</button>

<?php $conn->close(); ?>
</body>
</html>