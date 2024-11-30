<?php
// delete.php
require_once '../config/database.php';

$db = new Database();
$conn = $db->getConnection();

// Cek ID yang akan dihapus
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

try {
    // Persiapkan statement untuk menghapus data
    $stmt = $conn->prepare("DELETE FROM upah WHERE id = :id");
    $stmt->execute([':id' => $id]);

    // Redirect ke halaman utama dengan pesan sukses
    header("Location: ../index.php?message=Data_berhasil_dihapus");
    exit();
} catch(PDOException $e) {
    // Jika terjadi kesalahan, redirect dengan pesan error
    header("Location: ../index.php?error=" . urlencode($e->getMessage()));
    exit();
}
?>
