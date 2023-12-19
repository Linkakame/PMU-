<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/connexion.css" type='text/css' >
    <title>connexion </title>
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
                <li class="menu_il"><a  href="">Panier</a></li>
                <li class="menu_il"><a  href="">Compte</a></li>
            </ul>
        </div>
        <div id="profil">
            <img src="../image/utilisateur.png" class="img_profil">
        </div>
    </div>
    <div id="formulaire_connexion">
        <form method="POST" action="">
            <label>Login : </label>
            <input name="login" class="login"> 
            <br><br>
            <label>Password :</label>
            <input name="password" class="password">
            <br><br>
            <center><input type="submit"  name="connexion" value="se connecter"></center>
        </form>
    </div>
</body>
</html>
<?php
    session_start();
    require('../connexion_bdd/connexion_bdd.php');
    if(isset($_POST['connexion'])){
        $login = htmlentities($_POST['login']);
        $password = htmlentities($_POST['password']);
        if(!empty($login) AND !empty($password)) {
            $sql = 'SELECT * from client where login = ? AND password = ? ';
            $req = $DB->prepare($sql);
            $data = $req->execute(array($login,$password));
            $datas = $req->rowCount();
            if($datas == 1 ){
                $userinfo = $req->fetch();
                $_SESSION['id_client'] = $userinfo['id_client'];
                header("Location:profil.php?id_client=".$_SESSION['id_client']);
            }else{
                echo"Mauvais mail ou mot de passe !";
            }
        } else{
            echo"tout les champs doivent etre rempli ";
        }
    }
?>