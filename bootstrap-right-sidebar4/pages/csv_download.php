<?php
// Proses Download CSV
$db = new Database();
$conn = $db->conn;
if (isset($_GET['download']) && $_GET['download'] == 'csv') {
    // Fetch all data
    $stmt = $conn->query("SELECT nim, nama, alamat, prodi FROM tmhs");
    $mahasiswa = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Nama file
    $filename = "mahasiswa_" . date('Ymd_His') . ".csv";

    // Headers untuk download file
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Buka output stream
    $fp = fopen('php://output', 'w');

    // Tulis header
    fputcsv($fp, ['NIM', 'Nama', 'Alamat', 'Prodi'], ';');

    // Tulis data
    foreach ($mahasiswa as $mhs) {
        fputcsv($fp, $mhs, ';');
    }

    fclose($fp);
    exit();
}
?>