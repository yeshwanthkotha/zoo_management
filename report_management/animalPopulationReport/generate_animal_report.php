<?php
// Include the common database connection file
include '../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generateAnimalReport"])) {
    $selectedMonth = $_POST["selectedMonth"];

    // Assuming tables Animal, Species, Employee, and CaresFor

    $query = "SELECT 
                Animal.SpeciesID, 
                Species.Name AS SpeciesName, 
                Animal.Status,
                SUM(Species.FoodCost) AS TotalFoodCost,
                SUM(HourlyRate.HourlyRate * 40) AS TotalLaborCost
                FROM Animal
                INNER JOIN Species ON Animal.SpeciesID = Species.ID
                LEFT JOIN CaresFor ON Animal.SpeciesID = CaresFor.SpeciesID
                LEFT JOIN Employee ON CaresFor.EmployeeID = Employee.EmployeeID
                LEFT JOIN HourlyRate ON Employee.HourlyRateID = HourlyRate.ID
                WHERE DATE_FORMAT(Species.updated_date, '%Y-%m') = ?
                GROUP BY Animal.SpeciesID, Animal.Status";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $selectedMonth); // assuming $selectedMonth is in the format 'YYYY-MM'
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the report with a similar UI
    echo "<html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Animal Population Report</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        min-height: 100vh;
                    }

                    .container {
                        background-color: #fff;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        text-align: center;
                    }

                    h2 {
                        color: #333;
                    }

                    table {
                        border-collapse: collapse;
                        width: 100%;
                        margin-top: 20px;
                        margin-bottom: 20px;
                    }

                    th, td {
                        border: 1px solid #ccc;
                        padding: 10px;
                        text-align: left;
                    }

                    th {
                        background-color: #333;
                        color: #fff;
                    }

                    tr:nth-child(even) {
                        background-color: #f2f2f2;
                    }

                    a {
                        display: block;
                        text-align: center;
                        margin-top: 10px;
                        text-decoration: none;
                        color: #333;
                        font-weight: bold;
                    }
                </style>
            </head>
            <body>";

    echo "<div class='container'>";
    echo "<h2>Animal Population Report</h2>";

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Species</th><th>Status</th><th>Total Food Cost</th><th>Total Labor Cost</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['SpeciesName']}</td>";
            echo "<td>{$row['Status']}</td>";
            echo "<td>{$row['TotalFoodCost']}</td>";
            echo "<td>{$row['TotalLaborCost']}</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No data available for the selected month.</p>";
    }

    echo "<a href='animal_population_report_form.php'>Back to Report Form</a>";
    echo "</div>"; // Close the container div

    echo "</body></html>";

    $stmt->close();
    $conn->close();
}
?>
