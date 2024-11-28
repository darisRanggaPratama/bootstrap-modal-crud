<?php
class Database {
    private $host = 'localhost';
    private $user = 'rangga';
    private $pass = 'rangga';
    private $db = 'avengers';
    
    public $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Koneksi database gagal: " . $e->getMessage());
        }
    }

    public function closeConnection() {
        $this->conn = null;
    }
}
?>