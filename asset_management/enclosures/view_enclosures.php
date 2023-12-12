<?php
// Include the common database connection file
include '../includes/db_connection.php';

session_start();

// Fetch enclosures from the database
$sql = "SELECT e.ID, e.SqFt, b.Name AS BuildingName
        FROM Enclosure e
        JOIN Building b ON e.BuildingID = b.ID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enclosure Management</title>
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
            padding: 10px 20px;
            text-decoration: none;
            border: 1px solid #333;
            text-align: center;
            margin-top: 20px;
            border-radius: 4px;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #333;
        }

        th {
            background-color: #ddd;
        }

        tr:nth-child(even) {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h2>Enclosure Management</h2>

    <a href="create_enclosure.php">Create New Enclosure</a>

    <table>
        <tr>
            <th>Enclosure ID</th>
            <th>SqFt</th>
            <th>Building</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['SqFt']; ?></td>
                <td><?php echo $row['BuildingName']; ?></td>
                <td>
                    <a href="update_enclosure.php?id=<?php echo $row['ID']; ?>">Update</a> 
                    <?php if ($_SESSION['role'] === 'Admin'): ?>
                       <a href="delete_enclosure.php?id=<?php echo $row['ID']; ?>">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

