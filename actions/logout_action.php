<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page or any other desired page
header("Location: ../templates/RegisterLogin.php");
exit();
