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

// Check user role
$userRole = $_SESSION['role']; // Assuming 'role' is a session variable that stores the user's role

// Define roles that have access to the asset management page
$allowedRoles = ['Manager', 'Admin'];

// Check if the user has the required role
if (!in_array($userRole, $allowedRoles)) {
    echo "Access denied. You do not have the required role.";
    exit();
}

// Get the logged-in username
$loggedInUsername = $_SESSION['username'];

// Get the server's system time
$currentTime = date("Y-m-d H:i:s");

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

    <!-- Display logged-in username and current time -->
    <p>Welcome, <?php echo $loggedInUsername; ?>! Current Time (Server): <?php echo $currentTime; ?>! Role: <?php echo $userRole; ?></p>

    <!-- Logout form -->
    <form method="post" action="">
        <button type="submit" name="logout">Logout</button>
    </form>

    <ul>
        <li><a href="animal/animal.php">Animal Management</a></li>
        <li><a href="buildings/building.php">Building Management</a></li>
        <li><a href="enclosures/enclosure.php">Enclosure Management</a></li>
        <li><a href="species/species.php">Species Management</a></li>
        <li><a href="revenuesTypes/revenue_types.php">Revenue Types</a></li>
        <li><a href="revenuesEvents/view_revenue_events.php">Revenue Events</a></li>
        <li><a href="concession/view_concessions.php">Concession Management</a></li>
        <li><a href="zooAdmission/view_zoo_admissions.php">Zoo Admission Management</a></li>
        <li><a href="caresFor/view_cares_for.php">Cares For Management</a></li>
        <li><a href="animalShows/view_animal_shows.php">Animal Shows</a></li>
        <li><a href="participatesIN/view_participates_in.php">Participates In Management</a></li>
    </ul>
</body>
</html>
