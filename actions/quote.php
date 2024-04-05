<?php
// Assuming you have functions to calculate prices based on these parameters
include '../config/connection.php';

$from = $_POST['from'];
$to = $_POST['to'];
$passengers = $_POST['passengers'];
$class = $_POST['class'];

// Calculate price, tax, and total price based on business logic
$basePrice = calculateBasePrice($from, $to, $passengers, $class);
$tax = calculateTax($basePrice);
$totalPrice = $basePrice + $tax;

// Prepare response data
$response = [
    'from' => $from,
    'to' => $to,
    'passengers' => $passengers,
    'class' => $class,
    'basePrice' => $basePrice,
    'tax' => $tax,
    'totalPrice' => $totalPrice
];

// Return response as JSON
echo json_encode($response);
?>
