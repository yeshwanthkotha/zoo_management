<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the SQL statement to delete the revenue event
    $deleteSql = "DELETE FROM RevenueEvents WHERE ID = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $id);
    $deleteStmt->execute();
    $deleteStmt->close();
}

// Redirect back to the revenue events list page
header("Location: view_revenue_events.php");
exit();
?>
