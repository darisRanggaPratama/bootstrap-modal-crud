<?php
require_once 'config/database.php';

$db = new Database();
$conn = $db->conn;

// Proses Upload CSV
include 'pages/csv_upload.php';

// Proses Download CSV
include 'pages/csv_download.php';

// Pagination
$limit = 15;
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

<div class="container mt-1">
    <h2>Data Mahasiswa</h2>
    <!-- Dropdown Button -->
    <div class="button-group">
        <div class="col-md-1 text-md-end mt-3 mt-md-0">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle me-2" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li>
                        <a class="dropdown-item" href="pages/create.php">ADD</a></li>
                    <li>
                        <a class="dropdown-item" href="?download=csv">Export CSV</a></li>
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#importCSVModal">Import CSV</a></li>
                </ul>
            </div>
        </div>

        <!-- Search Form -->
        <form method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari NIM, Nama, Alamat, Prodi"
                       value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

    </div>

    <table class="table table-bordered table-hover table-striped">
        <thead>
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Edit</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Prodi</th>
            <th>Drop</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($mahasiswa as $mhs): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $mhs['nim'] ?></td>
                <td><a href="pages/update.php?id=<?= $mhs['id_mhs'] ?>" class="btn btn-warning btn-sm"><i
                                class="far fa-edit"></i></a>
                </td>
                <td><?= $mhs['nama'] ?></td>
                <td><?= $mhs['alamat'] ?></td>
                <td><?= $mhs['prodi'] ?></td>
                <td>
                    <a href="pages/delete.php?id=<?= $mhs['id_mhs'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin hapus?')"><i class="fas fa-backspace"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= $search ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<!-- Import CSV Modal -->
<div class="modal fade" id="importCSVModal" tabindex="-1" aria-labelledby="importCSVModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importCSVModalLabel">Import CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="input-group">
                        <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                    <small class="text-muted">Format: NIM;Nama;Alamat;Prodi (Skip header baris pertama)</small>
                </form>
                <?php if (isset($uploadMessage)): ?>
                    <div class="alert alert-info mt-2"><?= $uploadMessage ?></div>
                <?php endif; ?>
            </div>
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