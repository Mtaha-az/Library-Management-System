<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php
$msg="";
if(!empty($_REQUEST['msg'])){
    $msg=$_REQUEST['msg'];
 }
 $msg1="";
if(!empty($_REQUEST['msg1'])){
    $msg1=$_REQUEST['msg1'];
 }
 $msg2="";
if(!empty($_REQUEST['msg2'])){
    $msg2=$_REQUEST['msg2'];
 }
?>
    <!-- Student Login Page -->
    <div class="login-container" id="student-login" style="display: none;">
        <h1>Library Management System</h1>
        <h2>Student Login</h2>
        <form method="post" action="studentLogin_server_page.php">
            <div class="input-container">
                <img src="persons.jpg" alt="User Icon">
                <input type="text" placeholder="Student ID" required id="studentID" name="studentID">
            </div>
            <div class="input-container">
                <img src="lock.png" id="student-lock" alt="Password Icon">
                <input type="password" id="studentPassword" placeholder="Password" required name="studentPassword">
            </div>
            <div class="checkbox-container">
                <input type="checkbox" id="student-password-checkbox" onclick="togglePassword('student-password', 'student-lock')">
                <label for="student-password-checkbox">Show Password</label>
            </div>
            
            <button type="submit">Login</button>
        </form>
        <button onclick="showAdminLogin()">Admin Login</button>
    </div>

    <!-- Admin Login Page -->
    <div class="login-container" id="admin-login" >
        <div class="row" style="color: red"><h2><?php echo $msg?></h2></div>
        <div class="row" style="color: greenyellow"><h2><?php echo $msg1?></h2></div>
        <div class="row" style="color: red"><h2><?php echo $msg2?></h2></div>
        <h1>Library Management System</h1>
        <h2>Admin Login</h2>
        <form method="post" action="loginadmin_server_page.php">
            <div class="input-container">
                <img src="person.png" alt="User Icon">
                <input type="text" placeholder="Email" required name="admin_email1" id="admin_email1">
            </div>
            <div class="input-container">
                <img src="lock.png" id="admin-lock" alt="Password Icon">
                <input type="password" id="admin_password_reg1" placeholder="Password" required name="admin_password_reg1">
            </div>
            <div class="checkbox-container">
                <input type="checkbox" id="admin-password-checkbox" onclick="togglePassword('admin-password', 'admin-lock')">
                <label for="admin-password-checkbox">Show Password</label>
            </div>
            
            <button type="submit">Login</button>
        </form>
        <button onclick="showStudentLogin()">Student Login</button>

        <!-- Sign-up Link -->
        <p class="signup-text">Don't have an account? <a href="#" onclick="showAdminRegister()">Sign Up</a></p>
    </div>

    <!-- Admin Registration Page -->
    <div class="login-container" id="admin-register" style="display: none;">
        <h1>Library Management System</h1>
        <h2>Register Admin</h2>
        <form method="post" action="register.php">
            <div class="input-container">
                <img src="E1.jpg" alt="Email Icon">
                <input type="email" name="admin_email" id="admin_email" placeholder="Email" required oninput="validateEmail()">
            </div>
            <div id="email-error" style="color: red; display: none; font-size: 18px; margin-bottom: 10px;"></div>            
            <div class="input-container">
                <img src="person.png" alt="person Icon">
                <input type="text" name="admin_name" id="admin_name" placeholder="Name" required>
            </div>
            <div class="input-container">
                <img src="lock.png" alt="Lock Icon">
                <input type="password" name="admin_password_reg" id="admin_password_reg" placeholder="Password" required>
            </div>
            <div class="input-container">
                <img src="lock.png" alt="Lock Icon">
                <input type="password" name="admin_confirm_password" id="admin_confirm_password" placeholder="Confirm Password" required oninput="validatePassword()">
            </div>
            <div id="Pass-error" style="color: rgb(227, 193, 193); display: none; font-size: 18px;margin-bottom: 10px"></div>   
            <button type="submit">Register</button>
        </form>
        <button onclick="showAdminLogin()">Back to Login</button>
    </div>

    <script src="assets/js/script.js"></script>

</body>
</html>
