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
</head>
<body>
    <h2>Create Revenue Type</h2>

    <!-- Revenue type creation form -->
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="type">Type:</label>
        <select name="type" required>
            <?php foreach ($allowedRevenueTypes as $allowedType) : ?>
                <option value="<?php echo $allowedType; ?>"><?php echo $allowedType; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="buildingId">Building:</label>
        <select name="buildingId" required>
            <?php while ($building = $buildingResult->fetch_assoc()) : ?>
                <option value="<?php echo $building['ID']; ?>"><?php echo $building['Name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <button type="submit" name="createRevenueType">Create Revenue Type</button>
    </form>

    <a href="revenue_types.php">Back to Revenue Types</a>
</body>
</html>
