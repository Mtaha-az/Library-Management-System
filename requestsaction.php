<?php
session_start();

// Ensure only a logged-in admin can access
if (!isset($_SESSION["adminsid"])) {
    header("Location: index.php?msg=Please+log+in+as+Admin");
    exit();
}

// Include database connection
require_once 'db.php';
$db = new db();
$db->setconnection();
$conn = $db->getConnection();

// Handle status update request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['request_id']) && isset($_POST['status'])) {
    $request_id = (int)$_POST['request_id']; // Ensure it's an integer
    $status = $conn->real_escape_string($_POST['status']); // Escape input

    // Update the status in the database
    $sql = "UPDATE requests SET status='$status' WHERE request_id=$request_id";
    if ($conn->query($sql)) {
        $msg = "Status updated successfully!";
    } else {
        $msg = "Error updating status: " . $conn->error;
    }
}

/**
 * We now sort by whether the status is NOT Approved/Declined.
 * Rows with a status of (not Approved/Declined) will be sorted first (CASE -> 0).
 * Rows with Approved or Declined come after (CASE -> 1).
 */
$sql = "
    SELECT request_id, student_id, isbn, book_name, status
    FROM requests
    ORDER BY
        CASE WHEN status NOT IN ('Approved', 'Declined') THEN 0 ELSE 1 END,
        request_id ASC
";

$result = $conn->query($sql);

if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        /* Container for the requests */
        .requests-container {
            width: 80%;
            max-width: 1200px;
            margin: 0 auto;         /* Centers the container */
            display: flex;          /* Use Flex layout */
            flex-wrap: wrap;        /* Allow items to wrap to the next line */
            justify-content: center;/* Center items horizontally */
            gap: 20px;              /* Space between cards */
        }
        .book-box {
            /* ~2 cards per row on larger screens */
            flex: 0 0 45%;
            box-sizing: border-box;

            /* Spacing and styling */
            margin-bottom: 20px;
            padding: 15px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;

            /* Gradient background */
            background: linear-gradient(to bottom, #f9f9f9, #e9e9e9);

            /* Box shadow */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        /* Responsive behavior: on screens less than 768px wide, each card should be full width */
        @media (max-width: 768px) {
            .book-box {
                flex: 0 0 100%;
            }
        }
        .error {
            color: red;
            text-align: center;
        }
        .success {
            color: green;
            text-align: center;
        }
        .button {
            padding: 8px 12px;
            margin: 5px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
        }
        .approve {
            background-color: green;
            color: white;
        }
        .decline {
            background-color: red;
            color: white;
        }
        .status {
            font-weight: bold;
        }
        /* Back to Dashboard button */
        .back-btn {
            display: block;             /* Make the button appear on its own line */
            margin: 20px auto 0 auto;  /* Center the button below the requests */
            padding: 10px 20px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
        }
        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h1>Book Requests</h1>

<?php if (isset($msg)): ?>
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
                <p><strong>Status:</strong>
                    <span class="status"><?php echo htmlspecialchars($row['status']); ?></span>
                </p>

                <!-- Only show the Approve/Decline buttons if status is not Approved or Declined -->
                <?php if ($row['status'] !== 'Approved' && $row['status'] !== 'Declined'): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
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

<!-- Back to Dashboard button -->
<button class="back-btn" onclick="window.location.href='admin_service_dashboard.php'">Back to Dashboard</button>

<?php $conn->close(); ?>
</body>
</html>