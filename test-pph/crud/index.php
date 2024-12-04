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

// Alert messages
$alert = '';
if (isset($_SESSION['alert'])) {
    $alert = $_SESSION['alert'];
    unset($_SESSION['alert']);
}

$no = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPh21</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>

<body>
<!-- Sidebar -->
<?php require_once 'sidebar.php'; ?>

<!-- Main Content -->
<div class="content" id="content">

    <!-- Inside the body, before the container-fluid div -->
    <div class="container-fluid">
        <?= $alert ?>

        <!-- Add New Employee Button -->
        <div class="row mb-3">
            <div class="col-12">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                    <i class="bi bi-plus"></i> Add
                </button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="bi bi-upload"></i> Upload
                </button>
                <form method="post" action="download.php" class="d-inline">
                    <button type="submit" class="btn btn-secondary">
                        <i class="bi bi-download"></i> Download
                    </button>
                </form>
            </div>
        </div>

        <!-- Modal -->
        <?php require_once 'modal.php'; ?>

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
                    <input type="text" class="form-control" placeholder="Search..." id="searchInput"
                           value="<?= htmlspecialchars($search) ?>">
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
                    <th>No</th>
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
                        <td><?= $no++ ?></td>
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
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?\n<?= htmlspecialchars($row['nik']) ?> <?= htmlspecialchars($row['name']) ?>')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <?php require_once 'pagination.php'; ?>

    </div>
</div>

<!-- Add this modal at the end of the file, before closing body tag -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="process.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Upload CSV File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="upload">
                    <div class="mb-3">
                        <label for="csvFile" class="form-label">Select CSV File</label>
                        <input type="file" class="form-control" id="csvFile" name="csvFile" accept=".csv" required>
                        <small class="text-muted">
                            File should be CSV format with semicolon (;) separator and columns:<br>
                            nik;name;gaji;hadir_pusat;hadir_proyek;konsumsi;lembur;tunjang_lain;jkk;jkm;sehat;ptkp
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js">

</script>
</body>

</html>