<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve the Attendance ID from the URL parameter
$attendanceID = $_GET['id'];

// Fetch the current Attendance details
$sql = "SELECT * FROM AttendanceDaily WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $attendanceID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

// Handle form submission for updating the Attendance details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateAttendance"])) {
    $newDate = $_POST["newDate"];
    $newAttendance = $_POST["newAttendance"];
    $newRevenue = $_POST["newRevenue"];

    // Update the Attendance details in the database
    $updateSql = "UPDATE AttendanceDaily SET Date = ?, Attendance = ?, Revenue = ? WHERE ID = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("siii", $newDate, $newAttendance, $newRevenue, $attendanceID);
    $stmt->execute();
    $stmt->close();

    echo "Attendance updated successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Attendance</title>
</head>
<body>
    <h2>Update Attendance</h2>

    <!-- Attendance update form -->
    <form method="post" action="">
        <label for="newDate">New Date:</label>
        <input type="date" name="newDate" value="<?php echo $row['Date']; ?>" required><br>

        <label for="newAttendance">New Attendance:</label>
        <input type="number" name="newAttendance" value="<?php echo $row['Attendance']; ?>" required><br>

        <label for="newRevenue">New Revenue:</label>
        <input type="number" name="newRevenue" value="<?php echo $row['Revenue']; ?>" required><br>

        <button type="submit" name="updateAttendance">Update Attendance</button>
    </form>

    <a href="view_attendance.php">Back to Attendance</a>
</body>
</html>
