<?php
class db{
    protected $connection;
    function setconnection(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "lms";
        try {
            $this->connection = new mysqli($servername, $username, $password, $database);
            // echo"connection done";
        }catch(Exception $e){
            if ($this->connection->connect_error) {
                die("Connection failed: " . $this->connection->connect_error);
            }
        }
    }
    function getConnection() {
        return $this->connection;
    }

    function closeConnection() {
        $this->connection->close();
    }
}
?>