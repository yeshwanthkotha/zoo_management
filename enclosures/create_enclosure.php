<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch available buildings for dropdown
$buildingSql = "SELECT ID, Name FROM Building";
$buildingResult = $conn->query($buildingSql);

// Handle enclosure creation form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createEnclosure"])) {
    $buildingId = $_POST["buildingId"];
    $sqFt = $_POST["sqFt"];

    // Perform the necessary database operations to create a new enclosure
    $createSql = "INSERT INTO Enclosure (BuildingID, SqFt) VALUES (?, ?)";
    $createStmt = $conn->prepare($createSql);
    $createStmt->bind_param("ii", $buildingId, $sqFt);
    
    if ($createStmt->execute()) {
        echo "Enclosure created successfully.";
    } else {
        echo "Error creating enclosure: " . $createStmt->error;
    }

    $createStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Enclosure</title>
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

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
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

        a:hover {
            background-color: #2980b9;
        }

    </style>
</head>
<body>
    <h2>Create Enclosure</h2>

    <!-- Enclosure creation form -->
    <form method="post" action="">
        <label for="buildingId">Building:</label>
        <select name="buildingId" required>
            <?php while ($building = $buildingResult->fetch_assoc()) : ?>
                <option value="<?php echo $building['ID']; ?>"><?php echo $building['Name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="sqFt">Square Footage:</label>
        <input type="number" name="sqFt" required><br>

        <button type="submit" name="createEnclosure">Create Enclosure</button>
    </form>

    <a href="view_enclosures.php">Back to Enclosures</a>
</body>
</html>
