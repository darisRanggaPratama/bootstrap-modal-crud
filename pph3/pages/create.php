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
    $hadir_pusat = $_POST['hadir_pusat'];
    $hadir_proyek = $_POST['hadir_proyek'];
    $konsumsi = $_POST['konsumsi'];
    $lembur = $_POST['lembur'];
    $tunjang_lain = $_POST['tunjang_lain'];
    $jkk = $_POST['jkk'];
    $jkm = $_POST['jkm'];
    $sehat = $_POST['sehat'];
    $ptkp = $_POST['ptkp'];

    try {
        $stmt = $conn->prepare("INSERT INTO upah (nik, name, gaji, hadir_pusat, hadir_proyek, konsumsi, lembur, tunjang_lain, jkk, jkm, sehat, ptkp) 
VALUES (:nik, :name, :gaji, :hadir_pusat, :hadir_proyek, :konsumsi, :lembur, :tunjang_lain, :jkk, :jkm, :sehat, :ptkp)");
        $stmt->execute([
            ':nik' => $nik,
            ':name' => $name,
            ':gaji' => $gaji,
            ':hadir_pusat' => $hadir_pusat,
            ':hadir_proyek' => $hadir_proyek,
            ':konsumsi' => $konsumsi,
            ':lembur' => $lembur,
            ':tunjang_lain' => $tunjang_lain,
            ':jkk' => $jkk,
            ':jkm' => $jkm,
            ':sehat' => $sehat,
            ':ptkp' => $ptkp
        ]);

        // Redirect ke halaman utama dengan pesan sukses
        header("Location: ../index.php?message=Data_berhasil_ditambahkan");
        exit();
    } catch (PDOException $e) {
        $error = "Gagal menambahkan data: " . $e->getMessage();
    }
}
?>

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
<div class="container-fluid all-form">
    <div class="row">
        <div class="container mt-5">
            <h2>Tambah Data Upah</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" required maxlength="10">
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required maxlength="50">
                    </div>
                    <div class="form-group">
                        <label for="gaji" class="form-label">Gaji</label>
                        <input type="text" class="form-control" id="gaji" name="gaji" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="hadir_pusat" class="form-label">Hadir Pusat</label>
                        <input type="text" class="form-control" id="hadir_pusat" name="hadir_pusat" required min="0">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="hadir_proyek" class="form-label">Hadir Proyek</label>
                        <input type="text" class="form-control" id="hadir_proyek" name="hadir_proyek" required
                               min="0">
                    </div>
                    <div class="form-group">
                        <label for="konsumsi" class="form-label">Konsumsi</label>
                        <input type="text" class="form-control" id="konsumsi" name="konsumsi" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="lembur" class="form-label">Lembur</label>
                        <input type="text" class="form-control" id="lembur" name="lembur" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="tunjang_lain" class="form-label">Tunjang Lain</label>
                        <input type="text" class="form-control" id="tunjang_lain" name="tunjang_lain" required
                               min="0">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="jkk" class="form-label">JKK</label>
                        <input type="text" class="form-control" id="jkk" name="jkk" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="jkm" class="form-label">JKM</label>
                        <input type="text" class="form-control" id="jkm" name="jkm" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="sehat" class="form-label">Sehat</label>
                        <input type="text" class="form-control" id="sehat" name="sehat" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="ptkp" class="form-label">PTKP</label>
                        <select class="form-control select-option" id="ptkp" name="ptkp">
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
                        <button type="submit" class="btn btn-primary mt-3">Save</button>
                        <a href="../index.php" class="btn btn-secondary mt-3">Cancel</a>
                    </div>
                </div>
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

