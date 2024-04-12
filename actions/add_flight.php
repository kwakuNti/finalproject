<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/core.php';
include '../config/connection.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $flightCode = $_POST['flightCode'];
    $originDestination = $_POST['originDestination'];
    $destinationDestination = $_POST['destinationDestination'];
    $duration = $_POST['duration'];
    $stops = $_POST['stops'];
    $economySeats = $_POST['economySeats'];
    $businessSeats = $_POST['businessSeats'];
    $firstSeats = $_POST['firstSeats'];
    $departureDatetime = $_POST['departureDatetime'];
    $arrivalDatetime = $_POST['arrivalDatetime'];

    // Validate form data (you can add more validation rules)
    if (empty($flightCode) || empty($originDestination) || empty($destinationDestination) || empty($duration) || empty($stops) || empty($economySeats) || empty($businessSeats) || empty($firstSeats) || empty($departureDatetime) || empty($arrivalDatetime)) {
        // Handle empty fields error
        header("Location: ../templates/admin.php?msg=All fields are required.");
        exit();
    } else {
        // Insert the flight details into the database
        $conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);

        // Check connection
        if (!$conn) {
            header("Location: ../templates/admin.php?msg=Connection failed: " . mysqli_connect_error());
            exit();
        }

        // Prepare the SQL statement
        $sql = "INSERT INTO Flights (flight_code, origin_destination_id, destination_destination_id, duration, stops, economy_seats, business_seats, first_seats, departure_datetime, arrival_datetime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Create a prepared statement
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            // Bind parameters to the prepared statement
            mysqli_stmt_bind_param($stmt, "siiiiiiiss", $flightCode, $originDestination, $destinationDestination, $duration, $stops, $economySeats, $businessSeats, $firstSeats, $departureDatetime, $arrivalDatetime);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Flight added successfully
                header("Location: ../templates/admin.php?msg=Flight added successfully.");
                exit();
            } else {
                // Error executing the statement
                header("Location: ../templates/admin.php?msg=Error: " . mysqli_error($conn));
                exit();
            }
        }
    }
}
