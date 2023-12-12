<?php
include '../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["checkoutTicket"])) {
    $animalShowID = $_POST["animalShowID"];
    $adultTickets = $_POST["adultTickets"];
    $childTickets = $_POST["childTickets"];
    $seniorTickets = $_POST["seniorTickets"];

    $animalShowDetailsSql = "SELECT SeniorPrice, AdultPrice, ChildPrice FROM AnimalShow WHERE ID = ?";
    $animalShowDetailsStmt = $conn->prepare($animalShowDetailsSql);
    $animalShowDetailsStmt->bind_param("i", $animalShowID);
    $animalShowDetailsStmt->execute();
    $animalShowDetailsResult = $animalShowDetailsStmt->get_result();
    $animalShowDetails = $animalShowDetailsResult->fetch_assoc();
    $animalShowDetailsStmt->close();

    $seniorPrice = $animalShowDetails['SeniorPrice'];
    $adultPrice = $animalShowDetails['AdultPrice'];
    $childPrice = $animalShowDetails['ChildPrice'];

    $attendance = $adultTickets + $childTickets + $seniorTickets;
    $revenue = ($seniorTickets * $seniorPrice) + ($adultTickets * $adultPrice) + ($childTickets * $childPrice);

    $insertTicketSql = "INSERT INTO AnimalShowTickets (AnimalShowID, AdultTickets, ChildTickets, SeniorTickets, Price, Attendance, Revenue, CheckoutTime) VALUES (?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
    $insertTicketStmt = $conn->prepare($insertTicketSql);
    $insertTicketStmt->bind_param("iiididd", $animalShowID, $adultTickets, $childTickets, $seniorTickets, $revenue, $attendance, $revenue);
    $insertTicketStmt->execute();
    $insertTicketStmt->close();
}

$animalShowsSql = "SELECT ID, SeniorPrice, AdultPrice, ChildPrice FROM AnimalShow";
$animalShowsResult = $conn->query($animalShowsSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Show Ticket Checkout</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: black;
        }

        select, input {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Animal Show Ticket Checkout</h2>
        <form method="post" action="">
            <label for="animalShowID">Select Animal Show:</label>
            <select name="animalShowID" required>
                <?php while ($animalShow = $animalShowsResult->fetch_assoc()) : ?>
                    <option value="<?php echo $animalShow['ID']; ?>">
                        <?php echo "Show ID: " . $animalShow['ID']; ?>
                    </option>
                <?php endwhile; ?>
            </select><br>

            <label for="adultTickets">Adult Tickets:</label>
            <input type="button" value="-" onclick="decrement('adultTickets')"> 
            <input type="text" name="adultTickets" id="adultTickets" value="0" readonly>
            <input type="button" value="+" onclick="increment('adultTickets')"><br>

            <label for="childTickets">Child Tickets:</label>
            <input type="button" value="-" onclick="decrement('childTickets')"> 
            <input type="text" name="childTickets" id="childTickets" value="0" readonly>
            <input type="button" value="+" onclick="increment('childTickets')"><br>

            <label for="seniorTickets">Senior Tickets:</label>
            <input type="button" value="-" onclick="decrement('seniorTickets')"> 
            <input type="text" name="seniorTickets" id="seniorTickets" value="0" readonly>
            <input type="button" value="+" onclick="increment('seniorTickets')"><br>

            <button type="submit" name="checkoutTicket">Checkout Ticket</button>
        </form>

        <script>
            function increment(elementId) {
                var inputElement = document.getElementById(elementId);
                inputElement.value = parseInt(inputElement.value) + 1;
            }

            function decrement(elementId) {
                var inputElement = document.getElementById(elementId);
                var value = parseInt(inputElement.value);
                if (value > 0) {
                    inputElement.value = value - 1;
                }
            }
        </script>
    </div>
</body>
</html>