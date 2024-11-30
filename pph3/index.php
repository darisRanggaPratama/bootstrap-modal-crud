<?php
session_start();
require_once 'config/database.php';

$db = new Database();
$conn = $db->getConnection();

// Pagination
$recordsPerPage = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

// Total Records
$totalRecordsQuery = $conn->query("SELECT COUNT(*) FROM upah");
$totalRecords = $totalRecordsQuery->fetchColumn();
$totalPages = ceil($totalRecords / $recordsPerPage);

// Fetch Records
$stmt = $conn->prepare("SELECT * FROM upah LIMIT :offset, :recordsPerPage");
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

$no = 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Upah</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body>
<!-- Sidebar -->
<?php include 'sidebar.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="container mt-5">
            <!-- Add message display section -->
            <?php
            if (isset($_SESSION['upload_message'])) {
                echo '<div class="alert alert-info">' . htmlspecialchars($_SESSION['upload_message']) . '</div>';
                unset($_SESSION['upload_message']); // Clear the message
            }
            ?>
            <div class="row mb-3">
                <div class="col">
                    <h2>Data Upah</h2>
                </div>
                <div class="col text-end">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle me-2" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a class="btn" href="pages/create.php">Add Data</a>
                            </li>
                            <li>
                                <!--CSV Download Button-->
                                <a href="download_csv.php" class="btn">Download CSV</a>
                            <li>
                                <!--CSV Upload Button-->
                                <button type="button" class="btn" data-bs-toggle="modal"
                                        data-bs-target="#csvUploadModal">Upload CSV
                                </button>
                            </li>
                            <li>
                                <a class="btn" href="search.php">Search Data</a>
                            </li>
                            <li>
                                <!-- Delete All -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteAllModal">Erase All
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Edit</th>
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
                    <th>Drop</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($records as $record): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($record['nik']) ?></td>
                        <td><a href="pages/edit.php?id=<?= $record['id'] ?>" class="btn btn-sm btn-warning">
                                <i class="far fa-edit"></i></a></td>
                        <td><?= htmlspecialchars($record['name']) ?></td>
                        <td><?= number_format($record['gaji'], 0, ',', '.') ?></td>
                        <td><?= number_format($record['hadir_pusat'], 0, ',', '.') ?></td>
                        <td><?= number_format($record['hadir_proyek'], 0, ',', '.') ?></td>
                        <td><?= number_format($record['konsumsi'], 0, ',', '.') ?></td>
                        <td><?= number_format($record['lembur'], 0, ',', '.') ?></td>
                        <td><?= number_format($record['tunjang_lain'], 0, ',', '.') ?></td>
                        <td><?= number_format($record['jkk'], 0, ',', '.') ?></td>
                        <td><?= number_format($record['jkm'], 0, ',', '.') ?></td>
                        <td><?= number_format($record['sehat'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($record['ptkp']) ?></td>
                        <td>
                            <a href="pages/delete.php?id=<?= $record['id'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('DELETE: <?= htmlspecialchars($record['nik']) ?> <?= $record['name'] ?>. Are you sure?')">
                                <i class="fas fa-backspace"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav>
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- CSV Upload Modal -->
<div class="modal fade" id="csvUploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="upload_csv.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="csvFile" class="form-label">Pilih File CSV</label>
                        <input class="form-control" type="file" id="csvFile" name="csvFile" accept=".csv" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete All Modal -->
<div class="modal fade" id="deleteAllModal" tabindex="-1" aria-labelledby="deleteAllModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAllModalLabel">Delete All Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete all data?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="delete_all.php" class="btn btn-danger">Delete All</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/sidebar.js"></script>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container text-center">
        <span class="text-muted">&copy; <?= date('Y') ?> PPH 21 Calculator. All Rights Reserved.</span>
    </div>
</footer>
</body>
</html>
