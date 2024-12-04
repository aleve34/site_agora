<?php
// Connexion à la base de données
$servername = "localhost"; // Adresse de votre serveur MySQL
$username = "root"; // Votre nom d'utilisateur MySQL
$password = ""; // Votre mot de passe MySQL
$dbname = "siteagora"; // Nom de votre base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $motdepasse = mysqli_real_escape_string($conn, $_POST['motdepasse']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    
    // Hash du mot de passe
    $motdepasse_hashed = password_hash($motdepasse, PASSWORD_DEFAULT);
    
    // Vérifier si l'email existe déjà dans la base de données
    $sql_check_email = "SELECT * FROM " . ($role == "vendeur" ? "Vendeur" : "Acheteur") . " WHERE Email = '$email'";
    $result = $conn->query($sql_check_email);

    if ($result->num_rows > 0) {
        // L'email existe déjà dans la base de données
        echo "Erreur : L'email '$email' est déjà utilisé.";
    } else {
        // Vérifier si le rôle est "vendeur"
        if ($role == "vendeur") {
            $pseudo = mysqli_real_escape_string($conn, $_POST['pseudo']);
            $sql = "INSERT INTO Vendeur (Nom, Prénom, Email, Mot_de_passe, Pseudo) VALUES ('$nom', '$prenom', '$email', '$motdepasse_hashed', '$pseudo')";
        } else {
            $sql = "INSERT INTO Acheteur (Nom, Prénom, Email, Mot_de_passe) VALUES ('$nom', '$prenom', '$email', '$motdepasse_hashed')";
        }

        // Exécuter la requête
        if ($conn->query($sql) === TRUE) {
            echo "Inscription réussie!";
        } else {
            echo "Erreur : " . $sql . "<br>" . $conn->error;
        }
    }
}

// Fermer la connexion
$conn->close();
?>
