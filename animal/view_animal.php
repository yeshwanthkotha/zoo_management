<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch animals data
$animalsSql = "SELECT * FROM Animal";
$animalsResult = $conn->query($animalsSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Animals</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
            color: #333;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>View Animals</h2>

    <!-- Display animals data as a list -->
    <?php if ($animalsResult->num_rows > 0) : ?>
        <ul>
            <?php while ($animal = $animalsResult->fetch_assoc()) : ?>
                <li>ID: <?php echo $animal['ID']; ?></li>
                <li>Status: <?php echo $animal['Status']; ?></li>
                <li>Birth Year: <?php echo $animal['BirthYear']; ?></li>
                <li>Species ID: <?php echo $animal['SpeciesID']; ?></li>
                <li>Building ID: <?php echo $animal['BuildingID']; ?></li>
                <li>Enclosure ID: <?php echo $animal['EnclosureID']; ?></li>
            <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <p>No animals found.</p>
    <?php endif; ?>

    <br>

    <a href="../dashboard.php">Go to Dashboard</a>
</body>
</html>

