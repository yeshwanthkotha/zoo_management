<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Start the session
session_start();

// Fetch buildings from the database
$sql = 'SELECT * FROM Building';
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Building Management</title>
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

        a {
            padding: 8px 15px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 5px;
        }

        table {
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Building Management</h2>

    <a href="create_building.php">Create New Building</a>

    <!-- Display a paginated list of buildings with links to view, update, and delete -->
    <table>
        <tr>
            <th>Building ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['ID']); ?></td>
                <td><?php echo htmlspecialchars($row['Name']); ?></td>
                <td><?php echo htmlspecialchars($row['Type']); ?></td>
                <td>
                    <a href="view_building.php?id=<?php echo htmlspecialchars($row['ID']); ?>">View</a> 
                    <a href="update_building.php?id=<?php echo htmlspecialchars($row['ID']); ?>">Update</a> 
                    <?php if ($_SESSION['role'] === 'Admin'): ?>
                        <a href="delete_building.php?id=<?php echo htmlspecialchars($row['ID']); ?>">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
