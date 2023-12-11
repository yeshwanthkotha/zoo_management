<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch attractions from the database
$sql = "SELECT * FROM AttractionsDaily";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attractions</title>
</head>
<body>
    <h2>Attractions</h2>

    <a href="create_attraction.php">Create New Attraction</a>

    <!-- Display a paginated list of attractions with links to view, update, and delete -->
    <table border="1">
        <tr>
            <th>Attraction ID</th>
            <th>Name</th>
            <th>Date</th>
            <th>Attendance</th>
            <th>Revenue</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['AttractionName']; ?></td>
                <td><?php echo $row['Date']; ?></td>
                <td><?php echo $row['Attendance']; ?></td>
                <td><?php echo $row['Revenue']; ?></td>
                <td>
                    <a href="update_attraction.php?id=<?php echo $row['ID']; ?>">Update</a> |
                    <a href="delete_attraction.php?id=<?php echo $row['ID']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
