<?php
// include db connection
include 'db.php';

// -----------------------------------------------
// LOGIN VALIDATION FUNCTION — local variables
// -----------------------------------------------
function validateLogin($conn, $mail, $pass)
{
    // local variables (only inside this function)
    $query = "SELECT * FROM users WHERE email = ?";

    $stmt = mysqli_prepare($conn, $query);

    // die() stops if query fails
    if (!$stmt) {
        die("Query failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $mail);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);  // array datatype

    if ($user) {
        // boolean — check password
        $isValid = password_verify($pass, $user['password']);
        return $isValid ? $user : false;
    }

    return false;
}

// -----------------------------------------------
// MAIN LOGIC
// -----------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // local variables
    $email = $_POST['email'];     // string
    $password = $_POST['password'];  // string

    // boolean result
    $user = validateLogin($conn, $email, $password);

    if ($user) {
        // print — login success
        print "<h2 style='color:green; font-family:sans-serif; text-align:center; margin-top:3rem;'>
                 Login Successful!
               </h2>";

        // echo — show user details
        echo "<p style='text-align:center; font-family:sans-serif; color:#555; margin-top:0.5rem;'>
                Welcome back, <strong>" . htmlspecialchars($user['username']) . "</strong>!
              </p>";
        echo "<p style='text-align:center; font-family:sans-serif; color:#aaa; font-size:0.8rem;'>
                Logged in as: " . htmlspecialchars($user['email']) . "
              </p>";
        echo "<p style='text-align:center; margin-top:1.5rem;'>
                <a href='register.html' style='color:#6c63ff; font-family:sans-serif;'>Back to Register</a>
              </p>";

    } else {
        // echo — login failed
        echo "<h2 style='color:red; font-family:sans-serif; text-align:center; margin-top:3rem;'>
                Login Failed!
              </h2>";

        // print — error message
        print "<p style='text-align:center; font-family:sans-serif; color:#888;'>
                 Invalid email or password.
               </p>";

        echo "<p style='text-align:center; margin-top:1rem;'>
                <a href='login.html' style='color:#6c63ff; font-family:sans-serif;'>Try Again</a>
              </p>";
    }

} else {
    header("Location: login.html");
    exit();
}
?>