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

    // Validate PTKP: must be a string max 5 characters
    if (strlen($data['ptkp']) > 5) {
        return null;
    }

    return [
        'nik' => trim($data['nik']),
        'name' => trim($data['name']),
        'gaji' => $gaji,
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
        $stmt = $conn->prepare("INSERT INTO upah (nik, name, gaji, ptkp) VALUES (:nik, :name, :gaji, :ptkp) 
                                ON DUPLICATE KEY UPDATE 
                                name = VALUES(name), 
                                gaji = VALUES(gaji), 
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
                'ptkp' => $data[3] ?? ''
            ];

            // Validate and sanitize data
            $cleanData = validateCSVData($rowData);

            if ($cleanData) {
                // Execute insert/update
                $stmt->execute([
                    ':nik' => $cleanData['nik'],
                    ':name' => $cleanData['name'],
                    ':gaji' => $cleanData['gaji'],
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

