<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpprojrct";
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Erreur de connexion");

if(isset($_POST["next"])) {
    $module = $_POST['module'];
    $mark = $_POST['mark'];
    $prix = $_POST['prix'];
    $quantitie = $_POST['quantitie'];
    $image = $_FILES['image']['name'];
    $path = "../uploads";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time().'.'.$image_ext;

    $product_query = "INSERT INTO products(module, mark, prix, quantitie, image) VALUES ('$module', '$mark', '$prix', '$quantitie', '$image')";
    $product_query_run = mysqli_query($conn, $product_query);

    if($product_query_run) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$filename)) {
            echo 'File is valid, and was successfully uploaded.';
        } else {
            echo 'Possible file upload attack!';
        }
        header("location: shop.php");
    } else {
        echo "Error: " . $product_query . "<br>" . mysqli_error($conn);
       
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style type="text/css">
        fieldset label {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        fieldset label input {
            margin-right: 5px;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="f.css">
    <script src="f.js" type="text/javascript"></script>
    <title> Ajouter une voiture </title>
</head>
<body>
    <form id="msform" method="POST" action="AjouterCar.php" enctype="multipart/form-data">
        <fieldset>
            <h2 class="fs-title">Ajouter Une Voiture</h2>
            <input type="text" placeholder="Nom de la voiture" name="module" required="required">

            <label>Marque de voiture:</label>
            <label>Citroen<input type="radio" name="mark" value="Citroen" required="required"></label>
            <label>Chevrolet<input type="radio" name="mark" value="Chevrolet" required="required"> </label>
            <label>Chery<input type="radio" name="mark" value="Chery" required="required"> </label>
            <label>Mercedes_Benz<input type="radio" name="mark" value="Mercedes-Benz" required="required"> </label>

            <input type="number" name="prix" placeholder="prix" required="required" min="0">
            <input type="number" placeholder="quantitie" name="quantitie" required="required" min="0" max="30">
            
            <label for="image">Car Image:</label>
            <input type="file" name="image" accept="image/jpeg, image/pjpeg, image/png, image/gif" required="required">
            
            <input type="submit" name="next" class="next action-button" value="Sauvgarder" />
        </fieldset>
    </form>
</body>
</html>
