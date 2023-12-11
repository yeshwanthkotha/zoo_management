<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Check if the employee ID is provided in the URL
if (isset($_GET['id'])) {
    $employeeId = $_GET['id'];

    // Fetch employee details
    $fetchSql = "SELECT * FROM Employee WHERE EmployeeID = ?";
    $fetchStmt = $conn->prepare($fetchSql);
    $fetchStmt->bind_param("i", $employeeId);
    $fetchStmt->execute();
    $employeeResult = $fetchStmt->get_result();

    if ($employeeResult->num_rows == 1) {
        $employee = $employeeResult->fetch_assoc();
    } else {
        echo "Employee not found.";
        exit();
    }

    // Close the prepared statement
    $fetchStmt->close();
} else {
    echo "Employee ID not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        p {
            margin-bottom: 10px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Employee Details</h2>

    <p><strong>Employee ID:</strong> <?php echo htmlspecialchars($employee['EmployeeID']); ?></p>
    <p><strong>Start Date:</strong> <?php echo htmlspecialchars($employee['StartDate']); ?></p>
    <p><strong>Job Type:</strong> <?php echo htmlspecialchars($employee['JobType']); ?></p>
    <p><strong>Full Name:</strong> <?php echo htmlspecialchars($employee['FirstName']) . ' ' . htmlspecialchars($employee['LastName']); ?></p>
    <p><strong>Middle Name:</strong> <?php echo htmlspecialchars($employee['MiddleName']); ?></p>
    <p><strong>Last Name:</strong> <?php echo htmlspecialchars($employee['LastName']); ?></p>
    <p><strong>Street:</strong> <?php echo htmlspecialchars($employee['Street']); ?></p>
    <p><strong>City:</strong> <?php echo htmlspecialchars($employee['City']); ?></p>
    <p><strong>State:</strong> <?php echo htmlspecialchars($employee['State']); ?></p>
    <p><strong>Zip:</strong> <?php echo htmlspecialchars($employee['Zip']); ?></p>
    <p><strong>Supervisor ID:</strong> <?php echo htmlspecialchars($employee['SuperID']); ?></p>
    <p><strong>Hourly Rate ID:</strong> <?php echo htmlspecialchars($employee['HourlyRateID']); ?></p>
    <p><strong>Concession ID:</strong> <?php echo htmlspecialchars($employee['ConcessionID']); ?></p>
    <p><strong>Zoo Admission ID:</strong> <?php echo htmlspecialchars($employee['ZooAdmissionID']); ?></p>

    <!-- Add more details as needed -->
</body>
</html>
