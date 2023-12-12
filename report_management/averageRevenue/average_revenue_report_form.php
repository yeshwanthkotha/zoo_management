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
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h2 {
            text-align: center;
        }

        form {
            max-width: 400px;
            padding: 20px;
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
            background-color: #000;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        p {
            text-align: center;
            margin-top: 10px;
        }

        a {
            text-decoration: none;
            color: #000;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div>
        <h2>Select Time Period for Average Revenue Report</h2>

        <!-- Form to select the time period -->
        <form method="post" action="generate_average_revenue_report.php">
            <label for="startDate">Start Date:</label>
            <input type="date" name="startDate" required>
            <label for="endDate">End Date:</label>
            <input type="date" name="endDate" required>
            <button type="submit" name="generateAverageRevenueReport">Generate Report</button>
        </form>

        <p><a href="index.php">Back to Home</a></p>
    </div>
</body>
</html>
