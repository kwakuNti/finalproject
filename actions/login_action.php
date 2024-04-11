<?php
session_start(); // Start a session to store user data
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config/connection.php';
// Function to sanitize input
function sanitize_input($input) {
    // Remove leading and trailing whitespace
    $input = trim($input);
    // Remove backslashes
    $input = stripslashes($input);
    // Convert special characters to HTML entities
    $input = htmlspecialchars($input);
    return $input;
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize them
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);
    // Validate email
    if (empty($email)) {
        // Email is empty
        header("Location: ../templates/RegisterLogin.php?msg=Please enter your email");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Invalid email format
        header("Location: ../templates/RegisterLogin.php?msg=Invalid email format");
        exit();
    }
    // Sanitize inputs (prevent SQL injection)
    $email = mysqli_real_escape_string($conn, $email);
    // Query to fetch user from the database
    $sql = "SELECT * FROM Users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // Check if a user with the provided email exists
        if (mysqli_num_rows($result) == 1) {
            // Fetch user data
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password'];
            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Password is correct, set session variables
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role_id'] = $row['role_id'];
                // Redirect to dashboard or any other page
                header("Location: ../templates/dashboard.php");
                exit();
            } else {
                // Invalid password
                header("Location: ../templates/RegisterLogin.php?msg=Invalid password");
                exit();
            }
        } else {
            // User with the provided email does not exist
            header("Location: ../templates/RegisterLogin.php?msg=User not found");
            exit();
        }
    } else {
        // Query execution failed
        header("Location: ../templates/RegisterLogin.php?msg=Something went wrong. Please try again later.");
        exit();
    }
}
