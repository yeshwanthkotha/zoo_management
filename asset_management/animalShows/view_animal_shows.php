<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch animal shows from the database
$sql = "SELECT ASH.ID, RT.Name AS RevenueType, ASH.ShowsPerDay, ASH.SeniorPrice, ASH.AdultPrice, ASH.ChildPrice
        FROM AnimalShow AS ASH
        JOIN RevenueType AS RT ON ASH.ID = RT.ID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Shows Management</title>
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
            margin-bottom: 10px;
            display: inline-block;
            text-decoration: none;
            color: blue;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid black;
            padding: 5px;
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
    <h2>Animal Shows Management</h2>

    <a href="create_animal_show.php">Create New Animal Show</a>

    <!-- Display a paginated list of animal shows with links to update and delete -->
    <table>
        <tr>
            <th>Animal Show ID</th>
            <th>Revenue Type</th>
            <th>Shows Per Day</th>
            <th>Senior Price</th>
            <th>Adult Price</th>
            <th>Child Price</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['ID']); ?></td>
                <td><?php echo htmlspecialchars($row['RevenueType']); ?></td>
                <td><?php echo htmlspecialchars($row['ShowsPerDay']); ?></td>
                <td><?php echo htmlspecialchars($row['SeniorPrice']); ?></td>
                <td><?php echo htmlspecialchars($row['AdultPrice']); ?></td>
                <td><?php echo htmlspecialchars($row['ChildPrice']); ?></td>
                <td>
                    <a href="update_animal_show.php?id=<?php echo htmlspecialchars($row['ID']); ?>">Update</a> |
                    <a href="delete_animal_show.php?id=<?php echo htmlspecialchars($row['ID']); ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
