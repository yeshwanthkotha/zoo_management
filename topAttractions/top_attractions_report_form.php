<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Attractions Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            width: fit-content;
            margin: auto;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Select Time Period for Top Attractions Report</h2>

    <!-- Form to select the time period -->
    <form method="post" action="generate_top_attractions_report.php">
        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate" required>
        <label for="endDate">End Date:</label>
        <input type="date" name="endDate" required>
        <button type="submit" name="generateTopAttractionsReport">Generate Report</button>
    </form>
</body>
</html>

