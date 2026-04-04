<?php
// global variables for database connection
$host = "localhost";
$dbname = "userdb";
$username = "root";
$password = "";  // xampp default is empty

// global keyword usage
$conn = mysqli_connect($host, $username, $password, $dbname);

// die() stops execution if connection fails
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>