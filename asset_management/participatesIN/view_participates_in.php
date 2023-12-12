<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch Participates In relationships from the database
$sql = "SELECT P.*, S.ID AS SpeciesID, A.ID AS AnimalShowID 
        FROM ParticipatesIN P
        JOIN Species S ON P.SpeciesID = S.ID
        JOIN AnimalShow A ON P.AnimalShowID = A.ID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participates In Relationships</title>
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
            margin-top: 10px;
            text-decoration: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Participates In Relationships</h2>

    <a href="create_participates_in.php">Create New Relationship</a>

    <!-- Display a paginated list of Participates In relationships with links to update and delete -->
    <table>
        <tr>
            <th>Species ID</th>
            <th>Animal Show ID</th>
            <th>Required</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['SpeciesID']; ?></td>
                <td><?php echo $row['AnimalShowID']; ?></td>
                <td><?php echo $row['Reqd']; ?></td>
                <td>
                    <a href="update_participates_in.php?speciesId=<?php echo $row['SpeciesID']; ?>&animalShowId=<?php echo $row['AnimalShowID']; ?>">Update</a>
                    <a href="delete_participates_in.php?speciesId=<?php echo $row['SpeciesID']; ?>&animalShowId=<?php echo $row['AnimalShowID']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

