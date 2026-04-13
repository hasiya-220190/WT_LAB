<?php
$conn = mysqli_connect("localhost", "root", "", "register");

if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}
?>
