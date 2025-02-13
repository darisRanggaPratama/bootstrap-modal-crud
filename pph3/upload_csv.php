<?php
session_start();
require_once 'config/database.php';

// Function to validate and sanitize CSV data
function validateCSVData($data) {
    $cleanData = [];

    // Validate NIK: must be unique and not empty
    if (empty($data['nik']) || strlen($data['nik']) > 10) {
        return null;
    }

    // Validate Name: required and max 50 characters
    if (empty($data['name']) || strlen($data['name']) > 50) {
        return null;
    }

    // Validate Gaji: must be a non-negative integer
    $gaji = filter_var($data['gaji'], FILTER_VALIDATE_INT);
    if ($gaji === false || $gaji < 0) {
        return null;
    }

    $hadir_pusat = filter_var($data['hadir_pusat'], FILTER_VALIDATE_INT);
    if ($hadir_pusat === false || $hadir_pusat < 0) {
        return null;
    }

    $hadir_proyek = filter_var($data['hadir_proyek'], FILTER_VALIDATE_INT);
    if ($hadir_proyek === false || $hadir_proyek < 0) {
        return null;
    }

    $konsumsi = filter_var($data['konsumsi'], FILTER_VALIDATE_INT);
    if ($konsumsi === false || $konsumsi < 0) {
        return null;
    }

    $lembur = filter_var($data['lembur'], FILTER_VALIDATE_INT);
    if ($lembur === false || $lembur < 0) {
        return null;
    }

    $tunjang_lain = filter_var($data['tunjang_lain'], FILTER_VALIDATE_INT);
    if ($tunjang_lain === false || $tunjang_lain < 0) {
        return null;
    }

    $jkk = filter_var($data['jkk'], FILTER_VALIDATE_INT);
    if ($jkk === false || $jkk < 0) {
        return null;
    }

    $jkm = filter_var($data['jkm'], FILTER_VALIDATE_INT);
    if ($jkm === false || $jkm < 0) {
        return null;
    }

    $sehat = filter_var($data['sehat'], FILTER_VALIDATE_INT);
    if ($sehat === false || $sehat < 0) {
        return null;
    }

    // Validate PTKP: must be a string max 5 characters
    if (strlen($data['ptkp']) > 5) {
        return null;
    }

    return [
        'nik' => trim($data['nik']),
        'name' => trim($data['name']),
        'gaji' => $gaji,
        'hadir_pusat' => $hadir_pusat,
        'hadir_proyek' => $hadir_proyek,
        'konsumsi' => $konsumsi,
        'lembur' => $lembur,
        'tunjang_lain' => $tunjang_lain,
        'jkk' => $jkk,
        'jkm' => $jkm,
        'sehat' => $sehat,
        'ptkp' => trim($data['ptkp']) ?: '-'
    ];
}

// Main upload handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if file was uploaded
    if (!isset($_FILES['csvFile']) || $_FILES['csvFile']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['upload_message'] = 'Error: No file uploaded or upload failed.';
        header('Location: index.php');
        exit();
    }

    $file = $_FILES['csvFile'];

    // Validate file type
    $allowedTypes = ['text/csv', 'application/csv', 'application/vnd.ms-excel'];
    if (!in_array($file['type'], $allowedTypes)) {
        $_SESSION['upload_message'] = 'Error: Invalid file type. Please upload a CSV file.';
        header('Location: index.php');
        exit();
    }

    // Attempt to open the file
    $handle = fopen($file['tmp_name'], 'r');
    if (!$handle) {
        $_SESSION['upload_message'] = 'Error: Could not read the uploaded file.';
        header('Location: index.php');
        exit();
    }

    // Initialize database connection
    $db = new Database();
    $conn = $db->getConnection();

    // Start transaction
    $conn->beginTransaction();

    try {
        // Prepare insert statement
        $stmt = $conn->prepare("INSERT INTO upah (nik, name, gaji, hadir_pusat, hadir_proyek, konsumsi, lembur, tunjang_lain, jkk, jkm, sehat, ptkp) 
VALUES (:nik, :name, :gaji, :hadir_pusat, :hadir_proyek, :konsumsi, :lembur, :tunjang_lain, :jkk, :jkm, :sehat, :ptkp) 
                                ON DUPLICATE KEY UPDATE 
                                name = VALUES(name), 
                                gaji = VALUES(gaji),
                                hadir_pusat = VALUES(hadir_pusat), 
                                hadir_proyek = VALUES(hadir_proyek), 
                                konsumsi = VALUES(konsumsi), 
                                lembur = VALUES(lembur), 
                                tunjang_lain = VALUES(tunjang_lain), 
                                jkk = VALUES(jkk), 
                                jkm = VALUES(jkm), 
                                sehat = VALUES(sehat),
                                ptkp = VALUES(ptkp)");

        // Skip header row
        fgetcsv($handle, 1000, ';');

        $successCount = 0;
        $skipCount = 0;

        // Process each row
        while (($data = fgetcsv($handle, 1000, ';')) !== false) {
            // Create associative array
            $rowData = [
                'nik' => $data[0] ?? '',
                'name' => $data[1] ?? '',
                'gaji' => $data[2] ?? '',
                'hadir_pusat' => $data[3] ?? '',
                'hadir_proyek' => $data[4] ?? '',
                'konsumsi' => $data[5] ?? '',
                'lembur' => $data[6] ?? '',
                'tunjang_lain' => $data[7] ?? '',
                'jkk' => $data[8] ?? '',
                'jkm' => $data[9] ?? '',
                'sehat' => $data[10] ?? '',
                'ptkp' => $data[11] ?? ''
            ];

            // Validate and sanitize data
            $cleanData = validateCSVData($rowData);

            if ($cleanData) {
                // Execute insert/update
                $stmt->execute([
                    ':nik' => $cleanData['nik'],
                    ':name' => $cleanData['name'],
                    ':gaji' => $cleanData['gaji'],
                    ':hadir_pusat' => $cleanData['hadir_pusat'],
                    ':hadir_proyek' => $cleanData['hadir_proyek'],
                    ':konsumsi' => $cleanData['konsumsi'],
                    ':lembur' => $cleanData['lembur'],
                    ':tunjang_lain' => $cleanData['tunjang_lain'],
                    ':jkk' => $cleanData['jkk'],
                    ':jkm' => $cleanData['jkm'],
                    ':sehat' => $cleanData['sehat'],
                    ':ptkp' => $cleanData['ptkp']
                ]);
                $successCount++;
            } else {
                $skipCount++;
            }
        }

        // Commit transaction
        $conn->commit();

        // Set success message
        $_SESSION['upload_message'] = "Upload successful. Added/Updated: $successCount rows. Skipped: $skipCount rows.";
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollBack();
        $_SESSION['upload_message'] = 'Error: ' . $e->getMessage();
    }

    // Close file handle
    fclose($handle);

    // Redirect back to index
    header('Location: index.php');
    exit();
} else {
    // Direct access protection
    $_SESSION['upload_message'] = 'Error: Invalid request method.';
    header('Location: index.php');
    exit();
}
?>

