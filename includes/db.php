<?php
class db {
    protected $connection;

    function setconnection() {
        // Railway provides MYSQL* variables. Fall back to XAMPP defaults locally.
        $servername = getenv('MYSQLHOST') ?: 'localhost';
        $username = getenv('MYSQLUSER') ?: 'root';
        $password = getenv('MYSQLPASSWORD') ?: '';
        $database = getenv('MYSQLDATABASE') ?: 'lms';
        $port = (int) (getenv('MYSQLPORT') ?: 3306);

        $this->connection = new mysqli(
            $servername,
            $username,
            $password,
            $database,
            $port
        );

        if ($this->connection->connect_error) {
            error_log('Database connection failed: ' . $this->connection->connect_error);
            die('Database connection failed.');
        }

        $this->connection->set_charset('utf8mb4');
    }

    function getConnection() {
        return $this->connection;
    }

    function closeConnection() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
?>
