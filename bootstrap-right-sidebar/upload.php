<?php
require_once 'config/database.php';

class CSVUploader {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function uploadCSV($file) {
        try {
            $allowed = ['csv'];
            $filename = $file['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                throw new Exception('Invalid file type. Only CSV allowed.');
            }

            $handle = fopen($file['tmp_name'], 'r');
            
            // Skip the first line (header)
            fgetcsv($handle, 0, ';');

            $stmt = $this->db->prepare("INSERT INTO tmhs (nim, nama, alamat, prodi) VALUES (:nim, :nama, :alamat, :prodi)");

            while (($data = fgetcsv($handle, 0, ';')) !== FALSE) {
                $stmt->execute([
                    ':nim' => $data[0],
                    ':nama' => $data[1],
                    ':alamat' => $data[2],
                    ':prodi' => $data[3]
                ]);
            }

            fclose($handle);
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}

// Proses upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploader = new CSVUploader();
    if (isset($_FILES['csvFile']) && $uploader->uploadCSV($_FILES['csvFile'])) {
        echo "Upload berhasil!";
    } else {
        echo "Upload gagal!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload CSV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'sidebar.php'; ?>
    <div class="container mt-5">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Pilih File CSV</label>
                <input type="file" name="csvFile" class="form-control" accept=".csv">
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
</body>
</html>