<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch species for dropdown
$speciesSql = "SELECT * FROM Species";
$speciesResult = $conn->query($speciesSql);

// Fetch buildings for dropdown
$buildingSql = "SELECT * FROM Building";
$buildingResult = $conn->query($buildingSql);

// Fetch enclosures for dropdown
$enclosureSql = "SELECT * FROM Enclosure";
$enclosureResult = $conn->query($enclosureSql);

// Handle animal creation form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createAnimal"])) {
    $status = $_POST["status"];
    $birthYear = $_POST["birthYear"];
    $speciesId = $_POST["species"];
    $buildingId = $_POST["building"];
    $enclosureId = $_POST["enclosure"];

    // Perform the necessary database operations to create a new animal
    $createSql = "INSERT INTO Animal (Status, BirthYear, SpeciesID, BuildingID, EnclosureID)
                  VALUES (?, ?, ?, ?, ?)";
    $createStmt = $conn->prepare($createSql);
    $createStmt->bind_param("ssiii", $status, $birthYear, $speciesId, $buildingId, $enclosureId);
    $createStmt->execute();
    $createStmt->close();

    echo "Animal created successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Animal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 20px;
        }
        form {
            margin-top: 15px;
        }
        label, input, select, button {
            display: block;
            margin-bottom: 10px;
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #555;
        }
        .container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
    <h2>Create Animal</h2>

    <!-- Animal creation form -->
    <form method="post" action="">
        <label for="status">Status:</label>
        <input type="text" name="status" required><br>

        <label for="birthYear">Birth Year:</label>
        <input type="text" name="birthYear" required><br>

        <label for="species">Species:</label>
        <select name="species" required>
            <?php
            // Reset the pointer to the beginning of the species result set
            $speciesResult->data_seek(0);
            while ($species = $speciesResult->fetch_assoc()) :
            ?>
                <option value="<?php echo $species['ID']; ?>"><?php echo $species['Name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="building">Building:</label>
        <select name="building" required>
            <?php
            // Reset the pointer to the beginning of the building result set
            $buildingResult->data_seek(0);
            while ($building = $buildingResult->fetch_assoc()) :
            ?>
                <option value="<?php echo $building['ID']; ?>"><?php echo $building['Name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="enclosure">Enclosure:</label>
        <select name="enclosure" required>
            <?php
            // Reset the pointer to the beginning of the enclosure result set
            $enclosureResult->data_seek(0);
            while ($enclosure = $enclosureResult->fetch_assoc()) :
            ?>
                <option value="<?php echo $enclosure['ID']; ?>"><?php echo $enclosure['SqFt']; ?> SqFt</option>
            <?php endwhile; ?>
        </select><br>

        <button type="submit" name="createAnimal">Create Animal</button>
    </form>

    <a href="view_animals.php">Back to Animals</a>
</body>
</html>
