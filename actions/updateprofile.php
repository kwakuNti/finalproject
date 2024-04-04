<?php
include '../config/connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection
    include '../config/core.php';
    include '../includes/Userfunctions.php';

    // Handle file upload
    $targetDir = "../uploads/";
    $fileName = basename($_FILES["profile_picture"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Check if the file is an image
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($fileType, $allowTypes)) {
        // Upload file to the server
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFilePath)) {
            // Update user profile picture in the database
            $user_id = $_SESSION['user_id'];
            
            // Update profile_picture column in Users table
            $updateUserQuery = "UPDATE Users SET profile_picture = '$targetFilePath' WHERE user_id = $user_id";
            mysqli_query($conn, $updateUserQuery);
            
            
            // Redirect back to settings page with success message
            header("Location: ../templates/settings.php?msg=Profile picture uploaded successfully.");
            exit();
        } else {
            // Redirect back to settings page with error message
            header("Location: ../templates/settings.php?msg=Sorry, there was an error uploading your file.");
            exit();
        }
    } else {
        // Redirect back to settings page with error message
        header("Location: ../templates/settings.php?msg=Sorry, only JPG, JPEG, PNG, GIF files are allowed.");
        exit();
    }
}

