<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Handle form submission for creating a new hourly rate
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createHourlyRate"])) {
    $hourlyRate = $_POST["hourlyRate"];

    // Insert the new hourly rate into the database
    $sql = "INSERT INTO HourlyRate (HourlyRate) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $hourlyRate);
    $stmt->execute();
    $stmt->close();

    echo "Hourly Rate created successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Hourly Rate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"], button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            margin-top: 15px;
            cursor: pointer;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Create Hourly Rate</h2>

    <!-- Hourly rate creation form -->
    <form method="post" action="">
        <label for="hourlyRate">Hourly Rate:</label>
        <input type="text" name="hourlyRate" required><br>

        <button type="submit" name="createHourlyRate">Create Hourly Rate</button>
    </form>

    <a href="view_hourly_rates.php">Back to Hourly Rates</a>
</body>
</html>

