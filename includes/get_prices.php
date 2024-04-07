<?php
include '../config/core.php';
include '../config/connection.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required POST parameters are set
    if (isset($_POST['toDestination']) && isset($_POST['class'])) {
        global $conn;
        $tDestination = $_POST['toDestination'];
        $selectedClass = $_POST['class'];

        // Fetch prices based on destination ID, class, and season
// Fetch destination names
$query = "SELECT destination_id, destination_name FROM Destinations WHERE destination_id IN (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $fromDestination, $toDestination);
$stmt->execute();
$result = $stmt->get_result();

$destinationNames = array();
while ($row = $result->fetch_assoc()) {
    $destinationNames[$row['destination_id']] = $row['destination_name'];
}

// Fetch prices based on destination ID, class, and season
$query = "SELECT Prices.*, Destinations.destination_name FROM Prices INNER JOIN Destinations ON Prices.destination_id = Destinations.destination_id WHERE Prices.destination_id = ? AND Prices.class = ? AND Prices.season = 'High'";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $toDestination, $selectedClass);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Calculate total price
    $total_price = 0;
    while ($row = $result->fetch_assoc()) {
        $total_price += $row['base_price'];
    }

    // Assume tax is 10% of total price
    $tax = $total_price * 0.1;

    // Construct response
    $response = array(
        'base_price' => $total_price,
        'tax' => $tax,
        'total_price' => $total_price + $tax,
        'from_destination_name' => $destinationNames[$fromDestination], // Add from destination name to the response
        'to_destination_name' => $destinationNames[$toDestination] // Add to destination name to the response
);

    // Send response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If prices not found for the selected class and destination, send error response
    http_response_code(404);
    echo json_encode(array("message" => "Prices not found for the selected class and destination."));
}

    } else {
        // If required parameters are not set, send error response
        http_response_code(400);
        echo json_encode(array("message" => "Missing required parameters."));
    }
} else {
    // If request method is not POST, send error response
    http_response_code(405);
    echo json_encode(array("message" => "Method Not Allowed."));
}
