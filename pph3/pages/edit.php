<?php
// edit.php
require_once '../config/database.php';

$db = new Database();
$conn = $db->getConnection();

// Cek ID yang akan diedit
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Ambil data yang akan diedit
try {
    $stmt = $conn->prepare("SELECT * FROM upah WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$record) {
        header("Location: index.php");
        exit();
    }
} catch (PDOException $e) {
    $error = "Gagal mengambil data: " . $e->getMessage();
}

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
        $stmt = $conn->prepare("UPDATE upah SET nik = :nik, name = :name, gaji = :gaji, hadir_pusat = :hadir_pusat, 
                hadir_proyek = :hadir_proyek, konsumsi = :konsumsi, lembur = :lembur, tunjang_lain = :tunjang_lain, 
                jkk = :jkk, jkm = :jkm, sehat = :sehat, ptkp = :ptkp WHERE id = :id");
        $stmt->execute([
            ':id' => $id,
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
        header("Location: ../index.php?message=Data berhasil diperbarui");
        exit();
    } catch (PDOException $e) {
        $error = "Gagal memperbarui data: " . $e->getMessage();
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
            <h2>Edit Data Upah</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" required maxlength="10"
                               value="<?= htmlspecialchars($record['nik']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required maxlength="50"
                               value="<?= htmlspecialchars($record['name']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="gaji" class="form-label">Gaji</label>
                        <input type="text" class="form-control" id="gaji" name="gaji" required min="0"
                               value="<?= htmlspecialchars($record['gaji']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="hadir_pusat" class="form-label">Hadir Pusat</label>
                        <input type="text" class="form-control" id="hadir_pusat" name="hadir_pusat" required min="0"
                               value="<?= htmlspecialchars($record['hadir_pusat']) ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="hadir_proyek" class="form-label">Hadir Proyek</label>
                        <input type="text" class="form-control" id="hadir_proyek" name="hadir_proyek" required min="0"
                               value="<?= htmlspecialchars($record['hadir_proyek']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="konsumsi" class="form-label">Konsumsi</label>
                        <input type="text" class="form-control" id="konsumsi" name="konsumsi" required min="0"
                               value="<?= htmlspecialchars($record['konsumsi']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="lembur" class="form-label">Lembur</label>
                        <input type="text" class="form-control" id="lembur" name="lembur" required min="0"
                               value="<?= htmlspecialchars($record['lembur']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="tunjang_lain" class="form-label">Tunjang Lain</label>
                        <input type="text" class="form-control" id="tunjang_lain" name="tunjang_lain" required min="0"
                               value="<?= htmlspecialchars($record['tunjang_lain']) ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="jkk" class="form-label">JKK</label>
                        <input type="text" class="form-control" id="jkk" name="jkk" required min="0"
                               value="<?= htmlspecialchars($record['jkk']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="jkm" class="form-label">JKM</label>
                        <input type="text" class="form-control" id="jkm" name="jkm" required min="0"
                               value="<?= htmlspecialchars($record['jkm']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="sehat" class="form-label">Sehat</label>
                        <input type="text" class="form-control" id="sehat" name="sehat" required min="0"
                               value="<?= htmlspecialchars($record['sehat']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="ptkp" class="form-label">PTKP</label>
                        <select class="form-control select-option" id="ptkp" name="ptkp">
                            <option value="-" <?= $record['ptkp'] == '-' ? 'selected' : '' ?>>-</option>
                            <option value="TK/0" <?= $record['ptkp'] == 'TK/0' ? 'selected' : '' ?>>TK/0</option>
                            <option value="TK/1" <?= $record['ptkp'] == 'TK/1' ? 'selected' : '' ?>>TK/1</option>
                            <option value="TK/2" <?= $record['ptkp'] == 'TK/2' ? 'selected' : '' ?>>TK/2</option>
                            <option value="TK/3" <?= $record['ptkp'] == 'TK/3' ? 'selected' : '' ?>>TK/3</option>
                            <option value="K/0" <?= $record['ptkp'] == 'K/0' ? 'selected' : '' ?>>K/0</option>
                            <option value="K/1" <?= $record['ptkp'] == 'K/1' ? 'selected' : '' ?>>K/1</option>
                            <option value="K/2" <?= $record['ptkp'] == 'K/2' ? 'selected' : '' ?>>K/2</option>
                            <option value="K/3" <?= $record['ptkp'] == 'K/3' ? 'selected' : '' ?>>K/3</option>
                        </select>
                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                        <a href="../index.php" class="btn btn-secondary mt-3">Cancel</a>
                    </div>
                </div>
            </form>
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
