<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection file
include '../config/connection.php';
include '../config/core.php';

// Define variables and initialize with empty values
$first_name = $last_name = $email = $password = $dob = $mobile_number = $country = "";

// Function to sanitize input data
function sanitize_input($data)
{
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

// Process registration form if submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $first_name = sanitize_input($_POST["first_name"]);
    $last_name = sanitize_input($_POST["last_name"]);
    $email = sanitize_input($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $dob = sanitize_input($_POST["dob"]);
    $mobile_number = sanitize_input($_POST["mobile_number"]);
    $country = sanitize_input($_POST["country"]);
    $roleid = 2;

    $activation_hash = md5(uniqid(rand(), true));

    // Validate inputs
    if (empty($first_name) || empty($last_name) || empty($email) || empty($_POST["password"]) || empty($dob) || empty($mobile_number) || empty($country)) {
        // If any required field is empty, redirect with error message
        header("Location: ../templates/RegisterLogin.php?msg=All fields are required.");
        exit(); // Stop further execution of the script
    } else {
        // Check if email already exists
        $sql_check_email = "SELECT user_id FROM Users WHERE email=?";
        $stmt_check_email = mysqli_prepare($conn, $sql_check_email);
        mysqli_stmt_bind_param($stmt_check_email, "s", $email);
        mysqli_stmt_execute($stmt_check_email);
        mysqli_stmt_store_result($stmt_check_email);
        if (mysqli_stmt_num_rows($stmt_check_email) > 0) {
            // If email already exists, redirect with error message
            header("Location: ../templates/RegisterLogin.php?msg=Email already exists.");
            exit(); // Stop further execution of the script
        }
    }

    // Proceed with registration
    // Prepare SQL statement for insertion
    $sql_insert_user = "INSERT INTO Users (first_name, last_name, email, password, date_of_birth, mobile_number, country,role_id,account_activation_hash)
                        VALUES (?, ?, ?, ?, ?, ?, ?,?,?)";
    $stmt_insert_user = mysqli_prepare($conn, $sql_insert_user);
    mysqli_stmt_bind_param($stmt_insert_user, "sssssssis", $first_name, $last_name, $email, $password, $dob, $mobile_number, $country, $roleid, $activation_hash);
    if (mysqli_stmt_execute($stmt_insert_user)) {
        // Registration successful, redirect to dashboard with success message
        header("Location: ../templates/RegisterLogin.php?msg=Success");
        exit(); // Stop further execution of the script
    } else {
        // Registration failed, redirect to dashboard with error message
        header("Location: ../templates/RegisterLogin.php?msg=Registration failed. Please try again later.");
        exit(); // Stop further execution of the script
    }
}
