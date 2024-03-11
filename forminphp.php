<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpprojrct";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $firstName = isset($_POST['Prénom']) ? $_POST['Prénom'] : ''; 
    $lastName = isset($_POST['Nom']) ? $_POST['Nom'] : ''; 
    $phone = isset($_POST['phone']) ? $_POST['phone'] : ''; 
    $address = isset($_POST['address']) ? $_POST['address'] : ''; 
    $cpass= isset($_POST['cpass']) ? $_POST['cpass'] : '';
    if ($password !== $cpass) {
        header("Location:formin.php?error=Assurez-vous que les deux mots de passe correspondent");
        exit();
}
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $firstName = mysqli_real_escape_string($conn, $firstName);
    $lastName = mysqli_real_escape_string($conn, $lastName);
    $phone = mysqli_real_escape_string($conn, $phone);
    $address = mysqli_real_escape_string($conn, $address);

    $emailCheckQuery = "SELECT * FROM client WHERE email='$email'";
    $emailCheckResult = $conn->query($emailCheckQuery);

    if ($emailCheckResult->num_rows > 0) {
        header("Location: formin.php?error=Cet e-mail est déjà enregistré. Veuillez utiliser une autre adresse e-mail..");
        exit();
    } else {
        $sql = "INSERT INTO client (email, pass , Prenom, Nom, phone, address, news) 
                VALUES ('$email', '$password', '$firstName', '$lastName', '$phone', '$address', 'non')";

        if ($conn->query($sql) === TRUE) {
            header("Location:index.php?email=$email&name=$firstName");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>