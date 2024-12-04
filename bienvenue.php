<?php
// Démarrer la session pour vérifier si l'utilisateur est connecté
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: connexion.php");
    exit;
}

// Vous pouvez accéder aux informations de l'utilisateur ici
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Affichage du message de bienvenue
echo "<h1>Bienvenue sur votre espace " . ucfirst($role) . " !</h1>";
echo "<p>Votre ID utilisateur est : " . $user_id . "</p>";

// Si l'utilisateur est un vendeur, vous pouvez afficher des options pour gérer les produits
if ($role == 'vendeur') {
    echo "<p><a href='gerer_produits.php'>Gérer vos produits</a></p>";
} else {
    echo "<p><a href='panier.php'>Voir votre panier</a></p>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h1 {
            color: #4CAF50;
        }
        p {
            font-size: 18px;
        }
    </style>
</head>
<body>

    <!-- Lien pour se déconnecter -->
    <p><a href="deconnexion.php">Se déconnecter</a></p>

</body>
</html>
