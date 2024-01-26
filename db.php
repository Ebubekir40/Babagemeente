<?php
class DBConnection {
    private $conn;

    public function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "gemeentebabalar";

        // Maak een databaseverbinding
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // Controleer de verbinding
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>