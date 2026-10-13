<?php
require "conn.php";
$message = "";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form action="pets.php" method="POST">
        username: <input type="text" name="username"><br>
        password: <input type="text" name="pass"><br>
        <input type="submit">
    

    </form>
    Don't have an account? <a href="register.php">register</a>
    
</body>
</html>

