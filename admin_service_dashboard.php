<?php
session_start();

// 1) Ensure only logged-in admin can access.
if (!isset($_SESSION["adminsid"])) {
    header("Location: index.php?msg=Please+log+in+as+Admin");
    exit();
}

// 2) Include your DB or data_class to fetch admin details.
require_once 'db.php';
$db = new db();
$db->setconnection();
$conn = $db->getConnection();

// 3) Retrieve the current admin's info from database
$adminID = $_SESSION["adminsid"];
// Adjust column/table names as needed:
$sql = "SELECT ID, admin_email, admin_name 
        FROM admins 
        WHERE ID = '$adminID' 
        LIMIT 1";

$result = $conn->query($sql);

$admin_info = null;
if ($result && $result->num_rows > 0) {
    $admin_info = $result->fetch_assoc();
}

// 4) Close DB connection if you like (optional)
$db->closeConnection();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        /* Styling for centralizing and making the dashboard visually appealing */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .buttons-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        button {
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .section {
            display: none; /* Hidden by default */
            margin-top: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            padding: 20px;
            width: 100%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .section h2 {
            margin-top: 0;
            color: #007bff;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px;
            text-align: center;
        }

        input[type="text"], input[type="email"],
        input[type="number"], input[type="password"],
        select {
            width: 80%;
            max-width: 300px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .submit-btn {
            padding: 10px 20px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            display: block;
            margin: 0 auto;
        }

        .submit-btn:hover {
            background-color: #218838;
        }

        p {
            text-align: center;
            font-size: 14px;
        }

        /* Center-align admin details */
        .admin-details {
            text-align: center;
            font-size: 14px;
        }

        /* Align forms and sections in the center */
        .form-group,
        .section {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <script>
        // Simple function to toggle which section is visible
        function showSection(sectionID) {
            // Hide all sections
            document.getElementById('admin-section').style.display = 'none';
            document.getElementById('add-book-section').style.display = 'none';
            document.getElementById('add-student-section').style.display = 'none';

            // Show the chosen section
            document.getElementById(sectionID).style.display = 'block';
        }

        // On page load, show the "Admin" section by default
        window.onload = function() {
            showSection('admin-section');
        }
    </script>
</head>
<body>

    <h1>Admin Dashboard</h1>

    <div class="buttons-container">
        <button onclick="showSection('admin-section')">Admin</button>
        <button onclick="showSection('add-book-section')">Add Book</button>
        <button onclick="showSection('add-student-section')">Add Student</button>
        <button onclick="window.location.href='requestsaction.php'">Books Approval</button>
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>

    <!-- SECTION 1: ADMIN DETAILS -->
    <div class="section" id="admin-section">
        <h2>Admin Details</h2>
        <?php if($admin_info): ?>
            <div class="admin-details">
                <p><strong>ID:</strong> <?php echo $admin_info['ID']; ?></p>
                <p><strong>Name:</strong> <?php echo $admin_info['admin_name']; ?></p>
                <p><strong>Email:</strong> <?php echo $admin_info['admin_email']; ?></p>
            </div>
        <?php else: ?>
            <p style="color: red;">Could not find admin details.</p>
        <?php endif; ?>
    </div>

    <!-- SECTION 2: ADD BOOK -->
    <div class="section" id="add-book-section">
        <h2>Add Book</h2>
        <form method="post" action="addBook.php">
            <div class="form-group">
                <label for="ISBN">Book ISBN:</label>
                <input type="text" name="ISBN" id="ISBN" required>
            </div>
            <div class="form-group">
                <label for="bookName">Book Name:</label>
                <input type="text" name="bookName" id="bookName" required>
            </div>
            <div class="form-group">
                <label for="authorName">Author Name:</label>
                <input type="text" name="authorName" id="authorName" required>
            </div>
            <div class="form-group">
                <label for="price">Price (USD):</label>
                <input type="number" name="price" id="price" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" required>
            </div>
            <button class="submit-btn" type="submit">Add Book</button>
        </form>
    </div>

    <!-- SECTION 3: ADD STUDENT -->
    <div class="section" id="add-student-section">
        <h2>Add Student</h2>
        <form method="post" action="addStudent.php">
            <div class="form-group">
                <label for="studentName">Name:</label>
                <input type="text" name="studentName" id="studentName" required>
            </div>
            <div class="form-group">
                <label for="studentID">ID:</label>
                <input type="text" name="studentID" id="studentID" required>
            </div>
            <div class="form-group">
                <label for="studentEmail">Email:</label>
                <input type="email" name="studentEmail" id="studentEmail" required>
            </div>
            <div class="form-group">
                <label for="studentPassword">Password:</label>
                <input type="password" name="studentPassword" id="studentPassword" required>
            </div>
            <div class="form-group">
                <label for="degree">Degree:</label>
                <select name="degree" id="degree" required>
                    <option value="">-- Select Degree --</option>
                    <option value="bscs">BSCS</option>
                    <option value="bsai">BSAI</option>
                    <option value="bsit">BSIT</option>
                    <option value="bscys">BSCYS</option>
                    <option value="bsse">BSSE</option>
                </select>
            </div>
            <button class="submit-btn" type="submit">Add Student</button>
        </form>
    </div>

</body>
</html>