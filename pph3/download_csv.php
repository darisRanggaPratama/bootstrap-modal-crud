<?php
// download_csv.php
require_once 'config/database.php';

// Initialize database connection
$db = new Database();
$conn = $db->getConnection();

try {
    // Query to fetch all records
    $stmt = $conn->query("SELECT nik, name, gaji, ptkp FROM upah");
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Set headers for file download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=upah_data_' . date('Y-m-d_H-i-s') . '.csv');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Open output stream
    $output = fopen('php://output', 'w');

    // Write CSV headers
    fputcsv($output, ['NIK', 'Name', 'Gaji', 'PTKP'], ';');

    // Write data rows
    foreach ($records as $record) {
        fputcsv($output, [
            $record['nik'],
            $record['name'],
            $record['gaji'],
            $record['ptkp']
        ], ';');
    }

    fclose($output);
    exit();

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
