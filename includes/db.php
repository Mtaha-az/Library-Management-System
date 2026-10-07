<?php
class db {
    protected $connection;

    function setconnection() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "lms";

        $this->connection = new mysqli($servername, $username, $password, $database);

        if ($this->connection->connect_error) {
            die("Database connection failed.");
        }

        $this->connection->set_charset("utf8mb4");
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