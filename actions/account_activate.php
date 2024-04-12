<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include '../config/core.php';
require '../vendor/autoload.php';
include '../config/connection.php';
$user_id = $_SESSION['user_id'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Prepare and execute the query to retrieve the activation hash for the logged-in user
$stmt = $conn->prepare("SELECT first_name, account_activation_hash FROM Users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if the user exists
if (!$user) {
    header('Location: ../templates/settings.php?Activation hash not found for the user.');
    exit;
}

// Get the activation hash
$activationHash = $user['account_activation_hash'];
$user_name = $user['first_name'];
// Construct the verification link
$verificationLink = "http://4.231.236.2/finalproject/actions/verify.php?hash=$activationHash";

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'cliffco24@gmail.com';
    $mail->Password = 'zsve myrn ajao xhuw';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    //Recipients
    $mail->setFrom('cliffco24@gmail.com', 'CliffCo');
    $mail->addAddress($_SESSION['email']);
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Activate Your Account';
    $mail->Body = 'Dear ' . $user_name . ',<br><br>';
    $mail->Body .= 'Please click the following link to activate your account:<br><a href="' . $verificationLink . '">Activate Account</a><br><br>Thank you,<br>CliffCo';


    // Send the email
    $mail->send();
    header("Location: ../templates/settings.php?msg=Verification email has been sent to your email address.");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
