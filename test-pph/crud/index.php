<?php
require_once 'database.php';
require_once 'functions.php';

session_start();

$db = new Database();
$conn = $db->getConnection();

// Get search parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$entries = isset($_GET['entries']) ? (int)$_GET['entries'] : 25;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate offset for pagination
$offset = ($page - 1) * $entries;

// Build query with search conditions
$query = "SELECT * FROM upah WHERE 1=1";
if (!empty($search)) {
    $query .= " AND (nik LIKE :search OR name LIKE :search OR gaji LIKE :search OR ptkp LIKE :search)";
}

// Get total records for pagination
$countQuery = str_replace("SELECT *", "SELECT COUNT(*)", $query);
$stmt =  $conn->prepare($countQuery);
if (!empty($search)) {
    $searchParam = "%$search%";
    $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
}
$stmt->execute();
$totalRecords = $stmt->fetchColumn();

// Add limit and offset to main query
$query .= " LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($query);
if (!empty($search)) {
    $searchParam = "%$search%";
    $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
}
$stmt->bindParam(':limit', $entries, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total pages
$totalPages = ceil($totalRecords / $entries);

// Alert messages
$alert = '';
if (isset($_SESSION['alert'])) {
    $alert = $_SESSION['alert'];
    unset($_SESSION['alert']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Upah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            background-color: #343a40;
            transition: 0.3s;
            z-index: 1000;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar-link {
            color: #fff;
            transition: all 0.3s;
        }

        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .sidebar-link.active {
            animation: blink 0.5s;
        }

        @keyframes blink {
            0% {
                background-color: #0d6efd;
            }

            50% {
                background-color: #60a5fa;
            }

            100% {
                background-color: #0d6efd;
            }
        }

        .content {
            margin-left: 0;
            transition: 0.3s;
        }

        .content.shifted {
            margin-left: 250px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-white">
            <span class="fs-4 mb-3">Menu</span>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link sidebar-link active">
                        <i class="bi bi-house me-2"></i>
                        Home
                    </a>
                </li>
                <li>
                    <a href="page1.php" class="nav-link sidebar-link">
                        <i class="bi bi-file-text me-2"></i>
                        Page 1
                    </a>
                </li>
                <li>
                    <a href="page2.php" class="nav-link sidebar-link">
                        <i class="bi bi-file-text me-2"></i>
                        Page 2
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content" id="content">

        <!-- Inside the body, before the container-fluid div -->
        <div class="container-fluid">
            <?= $alert ?>

            <!-- Add New Employee Button -->
            <div class="row mb-3">
                <div class="col-12">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                        <i class="bi bi-plus"></i> Tambah Karyawan
                    </button>
                </div>
            </div>

            <!-- Add Employee Modal -->
            <div class="modal fade" id="addEmployeeModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Karyawan Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="create.php" method="POST">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">NIK</label>
                                    <input type="text" class="form-control" name="nik" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gaji</label>
                                    <input type="text" class="form-control" name="gaji" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hadir Pusat</label>
                                    <input type="text" class="form-control" name="hadir_pusat" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hadir Proyek</label>
                                    <input type="text" class="form-control" name="hadir_proyek" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Konsumsi</label>
                                    <input type="text" class="form-control" name="konsumsi" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lembur</label>
                                    <input type="text" class="form-control" name="lembur" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tunjangan Lain</label>
                                    <input type="text" class="form-control" name="tunjang_lain" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">BPJS: JKK</label>
                                    <input type="text" class="form-control" name="jkk" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">BPJS: JKM</label>
                                    <input type="text" class="form-control" name="jkm" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">BPJS: Sehat</label>
                                    <input type="text" class="form-control" name="sehat" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">PTKP</label>
                                    <select class="form-select" name="ptkp" required>
                                        <option value="K/0">K/0</option>
                                        <option value="K/1">K/1</option>
                                        <option value="K/2">K/2</option>
                                        <option value="K/3">K/3</option>
                                        <option value="TK/0">TK/0</option>
                                        <option value="TK/1">TK/1</option>
                                        <option value="TK/2">TK/2</option>
                                        <option value="TK/3">TK/3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Employee Modal -->
            <div class="modal fade" id="editEmployeeModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Karyawan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="update.php" method="POST">
                            <input type="hidden" name="id" id="editId">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">NIK</label>
                                    <input type="text" class="form-control" name="nik" id="editNik" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="name" id="editName" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gaji</label>
                                    <input type="text" class="form-control" name="gaji" id="editGaji" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hadir Pusat</label>
                                    <input type="text" class="form-control" name="hadir_pusat" id="editHadirPusat" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hadir Proyek</label>
                                    <input type="text" class="form-control" name="hadir_proyek" id="editHadirProyek" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Konsumsi</label>
                                    <input type="text" class="form-control" name="konsumsi" id="editKonsumsi" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lembur</label>
                                    <input type="text" class="form-control" name="lembur" id="editLembur" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tunjangan Lain</label>
                                    <input type="text" class="form-control" name="tunjang_lain" id="editTunjangLain" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">BPJS: JKK</label>
                                    <input type="text" class="form-control" name="jkk" id="editJkk" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">BPJS: JKM</label>
                                    <input type="text" class="form-control" name="jkm" id="editJkm" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">BPJS Sehat</label>
                                    <input type="text" class="form-control" name="sehat" id="editSehat" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">PTKP</label>
                                    <select class="form-select" name="ptkp" id="editPtkp" required>
                                        <option value="K/0">K/0</option>
                                        <option value="K/1">K/1</option>
                                        <option value="K/2">K/2</option>
                                        <option value="K/3">K/3</option>
                                        <option value="TK/0">TK/0</option>
                                        <option value="TK/1">TK/1</option>
                                        <option value="TK/2">TK/2</option>
                                        <option value="TK/3">TK/3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-12">
                    <button class="btn btn-primary mt-3" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            </div>

            <!-- Search and Entries Controls -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search..." id="searchInput" value="<?= htmlspecialchars($search) ?>">
                        <button class="btn btn-primary" type="button" onclick="updateSearch()">Search</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <select class="form-select" id="entriesSelect" onchange="updateEntries()">
                        <?php foreach ([1, 5, 15, 25, 50, 100] as $value): ?>
                            <option value="<?= $value ?>" <?= $entries == $value ? 'selected' : '' ?>>
                                Show <?= $value ?> entries
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Name</th>
                            <th>Gaji</th>
                            <th>Hadir Pusat</th>
                            <th>Hadir Proyek</th>
                            <th>Konsumsi</th>
                            <th>Lembur</th>
                            <th>Tunjangan Lain</th>
                            <th>JKK</th>
                            <th>JKM</th>
                            <th>Sehat</th>
                            <th>PTKP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nik']) ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= number_format($row['gaji'], 0, ',', '.') ?></td>
                                <td><?= number_format($row['hadir_pusat'], 0, ',', '.') ?></td>
                                <td><?= number_format($row['hadir_proyek'], 0, ',', '.') ?></td>
                                <td><?= number_format($row['konsumsi'], 0, ',', '.') ?></td>
                                <td><?= number_format($row['lembur'], 0, ',', '.') ?></td>
                                <td><?= number_format($row['tunjang_lain'], 0, ',', '.') ?></td>
                                <td><?= number_format($row['jkk'], 0, ',', '.') ?></td>
                                <td><?= number_format($row['jkm'], 0, ',', '.') ?></td>
                                <td><?= number_format($row['sehat'], 0, ',', '.') ?></td>
                                <td><?= htmlspecialchars($row['ptkp']) ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-warning edit-btn"
                                            data-id="<?= $row['id'] ?>"
                                            data-nik="<?= htmlspecialchars($row['nik']) ?>"
                                            data-name="<?= htmlspecialchars($row['name']) ?>"
                                            data-gaji="<?= $row['gaji'] ?>"
                                            data-hadirpusat="<?= $row['hadir_pusat'] ?>"
                                            data-hadirproyek="<?= $row['hadir_proyek'] ?>"
                                            data-konsumsi="<?= $row['konsumsi'] ?>"
                                            data-lembur="<?= $row['lembur'] ?>"
                                            data-tunjanglain="<?= $row['tunjang_lain'] ?>"
                                            data-jkk="<?= $row['jkk'] ?>"
                                            data-jkm="<?= $row['jkm'] ?>"
                                            data-sehat="<?= $row['sehat'] ?>"
                                            data-ptkp="<?= htmlspecialchars($row['ptkp']) ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editEmployeeModal">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger delete-btn"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>&entries=<?= $entries ?>&search=<?= urlencode($search) ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&entries=<?= $entries ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>&entries=<?= $entries ?>&search=<?= urlencode($search) ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            content.classList.toggle('shifted');
        });

        // Sidebar Link Effects
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', function(e) {
                document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Search and Entries Functions
        function updateSearch() {
            const searchValue = document.getElementById('searchInput').value;
            const entriesValue = document.getElementById('entriesSelect').value;
            window.location.href = `?search=${encodeURIComponent(searchValue)}&entries=${entriesValue}&page=1`;
        }

        function updateEntries() {
            const searchValue = document.getElementById('searchInput').value;
            const entriesValue = document.getElementById('entriesSelect').value;
            window.location.href = `?search=${encodeURIComponent(searchValue)}&entries=${entriesValue}&page=1`;
        }

        // Search on Enter Key
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                updateSearch();
            }
        });

        // Edit Modal Population
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('editId').value = this.getAttribute('data-id');
                document.getElementById('editNik').value = this.getAttribute('data-nik');
                document.getElementById('editName').value = this.getAttribute('data-name');
                document.getElementById('editGaji').value = this.getAttribute('data-gaji');
                document.getElementById('editHadirPusat').value = this.getAttribute('data-hadirpusat');
                document.getElementById('editHadirProyek').value = this.getAttribute('data-hadirproyek');
                document.getElementById('editKonsumsi').value = this.getAttribute('data-konsumsi');
                document.getElementById('editLembur').value = this.getAttribute('data-lembur');
               document.getElementById('editTunjangLain').value = this.getAttribute('data-tunjanglain');
                document.getElementById('editJkk').value = this.getAttribute('data-jkk');
                document.getElementById('editJkm').value = this.getAttribute('data-jkm');
                document.getElementById('editSehat').value = this.getAttribute('data-sehat');
                document.getElementById('editPtkp').value = this.getAttribute('data-ptkp');
            });
        });
    </script>
</body>

</html>