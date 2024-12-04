<?php
$host = 'localhost';
$user = 'rangga';
$pass = 'rangga';
$db = 'avengers';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}


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
$stmt = $conn->prepare($countQuery);
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
            0% { background-color: #0d6efd; }
            50% { background-color: #60a5fa; }
            100% { background-color: #0d6efd; }
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
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page-1 ?>&entries=<?= $entries ?>&search=<?= urlencode($search) ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&entries=<?= $entries ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page+1 ?>&entries=<?= $entries ?>&search=<?= urlencode($search) ?>">Next</a>
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
    </script>
</body>
</html>