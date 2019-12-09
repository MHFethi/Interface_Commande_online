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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style\main_style.css" />

</head>





<body>
    <div class=backgroud-body-connexion>
        <div class="container-fluid">
            <header class="row align-items-center">
                <h1 class="col-auto m-0 p-0 logo">EAT <span class="word-color">MyPhp</span> FOOD</a></h1>
                <nav class="col-auto ml-auto">
                    <ul class="row  justify-content-between my-0">
                        <li class="col-auto cool-link"><a href="#">Inscription</a></li>
                        <li class="col-auto cool-link"><a href="#">Ma commande</a></li>
                    </ul>
                </nav>
            </header>
        </div>



        <div style="height: 100vh;" class="row container-fluid d-flex align-items-center justify-content-start">
        
            <div class="window">
                <h1 class="welcome"><span class="word-color">Connectez-vous !</h1>

                <h1 class="annonce">Commander vos plats préféres <br> en un clic</h1>

                <section class="search-conn p-4">
                    <form method="POST" action="">
                        <input type="text" name="pseudoConnect" placeholder="Votre pseudo" id="pseudo"/>  
                            <br/>
                        <input type="password" name="passwordConnect" placeholder="   Votre mot de passe" id="mdp"/>  
                            <br/> <br/>

                            <?php
                                if (isset($erreur))
                                {
                                    echo '<font color="red">'.$erreur."</font>";
                                }
                            ?>   

                        <input type="submit" name="connexion" value ="Se connecter" id="connexion"/>
                           
                    </form> 
          
            <p class="text-center pt-5">Pas encore inscrit ?
        <a href='Inscription.php'>Créer un compte</a></p>
                 </section>   
            </div>
        </div>
    </div>
  

<footer class="row d-flex justify-content-center align-items-center">
            <div class=f-wind1>
                <h2>Découvrir Eat MyPHP FOOD</h2>
                <ul>
                    <li>A propos</li>
                    <li>Ils en parlent</li>
                    <li>Nous rejoindre</li>
                </ul>

                <div class="m-2">
                    <img src="img\Facebook.png" alt="google_play" />
                    <img src="img\instagram.png" alt="App Store" />
                </div>
            </div>


            <div class=f-wind2>
                <h2>Mention légale</h2>
                <ul>
                    <li>Mentions légales</li>
                    <li>Confidentialité</li>
                    <li>Cookies</li>
                </ul>
            </div>


            <div class=f-wind3>
                <h2>Besoin d'aide</h2>
                <ul>
                    <li>Nous contacter</li>
                    <li>FAQ</li>
                    <li>Types de cuisine</li>
                    <li>Plan du site</li>
                </ul>
            </div>


            <div class=f-wind4>
                <h2>Garder Eat MyPHP Food partout</h2>
                <ul>
                    <li> <img src="img\icone_google-play.png" alt="google_play" /></li>
                    <li> <img src="img\icone_app-store.png" alt="App Store" /></li>
                </ul>
            </div>
        </footer>
        <!-- Script for contact window slide -->
        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "450px";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
            }

        </script>
</body>

</html>