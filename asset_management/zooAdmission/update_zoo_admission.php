<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve the Zoo Admission ID from the URL parameter
$zooAdmissionId = $_GET['id'];

// Fetch the zoo admission details from the database
$sql = "SELECT ZooAdmission.ID, RevenueType.Name AS RevenueTypeName, SeniorPrice, AdultPrice, ChildPrice 
        FROM ZooAdmission
        JOIN RevenueType ON ZooAdmission.ID = RevenueType.ID
        WHERE ZooAdmission.ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $zooAdmissionId);
$stmt->execute();
$result = $stmt->get_result();
$zooAdmission = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Zoo Admission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }

        a {
            display: block;
            text-align: center;
            margin: 10px 0;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <h2>Update Zoo Admission</h2>

    <!-- Zoo Admission update form -->
    <form method="post" action="">
        <label for="revenueTypeName">Revenue Type:</label>
        <input type="text" name="revenueTypeName" value="<?php echo $zooAdmission['RevenueTypeName']; ?>" readonly><br>

        <label for="seniorPrice">Senior Price:</label>
        <input type="number" name="seniorPrice" value="<?php echo $zooAdmission['SeniorPrice']; ?>" required><br>

        <label for="adultPrice">Adult Price:</label>
        <input type="number" name="adultPrice" value="<?php echo $zooAdmission['AdultPrice']; ?>" required><br>

        <label for="childPrice">Child Price:</label>
        <input type="number" name="childPrice" value="<?php echo $zooAdmission['ChildPrice']; ?>" required><br>

        <button type="submit" name="updateZooAdmission">Update Zoo Admission</button>
    </form>

    <a href="view_zoo_admissions.php">Back to Zoo Admissions</a>
</body>
</html>

<?php
// Handle update zoo admission form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateZooAdmission"])) {
    $seniorPrice = $_POST["seniorPrice"];
    $adultPrice = $_POST["adultPrice"];
    $childPrice = $_POST["childPrice"];

    // Update the Zoo Admission details in the database
    $updateSql = "UPDATE ZooAdmission SET SeniorPrice = ?, AdultPrice = ?, ChildPrice = ? WHERE ID = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("iii", $seniorPrice, $adultPrice, $childPrice, $zooAdmissionId);
    $stmt->execute();
    $stmt->close();

    echo "Zoo Admission updated successfully.";
}
?>
