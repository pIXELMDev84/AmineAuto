
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

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Fetch user details
    $userQuery = "SELECT * FROM client WHERE id='$userId'";
    $userResult = $conn->query($userQuery);

    if ($userResult && $userResult->num_rows > 0) {
        // Fetch user details
        $userRow = $userResult->fetch_assoc();

        // Function to fetch cart items for a specific client
        function getCartItemsForClient($userId)
        {
            global $conn;
           $sql = "SELECT * FROM command WHERE client_id = $userId AND address IS NULL AND telephone IS NULL";
            $result = $conn->query($sql);

            $cartItems = array();

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cartItems[] = $row;
                }
            }

            return $cartItems;
        }

        // Function to update quantity in the cart
        function updateQuantity($id, $quantity)
        {
            global $conn;
            $sql = "UPDATE command SET quantitie = $quantity WHERE id = $id";
            $conn->query($sql);
        }

        // Function to delete item from the cart
        function deleteItem($id)
        {
            global $conn;
            $sql = "DELETE FROM command WHERE id = $id";
            $conn->query($sql);
        }

        // Handle update and delete actions
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["update_quantity"])) {
                $id = $_POST["item_id"];
                $quantity = $_POST["quantity"];
                updateQuantity($id, $quantity);
            } elseif (isset($_POST["delete_item"])) {
                $id = $_POST["item_id"];
                deleteItem($id);
            }
        }

        // Fetch cart items for the specified client
        $cartItems = getCartItemsForClient($userId);
    } else {
        echo "User ID not found.";
    }
} else {
    echo "User not logged in.";
}

// Check if the cart is empty
$cartIsEmpty = empty($cartItems);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        html {
	        height: 100%;
	        background-image:url(imgs/auto.png);
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        table {
            border-collapse: collapse;
            width: 70%;
            margin-top: 20px;
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

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .quantity-input {
            width: 40px;
            text-align: center;
            margin: 0 5px;
        }

        .btn {
            padding: 8px;
            margin: 0 5px;
            cursor: pointer;
        }

        .delete-btn {
            background-color: #ff3333;
            color: white;
            border: none;
            padding: 5px 10px;
             cursor: pointer;
        }
        .delete-btn {
            background-color: #ff3333;
            color: white;
            border: none;
            cursor: pointer;
        }
        


        .update-btn {
            background-color: #000000;
            color: white;
            border: none;
            cursor: pointer;
        }

        img {
            width: 100px;
            height: 100px;
        }

        .checkout-btn {
            background-color: #b60000;
            color: white;
            font-size: 18px;
            border: none;
            width: 150px;
            height: 50px;
            cursor: pointer;
        }

        .return-btn {
            background-color: #b60000;
            color: white;
            font-size: 18px;
            border: none;
            width: 150px;
            height: 50px;
            cursor: pointer;
        }
        table .delete-btn:hover, table .delete-btn:focus {
                    box-shadow: 0 5px 15px rgb(189, 85, 85);
        }
        .return-btn:hover, .return-btn:focus {
                    box-shadow: 0 5px 15px rgb(189, 85, 85);
        }
        .checkout-btn:hover, .checkout-btn:focus {
                    box-shadow: 0 5px 15px rgb(189, 85, 85);
        }
    </style>
</head>
<body>

    <h2 style="color: white; text-align: center;">Votre panier</h2>

    <table>
        <thead>
            <tr>
                <th>Module</th>
                <th>Mark</th>
                <th>Photo</th>
                <th>Quantitie</th>
                <th>Prix</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($cartItems as $item) {
                echo "<tr>";
                echo "<td>{$item['product_module']}</td>";
                echo "<td>{$item['product_mark']}</td>";
                echo "<td><img src='imgs/{$item['product_image']}' alt='Product Image'></td>";
                echo "<td class='actions'>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='item_id' value='{$item['id']}'>";
                echo "<div class='quantity-input'><input type='number' name='quantity' value='{$item['quantitie']}'></div>";
                echo "<button type='submit' name='update_quantity' class='btn update-btn' style='padding: 5px;'>Modifier</button>";
                echo "</form>";
                echo "</td>";
                echo "<td>";
                // Check if both 'prix' and 'quantitie' are numeric before multiplication
                if (is_numeric($item['prix']) && is_numeric($item['quantitie'])) {
                    echo $item['prix'] * $item['quantitie'];
                } else {
                    echo "Invalid";
                }
                echo "</td>";
                echo "<td class='actions'>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='item_id' value='{$item['id']}'>";
                echo "<button type='submit' name='delete_item' class='btn delete-btn' style='padding: 5px;'>Supprimer</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <div style="text-align: center; margin-top: 20px;">
        <?php if (!$cartIsEmpty): ?>
            <button class="checkout-btn" onclick="window.location.href='checkout.php'">Checkout</button>
        <?php else: ?>
            <p style="color:white;">Votre panier est vide. Ajoutez des Voiture à votre panier avant de passer à le checkout</p>
        <?php endif; ?>
        <button  class="return-btn" onclick="window.location.href='shop.php'">Produit Page</button>
    </div>
</body>
</html>
