<?php
// Include the file with the database connection
require_once 'db_connection.php';

// Get the selected destination and class from the form
$selected_destination_id = $_POST['to'];
$selected_class = $_POST['class'];

// Prepare the SQL query to retrieve the price
$query = "SELECT base_price
          FROM Prices
          WHERE destination_id = $selected_destination_id
          AND class = '$selected_class'
          AND season = 'High'";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Fetch the result row
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $price = $row['base_price'];
        // Calculate tax (assuming a tax rate of 10%)
        $tax = $price * 0.1;
        // Calculate total price
        $total_price = $price + $tax;

        // Prepare HTML response
        $html = '<h2>Quote Results</h2>';
        $html .= '<div class="trip-detail-container">';
        $html .= '<div id="oneWayTripDetails" style="display: block;">';
        $html .= '<h3 class="trip-detail-title">One-Way</h3>';
        $html .= '<table>';
        $html .= '<tr><td>From</td><td>' . $_POST['from'] . '</td></tr>';
        $html .= '<tr><td>To</td><td>' . $_POST['to'] . '</td></tr>';
        $html .= '<tr><td>Stops</td><td>' . $_POST['stops'] . '</td></tr>';
        $html .= '<tr><td>Departure</td><td>' . $_POST['departure'] . '</td></tr>';
        $html .= '<tr><td>Arrival</td><td>' . $_POST['arrival'] . '</td></tr>';
        $html .= '</table></div>';

        $html .= '<div class="price-container">';
        $html .= '<h3 class="trip-detail-title">Price</h3>';
        $html .= '<table>';
        $html .= '<tr><td>Base Price</td><td>$' . number_format($price, 2) . '</td></tr>';
        $html .= '<tr><td>Tax</td><td>$' . number_format($tax, 2) . '</td></tr>';
        $html .= '<tr><td>Total Price</td><td>$' . number_format($total_price, 2) . '</td></tr>';
        $html .= '</table></div></div>';

        // Send the response as JSON
        echo json_encode(['html' => $html]);
    } else {
        // Handle the case when no price is found (e.g., display an error message)
        echo json_encode(['html' => 'No price found for the selected destination and class.']);
    }
} else {
    // Handle the case when the query fails (e.g., display an error message)
    echo json_encode(['html' => 'Error: ' . mysqli_error($conn)]);
}

// Close the database connection
mysqli_close($conn);
?>
