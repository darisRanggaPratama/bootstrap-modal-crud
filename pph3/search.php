<?php
// search.php
require_once 'config/database.php';

$db = new Database();
$conn = $db->getConnection();

$searchTerm = $_GET['q'] ?? '';
$searchField = $_GET['field'] ?? 'name';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$recordsPerPage = 15;
$offset = ($page - 1) * $recordsPerPage;

// Hitung total hasil pencarian
$countStmt = $conn->prepare("SELECT COUNT(*) FROM upah WHERE $searchField LIKE :searchTerm");
$countStmt->execute(['searchTerm' => "%$searchTerm%"]);
$totalResults = $countStmt->fetchColumn();

// Hitung total halaman
$totalPages = ceil($totalResults / $recordsPerPage);

// Fetch Records dengan Pagination
$stmt = $conn->prepare("SELECT * FROM upah WHERE $searchField LIKE :searchTerm ORDER BY ptkp DESC LIMIT :offset, :recordsPerPage");
$stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$no = $offset + 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Upah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body>
<!-- Sidebar -->
<?php include 'sidebar.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="container mt-5">
            <div class="row mb-3">
                <div class="col">
                    <h2>Pencarian Data</h2>
                </div>
                <form method="GET" action="search.php">
                    <div class="row">
                        <div class="col-md-2">
                            <select name="field" class="form-control">
                                <option value="nik">NIK</option>
                                <option value="name">Nama</option>
                                <option value="gaji">Gaji</option>
                                <option value="ptkp">PTKP</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" name="q" value="<?= htmlspecialchars($searchTerm) ?>" class="form-control" placeholder="Kata kunci pencarian">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <?php if (count($results) > 0): ?>
                <table class="table mt-3 table-striped table-hover">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Gaji Pokok</th>
                        <th>Hadir Pusat</th>
                        <th>Hadir Proyek</th>
                        <th>Konsumsi</th>
                        <th>Lembur</th>
                        <th>Tunjangan</th>
                        <th>BPJS:JKK</th>
                        <th>BPJS:JKM</th>
                        <th>BPJS Sehat</th>
                        <th>PTKP</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($results as $result): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($result['nik']) ?></td>
                            <td><?= htmlspecialchars($result['name']) ?></td>
                            <td><?= number_format($result['gaji'], 0, ',', '.') ?></td>
                            <td><?= number_format($result['hadir_pusat'], 0, ',', '.') ?></td>
                            <td><?= number_format($result['hadir_proyek'], 0, ',', '.') ?></td>
                            <td><?= number_format($result['konsumsi'], 0, ',', '.') ?></td>
                            <td><?= number_format($result['lembur'], 0, ',', '.') ?></td>
                            <td><?= number_format($result['tunjang_lain'], 0, ',', '.') ?></td>
                            <td><?= number_format($result['jkk'], 0, ',', '.') ?></td>
                            <td><?= number_format($result['jkm'], 0, ',', '.') ?></td>
                            <td><?= number_format($result['sehat'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($result['ptkp']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <nav aria-label="Halaman Pencarian">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?q=<?= urlencode($searchTerm) ?>&field=<?= urlencode($searchField) ?>&page=<?= $page - 1 ?>">Back</a>
                            </li>
                        <?php endif; ?>

                        <?php
                        $startPage = max(1, $page - 2);
                        $endPage = min($totalPages, $page + 2);

                        for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?q=<?= urlencode($searchTerm) ?>&field=<?= urlencode($searchField) ?>&page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?q=<?= urlencode($searchTerm) ?>&field=<?= urlencode($searchField) ?>&page=<?= $page + 1 ?>">Next</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>

            <?php else: ?>
                <div class="alert alert-info" role="alert">
                    Tidak ada data yang ditemukan.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/sidebar.js"></script>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container text-center">
        <span class="text-muted">&copy; <?= date('Y') ?> Sistem Manajemen Upah. All Rights Reserved.</span>
    </div>
</footer>
</body>
</html>
