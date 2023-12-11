<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch Cares For relationships from the database
$sql = "SELECT C.*, E.FirstName, E.LastName, S.Name 
        FROM CaresFor C
        JOIN Employee E ON C.EmployeeID = E.EmployeeID
        JOIN Species S ON C.SpeciesID = S.ID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cares For Relationships</title>
</head>
<body>
    <h2>Cares For Relationships</h2>

    <a href="create_cares_for.php">Create New Relationship</a>

    <!-- Display a paginated list of Cares For relationships with links to update and delete -->
    <table border="1">
        <tr>
            <th>Employee</th>
            <th>Species</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['FirstName'] . ' ' . $row['LastName']; ?></td>
                <td><?php echo $row['Name']; ?></td>
                <td>
                    <a href="update_cares_for.php?id=<?php echo $row['EmployeeID']; ?>&speciesId=<?php echo $row['SpeciesID']; ?>">Update</a> |
                    <a href="delete_cares_for.php?id=<?php echo $row['EmployeeID']; ?>&speciesId=<?php echo $row['SpeciesID']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
