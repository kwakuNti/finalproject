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
    $sql = "SELECT profile_picture FROM Users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return !empty($row['profile_picture']);
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

