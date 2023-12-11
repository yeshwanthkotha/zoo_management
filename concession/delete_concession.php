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
// Check if ID parameter is present in the URL
if (isset($_GET['id'])) {
    $concessionId = $_GET['id'];

    // Delete the concession from the database
    $deleteSql = "DELETE FROM Concession WHERE ID = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $concessionId);
    $deleteStmt->execute();

    echo "Concession deleted successfully.";
} else {
    echo "Invalid request.";
}

// Redirect to the concessions view page
header("Location: view_concessions.php");
exit();
?>
