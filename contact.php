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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amineauto V7</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="c.css">
    <link href="/fontawesome-free-6.5.1-web/fontawesome-free-6.5.1-web/css/all.css" rel="stylesheet">
</head>
<body>
<section id="header">
        <a href="index.php"><img src="imgs/Amineauto.png" alt="" class="logo"></a>

        <div>
            <ul id="navbar">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="contact.php">Contacts</a></li>
                <li><a href="shop.php">Produits</a></li>

                <nav>
    <ul>
        <?php  if(isset($_SESSION["user_id"])){ ?>
            <?php    if($_SESSION["user_type"]=="client"){    ?>
            <li class="deroulant"><a href="#">Bonjour, <?php  echo $row['Prenom']   ?></a>
            <?php   }if($_SESSION["user_type"]=="admin"){     ?>
                <li class="deroulant"><a href="#">Bonjour, Admin</a>
                <?php   } ?>
                <ul class="sous">
                <li><a href="<?php echo ($_SESSION["user_type"]=="admin") ? 'profileadmin.php' : 'profile.php'; ?>">Profil</a></li>
                    <?php   if($_SESSION["user_type"]=="admin"){   ?>
                         <li><a href="AjouterCar.php">Ajouter Un Voiture</a></li>
                        <li><a href="clientList.php">Client List</a></li>
                        <li><a href="commandList.php">Command List</a></li>
                         <li><a href="transportprix.html">Transport Prix</a></li>
                         <li><a href="AjouterAdmin.php">Ajouter Admin</a></li>
                        <?php   } ?>
                         <?php   if($_SESSION["user_type"]=="client"){   ?>
                       <li><a href="cart.php">Panier</a></li>
                        <?php   } ?>
                    <li><a href="index.php?logout=logout">Deconexion</a></li>
                </ul>
            </li>
            <?php   }else { ?>
                <li class="deroulant"><a href="#">Menu &ensp;</a>
                <ul class="sous">
                    <li><a href="formco.php">connexion</a></li>
                    <li><a href="formin.php">s'inscrire</a></li>
                    <li><a href="contact.html">aide</a></li>
                </ul>
            </li>
            <?php  } ?>
            
    </ul>
</nav>
            </ul>
        </div>

        

    </section>
    <h2 style="text-align: center; padding-top: 20px; font-size: 4em;">Contactez Nous </h2>


<div class="form-wrapper">

    <form>

        <div class="form-group">

            <label class="form-label" for="name">Your Name:</label>

            <input class="form-control" type="text" id="name" name="name" required>

        </div>

        <div class="form-group">

            <label class="form-label" for="email">Your E-mail:</label>

            <input class="form-control" type="email" id="email" name="email" required>

        </div>

        <div class="form-group">

            <label class="form-label" for="phone">Your Phone:</label>

            <input class="form-control" type="tel" id="phone" name="phone" required>

        </div>

        <div class="form-group">

            <label class="form-label" for="message">Your Message:</label>

            <textarea class="form-control" id="message" name="message" rows="4" cols="50"></textarea required>

        </div>

        <button class="form-button" type="submit">Send Now</button>

    </form>

</div>
  <?php if (isset($_SESSION["user_id"])) { ?>
    <?php if (isset($row) && $row['news'] == 'non') { ?>
        <section id="newsletter" class="section-p1 section-m1">
            <div class="newstext">
                <h4>inscrivez-vous à notre lettre d'informations</h4>
                <p>Recevez des mises à jour par e-mail sur nos derniers produits</p>
            </div>
            <div class="form">
                <?php if (isset($row['id'])) { ?>
                    <a href="index.php?action=inscris&id=<?php echo $row['id']; ?>" class="normal">Inscription</a>
                <?php } else { ?>
                    <p>Erreur: impossible de récupérer l'identifiant de l'utilisateur</p>
                <?php } ?>
            </div>
        </section>
    <?php } else { ?>
        <section id="newsletter" class="section-p1 section-m1">
            <div class="newstext">
                <h4>inscrivez-vous à notre lettre d'informations</h4>
                <p>Recevez des mises à jour par e-mail sur nos derniers produits</p>
            </div>
            <div class="form">
                <p>vous êtes déjà inscrit</p>
            </div>
        </section>
    <?php } ?>
<?php } else { ?>
    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>inscrivez-vous à notre lettre d'informations</h4>
            <p>Recevez des mises à jour par e-mail sur nos derniers produits</p>
        </div>
        <div class="form">
            <a href="formco.php" class="normal">Inscription</a>
        </div>
    </section>
<?php } ?>

<footer class="section-p1">
    <div class="col">
        <img src="imgs/Amineauto.png" alt="">
        <h4>Contacts</h4>
        <p><strong>Adress:</strong>Boudjemaa Temim, Draria</p>
        <p><Strong>Phone:</Strong>0798327055</p>
    </div> 

    <?php if (isset($_SESSION["user_id"])) { ?>
        <div class="col">
            <p>Conçu par Mokhtari Mohamed Lamine et</p>
            <p> Sidiboumedine Abdelhak Amine </p>
            <a href="contact.php">Contact Nous</a>
        </div>
    <?php } else { ?>
        <div class="col">
            <h4>My Account</h4>
            <a href="formco.php">connexion</a>
            <a href="contact.php">Contact Nous</a>
            <a href="formin.php">s'inscrire</a>
        </div>
    <?php } ?>


    <div class="copyright">
        <p>&copy; 2024 Amineauto V7. Tous droits réservés.</p>
    </div>
</footer>

<script src="script.js"></script>

</body>
