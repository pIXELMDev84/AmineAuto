<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "phpprojrct";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $adminQuery = "SELECT * FROM admin WHERE email='$email' AND pass='$pass'";
    $adminResult = $conn->query($adminQuery);

    if ($adminResult->num_rows == 1) {
        $rowa = $adminResult->fetch_assoc();
        $_SESSION['user_id'] = $rowa['id'];
    $_SESSION['user_type'] = 'admin';
    header("location:index.php");
    exit();
} else {
    $clientQuery = "SELECT * FROM client WHERE email='$email' AND pass='$pass'";
    $clientResult = $conn->query($clientQuery);

    if ($clientResult->num_rows == 1) {
        $row = $clientResult->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_type'] = 'client';
        header("location:index.php");
        exit();
    } else {
        header("location:formco.php?error=Incorrect email or password");
        exit();
    }
}
}
?>