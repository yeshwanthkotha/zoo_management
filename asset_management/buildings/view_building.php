<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve building details based on the ID from the query parameters
if (isset($_GET['id'])) {
    $buildingId = $_GET['id'];
    $sql = "SELECT * FROM Building WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $buildingId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $building = $result->fetch_assoc();
    } else {
        echo "Building not found.";
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
    <title>View Building</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h2, p {
            text-align: center;
            color: #333;
        }

        a {
            display: inline-block;
            padding: 8px 15px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>View Building</h2>

    <!-- Display building details -->
    <p><strong>Building ID:</strong> <?php echo htmlspecialchars($building['ID']); ?></p>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($building['Name']); ?></p>
    <p><strong>Type:</strong> <?php echo htmlspecialchars($building['Type']); ?></p>

    <div style="text-align: center;">
        <a href="view_buildings.php">Back to Buildings</a>
    </div>
</body>
</html>
