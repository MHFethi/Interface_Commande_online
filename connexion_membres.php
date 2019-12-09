<?php
    session_start();
    include ('connexion_bdd.php');
    //1er condition: qui verifie que les champs de connexion sont remplies:,
    if (isset($_POST['connexion'])){
        $pseudoConnect = htmlspecialchars($_POST['pseudoConnect']);
        $passwordConnect = sha1($_POST['passwordConnect']);
        if (!empty($pseudoConnect) AND !empty($passwordConnect)) {
            $reqUser = $bdd->prepare('SELECT * FROM members WHERE pseudo = ? AND mot_de_passe = ? ');
            $reqUser->execute(array($pseudoConnect, $passwordConnect));
            $userExist = $reqUser -> rowCount();
            if ($userExist == 1){
                $userInfo = $reqUser -> fetch();
                $_SESSION ['id_client'] = $userInfo['id_client'];
                $_SESSION ['pseudo'] = $userInfo['pseudo'];
                $_SESSION ['mail'] = $userInfo['mail'];
                header("Location: commande.php?id=".$_SESSION['id_client']);
            }else{
                $erreur = 'Mauvais identifiant';
            }
        }else{
            $erreur = "Tout les champs doivent etre complétés";
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Authentification</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="style\style.css" />
</head>


<body>

<div class="container">
    <div class="contentConnexion">
        <h1>Connexion</h1>
        
        <?php
        if (isset($erreur))
        {
            echo '<font color="red">'.$erreur."</font>";
        }
        ?>   
        
        <form method="POST" action="">
            <p>
                <input type="text" name="pseudoConnect" placeholder="Votre pseudo" id="pseudo"/>  
                <br/>
                <input type="password" name="passwordConnect" placeholder="   Votre mot de passe" id="mdp"/>  
                <br/> <br/>
                <input type="submit" name="connexion" value ="Se connecter" id="connexion"/>
                
            </p>
        </form> 

        <p>Pas encore inscrit ?</p>
        <p><a href='Inscription.php'>Créer un compte</a></p>
     </div>
</div>

</body>

</html>