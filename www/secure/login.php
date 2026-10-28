<?php
require "conn.php";
session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pass = $_POST["pass"];
//changed
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($pass, $user["password"])) {
        session_regenerate_id(true);
        $_SESSION["id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        header("Location: pets.php");
        exit;
    } else {
        $message = "Wrong username or password";
    }
}//changed
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
    <?= htmlspecialchars($message) ?><br>
    Don't have an account? <a href="register.php">register</a>
</body>
</html>