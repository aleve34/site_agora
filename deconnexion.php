<?php
// Démarrer la session pour pouvoir manipuler les variables de session
session_start();

// Détruire toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion
header("Location: connexion.php");
exit;
?>
