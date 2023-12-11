<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Handle form submission to create a new building
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createBuilding"])) {
    $name = $_POST["name"];
    $type = $_POST["type"];

    // Perform the necessary database operations to create a new building
    $sql = "INSERT INTO Building (Name, Type) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $type);
    $stmt->execute();
    $stmt->close();

    echo "Building created successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Building</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
            background-color: #fff; /* White background */
        }

        h2 {
            text-align: center;
        }

        form {
            width: fit-content;
            margin: auto;
            padding: 10px;
        }

        label, input, button {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }

        button {
            padding: 5px;
            background-color: #ddd;
            border: none;
            cursor: pointer;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #000;
        }
    </style>
</head>
<body>
    <h2>Create New Building</h2>

    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="type">Type:</label>
        <input type="text" name="type" required>

        <button type="submit" name="createBuilding">Create Building</button>
    </form>

    <a href="view_buildings.php">Back to Buildings</a>
</body>
</html>
