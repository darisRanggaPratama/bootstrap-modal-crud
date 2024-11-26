<?php
require_once 'config/database.php';

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csvfile'])) {
    $file = $_FILES['csvfile'];
    
    // Check if file is a CSV
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($file_ext != 'csv') {
        die("Only CSV files are allowed");
    }

    // Open and read CSV file
    $handle = fopen($file['tmp_name'], 'r');
    
    // Skip the first line (header)
    fgetcsv($handle, 0, ';');

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO tmhs (nim, nama, alamat, prodi) VALUES (?, ?, ?, ?)");

    while (($data = fgetcsv($handle, 0, ';')) !== FALSE) {
        $nim = $data[0];
        $nama = $data[1];
        $alamat = $data[2];
        $prodi = $data[3];

        $stmt->bind_param("ssss", $nim, $nama, $alamat, $prodi);
        $stmt->execute();
    }

    $stmt->close();
    fclose($handle);

    header("Location: index.php?upload=success");
    exit();
}
?>