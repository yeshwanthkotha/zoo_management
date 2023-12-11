<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve the Employee ID and Species ID from the URL parameters
$employeeID = $_GET['id'];
$speciesID = $_GET['speciesId'];

// Fetch the current Cares For relationship details
$sql = "SELECT * FROM CaresFor WHERE EmployeeID = ? AND SpeciesID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $employeeID, $speciesID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

// Handle form submission for updating the Cares For relationship
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateCaresFor"])) {
    $newEmployeeID = $_POST["newEmployeeID"];
    $newSpeciesID = $_POST["newSpeciesID"];

    // Update the Cares For relationship details in the database
    $updateSql = "UPDATE CaresFor SET EmployeeID = ?, SpeciesID = ? WHERE EmployeeID = ? AND SpeciesID = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("iiii", $newEmployeeID, $newSpeciesID, $employeeID, $speciesID);
    $stmt->execute();
    $stmt->close();

    echo "Cares For relationship updated successfully.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Cares For Relationship</title>
</head>
<body>
    <h2>Update Cares For Relationship</h2>

    <!-- Cares For relationship update form -->
    <form method="post" action="">
        <label for="newEmployeeID">New Employee:</label>
        <select name="newEmployeeID" required>
            <!-- Fetch and display available employees in dropdown -->
        </select><br>

        <label for="newSpeciesID">New Species:</label>
        <select name="newSpeciesID" required>
            <!-- Fetch and display available species in dropdown -->
        </select><br>

        <button type="submit" name="updateCaresFor">Update Relationship</button>
    </form>

    <a href="view_cares_for.php">Back to Cares For Relationships</a>
</body>
</html>
