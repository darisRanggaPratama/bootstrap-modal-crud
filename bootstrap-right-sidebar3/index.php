<?php
require_once 'config/database.php';

$db = new Database();
$conn = $db->conn;

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

include 'includes/header.php';
?>

<div class="container mt-5">
    <h2>Data Mahasiswa</h2>
    
    <!-- Search Form -->
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari NIM, Nama, Alamat, Prodi" value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Prodi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($mahasiswa as $mhs): ?>
            <tr>
                <td><?= $mhs['nim'] ?></td>
                <td><?= $mhs['nama'] ?></td>
                <td><?= $mhs['alamat'] ?></td>
                <td><?= $mhs['prodi'] ?></td>
                <td>
                    <a href="pages/update.php?id=<?= $mhs['id_mhs'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="pages/delete.php?id=<?= $mhs['id_mhs'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
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
</div>

<?php 
include 'includes/sidebar.php';
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/sidebar.js"></script>
</body>
</html>