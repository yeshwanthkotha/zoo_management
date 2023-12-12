<?php
// Include the common database connection file
include '../includes/db_connection.php';
// Start the session
session_start();
// Fetch concessions from the database
$sql = "SELECT C.ID, RT.Name AS RevenueType, C.Product
        FROM Concession AS C
        JOIN RevenueType AS RT ON C.ID = RT.ID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concessions Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #fff;
            color: #333;
        }

        h2 {
            text-align: center;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            background-color: transparent;
            border: 1px solid #333;
            padding: 10px 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h2>Concessions Management</h2>

    <a href="create_concession.php">Create New Concession</a>

    <!-- Display a paginated list of concessions with links to update and delete -->
    <table border="1">
        <tr>
            <th>Concession ID</th>
            <th>Revenue Type</th>
            <th>Product</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['RevenueType']; ?></td>
                <td><?php echo $row['Product']; ?></td>
                <td>
                    <a href="update_concession.php?id=<?php echo $row['ID']; ?>">Update</a>
                    <?php if ($_SESSION['role'] === 'Admin') : ?>
                        <a href="delete_concession.php?id=<?php echo $row['ID']; ?>">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
