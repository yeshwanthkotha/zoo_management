<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing revenue event details
    $selectSql = "SELECT * FROM RevenueEvents WHERE ID = ?";
    $selectStmt = $conn->prepare($selectSql);
    $selectStmt->bind_param("i", $id);
    $selectStmt->execute();
    $result = $selectStmt->get_result();
    $revenueEvent = $result->fetch_assoc();
    $selectStmt->close();

    // Handle revenue event update form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateRevenueEvent"])) {
        $dateTime = $_POST["dateTime"];
        $revenue = $_POST["revenue"];
        $ticketsSold = $_POST["ticketsSold"];

        // Prepare and execute the SQL statement to update the revenue event
        $updateSql = "UPDATE RevenueEvents SET DateTime = ?, Revenue = ?, TicketsSold = ? WHERE ID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("siii", $dateTime, $revenue, $ticketsSold, $id);
        $updateStmt->execute();
        $updateStmt->close();

        // Redirect back to the revenue events list page
        header("Location: view_revenue_events.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Revenue Event</title>
</head>
<body>
    <h2>Update Revenue Event</h2>

    <!-- Revenue event update form -->
    <form method="post" action="">
        <label for="dateTime">Date and Time:</label>
        <input type="datetime-local" name="dateTime" value="<?php echo date('Y-m-d\TH:i', strtotime($revenueEvent['DateTime'])); ?>" required><br>

        <label for="revenue">Revenue:</label>
        <input type="number" name="revenue" value="<?php echo $revenueEvent['Revenue']; ?>" required><br>

        <label for="ticketsSold">Tickets Sold:</label>
        <input type="number" name="ticketsSold" value="<?php echo $revenueEvent['TicketsSold']; ?>" required><br>

        <button type="submit" name="updateRevenueEvent">Update Revenue Event</button>
    </form>

    <a href="view_revenue_events.php">Back to Revenue Events</a>
</body>
</html>
