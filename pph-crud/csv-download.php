<?php
session_start();

// csv-download.php - buat file baru terpisah
require_once 'database.php';
require_once 'functions.php';

try {
    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT nik, name, gaji, hadir_pusat, hadir_proyek, konsumsi, 
            lembur, tunjang_lain, jkk, jkm, sehat, bruto, rate, pph, ptkp, hrf 
            FROM view_pph 
            ORDER BY nik";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        $_SESSION['alert'] = displayAlert('warning', 'No data available to download');
        header('Location: home.php');
        exit;
    }

    // Disable any previous output
    ob_clean();

    // Set headers for CSV download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="upah_data_' . date('Y-m-d') . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Create output handle
    $output = fopen('php://output', 'w');

    // Add UTF-8 BOM for Excel compatibility
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

    // Write headers
    $headers = ['nik', 'name', 'gaji', 'hadir_pusat', 'hadir_proyek', 'konsumsi',
        'lembur', 'tunjang_lain', 'jkk', 'jkm', 'sehat', 'bruto', 'rate', 'pph', 'ptkp', 'hrf'];
    fputcsv($output, $headers, ';');

    // Write data rows
    $successCount = 0;
    foreach ($results as $row) {
        if (fputcsv($output, array_values($row), ';') !== false) {
            $successCount++;
        }
    }

    // Close the output stream
    fclose($output);
    exit;

} catch (Exception $e) {
    $_SESSION['alert'] = displayAlert('danger', 'Download error: ' . $e->getMessage());
    header('Location: home.php');
    exit;
}
?>

