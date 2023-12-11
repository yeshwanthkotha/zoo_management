<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve the Attraction ID from the URL parameter
$attractionID = $_GET['id'];

// Delete the Attraction entry from the database
$deleteSql = "DELETE FROM AttractionsDaily WHERE ID = ?";
$stmt = $conn->prepare($deleteSql);
$stmt->bind_param("i", $attractionID);
$stmt->execute();
$stmt->close();

echo "Attraction deleted successfully.";

// Redirect to the Attractions view page after deletion
header("Location: view_attractions.php");
exit();
?>
