<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "register");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name     = $_POST['name'];
    $mobile   = $_POST['mobile'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];
    $dob      = $_POST['dob'];
    $gender   = $_POST['gender'];
    $country  = $_POST['country'];

    if ($password !== $confirm) {
        die("❌ Passwords do not match");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO registration 
            (name, mobile, email, password, dob, gender, country)
            VALUES 
            ('$name', '$mobile', '$email', '$hashedPassword', '$dob', '$gender', '$country')";

    if ($conn->query($sql)) {
        echo "✅ Registration successful";
    } else {
        echo "❌ Error: " . $conn->error;
    }
}

$conn->close();
?>
