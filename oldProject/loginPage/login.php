<?php
include 'admin_control.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css2?family=Oswald&display=swap' rel='stylesheet' type='text/css'>
    <title>Login</title>
</head>
<body>
    <form class="loginForm" method="POST" >
        <div class="loginBox">
            <p> Username </p>
            <input type="text" value="Username" name="Username">
            <p> Password </p>
            <input type="password" value="Password" name="Password">
            <div class="loginButton">
                <button type="submit" name="submitbutton" value="submitted"> Login </button>
            </div>
        </div>
    </form>
</body>
</html>