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
    $userQuery = "SELECT * FROM client WHERE id='$id'";
    $userResult = $conn->query($userQuery);
    $row = $userResult->fetch_assoc();
}
if(!empty($_GET["action"])) {
    if($_GET["action"]=="inscris") {
        $idc = $_GET["id"];
        $newsQuery = "UPDATE client SET news='oui' WHERE id='$idc'";
        $conn->query($newsQuery);
        header("Location:index.php");
    }}

    function getUserInfo($userId, $field, $conn)
    {
        $userQuery = "SELECT $field FROM client WHERE id='$userId'";
        $userResult = $conn->query($userQuery);
    
        if ($userResult && $userResult->num_rows > 0) {
            $row = $userResult->fetch_assoc();
            return $row[$field];
        }
    
        return '';
    }  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newEmail = $_POST["email"];
        $newNom = $_POST["Nom"];
        $newPrenom = $_POST["Prenom"];
        $newpass = $_POST["pass"];

        $updateQuery = "UPDATE client SET email='$newEmail', Nom='$newNom', Prenom='$newPrenom', pass='$newpass' WHERE id='$id'";
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
    <title> connecxion </title>
</head>
<body>
<form id="msform" method="POST" action="profile.php">
    <fieldset>
      <h2 class="fs-title">modifier vos paramètres</h2>
      <input type="email" name="email" value="<?php  echo $row['email']?>" placeholder="Nouveau Email"  required="S’il vous plaît remplir ce champ"/>
      <input type="text" name="Nom" value="<?php  echo $row['Nom']?>" placeholder="Nouveau Nom" required="S’il vous plaît remplir ce champ"/>
      <input type="text" name="Prenom" value="<?php  echo $row['Prenom']?>" placeholder=" Nouveau Prenom" required="S’il vous plaît remplir ce champ"/>
      <input type="password" name="pass" value="<?php  echo $row['pass']?>" placeholder="Nouveau Mot de passe" required="S’il vous plaît remplir ce champ"/>
      <input type="password" name="cpass"  value="<?php  echo $row['pass']?>" placeholder=" Confirmer Nouveau Mot de Passe" required="S’il vous plaît remplir ce champ"/>


      <?php if (isset($_GET['error'])) { ?>
                <p class="error-message"><?php echo $_GET['error']; ?></p>
            <?php } ?>
      <input href="index.php" type="submit" name="anunler" class="next action-button" value="Annuler" />
      <input href="index.php" type="submit"  name="next" class="next action-button" value="Sauvgarder" />
  </body>
    </fieldset>
  </form>
</body>
</html>