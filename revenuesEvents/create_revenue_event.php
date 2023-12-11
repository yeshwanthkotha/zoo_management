<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch available revenue types for dropdown
$revenueTypeSql = "SELECT ID, Name FROM RevenueType";
$revenueTypeResult = $conn->query($revenueTypeSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Revenue Event</title>
</head>
<body>
    <h2>Create Revenue Event</h2>

    <!-- Revenue event creation form -->
    <form method="post" action="">
        <label for="revenueTypeId">Revenue Type:</label>
        <select name="revenueTypeId" required>
            <?php while ($revenueType = $revenueTypeResult->fetch_assoc()) : ?>
                <option value="<?php echo $revenueType['ID']; ?>"><?php echo $revenueType['Name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="dateTime">Date and Time:</label>
        <input type="datetime-local" name="dateTime" required><br>

        <label for="revenue">Revenue:</label>
        <input type="number" name="revenue" required><br>

        <label for="ticketsSold">Tickets Sold:</label>
        <input type="number" name="ticketsSold" required><br>

        <button type="submit" name="createRevenueEvent">Create Revenue Event</button>
    </form>

    <a href="view_revenue_events.php">Back to Revenue Events</a>
</body>
</html>

<?php
// Handle revenue event creation form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createRevenueEvent"])) {
    $revenueTypeId = $_POST["revenueTypeId"];
    $dateTime = $_POST["dateTime"];
    $revenue = $_POST["revenue"];
    $ticketsSold = $_POST["ticketsSold"];

    // Prepare and execute the SQL statement to create a new revenue event
    $createSql = "INSERT INTO RevenueEvents (ID, DateTime, Revenue, TicketsSold) VALUES (?, ?, ?, ?)";
    $createStmt = $conn->prepare($createSql);
    $createStmt->bind_param("issi", $revenueTypeId, $dateTime, $revenue, $ticketsSold);
    $createStmt->execute();
    $createStmt->close();

    // Redirect back to the revenue events list page
    header("Location: view_revenue_events.php");
    exit();
}
?>
