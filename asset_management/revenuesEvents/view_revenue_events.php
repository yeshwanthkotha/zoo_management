<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch total attendance and revenue for Animal Shows
$animalShowSql = "SELECT SUM(Attendance) AS TotalAttendance, SUM(Revenue) AS TotalRevenue FROM AnimalShowTickets";
$animalShowResult = $conn->query($animalShowSql);
$animalShowData = $animalShowResult->fetch_assoc();

// Fetch total attendance and revenue for Zoo Admission Tickets
$zooAdmissionSql = "SELECT SUM(Attendance) AS TotalAttendance, SUM(Revenue) AS TotalRevenue FROM ZooAdmissionTickets";
$zooAdmissionResult = $conn->query($zooAdmissionSql);
$zooAdmissionData = $zooAdmissionResult->fetch_assoc();

// Fetch existing revenue events for displaying in the table
$revenueEventsSql = "SELECT * FROM RevenueEvents";
$revenueEventsResult = $conn->query($revenueEventsSql);

// Flag to check if an entry for the current date exists
$entryExists = false;

while ($row = $revenueEventsResult->fetch_assoc()) {
    // Check if an entry for the current date exists
    if ($row['DateTime'] == date('Y-m-d')) {
        $entryExists = true;
        break;
    }
}

// Handle the form submission to update RevenueEvents
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateRevenueEvents"])) {
    $totalCombinedAttendance = $animalShowData['TotalAttendance'] + $zooAdmissionData['TotalAttendance'];
    $totalCombinedRevenue = $animalShowData['TotalRevenue'] + $zooAdmissionData['TotalRevenue'];

    // Insert the combined attendance and revenue into RevenueEvents
    if ($entryExists) {
        // Update existing entry for the current date
        $updateSql = "UPDATE RevenueEvents SET Revenue = ?, TicketsSold = ? WHERE DateTime = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ids", $totalCombinedRevenue, $totalCombinedAttendance, date('Y-m-d'));
        $updateStmt->execute();
        $updateStmt->close();
    } else {
        // Insert a new entry for the current date
        $insertSql = "INSERT INTO RevenueEvents (ID, DateTime, Revenue, TicketsSold) VALUES (?, CURRENT_TIMESTAMP, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("ids", $totalCombinedAttendance, $totalCombinedRevenue, $totalCombinedAttendance);
        $insertStmt->execute();
        $insertStmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Attendance and Revenue</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #fff;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        h2, h3 {
            text-align: center;
        }

        p {
            margin: 5px 0;
        }

        button {
            display: block;
            margin: 20px auto;
            background-color: transparent;
            border: 1px solid #333;
            padding: 10px 20px;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #333;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        td a {
            text-decoration: none;
            color: #333;
        }

        .actions {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Total Attendance and Revenue</h2>

        <h3>Animal Shows</h3>
        <p>Total Attendance: <?php echo $animalShowData['TotalAttendance']; ?></p>
        <p>Total Revenue: <?php echo $animalShowData['TotalRevenue']; ?></p>

        <h3>Zoo Admission Tickets</h3>
        <p>Total Attendance: <?php echo $zooAdmissionData['TotalAttendance']; ?></p>
        <p>Total Revenue: <?php echo $zooAdmissionData['TotalRevenue']; ?></p>

        <h3>Total Combined</h3>
        <p>Total Combined Attendance: <?php echo $animalShowData['TotalAttendance'] + $zooAdmissionData['TotalAttendance']; ?></p>
        <p>Total Combined Revenue: <?php echo $animalShowData['TotalRevenue'] + $zooAdmissionData['TotalRevenue']; ?></p>

        <form method="post" action="">
            <button type="submit" name="updateRevenueEvents">Update Revenue Events</button>
        </form>

        <!-- Display a paginated list of revenue events with links to view, update, and delete -->
        <table>
            <tr>
                <th>Revenue Type ID</th>
                <th>Date and Time</th>
                <th>Revenue</th>
                <th>Tickets Sold</th>
                <!-- Add more columns as needed -->
                <th class="actions">Actions</th>
            </tr>

            <?php
            // Fetch and display revenue events
            $revenueEventsSql = "SELECT * FROM RevenueEvents";
            $revenueEventsResult = $conn->query($revenueEventsSql);

            while ($row = $revenueEventsResult->fetch_assoc()) :
            ?>
                <tr>
                    <td><?php echo $row['ID']; ?></td>
                    <td><?php echo $row['DateTime']; ?></td>
                    <td><?php echo $row['Revenue']; ?></td>
                    <td><?php echo $row['TicketsSold']; ?></td>
                    <!-- Display more columns as needed -->
                    <td class="actions">
                        <a href="update_revenue_event.php?id=<?php echo $row['ID']; ?>">Update</a> |
                        <a href="delete_revenue_event.php?id=<?php echo $row['ID']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

