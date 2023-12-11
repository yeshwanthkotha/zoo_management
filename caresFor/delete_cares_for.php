<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve the Employee ID and Species ID from the URL parameters
$employeeID = $_GET['id'];
$speciesID = $_GET['speciesId'];

// Delete the Cares For relationship record from the database
$deleteSql = "DELETE FROM CaresFor WHERE EmployeeID = ? AND SpeciesID = ?";
$stmt = $conn->prepare($deleteSql);
$stmt->bind_param("ii", $employeeID, $speciesID);
$stmt->execute();
$stmt->close();

header("Location: view_cares_for.php");
exit();
?>
