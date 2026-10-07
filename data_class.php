<?php
session_start();
include("db.php");
class data extends db{
    function __construct(){
       
    }
    function adminlogin($t1,$t2){

        $t2 = md5($t2); // Hash the password before checking
        $q="SELECT * FROM admins WHERE admin_email='$t1' AND admin_password_reg='$t2'";
        $recordSet = $this->connection->query($q);
        if ($recordSet->num_rows > 0) {
            $row = $recordSet->fetch_assoc(); // Fetch a single row as an associative array
            $logid = $row["ID"]; // Get the "id" field
            $_SESSION["adminsid"] = $logid; // Store it in the session
            header("Location: admin_service_dashboard.php?msg=");
            exit();
        }
        elseif($recordSet->num_rows<= 0)
        {
            header("Location:index.php?msg=Invalid login");
            exit();
        }
    }
    // Student Login
    function studentLogin($ID, $password) {
        // If you hashed the password in the DB as md5:
        $hashed = md5($password);

        $sql = "SELECT * FROM students WHERE studentID='$ID' AND studentPassword='$hashed'";
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION["studentsid"] = $row["studentID"];
            header("Location: student_dashboard.php?msg=WelcomeStudent");
            exit();
        } else {
            header("Location: index.php?msg=Invalid+Student+Login");
            exit();
        }
    }
}
?>