<?php
include '../config/core.php';
include '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the POST parameters
    $toDestination = $_POST['to'];
    $selectedClass = $_POST['class'];

    // Fetch destination names
    $query = "SELECT destination_id, name FROM Destinations WHERE destination_id IN (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i",  $toDestination);
    $stmt->execute();
    $result = $stmt->get_result();

    $destinationNames = array();
    while ($row = $result->fetch_assoc()) {
        $destinationNames[$row['destination_id']] = $row['name'];
    }

    // Ensure both destinations are found
    if (!isset($destinationNames[$toDestination])) {
        http_response_code(404);
        echo json_encode(["message" => "One or both destinations not found."]);
        exit;
    }

    // Fetch prices based on "to" destination ID and class
    $query = "SELECT base_price FROM Prices WHERE destination_id = ? AND class = ? AND season = 'High'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $toDestination, $selectedClass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $base_price = $row['base_price'];
        $tax = $base_price * 0.1;
        $total_price = $base_price + $tax;

        // Construct response
        $response = [
            'to_destination_name' => $destinationNames[$toDestination],
            'base_price' => $base_price,
            'tax' => $tax,
            'total_price' => $total_price,
        ];

        // Send response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // If prices not found for the selected class and "to" destination, send error response
        http_response_code(404);
        echo json_encode(["message" => "Prices not found for the selected class and destination."]);
    }
} else {
    // If the request method is not POST, send an error response
    http_response_code(400);
    echo json_encode(["message" => "Invalid request method."]);
}
