<?php
// Include the common database connection file
include '../includes/db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Average Revenue Report</title>
    
</head>
<body>
    <div class="container">
        <?php
        // Include the common database connection file
        include '../includes/db_connection.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generateAverageRevenueReport"])) {
            $startDate = $_POST["startDate"];
            $endDate = $_POST["endDate"];

            // Validate that startDate is before or equal to endDate
            if ($startDate > $endDate) {
                echo "<p>Error: Start Date should be before or equal to End Date.</p>";
                echo "<a href='average_revenue_report_form.php'>Back to Report Form</a>";
                exit();
            }

            // Assuming tables AnimalShowTickets, ZooAdmissionTickets, and DailyConcessionRevenue
            $query = "SELECT
                        'Animal Show' AS Category,
                        FORMAT(AVG(Revenue), 2) AS AverageRevenue
                      FROM AnimalShowTickets
                      WHERE CheckoutTime BETWEEN ? AND ?
                      UNION
                      SELECT
                        'Zoo Admission' AS Category,
                        FORMAT(AVG(Revenue), 2) AS AverageRevenue
                      FROM ZooAdmissionTickets
                      WHERE CheckoutTime BETWEEN ? AND ?
                      UNION
                      SELECT
                        'Concession' AS Category,
                        FORMAT(AVG(Revenue), 2) AS AverageRevenue
                      FROM DailyConcessionRevenue
                      WHERE SaleDate BETWEEN ? AND ?
                      UNION
                      SELECT
                        'Total Attendance' AS Category,
                        FORMAT(AVG(Attendance), 2) AS AverageRevenue
                      FROM (
                        SELECT Attendance
                        FROM AnimalShowTickets
                        WHERE CheckoutTime BETWEEN ? AND ?
                        UNION
                        SELECT Attendance
                        FROM ZooAdmissionTickets
                        WHERE CheckoutTime BETWEEN ? AND ?
                      ) AS CombinedAttendance";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssssssss", $startDate, $endDate, $startDate, $endDate, $startDate, $endDate, $startDate, $endDate, $startDate, $endDate);
            $stmt->execute();
            $result = $stmt->get_result();

            // Display the report
            echo "<h2>Average Revenue Report for $startDate to $endDate</h2>";

            // Check if there are rows in the result set
            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Category</th><th>Average Revenue</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['Category']}</td>";
                    echo "<td>{$row['AverageRevenue']}</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No data found for the selected time period.</p>";
            }

            echo "<a href='average_revenue_report_form.php'>Back to Report Form</a>";

            $stmt->close();
            $conn->close();
        } else {
            echo "<p>No report generated. Please go back to the <a href='average_revenue_report_form.php'>Report Form</a>.</p>";
        }
        ?>
    </div>
</body>
</html>

