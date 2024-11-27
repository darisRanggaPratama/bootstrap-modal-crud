<?php
// Proses Upload CSV
$db = new Database();
$conn = $db->conn;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file']['tmp_name'];

    if (($handle = fopen($file, 'r')) !== FALSE) {
        // Skip header row
        fgetcsv($handle, 1000, ';');

        // Prepare insert statement
        $stmt = $conn->prepare("INSERT INTO tmhs (nim, nama, alamat, prodi) VALUES (?, ?, ?, ?)");

        $successCount = 0;
        $errorCount = 0;

        while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
            try {
                // Pastikan data memiliki 4 kolom
                if (count($data) >= 4) {
                    $nim = trim($data[0]);
                    $nama = trim($data[1]);
                    $alamat = trim($data[2]);
                    $prodi = trim($data[3]);

                    // Cek apakah NIM sudah ada
                    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM tmhs WHERE nim = ?");
                    $checkStmt->execute([$nim]);

                    if ($checkStmt->fetchColumn() == 0) {
                        $stmt->execute([$nim, $nama, $alamat, $prodi]);
                        $successCount++;
                    } else {
                        $errorCount++;
                    }
                }
            } catch(PDOException $e) {
                $errorCount++;
            }
        }

        fclose($handle);

        $uploadMessage = "Upload selesai. Berhasil: $successCount, Gagal: $errorCount";
    }
}
?>
