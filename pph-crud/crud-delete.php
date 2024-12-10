<?php
session_start();

require_once 'database.php';
require_once 'functions.php';

if (isset($_GET['id'])) {
    try {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("DELETE FROM upah WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['alert'] = displayAlert('success', 'Data berhasil dihapus');
        } else {
            $_SESSION['alert'] = displayAlert('danger', 'Gagal menghapus data');
        }
    } catch(PDOException $e) {
        $_SESSION['alert'] = displayAlert('danger', 'Error: ' . $e->getMessage());
    }

    header('Location: home.php');
    exit();
}
?>

