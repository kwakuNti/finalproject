<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config/core.php';
include '../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $origin = $_POST['toDestination'];
    $destination = $_POST['toDestination'];
    $departureDate = $_POST['departureDate'];
    $passengers = $_POST['passengers'];
    $class = $_POST['classSelection'];

    if (empty($origin) || empty($destination) || empty($departureDate) || empty($passengers) || empty($class)) {
        header("Location: ../templates/flight.php?msg=Please fill out all fields for one-way booking unsuccessful");
        exit();
    }

    // Check for available flights between the selected origin and destination
    $stmt_flights = $conn->prepare("SELECT * FROM Flights WHERE origin_destination_id = ? AND destination_destination_id = ?");
    $stmt_flights->bind_param("ii", $origin, $destination);
    $stmt_flights->execute();
    $result_flights = $stmt_flights->get_result();

    if ($result_flights->num_rows > 0) {
        // Fetch the base price for the selected destination, class, and season
        $stmt_prices = $conn->prepare("SELECT base_price FROM Prices WHERE destination_id = ? AND class = ? AND season = 'High'");
        $stmt_prices->bind_param("is", $destination, $class);
        $stmt_prices->execute();
        $result_prices = $stmt_prices->get_result();

        if ($result_prices->num_rows > 0) {
            $row_price = $result_prices->fetch_assoc();
            $base_price = $row_price['base_price'];

            // Calculate tax and total amount
            $tax = $base_price * 0.1;
            $total_amount = $base_price + $tax;

            // Fetch flight details
            $flight = $result_flights->fetch_assoc();
            $flight_id = $flight['flight_id'];

            // Get user ID and booking date
            $user_id = $_SESSION['user_id'];
            $booking_date = date("Y-m-d");

            // Insert booking details into the Bookings table
            $sql_insert = "INSERT INTO Bookings (user_id, flight_id, booking_date, class, passengers, total_amount) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("iissid", $user_id, $flight_id, $booking_date, $class, $passengers, $total_amount);
            $stmt_insert->execute();

            // Redirect to the flight page with a success message
            header("Location: ../templates/flight.php?msg=Booking successful");
            exit();
        } else {
            // If the base price is not found for the selected destination, class, and season, redirect with an error message
            header("Location: ../templates/flight.php?msg=Base price not found for the selected destination, class, and season");
            exit();
        }
    } else {
        // If no flights are available between the selected origin and destination, redirect with an error message
        header("Location: ../templates/flight.php?msg=No flight available for the selected route");
        exit();
    }
} else {
    // If the form is not submitted via POST method, redirect with an error message
    header("Location: ../templates/flight.php?msg=Form not submitted");
    exit();
}
