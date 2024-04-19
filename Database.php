<?php
class Database {
    private $host = 'localhost'; 
    private $dbname = 'tms_db'; 
    private $username = 'root'; 
    private $password = ''; 
    private $conn;

    public function __construct() {
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

            // Check connection
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            // Handle the exception
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
