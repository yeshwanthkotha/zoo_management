<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch available employees for the supervisor dropdown
$employeesSql = "SELECT EmployeeID, CONCAT(FirstName, ' ', LastName) AS FullName FROM Employee";
$employeesResult = $conn->query($employeesSql);

// Fetch available hourly rates for the dropdown
$hourlyRatesSql = "SELECT ID, HourlyRate FROM HourlyRate";
$hourlyRatesResult = $conn->query($hourlyRatesSql);

// Fetch available concessions for the dropdown
$concessionsSql = "SELECT ID, Product FROM Concession";
$concessionsResult = $conn->query($concessionsSql);

// Fetch available zoo admissions for the dropdown
$zooAdmissionsSql = "SELECT ID FROM ZooAdmission";
$zooAdmissionsResult = $conn->query($zooAdmissionsSql);

// Variables to store existing data
$existingData = array();

// Check if employee ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $employeeId = $_GET['id'];

    // Fetch employee data for the given ID
    $selectSql = "SELECT * FROM Employee WHERE EmployeeID = ?";
    $selectStmt = $conn->prepare($selectSql);
    $selectStmt->bind_param("i", $employeeId);
    $selectStmt->execute();
    $selectResult = $selectStmt->get_result();

    if ($selectResult->num_rows == 1) {
        $existingData = $selectResult->fetch_assoc();
    } else {
        echo "Employee not found.";
        exit();
    }

    $selectStmt->close();
} else {
    echo "Invalid employee ID.";
    exit();
}

// Handle form submission for updating an existing employee
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateEmployee"])) {
    $newJobType = $_POST["newJobType"];
    $newFirstName = $_POST["newFirstName"];
    $newMiddleName = $_POST["newMiddleName"];
    $newLastName = $_POST["newLastName"];
    $newStreet = $_POST["newStreet"];
    $newCity = $_POST["newCity"];
    $newState = $_POST["newState"];
    $newZip = $_POST["newZip"];
    $newSuperID = $_POST["newSuperID"];
    $newHourlyRateID = $_POST["newHourlyRateID"];
    $newConcessionID = $_POST["newConcessionID"];
    $newZooAdmissionID = $_POST["newZooAdmissionID"];

    // Perform the necessary database operations to update the employee
    $updateSql = "UPDATE Employee SET JobType = ?, FirstName = ?, MiddleName = ?, 
                  LastName = ?, Street = ?, City = ?, State = ?, Zip = ?, SuperID = ?, 
                  HourlyRateID = ?, ConcessionID = ?, ZooAdmissionID = ? WHERE EmployeeID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param(
        "ssssssssiiiii",
        $newJobType,
        $newFirstName,
        $newMiddleName,
        $newLastName,
        $newStreet,
        $newCity,
        $newState,
        $newZip,
        $newSuperID,
        $newHourlyRateID,
        $newConcessionID,
        $newZooAdmissionID,
        $employeeId
    );    
    $updateStmt->execute();
    $updateStmt->close();

    echo "Employee updated successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee</title>
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

        input[type="text"], select, button {
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
    <h2>Update Employee</h2>

    <!-- Employee update form -->
    <form method="post" action="">
        <!-- Fetch available employees for dropdown -->

        <?php if (!empty($existingData)) : ?>
            <!-- Add input fields for existing employee details -->
            <label for="newJobType">Existing Job Type:</label>
            <input type="text" name="newJobType" value="<?php echo $existingData['JobType']; ?>" required>

            <label for="newFirstName">Existing First Name:</label>
            <input type="text" name="newFirstName" value="<?php echo $existingData['FirstName']; ?>" required>

            <label for="newMiddleName">Existing Middle Name:</label>
            <input type="text" name="newMiddleName" value="<?php echo $existingData['MiddleName']; ?>">

            <label for="newLastName">Existing Last Name:</label>
            <input type="text" name="newLastName" value="<?php echo $existingData['LastName']; ?>" required>

            <label for="newStreet">Existing Street:</label>
            <input type="text" name="newStreet" value="<?php echo $existingData['Street']; ?>" required>

            <label for="newCity">Existing City:</label>
            <input type="text" name="newCity" value="<?php echo $existingData['City']; ?>" required>

            <label for="newState">Existing State:</label>
            <input type="text" name="newState" value="<?php echo $existingData['State']; ?>" required>

            <label for="newZip">Existing Zip:</label>
            <input type="text" name="newZip" value="<?php echo $existingData['Zip']; ?>" required>

            <label for="newSuperID">Existing Supervisor:</label>
            <select name="newSuperID">
                <option value="">None</option>
                <?php $employeesResult->data_seek(0); ?>
                <?php while ($employee = $employeesResult->fetch_assoc()) : ?>
                    <option value="<?php echo $employee['EmployeeID']; ?>" <?php echo ($employee['EmployeeID'] == $existingData['SuperID']) ? 'selected' : ''; ?>>
                        <?php echo $employee['FullName']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="newHourlyRateID">Existing Hourly Rate:</label>
            <select name="newHourlyRateID" required>
                <?php $hourlyRatesResult->data_seek(0); ?>
                <?php while ($hourlyRate = $hourlyRatesResult->fetch_assoc()) : ?>
                    <option value="<?php echo $hourlyRate['ID']; ?>" <?php echo ($hourlyRate['ID'] == $existingData['HourlyRateID']) ? 'selected' : ''; ?>>
                        <?php echo $hourlyRate['HourlyRate']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="newConcessionID">Existing Concession:</label>
            <select name="newConcessionID">
                <option value="">None</option>
                <?php $concessionsResult->data_seek(0); ?>
                <?php while ($concession = $concessionsResult->fetch_assoc()) : ?>
                    <option value="<?php echo $concession['ID']; ?>" <?php echo ($concession['ID'] == $existingData['ConcessionID']) ? 'selected' : ''; ?>>
                        <?php echo $concession['Product']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="newZooAdmissionID">Existing Zoo Admission:</label>
            <select name="newZooAdmissionID">
                <option value="">None</option>
                <?php $zooAdmissionsResult->data_seek(0); ?>
                <?php while ($zooAdmission = $zooAdmissionsResult->fetch_assoc()) : ?>
                    <option value="<?php echo $zooAdmission['ID']; ?>" <?php echo ($zooAdmission['ID'] == $existingData['ZooAdmissionID']) ? 'selected' : ''; ?>>
                        <?php echo $zooAdmission['ID']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

        <?php endif; ?>

        <button type="submit" name="updateEmployee">Update Employee</button>
    </form>

    <a href="view_employees.php">Back to Employees</a>
</body>
</html>

