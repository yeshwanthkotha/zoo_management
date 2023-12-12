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

// Handle delete user action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['username'])) {
    $usernameToDelete = $_GET['username'];

    // Perform the necessary database operations to delete the user
    $sql = "DELETE FROM Users WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usernameToDelete);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the view_users.php page after deletion
    header("Location: view_users.php");
    exit();
}

// Fetch all users from the database
$sql = "SELECT * FROM Users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
        }

        a.button {
            display: block;
            width: 100px;
            margin: 10px auto;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border: 1px solid #333;
            border-radius: 5px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #333;
        }

        th {
            background-color: #333;
            color: white;
        }

        ul {
            list-style: none;
            padding: 0;
            text-align: center;
        }

        li {
            display: inline-block;
            margin-right: 20px;
        }

        li a {
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
    <h2>View All Users</h2>

    <!-- Create User button -->
    <a class="button" href="create_user.php">Create User</a>

    <!-- Display users in a table -->
    <table border="1">
        <tr>
            <th>Username</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['Username']; ?></td>
                <td><?= $row['Role']; ?></td>
                <td>
                    <a href="edit_user.php?username=<?= $row['Username']; ?>">Update</a>
                    <a href="view_users.php?action=delete&username=<?= $row['Username']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <ul>
        <li><a href="dashboard.php">Back to Dashboard</a></li>
    </ul>
</body>
</html>
