<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch available species and animal shows for dropdowns
$speciesSql = "SELECT ID, Name FROM Species";
$speciesResult = $conn->query($speciesSql);

$animalShowSql = "SELECT ID FROM AnimalShow";
$animalShowResult = $conn->query($animalShowSql);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createParticipatesIn"])) {
    $speciesID = $_POST["speciesID"];
    $animalShowID = $_POST["animalShowID"];
    $reqd = $_POST["reqd"];

    // Perform the necessary database operations to create the relationship
    $sql = "INSERT INTO ParticipatesIN (SpeciesID, AnimalShowID, Reqd) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $speciesID, $animalShowID, $reqd);
    $stmt->execute();
    $stmt->close();

    echo "Relationship created successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Participates In Relationship</title>
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
    <h2>Create Participates In Relationship</h2>

    <!-- Participates In relationship creation form -->
    <form method="post" action="">
        <label for="speciesID">Species:</label>
        <select name="speciesID" required>
            <?php while ($species = $speciesResult->fetch_assoc()) : ?>
                <option value="<?php echo $species['ID']; ?>"><?php echo $species['Name']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="animalShowID">Animal Show ID:</label>
        <select name="animalShowID" required>
            <?php while ($animalShow = $animalShowResult->fetch_assoc()) : ?>
                <option value="<?php echo $animalShow['ID']; ?>"><?php echo $animalShow['ID']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="reqd">Required:</label>
        <input type="number" name="reqd" required>

        <button type="submit" name="createParticipatesIn">Create Relationship</button>
    </form>

    <a href="view_participates_in.php">Back to Participates In Relationships</a>
</body>
</html>

