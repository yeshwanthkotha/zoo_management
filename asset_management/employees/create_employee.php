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
    $superID = empty($_POST["superID"]) ? null : $_POST["superID"];
    $hourlyRateID = empty($_POST["hourlyRateID"]) ? null : $_POST["hourlyRateID"];
    $concessionID = empty($_POST["concessionID"]) ? null : $_POST["concessionID"];
    $zooAdmissionID = empty($_POST["zooAdmissionID"]) ? null : $_POST["zooAdmissionID"];

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h2 {
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
            border: 1px solid #ddd;
        }

        button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #f7f7f7;
        }

        a {
            display: block;
            text-align: center;
            padding: 10px;
            text-decoration: none;
            color: #333;
            border: 1px solid #ddd;
            margin-top: 20px;
        }

        a:hover {
            background-color: #f7f7f7;
        }

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
            <?php
            while ($employee = $employeesResult->fetch_assoc()) :
                $employeeID = $employee['EmployeeID'];
                $fullName = $employee['FullName'];
            ?>
                <option value="<?php echo $employeeID; ?>"><?php echo $fullName; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="hourlyRateID">Hourly Rate:</label>
        <select name="hourlyRateID" required>
            <option value="">None</option>
            <?php
            while ($hourlyRate = $hourlyRatesResult->fetch_assoc()) :
                $rateID = $hourlyRate['ID'];
                $hourlyRateValue = $hourlyRate['HourlyRate'];
            ?>
                <option value="<?php echo $rateID; ?>"><?php echo $hourlyRateValue; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="concessionID">Concession:</label>
        <select name="concessionID">
            <option value="">None</option>
            <?php
            while ($concession = $concessionsResult->fetch_assoc()) :
                $concessionID = $concession['ID'];
                $product = $concession['Product'];
            ?>
                <option value="<?php echo $concessionID; ?>"><?php echo $product; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="zooAdmissionID">Zoo Admission:</label>
        <select name="zooAdmissionID">
            <option value="">None</option>
            <?php
            // Reset the pointer of the result set to the beginning
            $zooAdmissionsResult->data_seek(0);
            while ($zooAdmission = $zooAdmissionsResult->fetch_assoc()) :
                $zooAdmissionID = $zooAdmission['ID'];
            ?>
                <option value="<?php echo $zooAdmissionID; ?>"><?php echo $zooAdmissionID; ?></option>
            <?php endwhile; ?>
        </select><br>


        <button type="submit" name="createEmployee">Create Employee</button>
    </form>

    <a href="view_employees.php">Back to Employees</a>
</body>
</html>