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
        <?php
        // search.php
        require_once 'config/database.php';

        $db = new Database();
        $conn = $db->getConnection();

        $searchTerm = $_GET['q'] ?? '';
        $searchField = $_GET['field'] ?? 'name';

        $stmt = $conn->prepare("SELECT * FROM upah WHERE $searchField LIKE :searchTerm");
        $stmt->execute(['searchTerm' => "%$searchTerm%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="container mt-5">
            <h2>Pencarian Data</h2>
            <form method="GET" action="search.php">
                <div class="row">
                    <div class="col-md-4">
                        <select name="field" class="form-control">
                            <option value="nik">NIK</option>
                            <option value="name">Nama</option>
                            <option value="gaji">Gaji</option>
                            <option value="ptkp">PTKP</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="q" class="form-control" placeholder="Kata kunci pencarian">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>

            <table class="table mt-3 table-striped table-hover">
                <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Gaji</th>
                    <th>PTKP</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?= htmlspecialchars($result['nik']) ?></td>
                        <td><?= htmlspecialchars($result['name']) ?></td>
                        <td>Rp. <?= number_format($result['gaji'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($result['ptkp']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
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

