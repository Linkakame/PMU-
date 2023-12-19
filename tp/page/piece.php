<!DOCTYPE html>
<?php
    session_start();
    require('../connexion_bdd/connexion_bdd.php');
    function ajouterAuPanier($id_piece, $quantite, $prix, $stock_disponible) {
        // Initialise le panier s'il n'existe pas encore
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = array();
        }
    
        // Vérifie si la quantité demandée est inférieure ou égale au stock disponible
        if ($quantite > $stock_disponible) {
            echo "La quantité demandée dépasse le stock disponible. Veuillez réduire la quantité.";
            return; // Arrêtez l'ajout au panier si la quantité est trop élevée
        }
    
        // Si l'article est déjà dans le panier, met à jour la quantité
        if (isset($_SESSION['panier'][$id_piece])) {
            $_SESSION['panier'][$id_piece]['quantite'] += $quantite;
        } else {
            // Sinon, ajoute l'article au panier
            $_SESSION['panier'][$id_piece] = array(
                'quantite' => $quantite,
                'prix' => $prix
            );
        }
    
        echo "Ajout au panier réussi !";
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouterAuPanier'])) {
        $id_piece = $_POST['id_piece'];
        $prix = $_POST['prix'];
        $quantite = $_POST['quantite'];
        $stock_disponible = $_POST['stock_disponible'];
        $nom = $_POST['nom'];
        ajouterAuPanier($id_piece, $quantite, $prix, $stock_disponible); 
        header("Location: Mon_panier.php");
        exit();
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/piece.css" type='text/css' >
    <title>Piece</title>
</head>
<body>
<div id="block">
    <div id="block1">
        <div id="logo">
            <img src="../image/logo.jpg">
        </div>
        <div id="titre">
            <h1> P.M.U</h1>
        </div>
        <div id="menu">
            <ul class="menu_ul">
                <li class="menu_il"><a  href="../Accueil.php">Accueil</a></li>
                <li class="menu_il"><a  href="">Conseils</a></li>
                <li class="menu_il"><a  href="Mon_panier.php">Panier</a></li>
                <li class="menu_il"><a  href="">Compte</a></li>
            </ul>
        </div>
        <div id="profil">
            <a href="connexion.php"><img src="../image/utilisateur.png" class="img_profil"></a>
        </div>
    </div>
    <div id="block_principal">
    <div id="resultats_recherche">
        <form method="post">
            <label for="search">Rechercher une pièce :</label>
            <input type="text" id="search" name="search" required>
            <button type="submit">Rechercher</button>
        </form>

        <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
                $searchTerm = $_POST['search'];
                // Effectuer la recherche dans la base de données (par exemple, utiliser LIKE)
                $sql = "SELECT * FROM piece WHERE nom LIKE :searchTerm";
                $stmt = $DB->prepare($sql);
                $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
                $stmt->execute();
                echo "<h2>Résultats de la recherche pour '$searchTerm' :</h2>";
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div>';
                    echo '<h5>' . $row['nom'] . '</h5>';
                    echo '<p>Stock : ' . $row['stock'] . ' euro</p>';
                    echo '<img src="../image/piece/' . $row['nom'] . '.jpg">'; 
                    echo '<p>Prix : ' . $row['prix'] . ' euro</p>';
                    echo '</div>';
                }
            }
            
        ?>
        </div>
        <h1>Liste des pièces</h1>
        <?php
                $sql = 'SELECT * from piece ';
                $res = $DB->query($sql);
                while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div id="ligne">';
                    echo '<div id="piece">';
                    echo '<div id="titre">';
                    echo '<h5>' . $row['nom'] . '</h5>';
                    echo '</div>';
                    echo '<div id="image">';
                    echo '<img src="../image/piece/' . $row['nom'] . '.jpg">'; 
                    echo '</div>';
                    echo '<div id="stock">';
                    echo '<p>stock : ' . $row['stock'] . ' euro</p>';
                    echo '</div>';
                    echo '<div id="prix">';
                    echo '<p>prix : ' . $row['prix'] . ' euro</p>';
                    echo '</div>';
                
                    echo '<form method="post" enctype="multipart/form-data">';
                        echo '    <input type="hidden" name="id_piece" value="' . $row['id_piece'] . '">';
                        echo '    <input type="hidden" name="prix" value="' . $row['prix'] . '">';
                        echo '    <input type="hidden" name="stock_disponible" value="' . $row['stock'] . '">';
                        echo '    <label for="quantite">Quantité :</label>';
                        echo '    <input type="number" name="quantite" value="1" min="1" max="' . $row['stock'] . '">';
                        echo '    <button type="submit" name="ajouterAuPanier">Ajouter au panier</button>';
                        echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }           
                ?>
        </div>
        </div>
    </body>
</html>
