
<?php
    session_start();
    include ('connexion_bdd.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Produit ajouté</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style\main_style.css?<?php echo filemtime('style\main_style.css');?>" />
</head>


<body>
<div class=backgroud-body>
        <div class="container-fluid">
            <header class="row align-items-center">
                <h1 class="col-auto m-0 p-0 logo">EAT <span class="word-color">MyPhp</span> FOOD</a></h1>
                <nav class="col-auto ml-auto">
                    <ul class="row  justify-content-between my-0">
                        <li class="col-auto cool-link"><a href="#">Se deconnecter</a></li>
                        <li class="col-auto cool-link"><a href="commande.php<?php echo "?id=". $_SESSION['id_client'] ; ?>">Commander</a></li>
                    </ul>
                </nav>
            </header>
        </div>





        

        <div style="height: 100vh;" class="row container-fluid d-flex align-items-center justify-content-start">
        
            <div class="window">
            <h1 class="welcome annonce">Et hop c'est dans la <span class="word-color"> poche!</span></h1>


                <section class="">

                    <?php
                        if (isset($_GET['id']) AND $_GET['id'] > 0) 
                            {
                                $getId = intval($_GET['id']);
                                $reqUser = $bdd -> prepare("SELECT * FROM members WHERE id_client = ?");
                                $reqUser->execute(array($getId));
                                $userInfo= $reqUser -> fetch();
                            }

                                
                        if (isset($_POST['delete'])) {
                            $qty = intval ($_POST['quantity']);
                            $client = $_SESSION['id_client'];
                            $plat_aj = $_POST['id_plat']; 


                            if ($qty == 1){
                                $delPlat = $bdd-> prepare(
                                        "DELETE FROM ajout_panier 
                                        WHERE cle_plat_aj =". $plat_aj ."" );
                                
                                $delPlat-> execute(array($plat_aj));
                                echo '<h1 class="annonce"> Votre plat a bien été supprimer <br>du panier</h1>';
                            
                              
                            }else{
                                $upQty = $bdd -> prepare (
                                        "UPDATE ajout_panier 
                                        SET quantite =' ". $qty ."'WHERE cle_plat_aj =". $plat_aj . "");
                                       
                                        $upQty -> execute (array($qty, $plat_aj));
                                        echo '<h1 class="annonce"> Votre quantité a bien été <br>modifié</h1>';      

                         
                       
                        }
                                    
                    ?>

                                <form method="POST" action="commande.php<?php echo "?id=". $_SESSION['id_client'] ;?>">
                                    <input type="submit" name="connexion" value ="Retour" id="connexion"/>       
                                </form> 

                                <form method="POST" action="panier.php<?php echo "?id=". $_SESSION['id_client'] ;?>">
                                    <input type="submit" name="panier" value ="Visualiser votre panier" id="connexion"/>       
                                </form> 

                    <?php

                            ;
                            }else {
                                echo ' Merci d\'indiquer une quantité '

                    ?>
                            <form method="POST" action="commande.php<?php echo "?id=". $_SESSION['id_client'] ;?>">
                            <div>
                                <input type="hidden" name="id_plat" value="<?php echo $data['id']; ?>">
                            </div>
                                <input type="submit" name="connexion" value ="Retour" id="connexion"/>       
                            </form> 

                    <?php
                            ;
                            }
                        

                    ?>

                    
                 </section>   
            </div>
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


</body>

