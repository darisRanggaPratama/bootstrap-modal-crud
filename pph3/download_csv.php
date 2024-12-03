<?php
// download_csv.php
require_once 'config/database.php';

// Initialize database connection
$db = new Database();
$conn = $db->getConnection();

try {
    // Query to fetch all records
    $stmt = $conn->query("SELECT nik, name, gaji, hadir_pusat, hadir_proyek, konsumsi, lembur, tunjang_lain, jkk, jkm, sehat, bruto, rate, pph, ptkp, hrf FROM view_pph");
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Set headers for file download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=upah_data_' . date('Y-m-d_H-i-s') . '.csv');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Open output stream
    $output = fopen('php://output', 'w');

    // Write CSV headers
    fputcsv($output, ['nik', 'name', 'gaji', 'hadir_pusat', 'hadir_proyek', 'konsumsi', 'lembur', 'tunjang_lain', 'jkk', 'jkm', 'sehat', 'bruto', 'rate', 'pph', 'ptkp', 'hrf'], ';');

    // Write data rows
    foreach ($records as $record) {
        fputcsv($output, [
            $record['nik'],
            $record['name'],
            $record['gaji'],
            $record['hadir_pusat'],
            $record['hadir_proyek'],
            $record['konsumsi'],
            $record['lembur'],
            $record['tunjang_lain'],
            $record['jkk'],
            $record['jkm'],
            $record['sehat'],
            $record['bruto'],
            $record['rate'],
            $record['pph'],
            $record['ptkp'],
            $record['hrf']
        ], ';');
    }

    fclose($output);
    exit();

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
