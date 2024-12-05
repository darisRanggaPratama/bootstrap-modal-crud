<?php
require_once 'database.php';
require_once 'functions.php';

session_start();

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Begin transaction
    $conn->beginTransaction();

    // Disable foreign key checks temporarily
    $conn->exec('SET FOREIGN_KEY_CHECKS = 0');

    // Truncate the table to remove all data
    $conn->exec('TRUNCATE TABLE upah');

    // Enable foreign key checks back
    $conn->exec('SET FOREIGN_KEY_CHECKS = 1');

    // Commit transaction
    $conn->commit();

    // Set success message
    $_SESSION['alert'] = displayAlert('success', 'All data has been successfully deleted and ID counter has been reset.');

} catch (PDOException $e) {
    // Rollback transaction on error
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    // Set error message
    $_SESSION['alert'] = displayAlert('danger', 'Error: Unable to delete all data. ' . $e->getMessage());

    // Log the error
    error_log("Error in erase_all.php: " . $e->getMessage());
}

// Redirect back to index page
header('Location: index.php');
exit;
