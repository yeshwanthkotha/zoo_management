<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch available buildings for dropdown
$buildingSql = "SELECT ID, Name FROM Building";
$buildingResult = $conn->query($buildingSql);

// Define allowed revenue types
$allowedRevenueTypes = ['Animal Show', 'Concession', 'Zoo Admission'];

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing revenue type details
    $selectSql = "SELECT * FROM RevenueType WHERE ID = ?";
    $selectStmt = $conn->prepare($selectSql);
    $selectStmt->bind_param("i", $id);
    $selectStmt->execute();
    $result = $selectStmt->get_result();
    $revenueType = $result->fetch_assoc();
    $selectStmt->close();

    // Handle revenue type update form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateRevenueType"])) {
        $name = $_POST["name"];
        $type = $_POST["type"];
        $buildingId = $_POST["buildingId"];

        // Check if the submitted revenue type is allowed
        if (!in_array($type, $allowedRevenueTypes)) {
            echo "Invalid revenue type. Please select a valid type.";
            exit();
        }

        // Prepare and execute the SQL statement to update the revenue type
        $updateSql = "UPDATE RevenueType SET Name = ?, Type = ?, BuildingID = ? WHERE ID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ssii", $name, $type, $buildingId, $id);
        $updateStmt->execute();
        $updateStmt->close();

        // Redirect back to the revenue types list page
        header("Location: revenue_types.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Revenue Type</title>
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
            <h2>Update Revenue Type</h2>
        </div>

        <!-- Revenue type update form -->
        <form method="post" action="">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($revenueType['Name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="type">Type:</label>
                <select name="type" required>
                    <?php foreach ($allowedRevenueTypes as $allowedType) : ?>
                        <option value="<?php echo htmlspecialchars($allowedType); ?>" <?php echo ($allowedType == $revenueType['Type']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($allowedType); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="buildingId">Building:</label>
                <select name="buildingId" required>
                    <?php while ($building = $buildingResult->fetch_assoc()) : ?>
                        <option value="<?php echo htmlspecialchars($building['ID']); ?>" <?php echo ($building['ID'] == $revenueType['BuildingID']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($building['Name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" name="updateRevenueType">Update Revenue Type</button>
        </form>

        <div class="back-link">
            <a href="revenue_types.php">Back to Revenue Types</a>
        </div>
    </div>
</body>
</html>
