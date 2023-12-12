<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Start the session
session_start();

// Fetch animals with related information from referenced tables
$sql = "SELECT Animal.ID, Animal.Status, Animal.BirthYear, Species.Name AS SpeciesName, Enclosure.ID AS EnclosureID, Building.Name AS BuildingName
        FROM Animal
        LEFT JOIN Species ON Animal.SpeciesID = Species.ID
        LEFT JOIN Enclosure ON Animal.EnclosureID = Enclosure.ID
        LEFT JOIN Building ON Animal.BuildingID = Building.ID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 20px;
        }
        h2 {
            margin-bottom: 20px;
        }
        a {
            text-decoration: none;
            color: #333;
            margin-right: 10px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Animal Management</h2>

    <a href="create_animal.php">Create New Animal</a>

    <!-- Display a paginated list of animals with links to view, update, and delete -->
    <table>
        <tr>
            <th>Animal ID</th>
            <th>Status</th>
            <th>Birth Year</th>
            <th>Species Name</th>
            <th>Enclosure ID</th>
            <th>Building Name</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo isset($row['Status']) ? $row['Status'] : 'N/A'; ?></td>
                <td><?php echo isset($row['BirthYear']) ? $row['BirthYear'] : 'N/A'; ?></td>
                <td><?php echo isset($row['SpeciesName']) ? $row['SpeciesName'] : 'N/A'; ?></td>
                <td><?php echo isset($row['EnclosureID']) ? $row['EnclosureID'] : 'N/A'; ?></td>
                <td><?php echo isset($row['BuildingName']) ? $row['BuildingName'] : 'N/A'; ?></td>
                <td>
                    <a href="update_animal.php?id=<?php echo $row['ID']; ?>">Update</a> |
                    <?php if ($_SESSION['role'] === 'Admin') : ?>
                        <a href="delete_animal.php?id=<?php echo $row['ID']; ?>">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
