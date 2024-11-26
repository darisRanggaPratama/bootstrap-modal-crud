<?php
class Database {
    private $host = 'localhost';
    private $username = 'rangga';
    private $password = 'rangga';
    private $database = 'avengers';
    public $koneksi;

    public function __construct() {
        try {
            $this->koneksi = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
            $this->koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Koneksi gagal: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->koneksi;
    }
}