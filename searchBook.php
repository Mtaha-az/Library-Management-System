<?php
session_start();

// Ensure student is logged in
if (!isset($_SESSION["studentsid"])) {
    header("Location: index.php?msg=Please+log+in+as+Student");
    exit();
}

// Include DB connection
require_once 'db.php';
$db = new db();
$db->setconnection();
$conn = $db->getConnection();

$bookName = trim($_POST['bookName'] ?? '');
if ($bookName === '') {
    header("Location: student_dashboard.php?msg=No+book+name+provided");
    exit();
}

// Case-insensitive search
$bookNameLower = strtolower($bookName);
$bookEsc       = $conn->real_escape_string($bookNameLower);

$sql = "SELECT ISBN, bookName, authorName, price, quantity
        FROM books
        WHERE LOWER(bookName) LIKE '%$bookEsc%'";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif; 
            margin: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .book-box {
            border: 1px solid #ccc;              /* A subtle border */
            border-radius: 8px;                  /* Rounded corners */
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Box shadow for depth */
            background-color: #fff;              /* White background for clarity */
            max-width: 500px;                    /* Optional max width */
            margin: 0 auto 15px auto;            /* Center the card and add spacing */
        }

        .error {
            color: red;
            text-align: center;
        }

        /* Style for the Back to Dashboard button */
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;           /* Force each button to be on its own line */
            margin: 20px auto;        /* Center the button */
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h1>Search Results</h1>
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="book-box">
                <p><strong>ISBN:</strong> <?php echo $row['ISBN']; ?></p>
                <p><strong>Book Name:</strong> <?php echo $row['bookName']; ?></p>
                <p><strong>Author Name:</strong> <?php echo $row['authorName']; ?></p>
                <p><strong>Price:</strong> <?php echo $row['price']; ?></p>
                <p><strong>Quantity:</strong> <?php echo $row['quantity']; ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="error">Book is not available.</p>
    <?php endif; ?>

    <?php $db->closeConnection(); ?>

    <button onclick="window.location.href='student_dashboard.php'">Back to Dashboard</button>

</body>
</html>