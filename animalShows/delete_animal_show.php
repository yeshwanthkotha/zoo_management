<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch the ID of the animal show to be deleted
$showId = $_GET['id'];

// Prepare and execute the SQL statement to delete the animal show
$deleteSql = "DELETE FROM AnimalShow WHERE ID = ?";
$deleteStmt = $conn->prepare($deleteSql);
$deleteStmt->bind_param("i", $showId);
$deleteStmt->execute();
$deleteStmt->close();

// Redirect back to the animal shows list page
header("Location: view_animal_shows.php");
exit();
?>
