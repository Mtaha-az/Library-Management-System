<?php
session_start();
include("db.php");

class data extends db {
    function __construct() {
    }

    function adminlogin($email, $password) {
        $stmt = $this->connection->prepare("SELECT ID, admin_password_reg FROM admins WHERE admin_email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row && password_verify($password, $row["admin_password_reg"])) {
            $_SESSION["adminsid"] = $row["ID"];
            $stmt->close();
            header("Location: admin_service_dashboard.php?msg=");
            exit();
        }

        $stmt->close();
        header("Location: index.php?msg=Invalid+login");
        exit();
    }

    function studentLogin($ID, $password) {
        $stmt = $this->connection->prepare("SELECT studentID, studentPassword FROM students WHERE studentID = ? LIMIT 1");
        $stmt->bind_param("s", $ID);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row && password_verify($password, $row["studentPassword"])) {
            $_SESSION["studentsid"] = $row["studentID"];
            $stmt->close();
            header("Location: student_dashboard.php?msg=WelcomeStudent");
            exit();
        }

        $stmt->close();
        header("Location: index.php?msg=Invalid+Student+Login");
        exit();
    }
}
?>