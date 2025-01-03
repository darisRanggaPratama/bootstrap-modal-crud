<?php
session_start();

// Reference other file
require_once 'database.php';
require_once 'functions.php';

if ($_SESSION['status'] != "sudah_login") {
    header("location:index.php");
}

$db = new Database();
$conn = $db->getConnection();

// Get search parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$entries = isset($_GET['entries']) ? (int)$_GET['entries'] : 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate offset for pagination
$offset = ($page - 1) * $entries;

// Build query with search conditions
$query = "SELECT * FROM view_pph WHERE ptkp = 'K/1'";
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
    <link href="assets/style.css" rel="stylesheet">
</head>

<body>
<!-- Sidebar -->
<?php require_once 'sidebar.php'; ?>

<!-- Main Content -->
<div class="content" id="content">

    <!-- Inside the body, before the container-fluid div -->
    <div class="container-fluid d-flex justify-content-between align-items-center mb-3">
        <div class="row mb-3">
            <div class="col-12">
                <div class="col text-end">
                    <button class="btn btn-primary mt-0" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            </div>
        </div>
        <h4>Data PPh21 Karyawan</h4>
        <?= $alert ?>
        <div class="row mb-3">
            <div class="col-12">
                <div class="col text-end">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle me-2" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <button class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#addEmployeeModal">
                                    <i class="bi bi-plus-circle"></i> Add Data
                                </button>
                            </li>
                            <li>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                    <i class="bi bi-cloud-upload"></i> Send CSV
                                </button>
                            </li>
                            <li>
                                <form method="post" action="csv-download.php" class="d-inline">
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="bi bi-cloud-download"></i> G e t CSV
                                    </button>
                                </form>
                            </li>
                            <li>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eraseAllModal">
                                    <i class="bi bi-trash"></i> Erase ALL
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <?php require_once 'modal.php'; ?>

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
                <th>Edit</th>
                <th>NIK</th>
                <th>Name</th>
                <th>Gaji</th>
                <th>Hdr Pst</th>
                <th>Hdr Pry</th>
                <th>Konsumsi</th>
                <th>Lembur</th>
                <th>Tunj Lain</th>
                <th>JKK</th>
                <th>JKM</th>
                <th>Sehat</th>
                <th>Bruto</th>
                <th>Rate</th>
                <th>PPh</th>
                <th>PTKP</th>
                <th>Hrf</th>
                <th>Drop</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
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
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        </div>
                    </td>
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
                    <td><?= number_format($row['bruto'], 0, ',', '.') ?></td>
                    <td><?= number_format($row['rate'], 2, ',', '.') ?></td>
                    <td><?= number_format($row['pph'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['ptkp']) ?></td>
                    <td><?= htmlspecialchars($row['hrf']) ?></td>
                    <td>
                        <a href="crud-delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger delete-btn"
                           onclick="return confirm('Are you sure to delete this data? \n\n <?= htmlspecialchars($row['nik']) ?>   <?= htmlspecialchars($row['name']) ?>')">
                            <i class="bi bi-x-square"></i>
                        </a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/script.js">

</script>
</body>

</html>
