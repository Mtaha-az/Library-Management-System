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

$adminID = (int)$_SESSION["adminsid"];

$stmt = $conn->prepare("SELECT ID, admin_email, admin_name FROM admins WHERE ID = ? LIMIT 1");
$stmt->bind_param("i", $adminID);
$stmt->execute();
$result = $stmt->get_result();

$admin_info = null;
if ($result && $result->num_rows > 0) {
    $admin_info = $result->fetch_assoc();
}

$stmt->close();
$db->closeConnection();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f9; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh; }
        h1 { margin-bottom: 20px; color: #333; }
        .buttons-container { margin-bottom: 20px; display: flex; justify-content: center; flex-wrap: wrap; }
        button { padding: 10px 20px; margin: 5px; border: none; background-color: #007bff; color: white; border-radius: 5px; cursor: pointer; font-size: 14px; }
        button:hover { background-color: #0056b3; }
        .section { display: none; margin-top: 20px; border: 1px solid #ccc; background-color: #fff; padding: 20px; width: 100%; max-width: 500px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .section h2 { margin-top: 0; color: #007bff; text-align: center; }
        .form-group { margin-bottom: 15px; display: flex; flex-direction: column; align-items: center; }
        label { margin-bottom: 5px; font-weight: bold; font-size: 14px; text-align: center; }
        input[type="text"], input[type="email"], input[type="number"], input[type="password"], select { width: 80%; max-width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 5px; }
        .submit-btn { padding: 10px 20px; border: none; background-color: #28a745; color: white; border-radius: 5px; cursor: pointer; font-size: 14px; display: block; margin: 0 auto; }
        .submit-btn:hover { background-color: #218838; }
        p { text-align: center; font-size: 14px; }
        .admin-details { text-align: center; font-size: 14px; }
        .form-group, .section { margin-left: auto; margin-right: auto; }
    </style>
    <script>
        function showSection(sectionID) {
            document.getElementById('admin-section').style.display = 'none';
            document.getElementById('add-book-section').style.display = 'none';
            document.getElementById('add-student-section').style.display = 'none';
            document.getElementById(sectionID).style.display = 'block';
        }

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

    <div class="section" id="admin-section">
        <h2>Admin Details</h2>
        <?php if ($admin_info): ?>
            <div class="admin-details">
                <p><strong>ID:</strong> <?php echo htmlspecialchars($admin_info['ID']); ?></p>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($admin_info['admin_name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($admin_info['admin_email']); ?></p>
            </div>
        <?php else: ?>
            <p style="color: red;">Could not find admin details.</p>
        <?php endif; ?>
    </div>

    <div class="section" id="add-book-section">
        <h2>Add Book</h2>
        <form method="post" action="addBook.php">
            <div class="form-group"><label for="ISBN">Book ISBN:</label><input type="text" name="ISBN" id="ISBN" required></div>
            <div class="form-group"><label for="bookName">Book Name:</label><input type="text" name="bookName" id="bookName" required></div>
            <div class="form-group"><label for="authorName">Author Name:</label><input type="text" name="authorName" id="authorName" required></div>
            <div class="form-group"><label for="price">Price (USD):</label><input type="number" name="price" id="price" min="0" required></div>
            <div class="form-group"><label for="quantity">Quantity:</label><input type="number" name="quantity" id="quantity" min="0" required></div>
            <button class="submit-btn" type="submit">Add Book</button>
        </form>
    </div>

    <div class="section" id="add-student-section">
        <h2>Add Student</h2>
        <form method="post" action="addStudent.php">
            <div class="form-group"><label for="studentName">Name:</label><input type="text" name="studentName" id="studentName" required></div>
            <div class="form-group"><label for="studentID">ID:</label><input type="text" name="studentID" id="studentID" required></div>
            <div class="form-group"><label for="studentEmail">Email:</label><input type="email" name="studentEmail" id="studentEmail" required></div>
            <div class="form-group"><label for="studentPassword">Password:</label><input type="password" name="studentPassword" id="studentPassword" required></div>
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