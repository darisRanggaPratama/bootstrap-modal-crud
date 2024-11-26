<?php
require_once 'config/database.php';

class CSVDownloader {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function downloadCSV() {
        try {
            $stmt = $this->db->query("SELECT nim, nama, alamat, prodi FROM tmhs");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Set headers untuk download
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="mahasiswa_export.csv"');

            // Buka output stream
            $output = fopen('php://output', 'w');
            
            // Tulis header
            fputcsv($output, ['NIM', 'Nama', 'Alamat', 'Prodi'], ';');

            // Tulis data
            foreach ($data as $row) {
                fputcsv($output, $row, ';');
            }

            fclose($output);
            exit();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}

// Proses download
$downloader = new CSVDownloader();
$downloader->downloadCSV();
?>