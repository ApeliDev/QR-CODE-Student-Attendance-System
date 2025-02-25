<?php
// Start the session
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's name
$username = $_SESSION['admin_username'];
?>
