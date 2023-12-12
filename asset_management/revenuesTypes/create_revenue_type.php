<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch available buildings for dropdown
$buildingSql = "SELECT ID, Name FROM Building";
$buildingResult = $conn->query($buildingSql);

// Define allowed revenue types
$allowedRevenueTypes = ['Animal Show', 'Concession', 'Zoo Admission'];

// Handle revenue type creation form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createRevenueType"])) {
    $name = $_POST["name"];
    $type = $_POST["type"];
    $buildingId = $_POST["buildingId"];

    // Check if the submitted revenue type is allowed
    if (!in_array($type, $allowedRevenueTypes)) {
        echo "Invalid revenue type. Please select a valid type.";
        exit();
    }

    $createSql = "INSERT INTO RevenueType (Name, Type, BuildingID) VALUES (?, ?, ?)";
    $createStmt = $conn->prepare($createSql);
    $createStmt->bind_param("ssi", $name, $type, $buildingId);
    $createStmt->execute();
    $createStmt->close();

    header("Location: revenue_types.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Revenue Type</title>
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
            margin: 20px auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        label, input, select, button {
            width: 100%;
            padding: 8px;
            border: 1px solid #333;
            border-radius: 4px;
        }

        button {
            background-color: transparent;
            cursor: pointer;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Revenue Type</h2>

        <!-- Revenue type creation form -->
        <form method="post" action="">
            <label for="name">Name:</label>
            <input type="text" name="name" required>

            <label for="type">Type:</label>
            <select name="type" required>
                <?php foreach ($allowedRevenueTypes as $allowedType) : ?>
                    <option value="<?php echo htmlspecialchars($allowedType); ?>">
                        <?php echo htmlspecialchars($allowedType); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="buildingId">Building:</label>
            <select name="buildingId" required>
                <?php while ($building = $buildingResult->fetch_assoc()) : ?>
                    <option value="<?php echo htmlspecialchars($building['ID']); ?>">
                        <?php echo htmlspecialchars($building['Name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button type="submit" name="createRevenueType">Create Revenue Type</button>
        </form>

        <div class="back-link">
            <a href="revenue_types.php">Back to Revenue Types</a>
        </div>
    </div>
</body>
</html>
