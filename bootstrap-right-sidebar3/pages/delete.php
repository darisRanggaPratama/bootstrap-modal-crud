<?php
require_once '../config/database.php';

$db = new Database();
$conn = $db->conn;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $conn->prepare("DELETE FROM tmhs WHERE id_mhs = ?");
    
    if ($stmt->execute([$id])) {
        header("Location: ../index.php?status=deleted");
    } else {
        echo "Gagal menghapus data";
    }
} else {
    echo "ID tidak ditemukan";
}
?>