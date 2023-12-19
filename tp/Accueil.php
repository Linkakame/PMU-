<?php
    require('connexion_bdd/connexion_bdd.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/accueil.css">
    <title>P.M.U</title>
</head>
<body>
    <div id="block1">
        <div id="logo">
            <img src="image/logo.jpg">
        </div>
        <div id="titre">
            <h1> P.M.U</h1>
        </div>
        <div id="menu">
            <ul class="menu_ul">
                <li class="menu_il"><a  href="">Accueil</a></li>
                <li class="menu_il"><a  href="./page/conseil.php">Conseils</a></li>
                <li class="menu_il"><a  href="./page/Mon_panier.php">Panier</a></li>
                <li class="menu_il"><a  href="">Compte</a></li>
            </ul>
        </div>
        <div id="profil">
            <a href="page/connexion.php"><img src="image/utilisateur.png" class="img_profil"></a>
            <a href="page/inscription.php"><img src="image/inscription.png" class="img_inscription"></a>
        </div>
    </div>

    <?php
$sql = 'SELECT * FROM piece WHERE promotion = 1';
$res = $DB->query($sql);
$sql2 = 'SELECT * FROM piece ORDER BY date_achat DESC LIMIT 3';
        $res2 = $DB->query($sql2);
?>      
    <div id="last_ventes">
        <p class="titre_last_ventes">Dernières ventes</p>
        <ul>
        <?php
            while ($row = $res2->fetch(PDO::FETCH_ASSOC)) {
                echo '<li>' . $row['nom'] . ' - ' . $row['date_achat'] . '</li>';
            }
            ?>
        </ul>
    </div>
    <div id="promotions">
        <h1>PROMOTIONS</h1>
        <?php
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    // Affichez les détails de la pièce en promotion
    echo '<div id="ligne">';
                    echo '<div id="piece">';
                    echo '<div id="titre">';
                    echo '<h5>' . $row['nom'] . '</h5>';
                    echo '</div>';
                    echo '<div id="image">';
                    echo '<img src="image/piece/' . $row['nom'] . '.jpg">'; 
                    echo '</div>';
                    echo '<div id="prix">';
                    echo '<p>prix : ' . $row['prix_prom'] . ' euro</p>';
                    echo '</div>';
    echo'</div>';
}
?>
    </div>
</body>
</html>