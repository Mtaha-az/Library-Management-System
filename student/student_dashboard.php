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

$stmt = $conn->prepare("SELECT studentID, studentName, studentEmail, degree FROM students WHERE studentID = ? LIMIT 1");
$stmt->bind_param("s", $studentID);
$stmt->execute();
$result = $stmt->get_result();

$student_info = null;
if ($result && $result->num_rows > 0) {
    $student_info = $result->fetch_assoc();
}

$stmt->close();
$db->closeConnection();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: linear-gradient(to bottom, #ffffff, #f0f0f0); min-height: 100vh; display: flex; flex-direction: column; align-items: center; }
        .dashboard-container { width: 80%; max-width: 800px; margin-top: 40px; }
        h1 { text-align: center; margin-bottom: 20px; }
        .buttons-container { text-align: center; margin-bottom: 20px; }
        button { padding: 10px 15px; margin: 5px; cursor: pointer; background-color: #007bff; color: #fff; border: none; border-radius: 4px; font-size: 14px; }
        button:hover { background-color: #0056b3; }
        .section { display: none; margin: 0 auto 20px auto; background-color: #fff; width: 100%; max-width: 500px; border: 1px solid #ccc; border-radius: 5px; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .section h2 { text-align: center; margin-bottom: 15px; }
        form { display: flex; flex-direction: column; gap: 10px; }
        label { font-weight: bold; }
        input[type="text"], input[type="email"] { padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
        p { margin: 10px 0; }
        .error { color: red; text-align: center; }
    </style>
    <script>
        function showSection(sectionID) {
            document.getElementById('student-section').style.display = 'none';
            document.getElementById('search-book-section').style.display = 'none';
            document.getElementById('book-request-section').style.display = 'none';
            document.getElementById(sectionID).style.display = 'block';
        }

        window.onload = function() {
            showSection('student-section');
        }
    </script>
</head>
<body>
    <div class="dashboard-container">
        <h1>Student Dashboard</h1>

        <div class="buttons-container">
            <button onclick="showSection('student-section')">Student</button>
            <button onclick="showSection('search-book-section')">Search Book</button>
            <button onclick="showSection('book-request-section')">Book Request</button>
            <button onclick="window.location.href='logout.php'">Logout</button>
        </div>

        <div class="section" id="student-section">
            <h2>Student Details</h2>
            <?php if ($student_info): ?>
                <p><strong>ID:</strong> <?php echo htmlspecialchars($student_info['studentID']); ?></p>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($student_info['studentName']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($student_info['studentEmail']); ?></p>
                <p><strong>Degree:</strong> <?php echo htmlspecialchars(strtoupper($student_info['degree'])); ?></p>
            <?php else: ?>
                <p class="error">Could not find student details.</p>
            <?php endif; ?>
        </div>

        <div class="section" id="search-book-section">
            <h2>Search Book</h2>
            <form method="post" action="searchBook.php">
                <label for="bookName">Book Name:</label>
                <input type="text" name="bookName" id="bookName" required>
                <button type="submit">Search</button>
            </form>
        </div>

        <div class="section" id="book-request-section">
            <h2>Book Request</h2>
            <form method="post" action="requestBook.php">
                <label for="isbn">ISBN:</label>
                <input type="text" name="isbn" id="isbn" required>

                <label for="bookTitle">Book Name:</label>
                <input type="text" name="bookTitle" id="bookTitle" required>

                <button type="submit">Request</button>
                <button type="button" onclick="window.location.href='bookforrequest.php'">My Requests</button>
            </form>
        </div>
    </div>
</body>
</html>