<?php
include '../config/core.php';
include '../includes/Userfunctions.php';
checkLogin();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    // Retrieve user input
    $currentPassword = mysqli_real_escape_string($conn, $_POST['current_password']);
    $newPassword = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    
    // Get user ID
    $user_id = $_SESSION['user_id'];
    
    // Retrieve user information from the database
    $query = "SELECT * FROM Users WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify current password
        if (password_verify($currentPassword, $user['password'])) {
            // Check if new password and confirm password match
            if ($newPassword === $confirmPassword) {
                // Hash the new password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                
                // Update user's password in the database
                $updatePasswordQuery = "UPDATE Users SET password = '$hashedPassword' WHERE user_id = $user_id";
                mysqli_query($conn, $updatePasswordQuery);
                
                // Redirect back to settings page with success message
                header("Location: ../templates/settings.php?msg=Password changed successfully.");
                exit();
            } else {
                // Redirect back to settings page with error message
                header("Location: ../templates/settings.php?msg=New password and confirm password do not match.");
                exit();
            }
        } else {
            // Redirect back to settings page with error message
            header("Location: ../templates/settings.php?msg=Incorrect current password.");
            exit();
        }
    } else {
        // Handle the case where user is not found (optional)
        // Redirect back to settings page with error message
        header("Location: ../templates/settings.php?msg=User not found.");
        exit();
    }
}
