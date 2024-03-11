<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "phpprojrct";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $prix = $_POST['prix'];
    $mark = $_POST['mark'];
    $model = $_POST['model'];

    $sql = "INSERT INTO produit (prix, mark, model) VALUES ('$prix', '$mark', '$model')";

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully";
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
