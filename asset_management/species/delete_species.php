<?php
// Include the common database connection file
include '../includes/db_connection.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Check if the user is an admin, otherwise deny access
if ($_SESSION['role'] !== 'Admin') {
    echo "Access denied. Only admins can delete animals.";
    exit();
}

// Check if species ID is provided in the URL
if (isset($_GET['id'])) {
    $speciesId = $_GET['id'];

    // Perform the necessary database operations to delete the species
    $deleteSql = "DELETE FROM Species WHERE ID = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $speciesId);
    $deleteStmt->execute();
    $deleteStmt->close();

    echo "Species deleted successfully.";
} else {
    echo "Species ID not provided.";
}
?>
