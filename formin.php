<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="f.css">
    <script src="f.js" type="text/javascript"></script>
    <title> inscription </title>
</head>
<body>
<form id="msform" method="POST" action="forminphp.php">

    <fieldset>
      <h2 class="fs-title">Créez votre compte</h2>
  
      <input type="email" name="email" placeholder="Email" required="S’il vous plaît remplir ce champ" />
      <input type="password" name="pass" placeholder="mot de passe" required="S’il vous plaît remplir ce champ"/>
      <input type="password" name="cpass" placeholder="Confirmez votre mot de passe" required="S’il vous plaît remplir ce champ" />
      <input type="text" name="Prénom" placeholder="Prénom" required="S’il vous plaît remplir ce champ"/>
      <input type="text" name="Nom" placeholder="Nom" required="S’il vous plaît remplir ce champ"/>
      <input type="phone" name="phone" placeholder="telephone"required="S’il vous plaît remplir ce champ" />
      <textarea name="address" placeholder="Adresse"required="S’il vous plaît remplir ce champ"></textarea>
     <div id="error-section">
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error-message">' . $_GET['error'] . '</p>';
        }
        ?>
      <input type="submit" name="next" class="next action-button" value="Envoyer" />
    </fieldset>
  </form>
</body>
</html>