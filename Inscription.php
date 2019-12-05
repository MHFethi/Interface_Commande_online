<?php 
    include ('connexion_bdd.php');

    //Fonction qui verifie l'existance d'un pseudo dans la BDD, retourne true si le pseudo existe
    function sql_clients_exists($pseudo) {
        global $bdd;
        $sql = "SELECT 1
                FROM members
                WHERE pseudo = '$pseudo'";
        $res = $bdd->query($sql);
        $row = $res->fetch();
        return !empty($row);
        }
    //Premier condition: qui verifie que tout est en ordre dans le formulaire d'inscription 
    if (isset($_POST['inscription'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mail = htmlspecialchars($_POST['mail']);
        $password = sha1($_POST['password']);
        $password2 = sha1($_POST['password2']);
    //Deuxieme condition: qui verifie que toutes les sous-condition sont bien remplie,
    /* 
    1) Pseudo <255
    2) MDP & Confirmation de MDP sont identique
    3) Pseudo non existant dans la BDD
    Si les 3 condition sont remplies alors ont valide l'inscription et on redirige le client vers la page de commande
    */
        if(!empty($_POST['pseudo']) AND  !empty($_POST['mail']) AND !empty($_POST['password'])) {
            $pseudoLenght = strlen($pseudo);
                if ($pseudoLenght <= 255) {
                    if ($password == $password2){
                        if (sql_clients_exists($pseudo)){
                            $erreur="Cet identifiant existe déja";
                        }else{
                            $insertMbr= $bdd->prepare("INSERT INTO members(pseudo,mail,mot_de_passe) VALUES (?, ?, ?) ");
                            $insertMbr-> execute(array($pseudo,$mail,$password));
                            $erreur = "Votre compte a bien été créér !<a href='connexion_membres.php'>connecter</a>";
                            // header("location:Connexion_membres.php" ); 
                        }
                    }else{
                        $erreur="Vos mots de passe ne se correspondent pas";
                    }
                            
                }else{
                    echo 'Votre pseudo ne doit pas dépasser 255 caracteres';
                }
        }else {
            $erreur = "Tous les champs doivent être complétées";
        }
    }
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Inscription</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="style\style.css" />



</head>

<div class="container">
    <div class="contentSub">
        <h1>Inscription</h1>
        <?php
            if (isset($erreur))
            {
                echo '<font color="red">'.$erreur."</font>";
            }
        ?>
        <form method="POST" action="">
            <input type="text" placeholder="Votre pseudo" name="pseudo" id="pseudo"/>
            <input type="email" placeholder="Votre mail" name="mail" id="mail"/>
            <input type="password" placeholder="Votre mot de passe" name="password" id="mdp"/>
            <input type="password" placeholder="Confirmer votre mot de passe:" name="password2" id="mdp"/>
            <br/> <br/>
            <input type="submit" name="inscription" value="Inscription" id="subscribe"/>
        </form>

    </div>
</div>   


<body>


</body>

</html>