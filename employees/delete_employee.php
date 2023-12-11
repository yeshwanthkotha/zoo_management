<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Check if the user is not logged in, redirect to login page
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Check if the user is an admin, otherwise deny access
if ($_SESSION['role'] !== 'Admin') {
    die("Access denied. Only admins can access this page.");
}

// Initialize variables
$employeeIDToDelete = null;

// Handle the deletion of the employee based on the ID from the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteEmployee"])) {
    // Validate and sanitize input
    $employeeIDToDelete = filter_input(INPUT_POST, 'employeeIDToDelete', FILTER_VALIDATE_INT);

    if ($employeeIDToDelete === false || $employeeIDToDelete === null) {
        die("Invalid employee ID.");
    }

    // Perform the necessary database operations to delete the employee
    $deleteSql = "DELETE FROM Employee WHERE EmployeeID = ?";
    $stmt = $conn->prepare($deleteSql);

    if ($stmt) {
        $stmt->bind_param("i", $employeeIDToDelete);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Employee deleted successfully.";
        } else {
            echo "Error: Unable to delete employee. The specified employee may not exist.";
        }

        $stmt->close();
    } else {
        die("Error: Unable to prepare the delete statement.");
    }
}

// Fetch available employees for the supervisor dropdown
$employeesSql = "SELECT EmployeeID, CONCAT(FirstName, ' ', LastName) AS FullName FROM Employee";
$employeesResult = $conn->query($employeesSql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Employee</title>
</head>
<body>
    <h2>Delete Employee</h2>

    <!-- Employee deletion form -->
    <form method="post" action="">
        <label for="employeeIDToDelete">Select Employee to Delete:</label>
        <select name="employeeIDToDelete" required>
            <?php while ($employee = $employeesResult->fetch_assoc()) : ?>
                <option value="<?php echo $employee['EmployeeID']; ?>"><?php echo $employee['FullName']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <button type="submit" name="deleteEmployee">Delete Employee</button>
    </form>

    <a href="view_employees.php">Back to Employees</a>
</body>
</html>
