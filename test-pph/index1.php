<?php
// config.php
$host = 'localhost';
$dbname = 'avengers';
$username = 'rangga';
$password = 'rangga';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// index.php
session_start();

// Default values
$entries_per_page = isset($_GET['entries']) ? $_GET['entries'] : 25;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search_nik = isset($_GET['search_nik']) ? $_GET['search_nik'] : '';
$search_name = isset($_GET['search_name']) ? $_GET['search_name'] : '';
$search_gaji = isset($_GET['search_gaji']) ? $_GET['search_gaji'] : '';
$search_ptkp = isset($_GET['search_ptkp']) ? $_GET['search_ptkp'] : '';

// Build the WHERE clause for search
$where_conditions = [];
$params = [];

if (!empty($search_nik)) {
    $where_conditions[] = "nik LIKE ?";
    $params[] = "%$search_nik%";
}
if (!empty($search_name)) {
    $where_conditions[] = "name LIKE ?";
    $params[] = "%$search_name%";
}
if (!empty($search_gaji)) {
    $where_conditions[] = "gaji = ?";
    $params[] = $search_gaji;
}
if (!empty($search_ptkp)) {
    $where_conditions[] = "ptkp LIKE ?";
    $params[] = "%$search_ptkp%";
}

$where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

// Count total records
$count_sql = "SELECT COUNT(*) FROM upah $where_clause";
$stmt = $pdo->prepare($count_sql);
$stmt->execute($params);
$total_records = $stmt->fetchColumn();

// Calculate pagination
$total_pages = $entries_per_page === 'all' ? 1 : ceil($total_records / $entries_per_page);
if ($current_page > $total_pages) {
    $current_page = 1;
}

// Fetch records
$sql = "SELECT * FROM upah $where_clause";
if ($entries_per_page !== 'all') {
    $offset = ($current_page - 1) * $entries_per_page;
    $sql .= " LIMIT $entries_per_page OFFSET $offset";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid mt-4">
        <h2 class="mb-4">Salary Management System</h2>
        
        <!-- Search Form -->
        <form method="GET" class="mb-4">
            <div class="row g-3">
                <div class="col-md-2">
                    <input type="text" name="search_nik" class="form-control" placeholder="Search NIK" value="<?= htmlspecialchars($search_nik) ?>">
                </div>
                <div class="col-md-3">
                    <input type="text" name="search_name" class="form-control" placeholder="Search Name" value="<?= htmlspecialchars($search_name) ?>">
                </div>
                <div class="col-md-2">
                    <input type="number" name="search_gaji" class="form-control" placeholder="Search Gaji" value="<?= htmlspecialchars($search_gaji) ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" name="search_ptkp" class="form-control" placeholder="Search PTKP" value="<?= htmlspecialchars($search_ptkp) ?>">
                </div>
                <div class="col-md-2">
                    <select name="entries" class="form-select">
                        <?php
                        $entry_options = [1, 5, 25, 50, 100, 'all'];
                        foreach ($entry_options as $option) {
                            $selected = $entries_per_page == $option ? 'selected' : '';
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

        <!-- Data Table -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
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
                    <?php foreach ($records as $record): ?>
                    <tr>
                        <td><?= htmlspecialchars($record['nik']) ?></td>
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
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($entries_per_page !== 'all'): ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $current_page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $current_page-1 ?>&entries=<?= $entries_per_page ?>&search_nik=<?= urlencode($search_nik) ?>&search_name=<?= urlencode($search_name) ?>&search_gaji=<?= urlencode($search_gaji) ?>&search_ptkp=<?= urlencode($search_ptkp) ?>">Previous</a>
                </li>
                
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $current_page == $i ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&entries=<?= $entries_per_page ?>&search_nik=<?= urlencode($search_nik) ?>&search_name=<?= urlencode($search_name) ?>&search_gaji=<?= urlencode($search_gaji) ?>&search_ptkp=<?= urlencode($search_ptkp) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                
                <li class="page-item <?= $current_page >= $total_pages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $current_page+1 ?>&entries=<?= $entries_per_page ?>&search_nik=<?= urlencode($search_nik) ?>&search_name=<?= urlencode($search_name) ?>&search_gaji=<?= urlencode($search_gaji) ?>&search_ptkp=<?= urlencode($search_ptkp) ?>">Next</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>