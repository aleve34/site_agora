<?php
session_start();

// Vérifier si l'utilisateur est connecté et s'il est un vendeur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'vendeur') {
    // Si l'utilisateur n'est pas connecté ou n'est pas un vendeur, rediriger vers la page de connexion
    header("Location: connexion.php");
    exit;
}

require_once 'db_connect.php'; // Inclure le fichier de connexion à la base de données

// Récupérer les produits du vendeur
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM Item WHERE ID_Vendeur = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer mes produits</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h1 {
            color: #4CAF50;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h1>Gérer mes produits</h1>
    
    <!-- Liste des produits existants -->
    <h2>Mes produits en vente :</h2>
    <table>
        <tr>
            <th>Nom de l'item</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Catégorie</th>
            <th>Actions</th>
        </tr>

        <?php
        // Afficher les produits du vendeur
        while ($product = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $product['Nom'] . "</td>";
            echo "<td>" . $product['Description'] . "</td>";
            echo "<td>" . $product['Prix'] . "€</td>";
            
            // Récupérer le nom de la catégorie
            $category_id = $product['ID_Catégorie'];
            $category_query = "SELECT Nom FROM Catégorie ";
            $category_stmt = $conn->prepare($category_query);
            $category_stmt->bind_param('i', $category_id);
            $category_stmt->execute();
            $category_result = $category_stmt->get_result();
            $category = $category_result->fetch_assoc();
            echo "<td>" . $category['Nom'] . "</td>";
            
            echo "<td><a href='modifier_produit.php?id=" . $product['ID_Item'] . "'>Modifier</a> | ";
            echo "<a href='supprimer_produit.php?id=" . $product['ID_Item'] . "' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce produit ?\");'>Supprimer</a></td>";
            echo "</tr>";
        }
        ?>
    </table>

    <br>
    <h2>Ajouter un nouveau produit</h2>
    <form action="ajouter_produit.php" method="POST">
        <label for="nom">Nom de l'item :</label><br>
        <input type="text" id="nom" name="nom" required><br><br>
        
        <label for="description">Description :</label><br>
        <textarea id="description" name="description" required></textarea><br><br>
        
        <label for="prix">Prix :</label><br>
        <input type="number" id="prix" name="prix" step="0.01" required><br><br>
        
        <label for="categorie">Catégorie :</label><br>
        <select id="categorie" name="categorie" required>
            <option value="Achat immédiat">Meubles et objets d’art</option>
            <option value="Enchère"> Accessoire VIP</option>
            <option value="Négociation">Matériels scolaires</option>
        </select><br><br>
        </select><br><br>
        
        <label for="type_vente">Type de vente :</label><br>
        <select id="type_vente" name="type_vente" required>
            <option value="Achat immédiat">Achat immédiat</option>
            <option value="Enchère">Enchère</option>
            <option value="Négociation">Négociation</option>
        </select><br><br>

        <input type="submit" value="Ajouter le produit">
    </form>

</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
