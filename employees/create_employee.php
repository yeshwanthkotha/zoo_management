<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch available employees for the supervisor dropdown
$employeesSql = "SELECT EmployeeID, CONCAT(FirstName, ' ', LastName) AS FullName FROM Employee";
$employeesResult = $conn->query($employeesSql);

// Fetch available hourly rates for dropdown
$hourlyRatesSql = "SELECT ID, HourlyRate FROM HourlyRate";
$hourlyRatesResult = $conn->query($hourlyRatesSql);

// Fetch available concessions for dropdown
$concessionsSql = "SELECT ID, Product FROM Concession";
$concessionsResult = $conn->query($concessionsSql);

// Fetch available zoo admissions for dropdown
$zooAdmissionsSql = "SELECT ID FROM ZooAdmission";
$zooAdmissionsResult = $conn->query($zooAdmissionsSql);

// Handle form submission for creating a new employee
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createEmployee"])) {
    $jobType = $_POST["jobType"];
    $firstName = $_POST["firstName"];
    $middleName = $_POST["middleName"];
    $lastName = $_POST["lastName"];
    $street = $_POST["street"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];
    $superID = $_POST["superID"];
    $hourlyRateID = $_POST["hourlyRateID"];
    $concessionID = $_POST["concessionID"];
    $zooAdmissionID = $_POST["zooAdmissionID"];

    // Generate username and password based on first name and last name
    $username = strtolower($firstName . $lastName);
    $password = $firstName . $lastName;  // You can enhance this for better security

    // Set the role as the job type
    $role = $jobType;

    // Set the StartDate to the current date
    $startDate = date("Y-m-d");

    // Insert the new employee details into the Employee table
    $employeeSql = "INSERT INTO Employee (StartDate, JobType, FirstName, MiddleName, LastName, Street, City, State, Zip, SuperID, HourlyRateID, ConcessionID, ZooAdmissionID)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtEmployee = $conn->prepare($employeeSql);
    $stmtEmployee->bind_param(
        "ssssssssiiiii",
        $startDate,
        $jobType,
        $firstName,
        $middleName,
        $lastName,
        $street,
        $city,
        $state,
        $zip,
        $superID,
        $hourlyRateID,
        $concessionID,
        $zooAdmissionID
    );
    $stmtEmployee->execute();
    $stmtEmployee->close();

    // Insert the new user details into the Users table
    $userSql = "INSERT INTO Users (Username, Password, Role)
            VALUES (?, ?, ?)";
    $stmtUser = $conn->prepare($userSql);
    $stmtUser->bind_param("sss", $username, $password, $role);
    $stmtUser->execute();
    $stmtUser->close();

    echo "Employee and user created successfully.";
}
?>

<!-- ... (rest of the HTML code) ... -->


<!-- ... (rest of the HTML code) ... -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Employee</title>
    <style>
        
    </style>
</head>
<body>
    <h2>Create Employee</h2>

    <!-- Employee creation form -->
    <form method="post" action="">

        <label for="jobType">Job Type:</label>
        <select name="jobType" required>
            <option value="Veterinarian">Veterinarian</option>
            <option value="Animal Care Specialist">Animal Care Specialist</option>
            <option value="Maintenance">Maintenance</option>
            <option value="Customer Service">Customer Service</option>
            <option value="Ticket Seller">Ticket Seller</option>
        </select><br>

        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" required><br>

        <label for="middleName">Middle Name:</label>
        <input type="text" name="middleName"><br>

        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" required><br>

        <label for="street">Street:</label>
        <input type="text" name="street" required><br>

        <label for="city">City:</label>
        <input type="text" name="city" required><br>

        <label for="state">State:</label>
        <input type="text" name="state" required><br>

        <label for="zip">Zip:</label>
        <input type="text" name="zip" required><br>

        <label for="superID">Supervisor:</label>
        <select name="superID">
            <option value="">None</option>
            <?php while ($employee = $employeesResult->fetch_assoc()) : ?>
                <option value="<?php echo $employee['EmployeeID']; ?>"><?php echo $employee['FullName']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="hourlyRateID">Hourly Rate:</label>
        <select name="hourlyRateID" required>
            <?php while ($hourlyRate = $hourlyRatesResult->fetch_assoc()) : ?>
                <option value="<?php echo $hourlyRate['ID']; ?>"><?php echo $hourlyRate['HourlyRate']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="concessionID">Concession:</label>
        <select name="concessionID">
            <option value="">None</option>
            <?php while ($concession = $concessionsResult->fetch_assoc()) : ?>
                <option value="<?php echo $concession['ID']; ?>"><?php echo $concession['Product']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="zooAdmissionID">Zoo Admission:</label>
    <select name="zooAdmissionID">
        <option value="">None</option>
        <?php
        // Reset the pointer of the result set to the beginning
        $zooAdmissionsResult->data_seek(0);
        while ($zooAdmission = $zooAdmissionsResult->fetch_assoc()) : ?>
            <option value="<?php echo $zooAdmission['ID']; ?>"><?php echo $zooAdmission['ID']; ?></option>
        <?php endwhile; ?>
    </select><br>

        <button type="submit" name="createEmployee">Create Employee</button>
    </form>

    <a href="view_employees.php">Back to Employees</a>
</body>
</html>
