
<?php
    session_start();
    include ('connexion_bdd.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Resultat de recherche</title>
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
<div class=backgroud-body>
        <div class="container-fluid">
            <header class="row align-items-center">
                <h1 class="col-auto m-0 p-0 logo">EAT <span class="word-color">MyPhp</span> FOOD</a></h1>
                <nav class="col-auto ml-auto">
                    <ul class="row  justify-content-between my-0">
                        <li class="col-auto cool-link"><a href="#">Se deconnecter</a></li>
                        <li class="col-auto cool-link"><a href="#">Inscription</a></li>
                        <li class="col-auto cool-link"><a href="#">Commander</a></li>
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

                                
                        if (isset($_POST['ajouter'])) {
                            $qty = intval ($_POST['quantity']);
                            $client = $_SESSION['id_client'];
                            $plat_aj = $_POST['id_plat'];


                            if (!empty($qty))  {

                                $reqPlatAj = $bdd -> query("SELECT Prix FROM `plat` WHERE id_plat =". $plat_aj ."" );
                                $data=  $reqPlatAj->fetch();
                                $facture = $data ['Prix'] * $qty ;

                                $date = date("Y-m-d");
    
                                $insertQty= $bdd->prepare("INSERT INTO ajout_panier(cle_client, cle_plat_aj, quantite, facture, date) VALUES (?, ?, ?, ? , ?) ");
                                $insertQty-> execute(array($client, $plat_aj, $qty, $facture, $date));
                                
                                echo '<h1 class="annonce"> Votre plat a bien été ajouté <br>au panier</h1>'
                                    
                    ?>

                                <form method="POST" action="commande.php<?php echo "?id=". $_SESSION['id_client'] ;?>">
                                    <input type="submit" name="connexion" value ="Retour" id="connexion"/>       
                                </form> 

                    <?php

                            ;
                            }else {
                                echo ' Merci d\'indiquer une quantité '

                    ?>
                            <form method="POST" action="commande.php<?php echo "?id=". $_SESSION['id_client'] ;?>">
                                <input type="submit" name="connexion" value ="Retour" id="connexion"/>       
                            </form> 

                    <?php
                            ;
                            }
                        }

                    ?>

                    
                 </section>   
            </div>
        </div>
    </div>






</div>





