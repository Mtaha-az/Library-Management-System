<?php
session_start();
require_once __DIR__ . '/db.php';

class data extends db {
    function __construct() {}

    function adminlogin($email, $password) {
        $stmt = $this->connection->prepare("SELECT ID, admin_password_reg FROM admins WHERE admin_email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($row && password_verify($password, $row["admin_password_reg"])) {
            session_regenerate_id(true);
            $_SESSION["adminsid"] = $row["ID"];
            unset($_SESSION["studentsid"]);
            header("Location: ../admin/admin_service_dashboard.php");
            exit();
        }

        header("Location: ../index.php?msg=Invalid+login");
        exit();
    }

    function studentLogin($ID, $password) {
        $stmt = $this->connection->prepare("SELECT studentID, studentPassword FROM students WHERE studentID = ? LIMIT 1");
        $stmt->bind_param("s", $ID);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($row && password_verify($password, $row["studentPassword"])) {
            session_regenerate_id(true);
            $_SESSION["studentsid"] = $row["studentID"];
            unset($_SESSION["adminsid"]);
            header("Location: ../student/student_dashboard.php");
            exit();
        }

        header("Location: ../index.php?msg=Invalid+Student+Login");
        exit();
    }
}
?>