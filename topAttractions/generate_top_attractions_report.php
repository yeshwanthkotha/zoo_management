<?php
// Include the common database connection file
include '../includes/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Attractions Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a {
            color: blue;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generateTopAttractionsReport"])) {
            $startDate = $_POST["startDate"];
            $endDate = $_POST["endDate"];

            // Query to fetch top attractions
            $query = "SELECT 
                        AnimalShowID, 
                        SUM(Revenue) AS TotalRevenue
                      FROM AnimalShowTickets
                      WHERE CheckoutTime BETWEEN ? AND ?
                      GROUP BY AnimalShowID
                      ORDER BY TotalRevenue DESC
                      LIMIT 3";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $startDate, $endDate);
            $stmt->execute();
            $result = $stmt->get_result();

            // Display the report
            echo "<h2>Top 3 Attractions from $startDate to $endDate</h2>";

            if ($result->num_rows > 0) {
                echo "<table><tr><th>Attraction ID</th><th>Total Revenue</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>{$row['AnimalShowID']}</td><td>{$row['TotalRevenue']}</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No data available for the selected period.</p>";
            }

            echo "<a href='top_attractions_report_form.php'>Back to Report Form</a>";

            $stmt->close();
            $conn->close();
        } else {
            echo "<p>No report generated. Please <a href='top_attractions_report_form.php'>return to the Report Form</a>.</p>";
        }
        ?>
    </div>
</body>
</html>

