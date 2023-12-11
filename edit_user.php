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

// Fetch user details based on the provided username
if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $sql = "SELECT * FROM Users WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "Username not provided.";
    exit();
}

// Handle form submission for updating user details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateUser"])) {
    $newRole = $_POST["role"];

    // Perform the necessary database operations to update the user's role
    $sql = "UPDATE Users SET Role = ? WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $newRole, $username);
    $stmt->execute();
    $stmt->close();
    echo "User role updated successfully.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(144, 238, 144, 0.3); /* Light transparent green background */
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        p {
            color: #555;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: 20px auto; /* Center the form horizontally */
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
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
    <h2>Edit User - <?= $user['Username']; ?></h2>

    <!-- Display user details and form for updating role -->
    <p>Current Role: <?= $user['Role']; ?></p>
    
    <form method="post" action="">
        <label for="role">Select New Role:</label>
        <select name="role" id="role">
            <option value="Admin" <?= ($user['Role'] === 'Admin') ? 'selected' : ''; ?>>Admin</option>
            <option value="User" <?= ($user['Role'] === 'User') ? 'selected' : ''; ?>>User</option>
            <option value="Manager" <?= ($user['Role'] === 'Manager') ? 'selected' : ''; ?>>Manager</option>
            <!-- Add more options if needed -->
        </select>
        <button type="submit" name="updateUser">Update Role</button>
    </form>

    <ul>
        <li><a href="view_users.php">Back to View Users</a></li>
    </ul>
</body>
</html>
