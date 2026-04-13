 <?php
session_start();
$conn = new mysqli("localhost","root","","register");

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email=$_POST['email'];
    $pass=$_POST['password'];

    $res=$conn->query("SELECT * FROM registration WHERE email='$email'");
    if($res->num_rows==1){
        $row=$res->fetch_assoc();
        if(password_verify($pass,$row['password'])){
            $_SESSION['username']=$row['name'];
            $_SESSION['email']=$row['email'];
            header("Location: fd.php");
        }else echo "Wrong password";
    } else echo "User not found";
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to right, #6dd5fa, #2980b9);
            font-family: Arial;
        }

        .login-box {
            width: 350px;
            background: white;
            padding: 30px;
            box-shadow: 0 10px 25px black;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-size: 12px;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            border: 1px solid lightblue;
            border-radius: 4px;
            outline: none;
        }

        input:focus {
            border-color: #2980b9;
        }

        .btn {
            width: 100%;
            background: #2980b9;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background: #1f6691;
        }

        .msg {
            text-align: center;
            margin-top: 10px;
            color: red;
        }
    </style>
</head>

<body>

<div class="login-box">
    <h2>Login</h2>

    <form method="post" action="login.php">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button class="btn">Login</button>
        
    </form>
</div>

</body>
</html>

