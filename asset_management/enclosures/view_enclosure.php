<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve enclosure details based on the ID from the query parameters
if (isset($_GET['id'])) {
    $enclosureId = $_GET['id'];
    $sql = "SELECT e.ID, e.SqFt, b.Name AS BuildingName
            FROM Enclosure e
            JOIN Building b ON e.BuildingID = b.ID
            WHERE e.ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $enclosureId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $enclosure = $result->fetch_assoc();
    } else {
        echo "Enclosure not found.";
        exit();
    }

    $stmt->close();
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Enclosure</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(144, 238, 144, 0.3); /* Light green with reduced opacity */
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
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
    <h2>View Enclosure</h2>

    <!-- Display enclosure details -->
    <p><strong>Enclosure ID:</strong> <?php echo $enclosure['ID']; ?></p>
    <p><strong>SqFt:</strong> <?php echo $enclosure['SqFt']; ?></p>
    <p><strong>Building:</strong> <?php echo $enclosure['BuildingName']; ?></p>

    <a href="view_enclosures.php">Back to Enclosures</a>
</body>
</html>
