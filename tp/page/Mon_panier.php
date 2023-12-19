<?php
session_start();
require('../connexion_bdd/connexion_bdd.php');

function ajouterAuPanier($id_piece, $quantite, $prix, $stock_disponible) {
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }

    if ($quantite > $stock_disponible) {
        echo "La quantité demandée dépasse le stock disponible. Veuillez réduire la quantité.";
        return;
    }

    if (isset($_SESSION['panier'][$id_piece])) {
        $_SESSION['panier'][$id_piece]['quantite'] += $quantite;
    } else {
        $_SESSION['panier'][$id_piece] = array(
            'quantite' => $quantite,
            'prix' => $prix,
        );
    }

    echo "Ajout au panier réussi !";
}

function modifierQuantitePanier($id_piece, $nouvelleQuantite, $stock_disponible) {
    if (isset($_SESSION['panier'][$id_piece])) {
        if ($nouvelleQuantite > 0 && $nouvelleQuantite <= $stock_disponible) {
            $_SESSION['panier'][$id_piece]['quantite'] = $nouvelleQuantite;
            echo "Quantité modifiée avec succès.";
        } elseif ($nouvelleQuantite <= 0) {
            unset($_SESSION['panier'][$id_piece]);
            echo "Article supprimé du panier.";
        } else {
            echo "La nouvelle quantité dépasse le stock disponible.";
        }
    } else {
        echo "Cet article n'est pas dans le panier.";
    }
}
function calculerPrixTotal() {
    $prix_total = 0;

    if (isset($_SESSION['panier']) && count($_SESSION['panier']) > 0) {
        foreach ($_SESSION['panier'] as $id_piece => $article) {
            if (isset($article['quantite']) && isset($article['prix'])) {
                $prix_total += $article['quantite'] * $article['prix'];
            }
        }
    }

    return $prix_total;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['modifierQuantitePanier'])) {
        $id_piece = $_POST['id_piece'];
        $nouvelle_quantite = $_POST['nouvelle_quantite'];

        $stock_disponible = getStockDisponible($id_piece);

        modifierQuantitePanier($id_piece, $nouvelle_quantite, $stock_disponible);
    } elseif (isset($_POST['supprimerDuPanier'])) {
        $id_piece = $_POST['id_piece'];

        if (isset($_SESSION['panier'][$id_piece])) {
            unset($_SESSION['panier'][$id_piece]);
            echo "Article supprimé du panier.";
        } else {
            echo "Cet article n'est pas dans le panier.";
        }
    }
}

function afficherPanier() {
    if (isset($_SESSION['panier']) && count($_SESSION['panier']) > 0) {
        echo "<ul>";
        foreach ($_SESSION['panier'] as $id_piece => $article) {
            echo "<li>";
            echo "Article ID: " . $id_piece . ", ";
            if (isset($article['quantite'])) {
                echo "Quantité: " . $article['quantite'] . ", ";
            } else {
                echo "Quantité non définie, ";
            }

            if (isset($article['prix'])) {
                echo "Prix unitaire: " . $article['prix'];
            } else {
                echo "Prix unitaire non défini";
            }



            echo '<form method="post" enctype="multipart/form-data">';
            echo '    <input type="hidden" name="id_piece" value="' . $id_piece . '">';
            echo '    <label for="nouvelle_quantite">Nouvelle quantité :</label>';
            echo '    <input type="number" name="nouvelle_quantite" value="' . $article['quantite'] . '" min="1">';
            echo '    <button type="submit" name="modifierQuantitePanier">Modifier la quantité</button>';
            echo '</form>';

            echo '<form method="post" enctype="multipart/form-data">';
            echo '    <input type="hidden" name="id_piece" value="' . $id_piece . '">';
            echo '    <button type="submit" name="supprimerDuPanier">Supprimer</button>';
            echo '</form>';
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Le panier est vide.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier</title>
</head>

<body>
    <?php
        afficherPanier();
        echo'<br>';
        echo '<p>Prix total : ' . calculerPrixTotal() . ' euro</p>';
        echo '<a href="piece.php"><button>Retour liste</button></a>';
    ?>
</body>

</html>
