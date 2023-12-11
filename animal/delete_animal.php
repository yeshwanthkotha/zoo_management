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
    echo "Access denied. Only admins can delete animals.";
    exit();
}

// Handle the deletion of the animal based on the ID from the query parameters
if (isset($_GET['id'])) {
    $animalId = $_GET['id'];

    // Perform the necessary database operations to delete the animal
    $deleteSql = "DELETE FROM Animal WHERE ID = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $animalId);
    $deleteStmt->execute();
    $deleteStmt->close();

    echo "Animal deleted successfully.";
} else {
    echo "Invalid request.";
}

header("Location: view_animals.php");
exit();
?>
