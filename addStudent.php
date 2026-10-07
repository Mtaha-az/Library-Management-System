<?php
session_start();

// 1) Ensure only a logged-in admin can use this page
if (!isset($_SESSION["adminsid"])) {
    header("Location: index.php?msg=Please+log+in+as+Admin");
    exit();
}

// 2) Include your DB class and establish a connection
require_once 'db.php';
$db = new db();
$db->setconnection();
$conn = $db->getConnection();

// 3) Retrieve form POST data
$studentName     = $_POST['studentName'];
$studentID       = $_POST['studentID'];        // or roll number, etc.
$studentEmail    = $_POST['studentEmail'];
$studentPassword = $_POST['studentPassword'];
$degree          = $_POST['degree'];

// 4) Validate the inputs (basic checks)
if (empty($studentName) || empty($studentID) || empty($studentEmail) || 
    empty($studentPassword) || empty($degree)) {
    // Redirect with error if any required field is empty
    header("Location: admin_service_dashboard.php?msg=All+fields+are+required");
    exit();
}

// 5) Optionally validate email format
if (!filter_var($studentEmail, FILTER_VALIDATE_EMAIL)) {
    header("Location: admin_service_dashboard.php?msg=Invalid+email+address");
    exit();
}

// 6) Hash the password (using MD5 here, but consider stronger options in production)
$hashedPassword = md5($studentPassword);

// 7) Build the INSERT query (adjust column names based on your table structure)
$sql = "INSERT INTO students (studentID, studentName, studentEmail,studentPassword,degree)
        VALUES ('$studentID', '$studentName', '$studentEmail', '$hashedPassword', '$degree')";

// 8) Execute the query
if ($conn->query($sql) === TRUE) {
    // Success: redirect back to dashboard with a success message
    header("Location: admin_service_dashboard.php?msg=Student+added+successfully");
    exit();
} else {
    // Error: redirect back with an error message
    header("Location: admin_service_dashboard.php?msg=Error+adding+student");
    exit();
}

// 9) Close the connection (optional)
$db->closeConnection();
?>