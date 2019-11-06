<?php
ob_start(); //Turn on output buffering
session_start();

$timezone = date_default_timezone_set('Asia/Kolkata');

$con = mysqli_connect('DB_HOST', 'DB_USERNAME', 'DB_PASS', 'DB_NAME');
if(mysqli_connect_errno()) {
    echo "Failed to connect with the database<br>";
}
?>