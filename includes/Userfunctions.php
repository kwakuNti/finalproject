<?php

include '../config/connection.php';
function getUserFullName($userid)
{
    global $conn;

    $stmt = $conn->prepare("SELECT first_name, last_name FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fullName = $row["first_name"] . " " . $row["last_name"];
    } else {
        $fullName = "Unknown";
    }

    return $fullName;
}


function getUserCountry($userid)
{
    global $conn;

    $stmt = $conn->prepare("SELECT country FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $country = $row["country"];
    } else {
        $country = "Unknown";
    }

    return $country;
}

function hasProfilePicture($userId) {
    global $conn;
    
    // Prepare SQL query
    $sql = "SELECT profile_picture FROM Users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    
    // Bind parameters and execute query
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    
    // Get result and check if a profile picture exists
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return !empty($row['profile_picture']);
    } else {
        // Handle case where no result is found
        return false;
    }
}



function getUserEmail($user_id) {
    global $conn;

    $stmt = $conn->prepare("SELECT email FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row["email"];
    } else {
        $email = "Unknown";
    }

    return $email;
}


function getUserProfileImage($user_id) {
    global $conn;

    // Prepare and execute query to fetch user's profile image
    $stmt = $conn->prepare("SELECT profile_picture FROM Users WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->bind_result($img);
    $stmt->fetch();
    $stmt->close();

    return $img;
}

function getFlightsBookedCount($user_id) {
    global $conn;

    $sql = "SELECT COUNT(*) AS booked_count FROM Bookings WHERE user_id = ?";
    
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Handle error if statement preparation fails
        return false;
    } else {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        return $row['booked_count'];
    }
}

// Function to get the count of flights taken by the user
function getFlightsTakenCount($user_id) {
    global $conn;

    $sql = "SELECT COUNT(*) AS taken_count FROM Bookings b INNER JOIN Flights f ON b.flight_id = f.flight_id WHERE b.user_id = ? AND f.arrival_datetime < NOW()";
    
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Handle error if statement preparation fails
        return false;
    } else {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        return $row['taken_count'];
    }
}



function getUserFlightImages($user_id) {
    // Assuming you have a database connection
global $conn;
    // Initialize an empty array to store image URLs
    $images = array();

    $sql = "SELECT D.image_url
            FROM Flights F
            JOIN Destinations D ON F.destination_destination_id = D.destination_id
            JOIN Bookings B ON F.flight_id = B.flight_id
            WHERE B.user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Loop through the result set and add image URLs to the array
    while ($row = mysqli_fetch_assoc($result)) {
        $images[] = $row['image_url'];
    }



    // Return the array of image URLs
    return $images;
}


function displayTopTravelers($conn) {
    // Query to retrieve user travel data
    $sql = "SELECT u.first_name, u.last_name, u.profile_picture, COUNT(b.booking_id) AS total_trips
            FROM Users u
            LEFT JOIN Bookings b ON u.user_id = b.user_id
            GROUP BY u.user_id
            ORDER BY total_trips DESC
            LIMIT 4";
    $result = mysqli_query($conn, $sql);

    // Check if there are any results
    if (mysqli_num_rows($result) > 0) {
        // Loop through the results to display each user
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="travellers__card">';
            echo '<img src="' . $row['profile_picture'] . '" alt="traveller" />';
            echo '<div class="travellers__card__content">';
            echo '<img src="' . $row['profile_picture'] . '" alt="client" />';
            echo '<h4>' . $row['first_name'] . ' ' . $row['last_name'] . '</h4>';
            echo '<p>Total Trips: ' . $row['total_trips'] . '</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo 'No users found.';
    }

    // Free result set
    mysqli_free_result($result);
}



function getUserBirthday($userid)
{
    global $conn;

    $stmt = $conn->prepare("SELECT date_of_birth FROM Users WHERE user_id = ?");
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $birthday = $row["date_of_birth"];
    } else {
        $birthday = "Unknown";
    }

    return $birthday;
}

function getUserPhoneNumber($userid)
{
    global $conn;

    $stmt = $conn->prepare("SELECT mobile_number FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $phoneNumber = $row["mobile_number"];
    } else {
        $phoneNumber = "Unknown";
    }

    return $phoneNumber;
}


