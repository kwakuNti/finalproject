<?php
include '../config/connection.php';

function getPrices($destination, $class, $season) {
    global $conn;
    $query = "SELECT p.base_price
              FROM Destinations d
              JOIN Prices p ON d.destination_id = p.destination_id
              WHERE d.name = '$destination' AND p.class = '$class' AND p.season = '$season'";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $price = $row['base_price'];
        $response = array('price' => $price);
    } else {
        $response = array('message' => 'Price not available');
    }
    
    return json_encode($response);
}

// Get parameters from AJAX request
$destination = $_GET['destination'];
$class = $_GET['class'];
$season = $_GET['season'];

// Call getPrices function and echo JSON response
echo getPrices($destination, $class, $season);

