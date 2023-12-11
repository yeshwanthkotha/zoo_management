<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Days Revenue Report</title>
    
</head>
<body>
    <div class="container">
        <?php
        // Include the database connection file
        include '../includes/db_connection.php';

        // Check if the form is submitted
        if (isset($_POST['generateTopDaysReport'])) {
            // Get the selected month from the form
            $selectedMonth = $_POST['selectedMonth'];

            // Execute the query to set the target month
            $sql1 = "SET @target_month = '$selectedMonth';";
            $conn->query($sql1);

            // Execute the query to find the 5 best days in terms of total revenue
            $sql2 = "
                SELECT
                    DATE(TransactionDate) AS TransactionDate,
                    SUM(Revenue) AS TotalRevenue
                FROM (
                    SELECT
                        DATE(CheckoutTime) AS TransactionDate,
                        Revenue
                    FROM ZooAdmissionTickets
                    WHERE DATE_FORMAT(CheckoutTime, '%Y-%m') = @target_month
                    UNION ALL
                    SELECT
                        DATE(CheckoutTime) AS TransactionDate,
                        Revenue
                    FROM AnimalShowTickets
                    WHERE DATE_FORMAT(CheckoutTime, '%Y-%m') = @target_month
                    UNION ALL
                    SELECT
                        SaleDate AS TransactionDate,
                        Revenue
                    FROM DailyConcessionRevenue
                    WHERE DATE_FORMAT(SaleDate, '%Y-%m') = @target_month
                ) AS CombinedRevenue
                GROUP BY TransactionDate
                ORDER BY TotalRevenue DESC
                LIMIT 5;
            ";

            $result = $conn->query($sql2);

            if ($result->num_rows > 0) {
                echo "<h2>Top Days Revenue Report for $selectedMonth</h2>";
                echo "<table>";
                echo "<tr><th>Date</th><th>Total Revenue</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['TransactionDate']}</td>";
                    echo "<td>{$row['TotalRevenue']}</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No results found.</p>";
            }
        }

        // Close the database connection
        $conn->close();
        ?>
        <a href='top_days_report_form.php'>Back to Report Form</a>
    </div>
</body>
</html>
