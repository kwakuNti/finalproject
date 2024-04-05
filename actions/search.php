

<?php
include '../config/core.php';
include '../includes/flights.php';

// Initialize response array
$response = array('success' => false, 'flights' => array());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $bookingCode = isset($_POST['bookingCode']) ? $_POST['bookingCode'] : '';
    $departure = isset($_POST['departure']) ? $_POST['departure'] : '';
    $destination = isset($_POST['destination']) ? $_POST['destination'] : '';

    // Search for flights based on input
    if (!empty($bookingCode)) {
        $searchResults = findFlightByFlightCode($bookingCode);
    } else {
        $searchResults = findFlightsByLocations($departure, $destination);
    }

    // Check if any flights were found
    if (!empty($searchResults)) {
        // Update response
        $response['success'] = true;
        $response['flights'] = $searchResults;
    } else {
        // Update response for no flights found
        $response['message'] = 'No available flights for the selected criteria.';
    }
} else {
    // Update response for invalid request method
    $response['message'] = 'Invalid request method.';
}

// Output response as JSON
header('Content-Type: application/json');
echo json_encode($response);