<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpprojrct";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $pass = isset($_POST['pass']) ? $_POST['pass'] : "";

   
    $conn = mysqli_connect($servername, $username, $password, $dbname) or die("erreur de connexion");

    $email = mysqli_real_escape_string($conn, $email);
    $pass = mysqli_real_escape_string($conn, $pass);

  $checkEmailQuery = "SELECT * FROM admin WHERE email = '$email'";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);
     if (mysqli_num_rows($checkEmailResult) > 0) {
        // Email already exists
        header("Location: AjouterAdmin.php?error=Cet e-mail est déjà enregistré. Veuillez utiliser une autre adresse e-mail..");
    } else {
    $sql = "INSERT INTO admin (email, pass) VALUES ('$email', '$pass')";

    if (mysqli_query($conn, $sql)) {
       header("Location:index.php");  
        exit(); 
    } else {
        echo "Erreur: " . $sql . " " . mysqli_error($conn);
    }
}
  
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="f.css">
    <script src="f.js" type="text/javascript"></script>
    <title> Ajouter Admin </title>
</head>
<body>
<form id="msform" method="POST" action="AjouterAdmin.php">

    <fieldset>
      <h2 class="fs-title">Ajouter un admin</h2>
  
      <input type="email" name="email" placeholder="Email" required="S’il vous plaît remplir ce champ" />
      <input type="password" name="pass" placeholder="mot de passe" required="S’il vous plaît remplir ce champ"/>
      <div id="error-section">
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error-message">' . $_GET['error'] . '</p>';
        }
        ?>
      <input type="submit" name="next" class="next action-button" value="Sauvgarder" />
    </fieldset>
  </form>
</body>
</html>