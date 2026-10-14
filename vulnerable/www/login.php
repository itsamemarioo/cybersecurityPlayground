<?php
require "conn.php";
session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pass = $_POST["pass"];

    $sql = "SELECT id, username FROM users WHERE username = '$username' AND password = '$pass'";

    try {
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();

        if ($user) {
            $_SESSION["id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            header("Location: pets.php");
            exit;
        } else {
            $message = "Wrong username or password";
        }
    } catch (mysqli_sql_exception $e) {
        $message = "Database error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="POST">
        username: <input type="text" name="username"><br>
        password: <input type="password" name="pass"><br>
        <input type="submit">
    </form>
    <?= $message ?><br>
    Don't have an account? <a href="register.php">register</a>
</body>
</html>