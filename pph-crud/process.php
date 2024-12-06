<?php
// process.php
require_once 'database.php';
require_once 'functions.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'upload' && isset($_FILES['csvFile'])) {
            // Handle upload
            if ($_FILES['csvFile']['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['alert'] = displayAlert('danger', 'File upload failed');
                header('Location: index.php');
                exit;
            }

            $file = $_FILES['csvFile'];
            if (pathinfo($file['name'], PATHINFO_EXTENSION) !== 'csv') {
                $_SESSION['alert'] = displayAlert('danger', 'File must be a CSV');
                header('Location: index.php');
                exit;
            }

            try {
                $db = new Database();
                $conn = $db->getConnection();

                $handle = fopen($file['tmp_name'], 'r');

                // Skip header row
                fgetcsv($handle, 0, ';');

                $successCount = 0;
                $failCount = 0;

                while (($data = fgetcsv($handle, 0, ';')) !== false) {
                    if (count($data) !== 12) {
                        $failCount++;
                        continue;
                    }

                    $sql = "INSERT INTO upah (nik, name, gaji, hadir_pusat, hadir_proyek, konsumsi, 
                            lembur, tunjang_lain, jkk, jkm, sehat, ptkp) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                            ON DUPLICATE KEY UPDATE 
                            name=VALUES(name), gaji=VALUES(gaji), hadir_pusat=VALUES(hadir_pusat),
                            hadir_proyek=VALUES(hadir_proyek), konsumsi=VALUES(konsumsi),
                            lembur=VALUES(lembur), tunjang_lain=VALUES(tunjang_lain),
                            jkk=VALUES(jkk), jkm=VALUES(jkm), sehat=VALUES(sehat),
                            ptkp=VALUES(ptkp)";

                    $stmt = $conn->prepare($sql);

                    try {
                        $stmt->execute([
                            trim($data[0]),  // nik
                            trim($data[1]),  // name
                            (int)$data[2],   // gaji
                            (int)$data[3],   // hadir_pusat
                            (int)$data[4],   // hadir_proyek
                            (int)$data[5],   // konsumsi
                            (int)$data[6],   // lembur
                            (int)$data[7],   // tunjang_lain
                            (int)$data[8],   // jkk
                            (int)$data[9],   // jkm
                            (int)$data[10],  // sehat
                            trim($data[11])  // ptkp
                        ]);
                        $successCount++;
                    } catch (PDOException $e) {
                        $failCount++;
                    }
                }

                fclose($handle);

                $_SESSION['alert'] = displayAlert(
                    'success',
                    "Upload completed: $successCount records successful, $failCount records failed"
                );

            } catch (Exception $e) {
                $_SESSION['alert'] = displayAlert('danger', 'Database error: ' . $e->getMessage());
            }

        } elseif ($_POST['action'] === 'download') {
            // Redirect to dedicated download handler
            header('Location: download.php');
            exit;
        }
    }
}

header('Location: index.php');
exit;
?>

