<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include '../config/core.php';
include '../config/connection.php';
include '../includes/Userfunctions.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if the user's email is verified before allowing flight booking
    if (!isEmailVerified($_SESSION['email'])) {
        // If the email is not verified, redirect to the settings page with a message
        header("Location: ../templates/settings.php?msg=Please verify your email before booking a flight.");
        exit();
    }

    $origin = $_POST['fromDestination'];
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

            // Get user's name from the database
            $stmt_user = $conn->prepare("SELECT first_name FROM Users WHERE user_id = ?");
            $stmt_user->bind_param("i", $user_id);
            $stmt_user->execute();
            $result_user = $stmt_user->get_result();

            if ($result_user->num_rows > 0) {
                $user = $result_user->fetch_assoc();
                $user_name = $user['first_name'];


                // Insert booking details into the Bookings table
                // Insert booking details into the Bookings table
                $sql_insert_booking = "INSERT INTO Bookings (user_id, flight_id, booking_date, class, passengers, total_amount) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_insert_booking = $conn->prepare($sql_insert_booking);
                $stmt_insert_booking->bind_param("iissid", $user_id, $flight_id, $booking_date, $class, $passengers, $total_amount);
                $stmt_insert_booking->execute();
                $booking_id = $stmt_insert_booking->insert_id; // Retrieve the booking ID

                // Insert booking details into the Schedules table
                $sql_insert_schedule = "INSERT INTO Schedules (user_id, booking_id) VALUES (?, ?)";
                $stmt_insert_schedule = $conn->prepare($sql_insert_schedule);
                $stmt_insert_schedule->bind_param("ii", $user_id, $booking_id);
                $stmt_insert_schedule->execute();


                // Send congratulatory email to the user
                try {
                    // Load Composer's autoloader
                    require '../vendor/autoload.php';

                    // Create a new PHPMailer instance
                    $mail = new PHPMailer(true);

                    // Server settings
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host = 'smtp.gmail.com';                      // Specify main and backup SMTP servers
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'cliffco24@gmail.com';                     //SMTP username
                    $mail->Password   = 'zsve myrn ajao xhuw';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
                    $mail->Port = 587;                                   // TCP port to connect to


                    // Recipients
                    $mail->setFrom('cliffco24@gmail.com', 'CliffCo');
                    $mail->addAddress($_SESSION['email']); // User's email address
                    $mail->addReplyTo('info@example.com', 'Information');
                    $mail->addCC('cc@example.com');
                    $mail->addBCC('bcc@example.com');

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Congratulations on your flight booking!';
                    $mail->Body = 'Dear ' . $user_name . ',<br><br>';
                    $mail->Body .= 'Congratulations! You have successfully booked a flight with us. Here are your booking details:<br>';
                    // Add more details like flight information, etc., as needed.
                    $mail->Body .= '<br>Thank you for choosing our services.<br>';
                    $mail->Body .= 'Best regards,<br>CliffCo';

                    // Send the email
                    $mail->send();
                    // Redirect to the flight page with a success message
                    header("Location: ../templates/flight.php?msg=Booking successful. Congratulations email sent.");
                    exit();
                } catch (Exception $e) {
                    // If the email fails to send, log the error and redirect with a success message
                    error_log("Email sending failed: " . $mail->ErrorInfo);
                    header("Location: ../templates/flight.php?msg=Booking successful. Failed to send congratulations email.");
                    exit();
                }
            } else {
                // If user's name is not found, redirect with an error message
                header("Location: ../templates/flight.php?msg=User's name not found.");
                exit();
            }
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
