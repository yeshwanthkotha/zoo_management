<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Check if ID parameter is present in the URL
if (isset($_GET['id'])) {
    $concessionId = $_GET['id'];

    // Fetch concession details from the database
    $sql = "SELECT C.ID, RT.Name AS RevenueType, C.Product
            FROM Concession AS C
            JOIN RevenueType AS RT ON C.ID = RT.ID
            WHERE C.ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $concessionId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the concession exists
    if ($result->num_rows == 1) {
        $concession = $result->fetch_assoc();
    } else {
        echo "Concession not found.";
        exit();
    }

    // Handle update form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateConcession"])) {
        $updatedProduct = $_POST["updatedProduct"];

        // Update the concession in the database
        $updateSql = "UPDATE Concession SET Product = ? WHERE ID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $updatedProduct, $concessionId);
        $updateStmt->execute();

        echo "Concession updated successfully.";
    }
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
    <title>Update Concession</title>
</head>
<body>
    <h2>Update Concession</h2>

    <!-- Concession update form -->
    <form method="post" action="">
        <label for="updatedProduct">Updated Product:</label>
        <input type="text" name="updatedProduct" value="<?php echo $concession['Product']; ?>" required><br>

        <button type="submit" name="updateConcession">Update Concession</button>
    </form>

    <a href="view_concessions.php">Back to Concessions</a>
</body>
</html>
