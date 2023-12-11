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
                    <a href="update_concession.php?id=<?php echo $row['ID']; ?>">Update</a> |
                    <?php if ($_SESSION['role'] === 'Admin') : ?>
                        <a href="delete_concession.php?id=<?php echo $row['ID']; ?>">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
