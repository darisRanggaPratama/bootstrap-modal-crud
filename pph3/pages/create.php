<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Upah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>
<body>
<!-- Sidebar -->
<?php include 'sidebar.php'; ?>
<div class="container-fluid">
    <div class="row">


        <?php
        // create.php
        require_once '../config/database.php';

        $db = new Database();
        $conn = $db->getConnection();

        // Proses form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nik = $_POST['nik'];
            $name = $_POST['name'];
            $gaji = $_POST['gaji'];
            $ptkp = $_POST['ptkp'];

            try {
                $stmt = $conn->prepare("INSERT INTO upah (nik, name, gaji, ptkp) VALUES (:nik, :name, :gaji, :ptkp)");
                $stmt->execute([
                    ':nik' => $nik,
                    ':name' => $name,
                    ':gaji' => $gaji,
                    ':ptkp' => $ptkp
                ]);

                // Redirect ke halaman utama dengan pesan sukses
                header("Location: ../index.php?message=Data berhasil ditambahkan");
                exit();
            } catch (PDOException $e) {
                $error = "Gagal menambahkan data: " . $e->getMessage();
            }
        }
        ?>

        <div class="container mt-5">
            <h2>Tambah Data Upah</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" class="form-control" id="nik" name="nik" required maxlength="10">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" required maxlength="50">
                </div>
                <div class="mb-3">
                    <label for="gaji" class="form-label">Gaji</label>
                    <input type="number" class="form-control" id="gaji" name="gaji" required min="0">
                </div>
                <div class="mb-3">
                    <label for="ptkp" class="form-label">PTKP</label>
                    <select class="form-control" id="ptkp" name="ptkp">
                        <option value="-">-</option>
                        <option value="TK/0">TK/0</option>
                        <option value="TK/1">TK/1</option>
                        <option value="TK/2">TK/2</option>
                        <option value="TK/3">TK/3</option>
                        <option value="K/0">K/0</option>
                        <option value="K/1">K/1</option>
                        <option value="K/2">K/2</option>
                        <option value="K/3">K/3</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="../index.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/sidebar.js"></script>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container text-center">
        <span class="text-muted">&copy; <?= date('Y') ?> Sistem Manajemen Upah. All Rights Reserved.</span>
    </div>
</footer>
</body>
</html>

