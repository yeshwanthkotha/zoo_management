<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Handle form submission for creating a new attraction entry
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createAttraction"])) {
    $attractionName = $_POST["attractionName"];
    $date = $_POST["date"];
    $attendance = $_POST["attendance"];
    $revenue = $_POST["revenue"];

    // Insert the new attraction details into the database
    $sql = "INSERT INTO AttractionsDaily (AttractionName, Date, Attendance, Revenue)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $attractionName, $date, $attendance, $revenue);
    $stmt->execute();
    $stmt->close();

    echo "Attraction entry created successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Attraction</title>
</head>
<body>
    <h2>Create Attraction</h2>

    <!-- Attraction creation form -->
    <form method="post" action="">
        <label for="attractionName">Attraction Name:</label>
        <input type="text" name="attractionName" required><br>

        <label for="date">Date:</label>
        <input type="date" name="date" required><br>

        <label for="attendance">Attendance:</label>
        <input type="number" name="attendance" required><br>

        <label for="revenue">Revenue:</label>
        <input type="number" name="revenue" required><br>

        <button type="submit" name="createAttraction">Create Attraction</button>
    </form>

    <a href="view_attractions.php">Back to Attractions</a>
</body>
</html>
