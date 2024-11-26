<?php
require_once '../config/database.php';

$db = new Database();
$conn = $db->conn;

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM tmhs WHERE id_mhs = ?");
$stmt->execute([$id]);
$mhs = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $prodi = $_POST['prodi'];

    $stmt = $conn->prepare("UPDATE tmhs SET nim = ?, nama = ?, alamat = ?, prodi = ? WHERE id_mhs = ?");
    
    if ($stmt->execute([$nim, $nama, $alamat, $prodi, $id])) {
        header("Location: ../index.php?status=updated");
    } else {
        $error = "Gagal update data";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Update Data Mahasiswa</h2>
        <form method="POST">
            <div class="mb-3">
                <label>NIM</label>
                <input type="text" name="nim" class="form-control" value="<?= $mhs['nim'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="<?= $mhs['nama'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" required><?= $mhs['alamat'] ?></textarea>
            </div>
            <div class="mb-3">
                <label>Prodi</label>
                <input type="text" name="prodi" class="form-control" value="<?= $mhs['prodi'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>