<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve the Attraction ID from the URL parameter
$attractionID = $_GET['id'];

// Fetch the current Attraction details
$sql = "SELECT * FROM AttractionsDaily WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $attractionID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

// Handle form submission for updating the Attraction details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateAttraction"])) {
    $newAttractionName = $_POST["newAttractionName"];
    $newDate = $_POST["newDate"];
    $newAttendance = $_POST["newAttendance"];
    $newRevenue = $_POST["newRevenue"];

    // Update the Attraction details in the database
    $updateSql = "UPDATE AttractionsDaily SET AttractionName = ?, Date = ?, Attendance = ?, Revenue = ? WHERE ID = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ssiid", $newAttractionName, $newDate, $newAttendance, $newRevenue, $attractionID);
    $stmt->execute();
    $stmt->close();

    echo "Attraction updated successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Attraction</title>
</head>
<body>
    <h2>Update Attraction</h2>

    <!-- Attraction update form -->
    <form method="post" action="">
        <label for="newAttractionName">New Attraction Name:</label>
        <input type="text" name="newAttractionName" value="<?php echo $row['AttractionName']; ?>" required><br>

        <label for="newDate">New Date:</label>
        <input type="date" name="newDate" value="<?php echo $row['Date']; ?>" required><br>

        <label for="newAttendance">New Attendance:</label>
        <input type="number" name="newAttendance" value="<?php echo $row['Attendance']; ?>" required><br>

        <label for="newRevenue">New Revenue:</label>
        <input type="number" name="newRevenue" value="<?php echo $row['Revenue']; ?>" required><br>

        <button type="submit" name="updateAttraction">Update Attraction</button>
    </form>

    <a href="view_attractions.php">Back to Attractions</a>
</body>
</html>
