
<?php
    session_start();
    include ('connexion_bdd.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Votre panier</title>
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

            <?php
                if (isset($_POST['panier'])) {
                    $client = $_SESSION['id_client'];

                        $reqPlatCom = $bdd -> query("SELECT plat.libelle AS `Nom plat`, 
                        plat.img AS `image`,
                        plat.Prix AS prix,  
                        ajout_panier.quantite AS quantite, 
                        plat.id_plat AS 'id',
                        ajout_panier.total AS `Total`
                        FROM ajout_panier
                        INNER JOIN plat ON id_plat = cle_plat_aj" );
                        $CommExist = $reqPlatCom -> rowCount();
                           if ($CommExist >=  1){
                                        ?>
                    
                                            <h1 class='text-center font-weight-bold'>Votre panier: </h1><br/>
                    
                                        <?php
                    
                                        while ($data = $reqPlatCom -> fetch()) {
                    
                                        ?>
<!-- 
////////////////////////////////////////////////////////////////////////// CODE HTML POUR AFFICHER PANIER ///////////////////////////////////////////////////////////////////// 
-->
        <section class="result-win d-flex container mx-auto mt-5">  


            <div class="d-flex align-items-start flex-column bd-highlight  p-2" style="height: 300px;">
                <div class="p-2  bd-highlight">

                    <?php echo "<span = class='product-name'>" .  $data['Nom plat']. " </span>" ?> 
                </div>

                <div class="p-2  bd-highlight">
                    <?php echo "<span = class='product-describe'>Quantité: " .  $data['quantite'] ."</span> " ?> 
                </div>

                <div class="p-2 mt-auto bd-highlight">
                    <?php echo "<span = class='product-price'>Prix unitaire: " .  $data['prix'] ." €</span> " ?> 
                </div>

                <input type="hidden" name="id_plat" value="<?php echo $data['id']; ?>"> 
                               
                <div class="p-2 mt-auto bd-highlight">
                    <?php echo "<span = class='product-price'>Prix total: " .  $data['Total'] ." €</span> " ?> 
                </div>

            </div>


            <div class="d-flex flex-column align-items-center product-detail">
            
                <div class="mb-auto p-2 bd-highlight">
                    <span><?php echo "<img src ='". $data['image']."'></img>" ?></span> 
                </div>





            <div class="">
                        <form method="POST" action="delete-product.php<?php echo "?id=". $_SESSION['id_client'] ;?>"  >

                        <div class="mb-3 p-2 ml-5 bd-highlight">
                            <input type="number" id="number" step="1" name='quantity' value='<?php echo $data['quantite'];?>'>
                        </div>

                            <div>
                                <input type="hidden" name="id_plat" value="<?php echo $data['id']; ?>">
                            </div>

                            <div class="mt-auto p-2 bd-highlight">
                                <input type="submit" name="delete" value="Supprimer" class="btn-ajouter" />
                            </div>

                        </form>

                    </div>

        </section>

<?php
                }
            }
          

            
        }


            

            ?>



<?php





?>
        

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









</div>
</body>




    

</html>