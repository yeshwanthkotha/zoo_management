<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the user is an admin, otherwise deny access
if ($_SESSION['role'] !== 'Admin') {
    echo "Access denied. Only admins can access this page.";
    exit();
}

// Include the common database connection file
include 'db_connection.php';

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            text-align: left;
            margin: 10px 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .button-link {
            display: block;
            padding: 8px 15px;
            margin: 5px 0;
            text-decoration: none;
            color: #333;
            border: 1px solid #333;
            background: transparent;
            text-align: left;
        }

        .button-link:hover {
            background-color: #f4f4f4;
        }

        a {
            text-decoration: none;
            color: #333;
        }

        .logout-form, .view-users {
            text-align: left;
            margin: 0 20px;
        }

        button {
            padding: 8px 15px;
            border: 1px solid #333;
            background: transparent;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <div class="logout-form">
        <form method="post" action="">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>

    <div class="view-users">
        <p><a href="view_users.php">View All Users</a></p>
    </div>

    <table>
        <tr>
            <th>Assets Management</th>
            <th>Zoo Activity</th>
            <th>Report Management</th>
        </tr>
        <tr>
            <td>
                <button class="button-link" onclick="window.location.href='asset_management/animal/view_animals.php'">Animal Management</button>
                <button class="button-link" onclick="window.location.href='asset_management/buildings/view_buildings.php'">Building Management</button>
                <button class="button-link" onclick="window.location.href='asset_management/enclosures/view_enclosures.php'">Enclosure Management</button>
                <button class="button-link" onclick="window.location.href='asset_management/species/view_species.php'">Species Management</button>
                <button class="button-link" onclick="window.location.href='asset_management/revenuesTypes/revenue_types.php'">Revenue Types</button>
                <button class="button-link" onclick="window.location.href='asset_management/revenuesEvents/view_revenue_events.php'">Revenue Events</button>
                <button class="button-link" onclick="window.location.href='asset_management/animalShows/view_animal_shows.php'">Animal Shows</button>
                <button class="button-link" onclick="window.location.href='asset_management/concession/view_concessions.php'">Concession Management</button>
                <button class="button-link" onclick="window.location.href='asset_management/zooAdmission/view_zoo_admissions.php'">Zoo Admission</button>
                <button class="button-link" onclick="window.location.href='asset_management/caresFor/view_cares_for.php'">Cares For</button>
                <button class="button-link" onclick="window.location.href='asset_management/participatesIN/view_participates_in.php'">Participates In</button>
                <button class="button-link" onclick="window.location.href='asset_management/employees/view_employees.php'">Employee Management</button>
                <button class="button-link" onclick="window.location.href='asset_management/hourlyRate/view_hourly_rates.php'">Hourly Rates</button>
            </td>
            <td>
                <button class="button-link" onclick="window.location.href='zoo_activity/attendance/test_attendance.php'">Zoo Attendance</button>
                <button class="button-link" onclick="window.location.href='zoo_activity/attractions/test_attraction.php'">Attractions Management</button>
                <button class="button-link" onclick="window.location.href='asset_management/concession/sales_concession.php'">Concession Sales</button>
            </td>
            <td>
                <button class="button-link" onclick="window.location.href='report_management/reportForm/report_form.php'">Report Form</button>
                <button class="button-link" onclick="window.location.href='report_management/animalPopulationReport/animal_population_report_form.php'">Animal Population Report</button>
                <button class="button-link" onclick="window.location.href='report_management/topAttractions/top_attractions_report_form.php'">Top Attractions Report</button>
                <button class="button-link" onclick="window.location.href='report_management/averageRevenue/average_revenue_report_form.php'">Average Revenue Report</button>
                <button class="button-link" onclick="window.location.href='report_management/bestDays/best_days_report_form.php'">Best Days Report</button>
            </td>
        </tr>
    </table>
</body>
</html>