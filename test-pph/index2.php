<?php
// Database connection
$host = 'localhost';
$dbname = 'avengers';
$username = 'rangga';
$password = 'rangga';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get search parameters
$search_nik = $_GET['search_nik'] ?? '';
$search_name = $_GET['search_name'] ?? '';
$search_gaji = $_GET['search_gaji'] ?? '';
$search_ptkp = $_GET['search_ptkp'] ?? '';

// Get entries per page
$entries = isset($_GET['entries']) ? (int)$_GET['entries'] : 25;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $entries;

// Build query
$where_conditions = [];
$params = [];

if (!empty($search_nik)) {
    $where_conditions[] = "nik LIKE :nik";
    $params[':nik'] = "%$search_nik%";
}
if (!empty($search_name)) {
    $where_conditions[] = "name LIKE :name";
    $params[':name'] = "%$search_name%";
}
if (!empty($search_gaji)) {
    $where_conditions[] = "gaji = :gaji";
    $params[':gaji'] = $search_gaji;
}
if (!empty($search_ptkp)) {
    $where_conditions[] = "ptkp LIKE :ptkp";
    $params[':ptkp'] = "%$search_ptkp%";
}

$where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

// Count total rows
$count_sql = "SELECT COUNT(*) FROM upah $where_clause";
$stmt = $pdo->prepare($count_sql);
$stmt->execute($params);
$total_rows = $stmt->fetchColumn();

// Get data
$sql = "SELECT * FROM upah $where_clause";
if ($entries != 'all') {
    $sql .= " LIMIT :entries OFFSET :offset";
    $params[':entries'] = $entries;
    $params[':offset'] = $offset;
}

$stmt = $pdo->prepare($sql);
foreach ($params as $key => $value) {
    if (is_int($value)) {
        $stmt->bindValue($key, $value, PDO::PARAM_INT);
    } else {
        $stmt->bindValue($key, $value, PDO::PARAM_STR);
    }
}
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total pages safely
$total_pages = $entries == 'all' || $entries <= 0 ? 1 : ceil($total_rows / $entries);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            background-color: #343a40;
            transition: 0.3s;
            z-index: 1000;
        }

        .sidebar.show {
            left: 0;
        }

        .sidebar-link {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            transition: all 0.3s;
        }

        .sidebar-link:hover {
            background-color: #495057;
            color: #fff;
        }

        .sidebar-link.active {
            animation: blink 1s;
        }

        @keyframes blink {
            0% { background-color: #495057; }
            50% { background-color: #6c757d; }
            100% { background-color: #495057; }
        }

        .content {
            transition: margin-left 0.3s;
            padding: 20px;
        }

        .content.shifted {
            margin-left: 250px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-3">
            <h5 class="text-white">Menu</h5>
            <hr class="bg-white">
            <a href="#" class="sidebar-link">Dashboard</a>
            <a href="#" class="sidebar-link">Employee List</a>
            <a href="#" class="sidebar-link">Reports</a>
            <a href="#" class="sidebar-link">Settings</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content" id="content">
        <button class="btn btn-dark mb-3" id="sidebarToggle">
            <span class="navbar-toggler-icon">.::.</span>
        </button>

        <div class="card">
            <div class="card-body">
                <!-- Search Form -->
                <form method="GET" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="search_nik" placeholder="Search NIK" value="<?= htmlspecialchars($search_nik) ?>">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="search_name" placeholder="Search Name" value="<?= htmlspecialchars($search_name) ?>">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="search_gaji" placeholder="Search Gaji" value="<?= htmlspecialchars($search_gaji) ?>">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="search_ptkp" placeholder="Search PTKP" value="<?= htmlspecialchars($search_ptkp) ?>">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" name="entries">
                                <?php
                                $options = [1, 5, 15, 25, 50, 100, 'all'];
                                foreach ($options as $option) {
                                    $selected = $entries == $option ? 'selected' : '';
                                    echo "<option value='$option' $selected>" . 
                                         ($option === 'all' ? 'All' : $option) . 
                                         " entries</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary w-100">Search</button>
                        </div>
                    </div>
                </form>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
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
                            <?php foreach ($rows as $row): ?>
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
                <?php if ($entries != 'all'): ?>
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>&entries=<?= $entries ?>&search_nik=<?= urlencode($search_nik) ?>&search_name=<?= urlencode($search_name) ?>&search_gaji=<?= urlencode($search_gaji) ?>&search_ptkp=<?= urlencode($search_ptkp) ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('content').classList.toggle('shifted');
        });

        // Add click effect to sidebar links
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', function(e) {
                // Remove active class from all links
                document.querySelectorAll('.sidebar-link').forEach(l => {
                    l.classList.remove('active');
                });
                // Add active class to clicked link
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>