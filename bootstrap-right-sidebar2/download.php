<?php
require_once 'config/database.php';

$db = new Database();
$conn = $db->getConnection();

// Prepare CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="mahasiswa_data.csv"');

// Open output stream
$fp = fopen('php://output', 'wb');

// Write headers
fputcsv($fp, ['NIM', 'Nama', 'Alamat', 'Prodi'], ';');

// Fetch and write data
$result = $conn->query("SELECT nim, nama, alamat, prodi FROM tmhs");
while ($row = $result->fetch_assoc()) {
    fputcsv($fp, $row, ';');
}

fclose($fp);
exit();
?>