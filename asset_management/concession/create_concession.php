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
    <title>Create Concession</title>
</head>
<body>
    <h2>Create Concession</h2>

    <!-- Concession creation form -->
    <form method="post" action="">
        <label for="revenueTypeId">Revenue Type:</label>
        <select name="revenueTypeId" required>
            <?php while ($revenueType = $revenueTypeResult->fetch_assoc()) : ?>
                <option value="<?php echo $revenueType['ID']; ?>"><?php echo $revenueType['Name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="product">Product:</label>
        <input type="text" name="product" required><br>

        <button type="submit" name="createConcession">Create Concession</button>
    </form>

    <a href="view_concessions.php">Back to Concessions</a>
</body>
</html>

<?php
// Handle create concession form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createConcession"])) {
    $revenueTypeId = $_POST["revenueTypeId"];
    $product = $_POST["product"];

    // Insert the new concession into the database
    $createSql = "INSERT INTO Concession (ID, Product) VALUES (?, ?)";
    $createStmt = $conn->prepare($createSql);
    $createStmt->bind_param("is", $revenueTypeId, $product);
    $createStmt->execute();

    echo "Concession created successfully.";
}
?>
