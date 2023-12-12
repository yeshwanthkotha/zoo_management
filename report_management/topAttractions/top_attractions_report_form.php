<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Attractions Report</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
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

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #000;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Helvetica', sans-serif;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Select Time Period for Top Attractions Report</h2>

        <!-- Form to select the time period -->
        <form method="post" action="generate_top_attractions_report.php">
            <label for="startDate">Start Date:</label>
            <input type="date" name="startDate" required>
            <label for="endDate">End Date:</label>
            <input type="date" name="endDate" required>
            <button type="submit" name="generateTopAttractionsReport">Generate Report</button>
        </form>
    </div>
</body>
</html>
