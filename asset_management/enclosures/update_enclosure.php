<?php
// Include the common database connection file
include '../includes/db_connection.php';

$enclosureId = '';
$buildingId = '';
$sqFt = '';

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

// Fetch available buildings for dropdown
$buildingSql = "SELECT ID, Name FROM Building";
$buildingResult = $conn->query($buildingSql);

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
            margin: 0;
            padding: 20px;
            background-color: #fff;
            color: #333;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #333;
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input, select, button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: transparent;
            border: 1px solid #333;
            cursor: pointer;
            margin-top: 15px;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            padding: 10px 20px;
            text-decoration: none;
            border: 1px solid #333;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Update Enclosure</h2>
        </div>

        <!-- Enclosure update form -->
        <form method="post" action="">
            <div class="form-group">
                <label for="buildingId">Building:</label>
                <select name="buildingId" required>
                    <?php while ($building = $buildingResult->fetch_assoc()) : ?>
                        <option value="<?php echo $building['ID']; ?>" <?php echo ($building['ID'] == $buildingId) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($building['Name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="sqFt">Square Footage:</label>
                <input type="number" name="sqFt" value="<?php echo htmlspecialchars($sqFt); ?>" required>
            </div>

            <button type="submit" name="updateEnclosure">Update Enclosure</button>
        </form>

        <div class="back-link">
            <a href="view_enclosures.php">Back to Enclosures</a>
        </div>
    </div>
</body>
</html>
