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

$bookName = trim($_POST['bookName'] ?? '');

if ($bookName === '') {
    header("Location: student_dashboard.php?msg=No+book+name+provided");
    exit();
}

$searchTerm = "%" . $bookName . "%";
$stmt = $conn->prepare("SELECT ISBN, bookName, authorName, price, quantity FROM books WHERE LOWER(bookName) LIKE LOWER(?)");
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { text-align: center; margin-bottom: 20px; }
        .book-box { border: 1px solid #ccc; border-radius: 8px; padding: 15px; margin: 0 auto 15px auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); background-color: #fff; max-width: 500px; }
        .error { color: red; text-align: center; }
        button { padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; display: block; margin: 20px auto; }
    </style>
</head>
<body>
    <h1>Search Results</h1>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="book-box">
                <p><strong>ISBN:</strong> <?php echo htmlspecialchars($row['ISBN']); ?></p>
                <p><strong>Book Name:</strong> <?php echo htmlspecialchars($row['bookName']); ?></p>
                <p><strong>Author Name:</strong> <?php echo htmlspecialchars($row['authorName']); ?></p>
                <p><strong>Price:</strong> <?php echo htmlspecialchars($row['price']); ?></p>
                <p><strong>Quantity:</strong> <?php echo htmlspecialchars($row['quantity']); ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="error">Book is not available.</p>
    <?php endif; ?>

    <?php $stmt->close(); $db->closeConnection(); ?>
    <button onclick="window.location.href='student_dashboard.php'">Back to Dashboard</button>
</body>
</html>