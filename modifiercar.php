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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $userQuery = "SELECT * FROM products WHERE id='$id'";
    $userResult = $conn->query($userQuery);

    if ($userResult->num_rows > 0) {
        $row = $userResult->fetch_assoc();
    } else {
        echo "Product not found! ID: $id";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modify"])) {
        $newmodule = $_POST["module"];
        $newmark = $_POST["mark"];
        $newprix = $_POST["prix"];
        $newquantitie = $_POST["quantitie"];

        $Image = $_FILES['Image'];
        $originalFilename = $Image['name'];
        $filename = $originalFilename;  // Use product ID from the database
        $target_dir = "uploads/";

        // Check if the directory exists, if not, create it
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $target_path = $target_dir . $filename;

        if (move_uploaded_file($Image['tmp_name'], $target_path)) {
            $updateQuery = "UPDATE products SET module='$newmodule', mark='$newmark', prix='$newprix', quantitie='$newquantitie', image='$filename' WHERE id='$id'";
            $conn->query($updateQuery);

            header("Location: shop.php?id=$id");
            exit();
        } else {
            // Handle image upload failure
            echo "Image upload failed!";
            echo "Error: " . $_FILES['Image']['error'];
        }
    }
} else {
    echo "ID parameter not found in the form submission!";
    exit();
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
    <title>Modifier un voiture</title>
</head>

<body>
    <form id="msform" method="POST" action="modifiercar.php" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <fieldset>
            <h2 class="fs-title">Modifier Un Voiture</h2>

            <input type="text" placeholder="Nom de la voiture" name="module" required="required" value="<?php echo $row['module']; ?>">

            <label>Marque de voiture:</label>
            <label>Citroen<input type="radio" name="mark" value="Citroen" required="required"></label>
            <label>Chevrolet<input type="radio" name="mark" value="Chevrolet" required="required"> </label>
            <label>Chery<input type="radio" name="mark" value="Chery" required="required"> </label>
            <label>Mercedes_Benz<input type="radio" name="mark" value="Mercedes-Benz" required="required"> </label>

            <input type="number" name="prix" placeholder="prix" required="required" min="0" value="<?php echo $row['prix']; ?>">
            <input type="number" placeholder="quantitie" name="quantitie" required="required" min="0" max="30" value="<?php echo $row['quantitie']; ?>">

            <label for="newImage">Nouvelle image:</label>
            <input type="file" name="Image" accept="image/jpeg, image/pjpeg, image/png, image/gif">

            <input type="submit" name="modify" class="next action-button" value="Modifier" />
        </fieldset>
    </form>
</body>

</html>
