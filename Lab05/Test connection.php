<?php
// global variables
$host = "localhost";
$dbname = "userdb";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    // die() stops execution on failure
    die("Connection Failed: " . mysqli_connect_error());
}

// echo for success message
echo "Database Connected Successfully!";
echo "<br>Host: " . $host;
echo "<br>Database: " . $dbname;
?>