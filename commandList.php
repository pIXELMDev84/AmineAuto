<style type="text/css">
	html {
	height: 100%;
	background-image:url(imgs/auto.png);
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}

</style>
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $idToDelete = $_POST["id"];


    $deleteQuery = "DELETE FROM command WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $idToDelete);

    if ($stmt->execute()) {
        header("Location: commandlist.php");
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

$req = "SELECT * FROM command WHERE address IS NOT NULL AND telephone IS NOT NULL";
$result = mysqli_query($conn, $req);

echo "<html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <style>
                body {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 100vh;
                    margin: 0;
                }

                table {
                    border-collapse: collapse;
                    width: 70%;
                    margin-top: 20px;
                }

                th, td {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;
                }

                th {
                    background-color: #f2f2f2;
                }
                td {
                	color: black;
                }

                .delete-btn {
                    background-color: #ff3333;
                    color: white;
                    border: none;
                    padding: 5px 10px;
                    cursor: pointer;
                }
                table {
                    width: 400px;
                    margin: 50px auto;
                    text-align: center;
                    position: relative;
                }
                table {
                    background: white;
                    border: 0 none;
                    border-radius: 3px;
                    box-shadow: 0 5px 15px rgb(189, 85, 85);
                    padding: 20px 30px;
                    box-sizing: border-box;
                    width: 80%;
                    margin: 0 10%;
                
                    position: relative;
                }
                
                table fieldset:not(:first-of-type) {
                    display: none;
                }
                
                table .delete-btn {
                    width: 100px;
                    background: #ff0303;
                    font-weight: bold;
                    color: white;
                    border: 0 none;
                    border-radius: 1px;
                    cursor: pointer;
                    padding: 10px;
                    margin: 10px 5px;
                  text-decoration: none;
                  font-size: 14px;
                }
                table .delete-btn:hover, table .delete-btn:focus {
                    box-shadow: 0 5px 15px rgb(189, 85, 85);
                }
            </style>
        </head>
        <body>";

echo "<table>
        <tr>
            <th>id</th>
            <th>product_id</th>
            <th>product_module</th>
            <th>product_mark</th>
            <th>client_id</th>
            <th>address</th>
            <th>quantitie</th>
            <th>prix</th>
             <th>telephone</th>
             <th>Action</th>
        </tr>";

if ($result) {
    if (mysqli_num_rows($result) == 0) {
        echo "<tr><td colspan='10'>Aucun command trouvé</td></tr>";
    } else {
        echo "<br/>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['product_id'] . "</td>";
            echo "<td>" . $row['product_id'] . "</td>";
            echo "<td>" . $row['product_mark'] . "</td>";
            echo "<td>" . $row['client_id'] . "</td>";
            echo "<td>" . $row['address'] . "</td>";
            echo "<td>" . $row['quantitie'] . "</td>";
            echo "<td>" . $row['prix'] . "</td>";
            echo "<td>" . $row['telephone'] . "</td>";
            echo "<td>
                    <form method='POST' action='commandlist.php'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <button class='delete-btn' type='submit'>Supprimer</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
    }
} else {
    echo "<tr><td colspan='8'>Erreur dans la requête : " . mysqli_error($conn) . "</td></tr>";
}

echo "</table>
        </body>
      </html>";
?>
