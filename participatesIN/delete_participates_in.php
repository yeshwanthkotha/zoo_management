<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve the Species ID and Animal Show ID from the URL parameters
$speciesID = $_GET['speciesId'];
$animalShowID = $_GET['animalShowId'];

// Delete the Participates In relationship record from the database
$deleteSql = "DELETE FROM ParticipatesIN WHERE SpeciesID = ? AND AnimalShowID = ?";
$stmt = $conn->prepare($deleteSql);
$stmt->bind_param("ii", $speciesID, $animalShowID);
$stmt->execute();
$stmt->close();

header("Location: view_participates_in.php");
exit();
?>
