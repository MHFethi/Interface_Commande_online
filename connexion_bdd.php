<?php


try
{
    $bdd = new PDO('mysql:host=localhost;dbname=tp_commande_plats;charset=utf8', 'root', '');
}
catch (Exception $e)
{
        die('Erreur, impossible de se connecter à la base de donnée : ' . $e->getMessage());
}



?>
