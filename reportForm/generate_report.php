<?php
// Include the common database connection file
include '../includes/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Report</title>
    <style>
        body {
                        background-color: rgba(0, 128, 0, 0.2); /* Transparent green background */
                        padding: 20px;
                    }
                    h2 {
                        color: #008000; /* Green text */
                    }
                    table {
                        border: 1px solid #008000; /* Green border */
                        background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white background */
                        width: 100%;
                        margin-top: 20px;
                        margin-bottom: 20px;
                    }
                    table th, table td {
                        padding: 10px;
                        text-align: left;
                        border: 1px solid #008000; /* Green border */
                    }
                    p {
                        color: #008000; /* Green text */
                    }
                    a {
                        color: #008000; /* Green text */
                        text-decoration: none;
                        font-weight: bold;
                        margin-right: 20px;
                    }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generateReport"])) {
            $selectedDate = $_POST["selectedDate"];

            // Assuming a RevenueEvents table with columns ID, DateTime, Revenue, TicketsSold
            // You may need to join with other tables to get source details

            $query = "SELECT DateTime, Revenue, TicketsSold
                      FROM RevenueEvents
                      WHERE DateTime = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $selectedDate);
            $stmt->execute();
            $result = $stmt->get_result();

            // Display the report
            echo "<h2>Revenue Report for $selectedDate</h2>";
            echo "<table>";
            echo "<tr><th>Date</th><th>Revenue</th><th>Tickets Sold</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['DateTime']}</td>";
                echo "<td>{$row['Revenue']}</td>";
                echo "<td>{$row['TicketsSold']}</td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "<a href='report_form.php'>Back to Report Form</a>";

            $stmt->close();
        } else {
            echo "<p>No report generated. Please go back to the <a href='report_form.php'>Report Form</a>.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
