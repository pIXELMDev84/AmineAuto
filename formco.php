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
<form id="msform" method="POST" action="formcophp.php">
    <fieldset>
      <h2 class="fs-title">connecxion a votre compte</h2>
      <input type="email" name="email" placeholder="Email" name="email" required="S’il vous plaît remplir ce champ"/>
      <input type="password" name="pass" placeholder="mot de passe" name="mdp"required="S’il vous plaît remplir ce champ"/>
      <?php if (isset($_GET['error'])) { ?>
                <p class="error-message"><?php echo $_GET['error']; ?></p>
            <?php } ?>
      <input type="submit" name="next" class="next action-button" value="connection" />
    </fieldset>
  </form>
</body>
</html>