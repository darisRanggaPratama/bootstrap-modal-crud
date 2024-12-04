<?php
require_once 'database.php';
require_once 'functions.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $db = new Database();
        $conn = $db->getConnection();

        $id = (int)$_POST['id'];
        $nik = sanitizeInput($_POST['nik']);
        $name = sanitizeInput($_POST['name']);
        $gaji = (int)$_POST['gaji'];
        $hadir_pusat = (int)$_POST['hadir_pusat'];
        $hadir_proyek = (int)$_POST['hadir_proyek'];
        $konsumsi = (int)$_POST['konsumsi'];
        $lembur = (int)$_POST['lembur'];
        $tunjang_lain = (int)$_POST['tunjang_lain'];
        $jkk = (int)$_POST['jkk'];
        $jkm = (int)$_POST['jkm'];
        $sehat = (int)$_POST['sehat'];
        $ptkp = sanitizeInput($_POST['ptkp']);

        $stmt = $conn->prepare("UPDATE upah SET nik = :nik, name = :name, gaji = :gaji, hadir_pusat = :hadir_pusat, hadir_proyek = :hadir_proyek, konsumsi = :konsumsi, lembur = :lembur, tunjang_lain = :tunjang_lain, jkk = :jkk, jkm = :jkm, sehat = :sehat, ptkp = :ptkp WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nik', $nik);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':gaji', $gaji);
        $stmt->bindParam(':hadir_pusat', $hadir_pusat);
        $stmt->bindParam(':hadir_proyek', $hadir_proyek);
        $stmt->bindParam(':konsumsi', $konsumsi);
        $stmt->bindParam(':lembur', $lembur);
        $stmt->bindParam(':tunjang_lain', $tunjang_lain);
        $stmt->bindParam(':jkk', $jkk);
        $stmt->bindParam(':jkm', $jkm);
        $stmt->bindParam(':sehat', $sehat);
        $stmt->bindParam(':ptkp', $ptkp);

        if ($stmt->execute()) {
            $_SESSION['alert'] = displayAlert('success', 'Data berhasil diupdate');
        } else {
            $_SESSION['alert'] = displayAlert('danger', 'Gagal mengupdate data');
        }
    } catch(PDOException $e) {
        $_SESSION['alert'] = displayAlert('danger', 'Error: ' . $e->getMessage());
    }

    header('Location: index.php');
    exit();
}

// Fetch single record for editing
if (isset($_GET['id'])) {
    try {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT * FROM upah WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>