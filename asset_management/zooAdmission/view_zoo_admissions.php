<?php
// Include the common database connection file
include '../includes/db_connection.php';
session_start();
// Fetch zoo admissions from the database
$sql = "SELECT ZooAdmission.ID, RevenueType.Name AS RevenueTypeName, SeniorPrice, AdultPrice, ChildPrice 
        FROM ZooAdmission
        JOIN RevenueType ON ZooAdmission.ID = RevenueType.ID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Admissions Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }

        a {
            display: block;
            text-align: center;
            margin: 10px 0;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <h2>Zoo Admissions Management</h2>

    <a href="create_zoo_admission.php">Create New Zoo Admission</a>

    <!-- Display a paginated list of zoo admissions with links to view, update, and delete -->
    <table>
        <tr>
            <th>Zoo Admission ID</th>
            <th>Revenue Type</th>
            <th>Senior Price</th>
            <th>Adult Price</th>
            <th>Child Price</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['RevenueTypeName']; ?></td>
                <td><?php echo $row['SeniorPrice']; ?></td>
                <td><?php echo $row['AdultPrice']; ?></td>
                <td><?php echo $row['ChildPrice']; ?></td>
                <td>
                    <a href="update_zoo_admission.php?id=<?php echo $row['ID']; ?>">Update</a>
                    <?php if ($_SESSION['role'] === 'Admin') : ?>
                        <a href="delete_zoo_admission.php?id=<?php echo $row['ID']; ?>">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

