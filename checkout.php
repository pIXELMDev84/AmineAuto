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
            $sql = "SELECT * FROM command WHERE client_id = $userId AND address IS NULL AND (telephone IS NULL OR telephone = '')";
            $result = $conn->query($sql);

            $cartItems = array();

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cartItems[] = $row;
                }
            }

            return $cartItems;
        }

        // Function to clear the shopping cart for a specific user
        function clearShoppingCart($userId)
        {
            global $conn;
            $sql = "DELETE FROM command WHERE client_id = $userId AND address IS NULL AND (telephone IS NULL OR telephone = '')";
            $conn->query($sql);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["next"])) {
                // Retrieve selected location (address) from the form
                $selectedLocation = $_POST["location"];
                // Retrieve telephone from the form
                $telephone = $_POST["phone"];

                // Validate if the user is logged in
                if (isset($_SESSION['user_id'])) {
                    $userId = $_SESSION['user_id'];

                    // Fetch cart items for the specified client
                    $cartItems = getCartItemsForClient($userId);

                    // Insert the order details into the command table
                    $insertOrderQuery = "INSERT INTO command (client_id, address, telephone, product_id, product_module, product_mark, product_image, quantitie, prix)
                                        VALUES ";
                    $values = array();

                    foreach ($cartItems as $item) {
                        $values[] = "($userId, '$selectedLocation', '$telephone', {$item['product_id']}, '{$item['product_module']}', '{$item['product_mark']}', '{$item['product_image']}', {$item['quantitie']}, {$item['prix']})";
                    }

                    $insertOrderQuery .= implode(", ", $values);

                    if ($conn->query($insertOrderQuery) === TRUE) {
                        // Order successful, you may want to clear the shopping cart here
                        clearShoppingCart($userId); // Call the function to clear the shopping cart

                        // Redirect to the final page
                        header("Location: final.html");
                        exit();
                    } else {
                        echo "Error inserting order: " . $insertOrderQuery . "<br>" . $conn->error;
                    }
                } else {
                    echo "User not logged in.";
                }
            }
        }

        $conn->close();
    } else {
        echo "User ID not found.";
    }
} else {
    echo "User not logged in.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="f.css">
    <title>Choisissez votre emplacement</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0; 
        }

        #msform {
            width: 50%; 
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        #location {
            font-size: 18px;
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        #selectedLocation, #price {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
        }

        .action-button {
            width: 100%;
            padding: 10px;
            font-size: 18px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <form id="msform" method="POST" action="checkout.php">
      <fieldset>
            <input type="phone" name="phone" placeholder="telephone"required="S’il vous plaît remplir ce champ" />
            <select id="location" name="location" required>
                <option value="" disabled selected>Choose your location</option>
                <option value="Alger">Alger</option>
                <option value="Oran">Oran</option>
                <option value="Adrar">Adrar</option>
                <option value="Annaba">Annaba</option>
                <option value="Djijel">Djijel</option>
            </select>
            
            <p id="selectedLocation"></p>
            <p id="price"></p>

            <input type="submit" name="next" class="next action-button" value="Checkout" />
        </fieldset>
    </form>

    <script>
        document.getElementById('location').addEventListener('change', function() {
            var selectedLocation = this.value;
            var prices = {
                'Alger': 200,
                'Oran': 400,
                'Adrar': 800,
                'Annaba': 400,
                'Djijel': 600
            };
            var price = prices[selectedLocation] || 0;

            document.getElementById('selectedLocation').innerText = 'votre emplacement: ' + selectedLocation;
            document.getElementById('price').innerText = ' transport Prix: ' + price;
        });
    </script>
</body>
</html>