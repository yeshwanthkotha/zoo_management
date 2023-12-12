<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch available employees and species for dropdowns
$employeeSql = "SELECT EmployeeID, FirstName, LastName FROM Employee";
$employeeResult = $conn->query($employeeSql);

$speciesSql = "SELECT ID, Name FROM Species";
$speciesResult = $conn->query($speciesSql);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createCaresFor"])) {
    // Perform additional validation and handle the creation of a new record
    $employeeID = $_POST["employeeID"];
    $speciesID = $_POST["speciesID"];

    // Check if the combination of EmployeeID and SpeciesID already exists
    $checkSql = "SELECT * FROM CaresFor WHERE EmployeeID = ? AND SpeciesID = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ii", $employeeID, $speciesID);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows == 0) {
        // Combination does not exist, proceed to insert
        $insertSql = "INSERT INTO CaresFor (EmployeeID, SpeciesID) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("ii", $employeeID, $speciesID);
        $insertStmt->execute();
        $insertStmt->close();
        echo "Relationship created successfully.";
    } else {
        echo "Relationship already exists.";
    }

    $checkStmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Cares For Relationship</title>
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
    <h2>Create Cares For Relationship</h2>

    <!-- Cares For creation form -->
    <form method="post" action="">
        <label for="employeeID">Employee:</label>
        <select name="employeeID" required>
            <?php while ($employee = $employeeResult->fetch_assoc()) : ?>
                <option value="<?php echo $employee['EmployeeID']; ?>">
                    <?php echo $employee['FirstName'] . ' ' . $employee['LastName']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="speciesID">Species:</label>
        <select name="speciesID" required>
            <?php while ($species = $speciesResult->fetch_assoc()) : ?>
                <option value="<?php echo $species['ID']; ?>"><?php echo $species['Name']; ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit" name="createCaresFor">Create Relationship</button>
    </form>

    <a href="view_cares_for.php">Back to Cares For Relationships</a>
</body>
</html>

