<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve the Species ID and Animal Show ID from the URL parameters
$speciesID = $_GET['speciesId'];
$animalShowID = $_GET['animalShowId'];

// Fetch the current Participates In relationship details
$sql = "SELECT * FROM ParticipatesIN WHERE SpeciesID = ? AND AnimalShowID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $speciesID, $animalShowID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

// Handle form submission for updating the Participates In relationship
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateParticipatesIn"])) {
    $newSpeciesID = $_POST["newSpeciesID"];
    $newAnimalShowID = $_POST["newAnimalShowID"];
    $newRequired = $_POST["newRequired"];

    // Update the Participates In relationship details in the database
    $updateSql = "UPDATE ParticipatesIN SET SpeciesID = ?, AnimalShowID = ?, Reqd = ? 
                  WHERE SpeciesID = ? AND AnimalShowID = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("iiiii", $newSpeciesID, $newAnimalShowID, $newRequired, $speciesID, $animalShowID);
    $stmt->execute();
    $stmt->close();

    echo "Participates In relationship updated successfully.";
}

// Fetch available species for dropdown
$speciesSql = "SELECT ID, Name FROM Species";
$speciesResult = $conn->query($speciesSql);

// Fetch available animal shows for dropdown
$animalShowSql = "SELECT ID FROM AnimalShow";
$animalShowResult = $conn->query($animalShowSql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Participates In Relationship</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        select, input[type="number"], button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            margin-top: 15px;
            cursor: pointer;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Update Participates In Relationship</h2>

    <!-- Participates In relationship update form -->
    <form method="post" action="">
        <label for="newSpeciesID">New Species:</label>
        <select name="newSpeciesID" required>
            <?php while ($species = $speciesResult->fetch_assoc()) : ?>
                <option value="<?php echo $species['ID']; ?>" <?php echo ($species['ID'] == $row['SpeciesID']) ? 'selected' : ''; ?>>
                    <?php echo $species['Name']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="newAnimalShowID">New Animal Show:</label>
        <select name="newAnimalShowID" required>
            <?php while ($animalShow = $animalShowResult->fetch_assoc()) : ?>
                <option value="<?php echo $animalShow['ID']; ?>" <?php echo ($animalShow['ID'] == $row['AnimalShowID']) ? 'selected' : ''; ?>>
                    <?php echo $animalShow['ID']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="newRequired">New Required:</label>
        <input type="number" name="newRequired" value="<?php echo $row['Reqd']; ?>" required>

        <button type="submit" name="updateParticipatesIn">
            Update Relationship
        </button>
    </form>

    <a href="view_participates_in.php">Back to Participates In Relationships</a>
</body>
</html>

