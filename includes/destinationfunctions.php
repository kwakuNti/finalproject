<?php

include '../config/connection.php';

function displayDestinations() {
    global $conn;

    // SQL query to select destination name, country, and image URL
    $sql = "SELECT name, country, image_url FROM Destinations";

    // Execute the query
    $result = $conn->query($sql);

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Loop through each row of the result set
        while ($row = $result->fetch_assoc()) {
            // Extract destination name, country, and image URL
            $destinationName = $row["name"];
            $country = $row["country"];
            $imageUrl = $row["image_url"];

            // Output HTML for country card
            echo '<div class="country__card">';
            echo '<img src="' . $imageUrl . '" alt="country" />';
            echo '<div class="country__name">';
            echo '<i class="ri-map-pin-2-fill"></i>';
            echo '<span>' . $destinationName . ', ' . $country . '</span>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        // If no rows were returned, display a message
        echo "No destinations found";
    }
}

// Function to generate dropdown options for destinations
function generateDestinationOptions($conn, $selectName, $defaultText)
{
    // Fetch destinations from the database
    $sql = "SELECT destination_id, name FROM Destinations";
    $result = mysqli_query($conn, $sql);

    // Check if query was successful
    if ($result) {
        // Initialize an empty string to store the options
        $options = '<div class="select">
                        <div class="selectBtn" data-type="firstOption"><i class="fas fa-map-marker-alt"></i>' . $defaultText . '</div>
                        <div class="selectDropdown">';
        // Loop through each row in the result set
        while ($row = mysqli_fetch_assoc($result)) {
            // Append an option tag for each destination
            $options .= '<div class="option" data-type="' . $row['destination_id'] . '"><i class="fas fa-map-marker-alt"></i>' . $row['name'] . '</div>';
        }
        // Close the selectDropdown div and return the generated options
        $options .= '</div></div>';
        return $options;
    } else {
        // Return an empty string if query fails
        return '';
    }
}

function getDestinations() {
    global $conn; // Assuming $conn is your MySQLi database connection

    try {
        // Prepare the SQL query to select destinations
        $query = "SELECT name FROM Destinations";
        $result = $conn->query($query);

        // Check if the query was successful
        if ($result) {
            // Fetch all rows as an associative array
            $destinations = array();
            while ($row = $result->fetch_assoc()) {
                $destinations[] = $row['name'];
            }
            return $destinations;
        } else {
            // If the query failed, return an empty array
            return array();
        }
    } catch (Exception $e) {
        // Handle any errors that occur during the database operation
        // For simplicity, you can just log the error and return an empty array
        error_log("Error fetching destinations: " . $e->getMessage());
        return array();
    }
}
