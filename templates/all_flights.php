<?php
// Include necessary files
include '../config/core.php';
include '../config/connection.php';

// Fetch necessary flight information from the database
$stmt = $conn->prepare("SELECT flight_code, origin_destination_id, destination_destination_id, departure_datetime, arrival_datetime FROM Flights");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Flights</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/allflights.css">
    <nav>
    <div class="nav__logo">CliffCo Airways</div>
        <ul class="nav__links">
        <li class="link"><a href="../templates/all_flights.php">All Flights</a></li>

            <li class="link"><a href="../templates/myflights.php">My Flights</a></li>
            <!-- <li class="link"><a href="../templates/profile.php">Profile</a></li> -->
            <li class="link"><a href="../templates/settings.php">Settings</a>
                <ul class="sub-menu">
                    <li><a href="../templates/profile.php">Profile</a></li>
                </ul>
            </li>
            <li class="link"><a href="../templates/flight.php">Book a flight</a>
                <ul class="sub-menu">
                <li class="link"><a href="#find-flight">Find a Flight</a></li> 
                </ul>
            </li>
            <li class="link"><a href="../templates/destination.php">Destinations</a></li>
        </ul>
        <button class="btn" id="goBackButton">Go Back</button>
    </nav>
    
    <script>
        // Add event listener to the button
        document.getElementById("goBackButton").addEventListener("click", function() {
            // Redirect to the dashboard page
            window.location.href = "../templates/dashboard.php";
        });
    </script>
</head>

<body>
    <table>
        <tr>
            <th>Flight Code</th>
            <th>Origin Destination</th>
            <th>Destination Destination</th>
            <th>Departure DateTime</th>
            <th>Arrival DateTime</th>
        </tr>
        <?php


while ($row = $result->fetch_assoc()) {
    // Fetch origin destination name
    $originStmt = $conn->prepare("SELECT name FROM Destinations WHERE destination_id = ?");
    $originStmt->bind_param("i", $row['origin_destination_id']);
    $originStmt->execute();
    $originResult = $originStmt->get_result();
    $originName = $originResult->fetch_assoc()['name'];

    // Fetch destination destination name
    $destinationStmt = $conn->prepare("SELECT name FROM Destinations WHERE destination_id = ?");
    $destinationStmt->bind_param("i", $row['destination_destination_id']);
    $destinationStmt->execute();
    $destinationResult = $destinationStmt->get_result();
    $destinationName = $destinationResult->fetch_assoc()['name'];

    // Output table row
    echo "<tr>";
    echo "<td>" . $row['flight_code'] . "</td>";
    echo "<td>" . $originName . "</td>";
    echo "<td>" . $destinationName . "</td>";
    echo "<td>" . $row['departure_datetime'] . "</td>";
    echo "<td>" . $row['arrival_datetime'] . "</td>";
    echo "</tr>";
        }
        ?>
    </table>
</body>
</html>