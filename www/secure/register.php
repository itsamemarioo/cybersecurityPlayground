<?php
require "conn.php";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["pass"] ?? "";

    if ($username === "" || $password === "") {
        $message = "Username and password are required.";
    } elseif (strlen($password) < 8) {
        $message = "Password must be at least 8 characters.";
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "Username already exists.";
        } else {
            $query = $conn->prepare(
                "INSERT INTO users (username, password) VALUES (?, ?)");
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $query->bind_param("ss", $username, $hash);
            $query->execute();
            $message = "Account created!";
        }
        $check->close();
    }
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
    <?= htmlspecialchars($message) ?><br>
    <form action="register.php" method="POST">
        username: <input type="text" name="username" required><br>
        password: <input type="password" name="pass" required minlength="8"><br>
        <input type="submit">
    </form>
    Already have an account? <a href="login.php">login</a>
</body>
</html>