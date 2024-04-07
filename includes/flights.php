<?php
// Include the database connection
include '../config/connection.php';

// Function to find a flight by flight code
function findFlightByFlightCode($flightCode) {
    // Initialize an empty array to store the search results
    $searchResults = array();

    // Access the global connection variable
    global $conn;

    // Prepare the SQL statement to select specific fields from the Flights table
    $sql = "SELECT Flights.flight_code,
                   Origins.name AS origin_destination_name,
                   Destinations.name AS destination_destination_name,
                   Flights.departure_datetime,
                   Flights.arrival_datetime
            FROM Flights
            INNER JOIN Destinations AS Origins
            ON Flights.origin_destination_id = Origins.destination_id
            INNER JOIN Destinations
            ON Flights.destination_destination_id = Destinations.destination_id
            WHERE Flights.flight_code = ?";

    // Bind the flight code parameter
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $flightCode);

    // Execute the SQL statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch rows and add them to the search results array
        while ($row = $result->fetch_assoc()) {
            $searchResults[] = $row;
        }
    }

    // Return the search results
    return $searchResults;
}


// // Function to find flights by departure and destination locations
// function findFlightsByLocations($departure, $destination) {
//     // Initialize an empty array to store the search results
//     $searchResults = array();

//     // Access the global connection variable
//     global $conn;

//     // Prepare the SQL statement to select flights with the provided departure and destination locations
//     $sql = "SELECT * FROM Flights WHERE origin_destination_id = ? AND destination_destination_id = ?";

//     // Bind the departure and destination parameters
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("ii", $departure, $destination);

//     // Execute the SQL statement
//     $stmt->execute();

//     // Get the result set
//     $result = $stmt->get_result();

//     // Check if any rows were returned
//     if ($result->num_rows > 0) {
//         // Fetch rows and add them to the search results array
//         while ($row = $result->fetch_assoc()) {
//             $searchResults[] = $row;
//         }
//     }

//     // Return the search results
//     return $searchResults;
// }

function findFlightsByLocations($departure, $destination) {
    // Initialize an empty array to store the search results
    $searchResults = array();

    // Access the global connection variable
    global $conn;

    // Prepare the SQL statement to select specific fields from the Flights table
    $sql = "SELECT Flights.flight_code,
                   Origins.name AS origin_destination_name,
                   Destinations.name AS destination_destination_name,
                   Flights.departure_datetime,
                   Flights.arrival_datetime
            FROM Flights
            INNER JOIN Destinations AS Origins
            ON Flights.origin_destination_id = Origins.destination_id
            INNER JOIN Destinations
            ON Flights.destination_destination_id = Destinations.destination_id
            WHERE origin_destination_id = ? AND destination_destination_id = ?";

    // Bind the departure and destination parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $departure, $destination);

    // Execute the SQL statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch rows and add them to the search results array
        while ($row = $result->fetch_assoc()) {
            $searchResults[] = $row;
        }
    }

    // Return the search results
    return $searchResults;
}




