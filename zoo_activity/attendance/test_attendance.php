<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Handle ticket checkout form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["checkoutTicket"])) {
    $zooAdmissionID = $_POST["zooAdmissionID"];
    $adultTickets = $_POST["adultTickets"];
    $childTickets = $_POST["childTickets"];
    $seniorTickets = $_POST["seniorTickets"];

    // Fetch prices from ZooAdmission for calculation
    $zooAdmissionSql = "SELECT AdultPrice, ChildPrice, SeniorPrice FROM ZooAdmission WHERE ID = ?";
    $zooAdmissionStmt = $conn->prepare($zooAdmissionSql);
    $zooAdmissionStmt->bind_param("i", $zooAdmissionID);
    $zooAdmissionStmt->execute();
    $zooAdmissionResult = $zooAdmissionStmt->get_result();
    $zooAdmission = $zooAdmissionResult->fetch_assoc();
    $zooAdmissionStmt->close();

    $adultPrice = $zooAdmission['AdultPrice'];
    $childPrice = $zooAdmission['ChildPrice'];
    $seniorPrice = $zooAdmission['SeniorPrice'];

    // Calculate total attendance and revenue for the current transaction
    $attendance = $adultTickets + $childTickets + $seniorTickets;
    $revenue = ($adultPrice * $adultTickets) + ($childPrice * $childTickets) + ($seniorPrice * $seniorTickets);

    // Insert ticket records with checkout time
    $insertTicketSql = "INSERT INTO ZooAdmissionTickets (ZooAdmissionID, AdultTickets, ChildTickets, SeniorTickets, Price, Attendance, Revenue, CheckoutTime) VALUES (?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
    $insertTicketStmt = $conn->prepare($insertTicketSql);
    $insertTicketStmt->bind_param("iiididd", $zooAdmissionID, $adultTickets, $childTickets, $seniorTickets, $revenue, $attendance, $revenue);
    $insertTicketStmt->execute();
    $insertTicketStmt->close();
}

// Fetch and display zoo admissions
$zooAdmissionsSql = "SELECT ID, SeniorPrice, AdultPrice, ChildPrice FROM ZooAdmission";
$zooAdmissionsResult = $conn->query($zooAdmissionsSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Admission Ticket Checkout</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f5f5f5;
        }

        .container {
            padding: 20px;
            text-align: center;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 24px;
            color: black;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin: 10px 0;
            color: black;
        }

        select, input {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            color: black;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            color: black;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid black; /* Added border to the table */
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid black; /* Added border to table cells */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Zoo Admission Ticket Checkout</h2>

        <!-- Ticket checkout form -->
        <form method="post" action="">
            <label for="zooAdmissionID">Select Zoo Admission:</label>
            <select name="zooAdmissionID" required>
                <?php while ($zooAdmission = $zooAdmissionsResult->fetch_assoc()) : ?>
                    <option value="<?php echo $zooAdmission['ID']; ?>">
                        <?php echo "Admission ID: " . $zooAdmission['ID']; ?>
                    </option>
                <?php endwhile; ?>
            </select><br>

            <label for="adultTickets">Adult Tickets:</label>
            <input type="text" name="adultTickets" id="adultTickets" value="0" readonly>
            <br>

            <label for="childTickets">Child Tickets:</label>
            <input type="text" name="childTickets" id="childTickets" value="0" readonly>
            <br>

            <label for="seniorTickets">Senior Tickets:</label>
            <input type="text" name="seniorTickets" id="seniorTickets" value="0" readonly>
            <br>

            <button type="submit" name="checkoutTicket">Checkout Ticket</button>
        </form>

        <script>
            // Function to increment ticket quantity
            function increment(elementId) {
                var inputElement = document.getElementById(elementId);
                inputElement.value = parseInt(inputElement.value) + 1;
            }

            // Function to decrement ticket quantity
            function decrement(elementId) {
                var inputElement = document.getElementById(elementId);
                var value = parseInt(inputElement.value);
                if (value > 0) {
                    inputElement.value = value - 1;
                }
            }
        </script>

        <!-- Display zoo admissions with attendance and revenue -->
        <h3>Zoo Admissions Information</h3>
        <table>
            <tr>
                <th>Admission ID</th>
                <th>Senior Price</th>
                <th>Adult Price</th>
                <th>Child Price</th>
                <th>Attendance</th>
                <th>Revenue</th>
            </tr>
            <?php
            $zooAdmissionsResult = $conn->query($zooAdmissionsSql);
            while ($zooAdmission = $zooAdmissionsResult->fetch_assoc()) :
                $zooAdmissionID = $zooAdmission['ID'];
                
                // Fetch Attendance and Revenue from ZooAdmissionTickets
                $zooAdmissionTicketsSql = "SELECT SUM(Attendance) AS TotalAttendance, SUM(Revenue) AS TotalRevenue FROM ZooAdmissionTickets WHERE ZooAdmissionID = ?";
                $zooAdmissionTicketsStmt = $conn->prepare($zooAdmissionTicketsSql);
                $zooAdmissionTicketsStmt->bind_param("i", $zooAdmissionID);
                $zooAdmissionTicketsStmt->execute();
                $zooAdmissionTicketsResult = $zooAdmissionTicketsStmt->get_result();
                $zooAdmissionTickets = $zooAdmissionTicketsResult->fetch_assoc();
                $zooAdmissionTicketsStmt->close();
            ?>
                <tr>
                    <td><?php echo $zooAdmission['ID']; ?></td>
                    <td><?php echo $zooAdmission['SeniorPrice']; ?></td>
                    <td><?php echo $zooAdmission['AdultPrice']; ?></td>
                    <td><?php echo $zooAdmission['ChildPrice']; ?></td>
                    <td><?php echo $zooAdmissionTickets['TotalAttendance']; ?></td>
                    <td><?php echo $zooAdmissionTickets['TotalRevenue']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
