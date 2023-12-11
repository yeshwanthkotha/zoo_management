<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve the Attendance ID from the URL parameter
$attendanceID = $_GET['id'];

// Delete the Attendance entry from the database
$deleteSql = "DELETE FROM AttendanceDaily WHERE ID = ?";
$stmt = $conn->prepare($deleteSql);
$stmt->bind_param("i", $attendanceID);
$stmt->execute();
$stmt->close();

echo "Attendance deleted successfully.";

// Redirect to the Attendance view page after deletion
header("Location: view_attendance.php");
exit();
?>
