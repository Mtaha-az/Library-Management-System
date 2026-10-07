<?php
session_start();

// Ensure only a logged-in student can access
if (!isset($_SESSION["studentsid"])) {
    header("Location: index.php?msg=Please+log+in+as+Student");
    exit();
}

// Include database connection
require_once 'db.php';
$db = new db();
$db->setconnection();
$conn = $db->getConnection();

// Escape student ID to prevent SQL injection
$studentID = $conn->real_escape_string($_SESSION["studentsid"]);

// Fetch requests for the logged-in student
$sql = "SELECT request_id, student_id, isbn, book_name, status 
        FROM requests 
        WHERE student_id = '$studentID'";
$result = $conn->query($sql);

// Debugging: Check if the query executed correctly
if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Requests</title>
    <style>
        /* Basic reset for margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        /* Title styling */
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Container for the request cards */
        .requests-container {
            width: 80%;
            max-width: 1200px;
            margin: 0 auto;               /* Center the container */
            display: flex;                /* Use flex layout */
            flex-wrap: wrap;              /* Allow wrapping for multiple rows */
            justify-content: center;      /* Center the cards */
            gap: 20px;                    /* Space between cards */
        }

        /* Each book request card */
        .book-box {
            flex: 0 0 40%;                /* ~2 cards per row on larger screens, narrower width */
            border: 1px solid #ccc;
            border-radius: 8px;           /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent background */
            padding: 15px;
            margin-bottom: 10px;          /* Extra spacing if needed */
            /* You could also center the text if desired:
               text-align: center;
            */
        }

        /* Increase spacing and change font inside each card */
        .book-box p {
            margin-bottom: 10px;          /* Space between lines */
            line-height: 1.5;            /* Increase line spacing */
            font-family: Georgia, serif; /* Example new font */
        }

        /* Responsive: on narrower screens, use full width */
        @media (max-width: 768px) {
            .book-box {
                flex: 0 0 100%;
            }
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        /* Button styling */
        button {
            display: block;               /* Make button appear on its own line */
            margin: 20px auto;            /* Center the button horizontally */
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        button:hover {
            background-color: #0056b3;
        }
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

    <?php $conn->close(); ?>

    <button onclick="window.location.href='requestBook.php'">Back to Request Book</button>
</body>
</html>