<?php
    session_start();
    include ('connexion_bdd.php');

    if (isset($_GET['id']) AND $_GET['id'] > 0) 
    {
        $getId = intval($_GET['id']);
        $reqUser = $bdd -> prepare("SELECT * FROM members WHERE id_client = ?");
        $reqUser->execute(array($getId));
        $userInfo= $reqUser -> fetch();
    }

    
if (isset($_POST['ajouter'])) {
    $qty = intval ($_POST['quantity']);
    $client = $_SESSION['id_client'];
    $plat_aj = $_POST['id_plat'];


    if (!empty($qty))  {
        $insertQty= $bdd->prepare("INSERT INTO ajout_panier(cle_client, cle_plat_aj, quantite) VALUES (?, ?, ?) ");
         $insertQty-> execute(array($client, $plat_aj, $qty));
 

         echo  "Votre produit a bien été ajouter au panier ! <a href=commande.php?id=". $_SESSION['id_client'] . ">Retour</a>";
        
    }else {
        echo  "Merci de renseigner une quantité ! <a href=commande.php?id=". $_SESSION['id_client'] . ">Retour</a>";


    }
}

?>