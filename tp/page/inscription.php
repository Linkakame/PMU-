<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/inscription.css">
    <title>inscription</title>
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
            <a href="connexion.php"><img src="../image/utilisateur.png" class="img_profil"></a>
        </div>
    </div>
    <div id="formulaire_inscription">
        <form method="POST" action="">
            <label>nom : </label>
            <input name="nom" class="nom"> 
            <br><br>
            <label>prenom :</label>
            <input name="prenom" class="prenom">
            <br><br>
            <label>ville :</label>
            <input name="ville" class="ville">
            <br><br> 
            <label>code postal :</label>
            <input name="cp" class="cp">
            <br><br>
            <label>login :</label>
            <input name="login" class="login">
            <br><br>
            <label>password :</label>
            <input name="password" class="password">
            <br><br>
            <input type="submit"  name="inscription" value="s'inscrire">
        </form>
    </div>
</body>
</html>
<?php
    session_start();
    require('../connexion_bdd/connexion_bdd.php');
    if(isset($_POST['inscription'])){
        $nom = htmlentities($_POST['nom']);
        $prenom = htmlentities($_POST['prenom']);
        $ville = htmlentities($_POST['ville']);
        $cp = htmlentities($_POST['cp']);
        $login = htmlentities($_POST['login']);
        $password = htmlentities($_POST['password']);
        if(!empty($nom) AND !empty($prenom) AND !empty($ville) AND !empty($cp) AND !empty($login) AND !empty($password)){
        $sql='INSERT into client (nom,prenom,ville,cp,login,password) value (:nom,:prenom,:ville,:cp,:login,:password)';
        $req = $DB->prepare($sql);
        $data = $req->execute(array(":nom"=>$nom,":prenom"=>$prenom,":ville"=>$ville,":cp"=>$cp,":login"=>$login,":password"=>$password));
        }
    }
    exit();
?> 