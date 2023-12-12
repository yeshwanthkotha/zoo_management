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
    <h2>Hourly Rates</h2>

    <a href="create_hourly_rate.php">Create New Hourly Rate</a>

    <!-- Display a paginated list of hourly rates with links to update and delete -->
    <table>
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
                    <a href="update_hourly_rate.php?id=<?php echo $row['ID']; ?>">Update</a>
                    <a href="delete_hourly_rate.php?id=<?php echo $row['ID']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

