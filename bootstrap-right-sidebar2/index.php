<?php 
require_once 'config/database.php';
$db = new Database();
$conn = $db->getConnection();

// Search functionality
$search_query = "";
$search_results = [];
if (isset($_GET['search'])) {
    $search_query = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM tmhs WHERE 
            nim LIKE '%$search_query%' OR 
            nama LIKE '%$search_query%' OR 
            alamat LIKE '%$search_query%' OR 
            prodi LIKE '%$search_query%'";
    $result = $conn->query($sql);
    $search_results = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Avengers Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- Search Form -->
                <form method="get" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search by NIM, Nama, Alamat, Prodi" 
                               value="<?= htmlspecialchars($search_query) ?>">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>

                <!-- Upload CSV Form -->
                <form action="upload.php" method="post" enctype="multipart/form-data" class="mb-4">
                    <div class="input-group">
                        <input type="file" name="csvfile" class="form-control" accept=".csv">
                        <button type="submit" class="btn btn-success">Upload CSV</button>
                    </div>
                </form>

                <!-- Download CSV Button -->
                <a href="download.php" class="btn btn-warning mb-4">Download CSV</a>

                <!-- Results Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Prodi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($search_results as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nim']) ?></td>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= htmlspecialchars($row['alamat']) ?></td>
                                <td><?= htmlspecialchars($row['prodi']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/sidebar.js"></script>
</body>
</html>