<?php
ob_start(); // Start output buffering



// Check if session is not already started
if(session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session
}

$timezone = date_default_timezone_set("Australia/Sydney");

$con = mysqli_connect("localhost", "root", "", "acs");

if(mysqli_connect_errno()){
    echo "Failed to connect: " . mysqli_connect_errno();
}

?>