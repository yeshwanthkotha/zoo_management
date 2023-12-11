<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Handle species creation form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createSpecies"])) {
    $name = $_POST["name"];
    $foodCost = $_POST["foodCost"];

    // Perform the necessary database operations to create a new species with updated_date
    $createSql = "INSERT INTO Species (Name, FoodCost, updated_date) VALUES (?, ?, CURRENT_TIMESTAMP)";
    $createStmt = $conn->prepare($createSql);
    $createStmt->bind_param("si", $name, $foodCost);
    $createStmt->execute();
    $createStmt->close();

    echo "Species created successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Species</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(144, 238, 144, 0.3); /* Light green with reduced opacity */
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        a:hover {
            background-color: #2980b9;
        }

    </style>
</head>
<body>
    <h2>Create Species</h2>

    <!-- Species creation form -->
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="foodCost">Food Cost:</label>
        <input type="number" name="foodCost" required><br>

        <button type="submit" name="createSpecies">Create Species</button>
    </form>

    <a href="view_species.php">Back to Species</a>
</body>
</html>
