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

// Handle form submission for creating a new user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createUser"])) {
    $newUsername = $_POST["newUsername"];
    $newPassword = $_POST["newPassword"];
    $newRole = $_POST["role"];

    // Perform the necessary database operations to create a new user
    $sql = "INSERT INTO Users (Username, Password, Role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $newUsername, $newPassword, $newRole);
    $stmt->execute();
    $stmt->close();

    echo "User created successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <style>
        /* Add your styles here */
    </style>
</head>
<body>
    <h2>Create User</h2>

    <!-- Create User form -->
    <form method="post" action="">
        <label for="newUsername">New Username:</label>
        <input type="text" name="newUsername" required><br>

        <label for="newPassword">New Password:</label>
        <input type="password" name="newPassword" required><br>

        <label for="role">Select Role:</label>
        <select name="role" id="role">
            <option value="Admin">Admin</option>
            <option value="User">User</option>
            <option value="Manager">Manager</option>
            <!-- Add more options if needed -->
        </select>

        <button type="submit" name="createUser">Create User</button>
    </form>

    <ul>
        <li><a href="view_users.php">Back to View Users</a></li>
        <li><a href="dashboard.php">Back to Dashboard</a></li>
    </ul>
</body>
</html>
