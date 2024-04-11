<?php
// Include necessary files
include '../config/connection.php';
include '../config/core.php';

// Check if the activation hash is provided in the URL
if (!isset($_GET['hash'])) {
    echo "Activation hash is missing.";
    exit;
}

$activationHash = $_GET['hash'];

// Update the activation hash to null in the database
$stmt = $conn->prepare("UPDATE Users SET account_activation_hash = NULL WHERE account_activation_hash = ?");
$stmt->bind_param("s", $activationHash);
$stmt->execute();

// Check if any rows were affected
if ($stmt->affected_rows === 0) {
    echo "Invalid activation hash or account is already activated.";
    exit;
}

// Redirect the user to the settings page with a success message
header("Location: ../templates/settings.php?msg=Successfully Verified");
exit;
?>
