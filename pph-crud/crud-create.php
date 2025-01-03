<?php
require_once 'database.php';
require_once 'functions.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $db = new Database();
        $conn = $db->getConnection();

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

        $stmt = $conn->prepare("INSERT INTO upah (nik, name, gaji, hadir_pusat, hadir_proyek, konsumsi, lembur, tunjang_lain, jkk, jkm, sehat, ptkp) VALUES (:nik, :name, :gaji, :hadir_pusat, :hadir_proyek, :konsumsi, :lembur, :tunjang_lain, :jkk, :jkm, :sehat, :ptkp)");
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
            $_SESSION['alert'] = displayAlert('success', 'Data berhasil ditambahkan');
        } else {
            $_SESSION['alert'] = displayAlert('danger', 'Gagal menambahkan data');
        }
    } catch(PDOException $e) {
        $_SESSION['alert'] = displayAlert('danger', 'Error: ' . $e->getMessage());
    }

    header('Location: home.php');
    exit();
}


