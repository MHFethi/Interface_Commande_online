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
                            $erreur = "Votre compte a bien été créér !<a href='connexion_membres.phpgit '>connecter</a>";
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
                        <li class="col-auto cool-link"><a href="connexion_membres.php">Se connecter</a></li>
                    </ul>
                </nav>
            </header>
        </div>



        <div style="height: 100vh;" class="row container-fluid d-flex align-items-center justify-content-start">
        
            <div class="window">
            <h1 class="welcome"><span class="word-color">Devenez </span> membre!</h1>

                <h1 class="annonce">Commander vos plats préféres <br> en un clic</h1>

                <section class="search-sub  p-4">
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






<body>


</body>

</html>