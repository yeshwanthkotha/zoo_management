<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch available revenue types for dropdown
$revenueTypeSql = "SELECT ID, Name FROM RevenueType";
$revenueTypeResult = $conn->query($revenueTypeSql);

// Handle animal show creation form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createAnimalShow"])) {
    $revenueTypeId = $_POST["revenueTypeId"];
    $showsPerDay = $_POST["showsPerDay"];
    $seniorPrice = $_POST["seniorPrice"];
    $adultPrice = $_POST["adultPrice"];
    $childPrice = $_POST["childPrice"];

    // Prepare and execute the SQL statement to create a new animal show
    $createSql = "INSERT INTO AnimalShow (ID, ShowsPerDay, SeniorPrice, AdultPrice, ChildPrice) VALUES (?, ?, ?, ?, ?)";
    $createStmt = $conn->prepare($createSql);
    $createStmt->bind_param("iiiid", $revenueTypeId, $showsPerDay, $seniorPrice, $adultPrice, $childPrice);
    $createStmt->execute();
    $createStmt->close();

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
    <title>Create Animal Show</title>
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
    <h2>Create Animal Show</h2>

    <form method="post" action="">
        <label for="revenueTypeId">Revenue Type:</label>
        <select name="revenueTypeId" required>
            <?php while ($revenueType = $revenueTypeResult->fetch_assoc()) : ?>
                <option value="<?php echo $revenueType['ID']; ?>"><?php echo $revenueType['Name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="showsPerDay">Shows Per Day:</label>
        <input type="number" name="showsPerDay" required><br>

        <label for="seniorPrice">Senior Price:</label>
        <input type="number" name="seniorPrice" required><br>

        <label for="adultPrice">Adult Price:</label>
        <input type="number" name="adultPrice" required><br>

        <label for="childPrice">Child Price:</label>
        <input type="number" name="childPrice" required><br>

        <button type="submit" name="createAnimalShow">Create Animal Show</button>
    </form>

    <a href="view_animal_shows.php">Back to Animal Shows</a>
</body>
</html>
