<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Average Revenue Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid #333;
            text-align: center;
        }

        th, td {
            padding: 10px;
        }

        p {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }

        a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
    </style>
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
                echo "<p><a href='average_revenue_report_form.php'>Back to Report Form</a></p>";
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

            // Check if there are rows in the result set
            if ($result->num_rows > 0) {
                echo "<h2>Average Revenue Report for $startDate to $endDate</h2>";
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
                echo "<h2>No data found for the selected time period.</h2>";
            }

            echo "<p><a href='average_revenue_report_form.php'>Back to Report Form</a></p>";

            $stmt->close();
            $conn->close();
        } else {
            echo "<p>No report generated. Please go back to the <a href='average_revenue_report_form.php'>Report Form</a>.</p>";
        }
        ?>
    </div>
</body>
</html>
