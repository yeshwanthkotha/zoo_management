<!-- view_species.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Species Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(144, 238, 144, 0.3); /* Light green with reduced opacity */
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Species Data</h2>

        <?php
        include '../includes/db_connection.php';

        // Get the species ID from the URL
        $speciesID = isset($_GET['id']) ? $_GET['id'] : null;

        if ($speciesID) {
            // Fetch species data for the specific ID
            $speciesSql = "SELECT ID, Name, FoodCost, updated_date FROM species WHERE ID = ?";
            $stmt = $conn->prepare($speciesSql);
            $stmt->bind_param("i", $speciesID);
            $stmt->execute();
            $speciesResult = $stmt->get_result();

            while ($species = $speciesResult->fetch_assoc()) {
                echo "<div class='species-info'>";
                echo "<p><strong>Species ID:</strong> {$species['ID']}</p>";
                echo "<p><strong>Name:</strong> {$species['Name']}</p>";
                echo "<p><strong>Food Cost:</strong> {$species['FoodCost']}</p>";
                echo "<p><strong>Updated Date:</strong> {$species['updated_date']}</p>";
                echo "</div>";
            }

            $stmt->close();
        } else {
            echo "<p>No species ID specified.</p>";
        }
        ?>
    </div>
</body>
</html>
