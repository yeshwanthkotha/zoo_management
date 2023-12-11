<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve the Hourly Rate ID from the URL parameter
$hourlyRateID = $_GET['id'];

// Delete the hourly rate from the database
$deleteSql = "DELETE FROM HourlyRate WHERE ID = ?";
$stmt = $conn->prepare($deleteSql);
$stmt->bind_param("i", $hourlyRateID);
$stmt->execute();
$stmt->close();

echo "Hourly Rate deleted successfully.";

// Redirect to the view page
header("Location: view_hourly_rates.php");
exit();
?>
