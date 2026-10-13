<?php
require "conn.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" ){
    if (isset($_POST['username'])){
        $username = $_POST["username"]; 

        $query = $conn->prepare(
        "SELECT id FROM users WHERE username = ?");

        $query->bind_param("s", $username);
        $query->execute();
        $result = $query->get_result();
        $user = $result->fetch_assoc();
        $user_id = $user["id"];

        $_SESSION["id"] = $user_id;

        $query = $conn->prepare("SELECT * FROM pets WHERE user_id = ?");
        $query->bind_param("i", $user_id);
        $query->execute();
        $pets = $query->get_result();
    }
    if (isset($_POST["name"],$_POST["species"],$_POST["characteristics"])){
        $name = $_POST["name"]; 
        $species = $_POST["species"];
        $characteristics = $_POST["characteristics"];

        
        $query = $conn->prepare(
        "INSERT INTO pets (user_id, name,species,characteristics) VALUES (?, ?,?,?)");

        $query->bind_param("ssss", $_SESSION["id"], $name,$species,$characteristics);
        $query->execute();

    }
    
    
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pets Register</title>
</head>
<body>
    Welcome <?php echo $username ?><br>
    Register Your pet: <br>
    <form action="pets.php" method="POST">
        name: <input type="text" name="name"><br>
        species: <input type="text" name="species"><br>
        characteristics: <input type="textarea" name="characteristics"><br>

        <input type="submit">
    

    </form><br>
    Your pets:<br>
    <table border="1">
    <tr>
        <th>Name</th>
        <th>Species</th>
        <th>Characteristics</th>
    </tr>

    <?php while ($pet = $pets->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($pet["name"]) ?></td>
            <td><?= htmlspecialchars($pet["species"]) ?></td>
            <td><?= htmlspecialchars($pet["characteristics"]) ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>

