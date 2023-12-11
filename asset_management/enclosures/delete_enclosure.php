<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Check if the user is not logged in, redirect to login page
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Check if the user is an admin, otherwise deny access
if ($_SESSION['role'] !== 'Admin') {
    echo "Access denied. Only admins can access this page.";
    exit();
}

// Handle the deletion of the enclosure based on the ID from the query parameters
if (isset($_GET['id'])) {
    $enclosureId = $_GET['id'];

    // Perform the necessary database operations to delete the enclosure
    $deleteSql = "DELETE FROM Enclosure WHERE ID = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $enclosureId);
    $deleteStmt->execute();
    $deleteStmt->close();

    echo "Enclosure deleted successfully.";
} else {
    echo "Invalid request.";
}

header("Location: enclosure.php");
exit();
?>
