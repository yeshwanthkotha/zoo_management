<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Check if enclosure ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $enclosureId = $_GET['id'];

    // Fetch enclosure data for the given ID
    $selectSql = "SELECT BuildingID, SqFt FROM Enclosure WHERE ID = ?";
    $selectStmt = $conn->prepare($selectSql);
    $selectStmt->bind_param("i", $enclosureId);
    $selectStmt->execute();
    $selectResult = $selectStmt->get_result();

    if ($selectResult->num_rows == 1) {
        $enclosureData = $selectResult->fetch_assoc();
        $buildingId = $enclosureData['BuildingID'];
        $sqFt = $enclosureData['SqFt'];
    } else {
        echo "Enclosure not found.";
        exit();
    }

    $selectStmt->close();
} else {
    echo "Invalid enclosure ID.";
    exit();
}

// Handle enclosure update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateEnclosure"])) {
    $buildingId = $_POST["buildingId"];
    $sqFt = $_POST["sqFt"];

    // Perform the necessary database operations to update the enclosure
    $updateSql = "UPDATE Enclosure SET BuildingID = ?, SqFt = ? WHERE ID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("iii", $buildingId, $sqFt, $enclosureId);

    if ($updateStmt->execute()) {
        echo "Enclosure updated successfully.";
    } else {
        echo "Error updating enclosure: " . $updateStmt->error;
    }

    $updateStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Enclosure</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            width: 50%;
            margin: 20px auto;
            background-color: rgba(144, 238, 144, 0.3);
            padding: 20px;
            border-radius: 8px;
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
        }

        button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        a {
            display: block;
            margin-top: 10px;
            text-align: center;
            text-decoration: none;
            color: #333;
        }

    </style>
</head>
<body>
    <h2>Update Enclosure</h2>

    <!-- Enclosure update form -->
    <form method="post" action="">
        <label for="buildingId">Building:</label>
        <select name="buildingId" required>
            <?php
            // Fetch available buildings for dropdown
            $buildingSql = "SELECT ID, Name FROM Building";
            $buildingResult = $conn->query($buildingSql);

            while ($building = $buildingResult->fetch_assoc()) :
                $selected = ($building['ID'] == $buildingId) ? 'selected' : '';
            ?>
                <option value="<?php echo $building['ID']; ?>" <?php echo $selected; ?>><?php echo $building['Name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="sqFt">Square Footage:</label>
        <input type="number" name="sqFt" value="<?php echo $sqFt; ?>" required><br>

        <button type="submit" name="updateEnclosure">Update Enclosure</button>
    </form>

    <a href="view_enclosures.php">Back to Enclosures</a>
</body>
</html>
