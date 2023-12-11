<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch available revenue types for dropdown
$revenueTypeSql = "SELECT ID, Name FROM RevenueType";
$revenueTypeResult = $conn->query($revenueTypeSql);

// Fetch the details of the selected animal show
$showId = $_GET['id'];
$showSql = "SELECT * FROM AnimalShow WHERE ID = ?";
$showStmt = $conn->prepare($showSql);
$showStmt->bind_param("i", $showId);
$showStmt->execute();
$showResult = $showStmt->get_result();
$show = $showResult->fetch_assoc();
$showStmt->close();

// Handle animal show update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateAnimalShow"])) {
    $revenueTypeId = $_POST["revenueTypeId"];
    $showsPerDay = $_POST["showsPerDay"];
    $seniorPrice = $_POST["seniorPrice"];
    $adultPrice = $_POST["adultPrice"];
    $childPrice = $_POST["childPrice"];

    // Prepare and execute the SQL statement to update the animal show
    $updateSql = "UPDATE AnimalShow SET ID = ?, ShowsPerDay = ?, SeniorPrice = ?, AdultPrice = ?, ChildPrice = ? WHERE ID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("iiiidi", $revenueTypeId, $showsPerDay, $seniorPrice, $adultPrice, $childPrice, $showId);
    $updateStmt->execute();
    $updateStmt->close();

    // Redirect back to the animal shows list page
    header("Location: view_animal_shows.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Animal Show</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
        }

        form {
            width: fit-content;
            margin: auto;
            padding: 10px;
        }

        label, input, select, button {
            display: block;
            margin-bottom: 10px;
        }

        input[type="number"], select {
            padding: 5px;
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
    <h2>Update Animal Show</h2>

    <form method="post" action="">
        <label for="revenueTypeId">Revenue Type:</label>
        <select name="revenueTypeId" required>
            <?php while ($revenueType = $revenueTypeResult->fetch_assoc()) : ?>
                <option value="<?php echo $revenueType['ID']; ?>" <?php echo ($revenueType['ID'] == $show['ID']) ? 'selected' : ''; ?>>
                    <?php echo $revenueType['Name']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <label for="showsPerDay">Shows Per Day:</label>
        <input type="number" name="showsPerDay" value="<?php echo $show['ShowsPerDay']; ?>" required><br>

        <label for="seniorPrice">Senior Price:</label>
        <input type="number" name="seniorPrice" value="<?php echo $show['SeniorPrice']; ?>" required><br>

        <label for="adultPrice">Adult Price:</label>
        <input type="number" name="adultPrice" value="<?php echo $show['AdultPrice']; ?>" required><br>

        <label for="childPrice">Child Price:</label>
        <input type="number" name="childPrice" value="<?php echo $show['ChildPrice']; ?>" required><br>

        <button type="submit" name="updateAnimalShow">Update Animal Show</button>
    </form>

    <a href="view_animal_shows.php">Back to Animal Shows</a>
</body>
</html>
