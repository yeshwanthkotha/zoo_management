<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Animal Population Report</title>
</head>
<body>
    <h2>Generate Animal Population Report</h2>

    <form method="post" action="generate_animal_report.php">
        <label for="selectedMonth">Select Month:</label>
        <input type="month" name="selectedMonth" required>
        <button type="submit" name="generateAnimalReport">Generate Report</button>
    </form>
</body>
</html>
