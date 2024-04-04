<?php
include '../config/connection.php';


function getAllFlights() {
    global $conn;
    $query = "SELECT f.flight_id, f.flight_code, od.name AS origin, dd.name AS destination, f.departure_datetime, f.arrival_datetime, f.duration, f.stops, f.economy_seats, f.business_seats, f.first_seats
              FROM Flights f
              INNER JOIN Destinations od ON f.origin_destination_id = od.destination_id
              INNER JOIN Destinations dd ON f.destination_destination_id = dd.destination_id";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Function to show all users with their name, email, country, and mobile number
function getAllUsers() {
    global $conn;
    $query = "SELECT u.first_name, u.last_name, u.email, u.country, u.mobile_number, r.role_name
              FROM Users u
              INNER JOIN Roles r ON u.role_id = r.role_id";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Function to show all destinations with their names and descriptions
function getAllDestinationsWithPrices() {
    global $conn;
    $query = "SELECT d.name AS destination_name,
                     p.class,
                     p.season,
                     p.base_price
              FROM Destinations d
              JOIN Prices p ON d.destination_id = p.destination_id";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Function to show destinations with their corresponding prices with the seasons or whatever the prices depend on
function getAllDestinations() {
    global $conn;
    $query = "SELECT DISTINCT name FROM Destinations";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Function to get prices based on destination, class, and season
