<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Check if species ID is provided in the URL
if (isset($_GET['id'])) {
    $speciesId = $_GET['id'];

    // Fetch species details
    $fetchSql = "SELECT * FROM Species WHERE ID = ?";
    $fetchStmt = $conn->prepare($fetchSql);
    $fetchStmt->bind_param("i", $speciesId);
    $fetchStmt->execute();
    $speciesResult = $fetchStmt->get_result();

    if ($speciesResult->num_rows == 1) {
        $species = $speciesResult->fetch_assoc();
    } else {
        echo "Species not found.";
        exit();
    }
} else {
    echo "Species ID not provided.";
    exit();
}

// Handle species update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateSpecies"])) {
    $name = $_POST["name"];
    $foodCost = $_POST["foodCost"];

    // Perform the necessary database operations to update the species with updated_date
    $updateSql = "UPDATE Species SET Name = ?, FoodCost = ?, updated_date = CURRENT_TIMESTAMP WHERE ID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sii", $name, $foodCost, $speciesId);
    $updateStmt->execute();
    $updateStmt->close();

    echo "Species updated successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Species</title>
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

        input, button {
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
            <h2>Update Species</h2>
        </div>

        <!-- Species update form -->
        <form method="post" action="">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($species['Name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="foodCost">Food Cost:</label>
                <input type="number" name="foodCost" value="<?php echo htmlspecialchars($species['FoodCost']); ?>" required>
            </div>

            <button type="submit" name="updateSpecies">Update Species</button>
        </form>

        <div class="back-link">
            <a href="view_species.php">Back to Species</a>
        </div>
    </div>
</body>
</html>
