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


function getUserRole() {
    if (isset($_SESSION['role_id'])) {
        return $_SESSION['role_id'];
    } else {
        return null;
    }
}
function checkUserRole() {
    $role_id= getUserRole();
    // print_r($role_id);
    if ($role_id!=1) {
            header("Location: ../templates/dashboard.php");
        } else {
            header("Location: ../templates/admin.php");
        }
        exit();
    }

    function checkUserRolex($required_role) {
        $role_id = getUserRole();
        if ($role_id != $required_role) {
            header("Location: ../templates/dashboard.php");
        } else {
            header("Location: ../templates/admin.php");
        }
        exit();
    }