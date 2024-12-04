<?php
$servername = "localhost";
$username = "root";  // ou votre nom d'utilisateur MySQL
$password = "";      // ou votre mot de passe MySQL
$dbname = "siteagora";  // Remplacez par le nom de votre base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}
?>
