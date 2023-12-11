<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch attendance from the database
$sql = "SELECT * FROM AttendanceDaily";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
</head>
<body>
    <h2>Attendance</h2>

    <a href="create_attendance.php">Create New Attendance Entry</a>

    <!-- Display a paginated list of attendance with links to view, update, and delete -->
    <table border="1">
        <tr>
            <th>Attendance ID</th>
            <th>Date</th>
            <th>Attendance</th>
            <th>Revenue</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['Date']; ?></td>
                <td><?php echo $row['Attendance']; ?></td>
                <td><?php echo $row['Revenue']; ?></td>
                <td>
                    <a href="update_attendance.php?id=<?php echo $row['ID']; ?>">Update</a> |
                    <a href="delete_attendance.php?id=<?php echo $row['ID']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
