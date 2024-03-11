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

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
}

if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    $userQuery = "SELECT * FROM client WHERE id='$id'";
    $userResult = $conn->query($userQuery);
    $row = $userResult->fetch_assoc();
}

// Fetch products from the database
$productQuery = "SELECT * FROM products";
$productResult = $conn->query($productQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    // Handle deletion
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Delete the product from the database
        $deleteQuery = "DELETE FROM products WHERE id='$id'";
        $conn->query($deleteQuery);

        // Redirect or display a confirmation message
        header("Location: shop.php");
        exit();
    } else {
        echo "ID parameter not found in the form submission!";
        exit();
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amineauto V7</title>
    <link rel="stylesheet" href="styles.css">
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
                   <li><a href="contact.php">aide</a></li>
                </ul>
            </li>
            <?php  } ?>
            
    </ul>
</nav>
            </ul>
        </div>

        

    </section>
    <section id="filter" class="section-p1">
        <div id="btns">
            <button class="btn"data-filter="all">Tout</button>
            <button class="btn"data-filter="Citroen">Citroen</button>
            <button class="btn"data-filter="Chevrolet">Chevrolet</button>
            <button class="btn"data-filter="Chery">Chery</button>
            <button class="btn"data-filter="Mercedes-Benz">Mercedes-Benz</button>

        </div>
    </section>
    
    <section id="product1" class="section-p1">
        <div id="products">
            <div class="pro-container">
                <?php
                while ($product = $productResult->fetch_assoc()) {
                ?>
      <div class="pro" data-filter="<?php echo $product['mark']; ?>">
       <img src="imgs/<?php echo $product['image']; ?>" alt="">
      <div class="des">
     <span><?php echo $product['mark']; ?></span>
  <h5><?php echo $product['module']; ?></h5>
   <h4><?php echo $product['prix']; ?>DA</h4>
     <p>Quantitie: <?php echo $product['quantitie']; ?></p>
</div>
        <?php if (isset($_SESSION["user_id"])) { ?>
   <?php if ($_SESSION["user_type"] == "client") { ?>
    <form action="command.php" method="post">
          <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                  <button type="submit" class="command-btn" >Command</button>
              </form>
           <?php } elseif ($_SESSION["user_type"] == "admin") { ?>
            <form method="POST" action="modifiercar.php">
    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
    <button type="submit" class="command-btn" >Modifier</button>
</form>

          <form method="POST" action="shop.php">
         <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
       <input type="submit" name="delete" value="Supprimer" class="command-btn" >
      </form>
     <?php } ?>
     <?php } ?>
       </div>
       <?php
 }
     ?>
            </div>
        </div>
    </section>
    <section id="pagination" class="section-p1">
        <div id="pagination-container"></div>
    </section>

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
    <style>
        
    .command-btn {
        background-color: white;
        color: white;
        margin-top: 6px;
        font-size: 18px;
        border: none;
        width: 150px;
        height: 50px;
        cursor: pointer;
    }
    .command-btn{
            background-color: #ff3333;
            color: white;
            border: none;
            cursor: pointer;
        }
    .command-btn:hover, .command-btn:focus {
                    box-shadow: 0 5px 15px rgb(189, 85, 85);
        }
    </style>
    
    <script src="script.js"></script>
 

</body>
</html>