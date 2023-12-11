<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch employees from the database
$sql = "SELECT * FROM Employee";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
        }

        h2 {
            text-align: center;
        }

        a {
            color: blue;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h2>Employee Management</h2>

    <a href="create_employee.php">Create New Employee</a>

    <!-- Display a list of employees with links to view, update, and delete -->
    <table>
        <tr>
            <th>Employee ID</th>
            <th>Start Date</th>
            <th>Job Type</th>
            <th>Full Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Street</th>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
            <th>Supervisor ID</th>
            <th>Hourly Rate ID</th>
            <th>Concession ID</th>
            <th>Zoo Admission ID</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['EmployeeID']); ?></td>
                <td><?php echo htmlspecialchars($row['StartDate']); ?></td>
                <td><?php echo htmlspecialchars($row['JobType']); ?></td>
                <td><?php echo htmlspecialchars($row['FirstName']) . ' ' . htmlspecialchars($row['LastName']); ?></td>
                <td><?php echo htmlspecialchars($row['MiddleName']); ?></td>
                <td><?php echo htmlspecialchars($row['LastName']); ?></td>
                <td><?php echo htmlspecialchars($row['Street']); ?></td>
                <td><?php echo htmlspecialchars($row['City']); ?></td>
                <td><?php echo htmlspecialchars($row['State']); ?></td>
                <td><?php echo htmlspecialchars($row['Zip']); ?></td>
                <td><?php echo htmlspecialchars($row['SuperID']); ?></td>
                <td><?php echo htmlspecialchars($row['HourlyRateID']); ?></td>
                <td><?php echo htmlspecialchars($row['ConcessionID']); ?></td>
                <td><?php echo htmlspecialchars($row['ZooAdmissionID']); ?></td>
                <td>
                    <a href="view_employee.php?id=<?php echo htmlspecialchars($row['EmployeeID']); ?>">View</a>
                    <a href="update_employee.php?id=<?php echo htmlspecialchars($row['EmployeeID']); ?>">Update</a>
                    <a href="delete_employee.php?id=<?php echo htmlspecialchars($row['EmployeeID']); ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>


