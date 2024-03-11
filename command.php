<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["product_id"])) {

    // Check if the client is logged in
    if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == "client") {

        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "phpprojrct";

        // Connect to your database
        $mysqli = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Retrieve data from the form submission
        $product_id = $_POST['product_id'];
        $client_id = $_SESSION['user_id'];

        // Fetch product details from products table
        $productQuery = "SELECT * FROM products WHERE id = $product_id";
        $productResult = $mysqli->query($productQuery);

        if ($productResult && $productResult->num_rows > 0) {
            $product = $productResult->fetch_assoc();

            // Check if the product is already in the command table for this client
            $checkQuery = "SELECT * FROM command WHERE product_id = $product_id AND client_id = $client_id";
            $checkResult = $mysqli->query($checkQuery);

            if ($checkResult && $checkResult->num_rows > 0) {
                // Product already exists in the command table, check if telephone and address are not null
                $checkOrderQuery = "SELECT * FROM command WHERE product_id = $product_id AND client_id = $client_id AND telephone IS NOT NULL AND address IS NOT NULL";
                $checkOrderResult = $mysqli->query($checkOrderQuery);

                if ($checkOrderResult && $checkOrderResult->num_rows > 0) {
                    // Alert if telephone and address are not null for the existing order
                    echo "<script>alert('Vous avez déjà passé une commande pour ce produit.');</script>";
                } else {
                    // Telephone or address is null, do not increment quantity, display alert
                    echo "<script>alert('Le nombre d\\'articles n\\'a pas été augmenté. menu/panier');</script>";
                }
            } else {
                // Product does not exist in the command table, insert a new row
                $insertQuery = "INSERT INTO command (product_id, product_module, product_mark, product_image, client_id, quantitie, prix)
                                VALUES ($product_id, '{$product['module']}', '{$product['mark']}', '{$product['image']}', $client_id, 1, {$product['prix']})";

                if ($mysqli->query($insertQuery) === TRUE) {
                    echo " ";
                } else {
                    echo "Error inserting into command: " . $insertQuery . "<br>" . $mysqli->error;
                }

                echo "<script>alert('Le produit a été ajouté au panier avec succès. menu/panier');</script>";
            }

            echo "<script>window.history.back();</script>"; // Go back to the previous page
            exit;
        } else {
            echo "Product not found!";
        }

        // Close the database connection
        $mysqli->close();
    } else {
        echo "User not logged in as a client!";
    }
} else {
    echo "Invalid request!";
}
?>
