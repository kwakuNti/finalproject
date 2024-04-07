<?php
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

    $stmt = $conn->prepare("SELECT * FROM Flights WHERE origin_destination_id = ? AND destination_destination_id = ?");
    $stmt->bind_param("ii", $origin, $destination);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $flight = $result->fetch_assoc();
        $flight_id = $flight['flight_id'];

        $user_id = $_SESSION['user_id'];
        $booking_date = date("Y-m-d");

        $sql_insert = "INSERT INTO Bookings (user_id, flight_id, booking_date, class, passengers) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iissi", $user_id, $flight_id, $booking_date, $class, $passengers);
        $stmt_insert->execute();

        header("Location: ../templates/flight.php?msg=Booking successful");
        exit();
    } else {
        header("Location: ../templates/flight.php?msg=No flight available for the selected route");
        exit();
    }
} else {
    header("Location: ../templates/flight.php?msg=Form not submitted");
    exit();
}

