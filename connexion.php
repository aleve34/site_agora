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

// Variable pour afficher le message d'erreur
$error_message = "";

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $motdepasse = mysqli_real_escape_string($conn, $_POST['motdepasse']);
    
    // Vérifier si l'email existe dans la base de données
    // Sélectionner uniquement les colonnes nécessaires (ID, email, mot de passe, rôle)
    $sql = "SELECT ID_Vendeur AS ID, Email, Mot_de_passe, 'vendeur' AS Role FROM Vendeur WHERE Email = '$email'
            UNION
            SELECT ID_Acheteur AS ID, Email, Mot_de_passe, 'acheteur' AS Role FROM Acheteur WHERE Email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Si l'email existe, vérifier le mot de passe
        $row = $result->fetch_assoc();
        
        if (password_verify($motdepasse, $row['Mot_de_passe'])) {
            // Si le mot de passe est correct
            session_start(); // Démarre une session
            $_SESSION['user_id'] = $row['ID']; // ID de l'utilisateur (Acheteur ou Vendeur)
            $_SESSION['role'] = $row['Role']; // Détermine le rôle de l'utilisateur
            
            header("Location: bienvenue.php"); // Redirige vers une page après connexion réussie
            exit;
        } else {
            $error_message = "Erreur : Mot de passe incorrect.";
        }
    } else {
        $error_message = "Erreur : L'email n'existe pas.";
    }
}

// Fermer la connexion
$conn->close();
?>
