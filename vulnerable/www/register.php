<?php
require "conn.php";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"]; 
    $password = $_POST["pass"];
    
    $query = $conn->prepare(
    "INSERT INTO users (username, password) VALUES (?, ?)");

    $query->bind_param("ss", $username, $password);
    $query->execute();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form action="register.php" method="POST">
        username: <input type="text" name="username"><br>
        password: <input type="text" name="pass"><br>
        <input type="submit">
    

    </form>
    Already have an account? <a href="login.php">login</a>
    
</body>
</html>

