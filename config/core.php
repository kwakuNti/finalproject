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