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
// Retrieve the Zoo Admission ID from the URL parameter
$zooAdmissionId = $_GET['id'];

// Delete the Zoo Admission record from the database
$deleteSql = "DELETE FROM ZooAdmission WHERE ID = ?";
$stmt = $conn->prepare($deleteSql);
$stmt->bind_param("i", $zooAdmissionId);
$stmt->execute();
$stmt->close();

header("Location: view_zoo_admissions.php");
exit();
?>
