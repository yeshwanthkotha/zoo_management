<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
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
    <title>Asset Management System</title>
</head>
<body>
    <h1>Asset Management System</h1>

    <!-- Logout form -->
    <form method="post" action="">
        <button type="submit" name="logout">Logout</button>
    </form>

    <ul>
        <li><a href="asset_management/animal/view_animals.php">Animal Management</a></li>
        <li><a href="asset_management/buildings/view_buildings.php">Building Management</a></li>
        <li><a href="asset_management/enclosures/view_enclosures.php">Enclosure</a></li>
        <li><a href="asset_management/species/view_species.php">Species</a></li>
        <li><a href="asset_management/revenuesTypes/revenue_types.php">RevenueTypes</a></li>
        <li><a href="asset_management/revenuesEvents/view_revenue_events.php">RevenueEvents</a></li>
        <li><a href="asset_management/animalShows/view_animal_shows.php">Animal Shows</a></li>
        <li><a href="asset_management/concession/view_concessions.php">concession</a></li>
        <li><a href="asset_management/zooAdmission/view_zoo_admissions.php">zooAdmission</a></li>
        <li><a href="asset_management/caresFor/view_cares_for.php">caresFor</a></li>
        <li><a href="asset_management/participatesIN/view_participates_in.php">participatesIN</a></li>
        <li><a href="asset_management/employees/view_employees.php">view_employees</a></li>
        <li><a href="asset_management/hourlyRate/view_hourly_rates.php">view_hourly_rates</a></li>
        <li><a href="zoo_activity/attendance/view_attendance.php">view_attendance</a></li>
        <li><a href="zoo_activity/attractions/view_attractions.php">view_attractions</a></li>
        <li><a href="report_management/reportForm/report_form.php">report_form</a></li>
        <li><a href="report_management/animalPopulationReport/animal_population_report_form.php">animal_report_form</a></li>
        <li><a href="report_management/topAttractions/top_attractions_report_form.php">top_attractions_report_form</a></li>
        <li><a href="report_management/averageRevenue/average_revenue_report_form.php">average_revenue_report_form</a></li>
        <li><a href="report_management/bestDays/best_days_report_form.php">best_days_report_form</a></li>
        <!-- Add more navigation links for other features -->
    </ul>
</body>
</html>
