<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch available revenue types for dropdown
$revenueTypeSql = "SELECT ID, Name FROM RevenueType";
$revenueTypeResult = $conn->query($revenueTypeSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Zoo Admission</title>
</head>
<body>
    <h2>Create Zoo Admission</h2>

    <!-- Zoo Admission creation form -->
    <form method="post" action="">
        <label for="revenueTypeId">Revenue Type:</label>
        <select name="revenueTypeId" required>
            <?php while ($revenueType = $revenueTypeResult->fetch_assoc()) : ?>
                <option value="<?php echo $revenueType['ID']; ?>"><?php echo $revenueType['Name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="seniorPrice">Senior Price:</label>
        <input type="number" name="seniorPrice" required><br>

        <label for="adultPrice">Adult Price:</label>
        <input type="number" name="adultPrice" required><br>

        <label for="childPrice">Child Price:</label>
        <input type="number" name="childPrice" required><br>

        <button type="submit" name="createZooAdmission">Create Zoo Admission</button>
    </form>

    <a href="view_zoo_admissions.php">Back to Zoo Admissions</a>
</body>
</html>

<?php
// Handle create zoo admission form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createZooAdmission"])) {
    $revenueTypeId = $_POST["revenueTypeId"];
    $seniorPrice = $_POST["seniorPrice"];
    $adultPrice = $_POST["adultPrice"];
    $childPrice = $_POST["childPrice"];

    // Insert the new zoo admission into the database
    $createSql = "INSERT INTO ZooAdmission (ID, SeniorPrice, AdultPrice, ChildPrice) VALUES (?, ?, ?, ?)";
    $createStmt = $conn->prepare($createSql);
    $createStmt->bind_param("iddd", $revenueTypeId, $seniorPrice, $adultPrice, $childPrice);
    $createStmt->execute();

    echo "Zoo Admission created successfully.";
}
?>
