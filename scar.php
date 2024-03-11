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
<form id="msform" method="POST" action="scarphp.php">

    <fieldset>
      <h2 class="fs-title">Ajouter Un Produit</h2>
  
      <input type="text" name="prix" placeholder="Prix" required="S’il vous plaît remplir ce champ" />
      <input type="text" name="mark" placeholder="Mark" required="S’il vous plaît remplir ce champ"/>
      <input type="text" name="model" placeholder="Models" required="S’il vous plaît remplir ce champ" />
      <input type="submit" name="next" class="next action-button" value="Envoyer" />
    </fieldset>
  </form>
</body>
</html>