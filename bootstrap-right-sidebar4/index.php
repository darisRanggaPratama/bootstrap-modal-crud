<?php
require_once 'config/database.php';

$db = new Database();
$conn = $db->conn;

// Proses Upload CSV
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

// Proses Download CSV
if (isset($_GET['download']) && $_GET['download'] == 'csv') {
    // Fetch all data
    $stmt = $conn->query("SELECT nim, nama, alamat, prodi FROM tmhs");
    $mahasiswa = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Nama file
    $filename = "mahasiswa_" . date('Ymd_His') . ".csv";
    
    // Headers untuk download file
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    // Buka output stream
    $fp = fopen('php://output', 'w');
    
    // Tulis header
    fputcsv($fp, ['NIM', 'Nama', 'Alamat', 'Prodi'], ';');
    
    // Tulis data
    foreach ($mahasiswa as $mhs) {
        fputcsv($fp, $mhs, ';');
    }
    
    fclose($fp);
    exit();
}

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search
$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchQuery = '';
if (!empty($search)) {
    $searchQuery = "WHERE nim LIKE '%$search%' OR nama LIKE '%$search%' OR alamat LIKE '%$search%' OR prodi LIKE '%$search%'";
}

// Total records
$totalQuery = $conn->query("SELECT COUNT(*) FROM tmhs $searchQuery")->fetchColumn();
$totalPages = ceil($totalQuery / $limit);

// Fetch data
$stmt = $conn->prepare("SELECT * FROM tmhs $searchQuery LIMIT :start, :limit");
$stmt->bindParam(':start', $start, PDO::PARAM_INT);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$mahasiswa = $stmt->fetchAll(PDO::FETCH_ASSOC);

$no = 1;

include 'includes/header.php';
?>

<div class="container mt-5">
    <h2>Data Mahasiswa</h2>      
    <!-- Download CSV Button -->
    <div class="mb-3">        
        <a href="pages/create.php" class="btn btn-success">ADD</a>
        <a href="?download=csv" class="btn btn-secondary">Export CSV</a>
    </div>    
    
    <!-- Search Form -->
    <form method="GET" class="mb-3">   
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari NIM, Nama, Alamat, Prodi" value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr><th>No</th>
                <th>NIM</th>
                <th>Edit</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Prodi</th>
                <th>Drop</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($mahasiswa as $mhs): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $mhs['nim'] ?></td>
                <td><a href="pages/update.php?id=<?= $mhs['id_mhs'] ?>" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></a></td>
                <td><?= $mhs['nama'] ?></td>
                <td><?= $mhs['alamat'] ?></td>
                <td><?= $mhs['prodi'] ?></td>
                <td>                    
                    <a href="pages/delete.php?id=<?= $mhs['id_mhs'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="fas fa-backspace"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= $search ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

    <!-- Upload CSV Form -->
    <div class="card mb-3">
        <div class="card-header">
            Import CSV
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
                <small class="text-muted">Format: NIM;Nama;Alamat;Prodi (Skip header baris pertama)</small>
            </form>
            <?php if(isset($uploadMessage)): ?>
                <div class="alert alert-info mt-2"><?= $uploadMessage ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php 
include 'includes/sidebar.php';
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/sidebar.js"></script>
</body>
</html>