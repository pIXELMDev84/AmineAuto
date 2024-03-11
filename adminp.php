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
    <title>Admin-Amine</title>
    <link rel="stylesheet" href="ca.css">
    <link rel=stylesheet href="styles.css">
    <script src="https://kit.fontawesome.com/aa7454d09f.js" crossorigin="anonymous"></script>
</head>
<body>

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
                <li><a href="profile.php">Profil</a></li>
                    <?php   if($_SESSION["user_type"]=="admin"){   ?>
                        <li><a href="adminp.php">AdminDash</a></li>
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


   <div id="dashboard">
       <div>
           <div class="toggleMenu" id="toggleMenu">
             <i class="fa-solid fa-arrow-right icon toggelMenuIcon" id="toggelMenuIcon"></i>
           </div>
        <div class="sideNav" id="sideNav">
            <div id="topNav">
                 <div id="logo">
                   <span class="logoPic">A</span>
                   <a href="index.php" style="text-decoration: none;
        color: inherit;">
                   <h1 class="logoName">Amine-Auto AdminPanel</h1>
                   </a>
                 </div>
                   <p class="navSectionName">menu principale</p>
                 <ul class="nav">
                   <li class="navLink activeNavLink">
                       <i class="fa-solid fa-gauge icon"></i>
                       Tableau de bord
                   </li>
                   <li class="navLink">
                       <i class="fa-solid fa-address-book icon"></i>
                       Contacts
                   </li>
                   <li class="navLink">
                       <i class="fa-solid fa-chart-simple icon"></i>
                       Reports
                   </li>
                 </ul>
                   <p class="navSectionName">Autres</p>
                 <ul class="nav">
                   <li class="navLink">
                       <i class="fa-solid fa-headset icon"></i>
                       Help Center
                   </li>
                 </ul>
            </div>
   
            <div id="bottomNav">
               <h3 class="copyright">&copy; Amine-Auto, 2024</h3>
               <p class="copyDesc">Ce Panau dois etre Utiliser Que par les administrateur</p>
            </div>
   
          </div>
       </div>
       <main id="main">
           <header>
                <div class="headlineContainer">
              
                    <h1 class="headline">Bienvenue : admin</h1>
                    <p class="subheadline">
                        Salut administrateur, voici Notre Panau administrateur
                    </p>
                </div>


                <div class="profileContainer">
                    <div class="iconContainer moonIcon" id="toggleTheme">
                        <i class="fa-solid fa-moon" id="toggleThemeIcon"></i>
                    </div>
                    <div class="iconContainer">
                        <i class="fa-solid fa-bell notification"></i>
                    </div>
                    <div class="profilePic">
                           <img src="/img/profile.jpg" alt="">
                    </div>
                </div>
           </header>

           <section class="analytics">
             <div class="analyticsCard">
                <h3 class="cardHeader">Utilisateur Eenregistrer</h3>
                 
                <div class="debitcardContainer">
                    <div class="debitcardPic">
                        
                    </div>

                    
                </div>
             </div>

             <div class="analyticsCard totalBalanceCard">
                <h3 class="cardHeader">Your Total Balance</h3>
                <h1 class="totalBalance">$80,201.50</h1>
                <p class="earnDate">Novemeber 28, 2023 . 02:20PM</p>

                <div class="btnContainer">
                    <div class="btn">
                        <i class="fa-solid fa-paper-plane"></i>
                        send
                    </div>
                    <div class="btn">
                        <i class="fa-solid fa-circle-plus"></i>
                        topup
                    </div>
                    <div class="btn">
                        <i class="fa-solid fa-braille"></i>
                        more
                    </div>
                </div>
             </div>

             <div class="analyticsCard">
                <h3 class="cardHeader cardHeader1">
                    <span>Recent Transactions</span>
                    <span class="filterDate"><i class="fa-solid fa-calendar-days"></i> Last 7 Days</span>
                </h3>
                
                <div class="transactionContainer">
                    <div class="eachTransaction">
                     <div class="tansactionDesc">
                         <div class="paymentMethod">
                          <img src="./img/paypal.png" alt="">
                         </div>
                         <div class="paymentStatus">
                            <h3>Paypal - Received</h3>
                            <p>
                                20 December 2023, 08:20 AM
                            </p>
                         </div>
                     </div>

                     <div class="transactionPrice">
                        <h3 class="earnTransaction">+ $8,200.00</h3>
                     </div>
                    </div>

                    <div class="eachTransaction">
                        <div class="tansactionDesc">
                            <div class="paymentMethod">
                             <img src="./img/spotify.png" alt="">
                            </div>
                            <div class="paymentStatus">
                               <h3>Spotify Premium</h3>
                               <p>
                                   19 December 2023, 07:17 AM
                               </p>
                            </div>
                        </div>
   
                        <div class="transactionPrice">
                           <h3 class="reduceTransaction">- $199.00</h3>
                        </div>
                       </div>

                       <div class="eachTransaction">
                        <div class="tansactionDesc">
                            <div class="paymentMethod">
                             <img src="./img/transferwise.png" alt="">
                            </div>
                            <div class="paymentStatus">
                               <h3>transferwise - Received</h3>
                               <p>
                                   19 August 2023, 04:17 PM
                               </p>
                            </div>
                        </div>
   
                        <div class="transactionPrice">
                           <h3 class="earnTransaction">+ $1200.00</h3>
                        </div>
                       </div>

                       <div class="eachTransaction">
                        <div class="tansactionDesc">
                            <div class="paymentMethod">
                             <img src="./img/HM.png" alt="">
                            </div>
                            <div class="paymentStatus">
                               <h3>H&M Payment</h3>
                               <p>
                                   13 August 2023, 04:17 PM
                               </p>
                            </div>
                        </div>
   
                        <div class="transactionPrice">
                           <h3 class="reduceTransaction">- $2200.00</h3>
                        </div>
                       </div>
                </div>

               
             </div>

             <div class="analyticsCard totalBalanceCard">
                <h3 class="cardHeader cardHeader1">
                    <span>Expenses Instead</span>
                    <span><i class="fa-solid fa-ellipsis"></i></span>
                </h3>

                <div class="gaugeContainer">
                    <div class="gaugeBody">
                        <div class="gaugeProgress"></div>
                        <div class="guageNumber">
                            85.5%<br>
                            <span class="expenseStatus">Normal Level</span>
                        </div>
                    </div>
                    <div class="totalExpense">Total Exp: 
                        <span class="totalExpensePrice">$1,820.80</span>
                    </div>
                </div>
            </div>
           </section>

       </main>
   </div>

   <script src="ascript.js"></script>
    
</body>
</html>