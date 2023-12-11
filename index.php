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
        <li><a href="animal/animal.php">Animal Management</a></li>
        <li><a href="buildings/building.php">Building Management</a></li>
        <li><a href="enclosures/enclosure.php">Enclosure</a></li>
        <li><a href="species/species.php">Species</a></li>
        <li><a href="revenuesTypes/revenue_types.php">RevenueTypes</a></li>
        <li><a href="revenuesEvents/view_revenue_events.php">RevenueEvents</a></li>
        <li><a href="animalShows/view_animal_shows.php">Animal Shows</a></li>
        <li><a href="concession/view_concessions.php">concession</a></li>
        <li><a href="zooAdmission/view_zoo_admissions.php">zooAdmission</a></li>
        <li><a href="caresFor/view_cares_for.php">caresFor</a></li>
        <li><a href="participatesIN/view_participates_in.php">participatesIN</a></li>
        <li><a href="employees/view_employees.php">view_employees</a></li>
        <li><a href="hourlyRate/view_hourly_rates.php">view_hourly_rates</a></li>
        <li><a href="attendance/view_attendance.php">view_attendance</a></li>
        <li><a href="attractions/view_attractions.php">view_attractions</a></li>
        <li><a href="reportForm/report_form.php">report_form</a></li>
        <li><a href="animalPopulationReport/animal_population_report_form.php">animal_report_form</a></li>
        <li><a href="topAttractions/top_attractions_report_form.php">top_attractions_report_form</a></li>
        <li><a href="averageRevenue/average_revenue_report_form.php">average_revenue_report_form</a></li>
        <li><a href="bestDays/best_days_report_form.php">best_days_report_form</a></li>
        <!-- Add more navigation links for other features -->
    </ul>
</body>
</html>
