<?php
// include db connection (global $conn available)
include 'db.php';

// -----------------------------------------------
// DATATYPES DEMO
// -----------------------------------------------
// string datatype
$username = "";
$email = "";
$password = "";

// boolean datatype
$success = false;

// integer datatype (will be set after insert)
$user_id = 0;

// -----------------------------------------------
// STATIC VARIABLE — counts registrations per request
// -----------------------------------------------
function countRegistrations()
{
    static $count = 0;  // static — retains value across calls
    $count++;
    return $count;
}

// -----------------------------------------------
// REGISTRATION FUNCTION — local variables inside
// -----------------------------------------------
function registerUser($conn, $uname, $mail, $pass)
{
    // local variables (scope: only inside this function)
    $hashed = password_hash($pass, PASSWORD_DEFAULT);  // string
    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);

    // die() stops execution if prepare fails
    if (!$stmt) {
        die("Query preparation failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "sss", $uname, $mail, $hashed);

    $result = mysqli_stmt_execute($stmt);  // boolean
    return $result;
}

// -----------------------------------------------
// MAIN LOGIC — runs when form is submitted
// -----------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // receive data using $_POST
    $username = $_POST['username'];  // string
    $email = $_POST['email'];     // string
    $password = $_POST['password'];  // string

    // call registration function
    $success = registerUser($conn, $username, $email, $password);

    // count registrations using static variable
    $regCount = countRegistrations();

    if ($success) {
        // echo — success message
        echo "<h2 style='color:green; font-family:sans-serif; text-align:center; margin-top:3rem;'>
                Registration Successful!
              </h2>";
        echo "<p style='text-align:center; font-family:sans-serif; color:#555;'>
                Welcome, <strong>" . htmlspecialchars($username) . "</strong>!
                Registration count this session: <strong>$regCount</strong>
              </p>";
        echo "<p style='text-align:center; margin-top:1rem;'>
                <a href='login.html' style='color:#6c63ff; font-family:sans-serif;'>Go to Login</a>
              </p>";

        // print — alternate output
        print "<br>";

        // integer datatype — get last inserted id
        $user_id = mysqli_insert_id($conn);
        echo "<p style='text-align:center; font-family:sans-serif; color:#aaa; font-size:0.8rem;'>
                User ID assigned: $user_id
              </p>";
    } else {
        // echo error
        echo "<h2 style='color:red; font-family:sans-serif; text-align:center; margin-top:3rem;'>
                Registration Failed!
              </h2>";
        echo "<p style='text-align:center;'>
                <a href='register.html' style='color:#6c63ff; font-family:sans-serif;'>Try Again</a>
              </p>";
    }

} else {
    // if someone opens register.php directly without form
    header("Location: register.html");
    exit();
}
?>