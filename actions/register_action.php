<?php
// Include database connection file
include '../config/connection.php';
include '../config/core.php';
// Define variables and initialize with empty values
$first_name = $last_name = $email = $password = $dob = $mobile_number = $country = "";
$errors = array();
// Function to sanitize input data
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}
// Function to display errors in toast div
function display_error($message) {
    echo '<script>
            document.querySelector(".toast .message .text-1").textContent = "'.$message.'";
            document.querySelector(".toast").classList.add("show");
          </script>';
}
// Process registration form if submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $first_name = sanitize_input($_POST["first_name"]);
    $last_name = sanitize_input($_POST["last_name"]);
    $email = sanitize_input($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash password
    $dob = sanitize_input($_POST["dob"]);
    $mobile_number = sanitize_input($_POST["mobile_number"]);
    $country = sanitize_input($_POST["country"]);
    $roleid = 2;
    // Validate inputs
    if (empty($first_name) || empty($last_name) || empty($email) || empty($_POST["password"]) || empty($dob) || empty($mobile_number) || empty($country)) {
        $errors[] = "All fields are required.";
    } else {
        // Check if email already exists
        $sql_check_email = "SELECT user_id FROM Users WHERE email=?";
        $stmt_check_email = mysqli_prepare($conn, $sql_check_email);
        mysqli_stmt_bind_param($stmt_check_email, "s", $email);
        mysqli_stmt_execute($stmt_check_email);
        mysqli_stmt_store_result($stmt_check_email);
        if (mysqli_stmt_num_rows($stmt_check_email) > 0) {
            $errors[] = "Email already exists.";
        }
    }
    // If no errors, proceed with registration
    if (empty($errors)) {
        // Prepare SQL statement for insertion
        $sql_insert_user = "INSERT INTO Users (first_name, last_name, email, password, date_of_birth, mobile_number, country,role_id)
                            VALUES (?, ?, ?, ?, ?, ?, ?,?)";
        $stmt_insert_user = mysqli_prepare($conn, $sql_insert_user);
        mysqli_stmt_bind_param($stmt_insert_user, "sssssssi", $first_name, $last_name, $email, $password, $dob, $mobile_number, $country,$roleid);
        if (mysqli_stmt_execute($stmt_insert_user)) {
            // Registration successful, redirect to dashboard
            header("Location: ../templates/RegisterLogin.php");
            exit(); // Stop further execution of the script
        } else {
            $errors[] = "Registration failed. Please try again later.";
        }
    }
    // Display errors
    if (!empty($errors)) {
        display_error($errors[0]); // Display error in toast div
    }
}
