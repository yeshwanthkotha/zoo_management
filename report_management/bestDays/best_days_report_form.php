<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Days Revenue Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #333;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            display: block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Select Month for Top Days Revenue Report</h2>

    <!-- Form to select the month -->
    <form method="post" action="generate_best_days_report.php">
        <label for="selectedMonth">Select Month:</label>
        <input type="month" name="selectedMonth" required>
        <button type="submit" name="generateTopDaysReport">Generate Report</button>
    </form>

    <a href="index.php">Back to Home</a>
</body>
</html>
