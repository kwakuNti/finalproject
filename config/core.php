<?php

//starting a sessionn
session_start();

// a function to check if the user is logged into the website
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../templates/RegisterLogin.php");
        exit();
    }
}

function checkUserRole() {
    // Check if the role_id session variable is set
    if (isset($_SESSION['role_id'])) {
        $role_id = $_SESSION['role_id'];
        if ($role_id == 1) {
            // Redirect to admin.php for users with role_id = 1 (Admin)
            header("Location: ../templates/admin.php");
            exit(); // Ensure that script execution stops after redirection
        }
    }
}
