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
    <!-- Styles remain unchanged for brevity -->
</head>
<body>
    <h2>Update Species</h2>

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
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $species['Name']; ?>" required><br>

        <label for="foodCost">Food Cost:</label>
        <input type="number" name="foodCost" value="<?php echo $species['FoodCost']; ?>" required><br>

        <button type="submit" name="updateSpecies">Update Species</button>
    </form>

    <a href="view_species.php">Back to Species</a>
</body>
</html>
