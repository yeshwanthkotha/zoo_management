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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        select, button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            margin-top: 15px;
            cursor: pointer;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Update Cares For Relationship</h2>

    <!-- Cares For relationship update form -->
    <form method="post" action="">
        <label for="newEmployeeID">New Employee:</label>
        <select name="newEmployeeID" required>
            <?php
            // Fetch and display available employees in dropdown
            $employeeSql = "SELECT EmployeeID, FirstName, LastName FROM Employee";
            $employeeResult = $conn->query($employeeSql);
            while ($employee = $employeeResult->fetch_assoc()) {
                echo '<option value="' . $employee['EmployeeID'] . '">' . $employee['FirstName'] . ' ' . $employee['LastName'] . '</option>';
            }
            ?>
        </select>

        <label for="newSpeciesID">New Species:</label>
        <select name="newSpeciesID" required>
            <?php
            // Fetch and display available species in dropdown
            $speciesSql = "SELECT ID, Name FROM Species";
            $speciesResult = $conn->query($speciesSql);
            while ($species = $speciesResult->fetch_assoc()) {
                echo '<option value="' . $species['ID'] . '">' . $species['Name'] . '</option>';
            }
            ?>
        </select>

        <button type="submit" name="updateCaresFor">Update Relationship</button>
    </form>

    <a href="view_cares_for.php">Back to Cares For Relationships</a>
</body>
</html>


