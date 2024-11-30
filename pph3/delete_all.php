<?php
session_start();
require_once 'config/database.php';

try {
    // Create database connection
    $db = new Database();
    $conn = $db->getConnection();

    // Prepare and execute DELETE query
    $stmt = $conn->prepare("DELETE FROM upah");
    $result = $stmt->execute();

    // Prepare and execute AUTO_INCREMENT reset
    $resetStmt = $conn->prepare("ALTER TABLE upah AUTO_INCREMENT = 1");
    $resetStmt->execute();

    // Set success message in session
    $_SESSION['upload_message'] = "Seluruh data upah berhasil dihapus.";

    // Redirect back to index page
    header("Location: index.php");
    exit();

} catch(PDOException $e) {
    // Set error message in session if something goes wrong
    $_SESSION['upload_message'] = "Gagal menghapus data: " . $e->getMessage();
    header("Location: index.php");
    exit();
}
?>
