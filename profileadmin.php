<?php 
session_start();
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "phpprojrct";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['logout'])){     
    session_destroy();
    header("Location: index.php");
} 

if(isset($_SESSION['user_id'])){
    $id=$_SESSION['user_id'];
    $userQuery = "SELECT * FROM admin WHERE id='$id'";
    $userResult = $conn->query($userQuery);
    $row = $userResult->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newEmail = $_POST["email"];

    $updateQuery = "UPDATE admin SET email='$newEmail' WHERE id='$id'";
    $conn->query($updateQuery);

    header("Location: index.php?id=$id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="f.css">
    <script src="f.js" type="text/javascript"></script>
    <title>Gérer vos paramètres</title>
</head>
<body>
    <form id="msform" method="POST" action="profileadmin.php">
        <fieldset>
            <h2 class="fs-title">Changer Votre Email</h2>
            <input type="email" name="email" value="<?php echo $row['email']?>" placeholder="Nouveau Email" required="S’il vous plaît remplir ce champ">

            <input href="index.php" type="submit" name="anunler" class="next action-button" value="Annuler" />
            <input href="index.php" type="submit" name="next" class="next action-button" value="Sauvgarder" />
        </fieldset>
    </form>
</body>
</html>
