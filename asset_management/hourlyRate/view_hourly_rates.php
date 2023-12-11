<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch hourly rates from the database
$sql = "SELECT * FROM HourlyRate";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Hourly Rates</title>
</head>
<body>
    <h2>Hourly Rates</h2>

    <a href="create_hourly_rate.php">Create New Hourly Rate</a>

    <!-- Display a paginated list of hourly rates with links to update and delete -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Hourly Rate</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['HourlyRate']; ?></td>
                <td>
                    <a href="update_hourly_rate.php?id=<?php echo $row['ID']; ?>">Update</a> |
                    <a href="delete_hourly_rate.php?id=<?php echo $row['ID']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
