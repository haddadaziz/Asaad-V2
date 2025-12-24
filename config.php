<?php
class Database {
    private $host = "localhost";
    private $db_name = "zoo_assad";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null; 
        $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        // configurer pour afficher les errerus
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $this->conn;
    }
}
?>