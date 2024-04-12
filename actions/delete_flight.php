<?php
include '../config/core.php';
include '../config/connection.php';

// Check if the request method is GET and if the flight ID is set
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['flight_id'])) {
    // Sanitize the input (optional but recommended)
    $flightId = intval($_GET['flight_id']);

    // Prepare the SQL statement to delete the flight
    $sql = "DELETE FROM Flights WHERE flight_id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        // Return an error response if the statement preparation fails
        http_response_code(500);
        echo json_encode(array('error' => 'Failed to prepare statement'));
        exit();
    }

    // Bind the flight ID parameter
    $stmt->bind_param("i", $flightId);

    // Execute the statement
    if ($stmt->execute()) {
        // Return a success response if the deletion was successful
        echo json_encode(array('success' => true));
    } else {
        // Return an error response if the deletion fails
        http_response_code(500);
        echo json_encode(array('error' => 'Failed to delete the flight'));
    }

    // Close the statement
    $stmt->close();
} else {
    // Return an error response for invalid requests
    http_response_code(400);
    echo json_encode(array('error' => 'Invalid request'));
}