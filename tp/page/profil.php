
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/profil.css" type='text/css' >
    <title>Profil</title>
</head>
<body>
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
            <img src="../image/utilisateur.png" class="img_profil">
            <a href="../deconnexion.php"><img src="../image/deconnexion.png" class="img_deconnexion"></a>
        </div>
    </div>

    <div id="contenue_profil">
    <?php
    session_start();
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    require('../connexion_bdd/connexion_bdd.php');
    if(isset($_GET['id_client']) AND $_GET['id_client'] > 0) { 
            $getid_client = intval($_GET['id_client']);
            $sql = 'SELECT * from client where id_client = ?';
            $req = $DB->prepare($sql);
            $req->execute(array($getid_client));
            $userinfo = $req->fetch();
            $_SESSION['id_client'] = $userinfo['id_client'];
            $_SESSION['nom'] = $userinfo['nom'];
            $_SESSION['prenom'] = $userinfo['prenom'];            
            $_SESSION['ville'] = $userinfo['ville'];
            $_SESSION['cp'] = $userinfo['cp'];
    ?>  
        Votre nom est : <?php echo $userinfo['nom']; ?>
        <br><br>
        Votre prenom est :<?php echo $userinfo['prenom']; ?>
        <br><br>
        Votre ville est : <?php echo $userinfo['ville']; ?>
        <br><br>
        Votre code poste est : <?php echo $userinfo['cp']; ?>
    
    </div>
    <?php
            }
    ?>
</body>
</html>