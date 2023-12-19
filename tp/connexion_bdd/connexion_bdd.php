<?php
    $host='localhost';
    $dbname='tp';
    $username='root';
    $password='';

    try{
        $DB = new PDO("mysql:host=$host;dbname=$dbname","$username","$password");
        //echo "vous êtes connecter a la base de données ";
    }
    catch(PDOException $e){
        die("impossible de se connecter à la base de données ". $e->getMessage());
    }

    function getStockDisponible($id_piece) {
        global $DB;  // Utilise la variable globale $DB à l'intérieur de la fonction
        // Remplacez ce code par la logique pour récupérer le stock disponible depuis la base de données
        $sql = 'SELECT stock FROM piece WHERE id_piece = :id_piece';
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(':id_piece', $id_piece, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result['stock'];
    }
?> 