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



    <!-- 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////// CODE PHP POUR RECHERCHE PAR MOT CLES //////////////////////////////////////////////////////////////////////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-->
<?php
    if (isset ($_POST['search'])) {
        $searchVerif = htmlspecialchars($_POST['search']);
    // Premiere condition qui vérifie que le champs de recherche de mot est rempli
            if (!empty($searchVerif)) {
    // On declare une variable qui va faire une requete SQL . Celui va aller selectionner des données
                $reqPlat = $bdd -> query("SELECT plat.libelle AS `Nom plat`, type.type AS type, plat.prix AS prix, specialite.nom_pays AS specialite, plat.img AS `image`, plat.id_plat AS id,
                GROUP_CONCAT(ingredient.libelle SEPARATOR ', ') AS ingredient FROM recette 
                INNER JOIN plat ON plat.id_plat = recette.cle_plat 
                INNER JOIN specialite on plat.specialite = specialite.id_specialite 
                INNER JOIN ingredient ON ingredient.id_ingredient = recette.cle_ingredient 
                INNER JOIN type ON plat.type = type.id_type 
                WHERE plat.libelle 
                LIKE '%" . $searchVerif . "%' GROUP BY id_plat");
    // On declare une variale qui va excuter une req SQL qui va consister a compter le npmbre du resultat de la requete 
                $platExist = $reqPlat -> rowCount();
    // Si le resultat de la requete est egale a 0 alors on affiche "Plat inexistant" sinon on affiche le resultat de la recherche grace a une boucle while 
    // qui nous permettra d'afficher plusieurs donnée d'une requete de recherche et dans laquelle on declare une variable qui aura pour valeur le resultat de la requete 
                if ($platExist >=  1){
                    ?>

                        <h1 class='text-center font-weight-bold'>Résultats de recherche: </h1><br/>
                        <div class="text-center text-danger"><?php echo $searchVerif; ?></div> <br/>

                    <?php

                    while ($data = $reqPlat -> fetch()) {

                    ?>

<!-- 
////////////////////////////////////////////////////////////////////////// CODE HTML POUR AFFICHER RESULTAT RECHERCHE MOT CLES ///////////////////////////////////////////////////////////////////// 
-->
            <section class="result-win d-flex container mx-auto mt-5">  


                <div class="d-flex align-items-start flex-column bd-highlight  p-2" style="height: 300px;">
                    <div class="p-2  bd-highlight">
                
                        <?php echo "<span = class='product-name'>" .  $data['Nom plat']. " - ". "<span = class='specialite'>". $data['specialite']."</span> </span>" ?> 
                    </div>

                    <div class="p-2  bd-highlight">
                        <?php echo "<span = class='product-describe'>" .  $data['ingredient'] ."</span> " ?> 
                    </div>

                    <div class="p-2 mt-auto bd-highlight">
                        <?php echo "<span = class='product-price'>" .  $data['prix'] ." €</span> " ?> 
                    </div>
                </div>


                <div class="d-flex flex-column align-items-center product-detail">
                   
                    <div class="mb-auto p-2 bd-highlight">
                        <span><?php echo "<img src ='". $data['image']."'></img>" ?></span> 
                    </div>


                    <div class="">
                        <form method="POST" action="ajout_panier.php<?php echo "?id=". $_SESSION['id_client'] ;?>"  >

                            <div class="mb-3 p-2 ml-5 bd-highlight">
                                <input type="number" id="number" width="5%" step="1" name='quantity' />
                            </div>

                            <div>
                                <input type="hidden" name="id_plat" value="<?php echo $data['id']; ?>">
                            </div>

                            <div class="mt-auto p-2 bd-highlight">
                                <input type="submit" name="ajouter" value="Ajouter au panier" class="btn-ajouter" />
                            </div>

                        </form>

                    </div>

                </div>

            </section>
                
    
<!-- 
/////////////////////////////////////////////////////////////////////////////////////// REPRISE DE L'ALGO REQ MOT CLES  /////////////////////////////////////////////////////////////////////////////// 
-->

<?php
                }  

            }else{
                echo '<p class="text-center font-weight-bold text-danger">Plat inexistant</p>';                 
            }
        }else{
            echo '<p class="text-center font-weight-bold text-danger">Veuillez saisir une recherche</p>';               
        }

    }      

?>





<!-- 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////// CODE PHP POUR RECHERCHE PAR INGREDIENT ///////////////////////////////////////////////////////////////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
NOTE URGENT:
    !! PENSEZ A COMMENTER LES ETAPES DE L'ALGO !!
-->
<?php
    if (isset($_POST['ingredient'])){
        $ingredient = $_POST['ingredient'];
        $reqIng = $bdd -> query("SELECT plat.libelle AS `Nom plat`, type.type AS type, plat.prix AS prix, specialite.nom_pays AS specialite , plat.img AS `image`, plat.id_plat AS id,
        GROUP_CONCAT(ingredient.libelle SEPARATOR ', ') AS ingredient FROM recette 
        INNER JOIN plat ON plat.id_plat = recette.cle_plat
        INNER JOIN specialite on plat.specialite = specialite.id_specialite 
        INNER JOIN ingredient ON ingredient.id_ingredient = recette.cle_ingredient 
        INNER JOIN type ON plat.type = type.id_type 
        GROUP BY id_plat HAVING GROUP_CONCAT(ingredient.libelle SEPARATOR ', ') LIKE '%" . $ingredient . "%'");
        $ingExist = $reqIng -> rowCount();
        if ($ingExist != 0){
            ?>
            <h1 class='text-center font-weight-bold'>Résultats de recherche:</h1>
            <div class="text-center text-danger"><?php echo $ingredient?></div> <br/>
            <?php
            while ($data = $reqIng -> fetch()) {
                ?>


<!-- 
//////////////////////////////////////////////////////////////////////// CODE HTML POUR AFFICHER RESULTAT RECHERCHE ING ///////////////////////////////////////////////////////////////////// 
-->

<section class="result-win d-flex container mx-auto mb-5">  


<div class="d-flex align-items-start flex-column bd-highlight  p-2" style="height: 300px;">
    <div class="p-2  bd-highlight">

        <?php echo "<span = class='product-name'>" .  $data['Nom plat']. " - ". "<span = class='specialite'>". $data['specialite']."</span> </span>" ?> 
    </div>

    <div class="p-2  bd-highlight">
        <?php echo "<span = class='product-describe'>" .  $data['ingredient'] ."</span> " ?> 
    </div>

    <div class="p-2 mt-auto bd-highlight">
        <?php echo "<span = class='product-price'>" .  $data['prix'] ." €</span> " ?> 
    </div>
</div>


<div class="d-flex flex-column align-items-center product-detail">
   
    <div class="mb-auto p-2 bd-highlight">
        <span><?php echo "<img src ='". $data['image']."'></img>" ?></span> 
    </div>


    <div class="">
        <form method="POST" action="ajout_panier.php<?php echo "?id=". $_SESSION['id_client'] ;?>"  >

            <div class="mb-3 p-2 ml-5 bd-highlight">
                <input type="number" id="number" width="5%" step="1" name='quantity' />
            </div>

            <div>
                <input type="hidden" name="id_plat" value="<?php echo $data['id']; ?>">
            </div>

            <div class="mt-auto p-2 bd-highlight">
                <input type="submit" name="ajouter" value="Ajouter au panier" class="btn-ajouter" />
            </div>

        </form>

    </div>

</div>

</section>
<!--
///////////////////////////////////////////////////////////////////////////////// REPRISE DE L'ALGO REQ ING /////////////////////////////////////////////////////////////////////////////// 
-->
        <?php
            }
        }else{  
            echo '<p class="text-center font-weight-bold text-danger">Aucun plat n\'a été trouver pour cette spécialité</p>';                
            }
        }
?>







<!-- 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////// CODE PHP POUR RECHERCHE PAR SPECIALITE ///////////////////////////////////////////////////////////////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
NOTE URGENT:
    !! PENSEZ A COMMENTER LES ETAPES DE L'ALGO !!
-->
<?php
    if (isset($_POST['specialite'])){
        $specialite = $_POST['specialite'];
        $reqSpe = $bdd -> query("SELECT plat.libelle AS `Nom plat`, type.type AS type, plat.prix AS prix, specialite.nom_pays AS specialite ,  plat.img AS `image`, plat.id_plat AS id,
        GROUP_CONCAT(ingredient.libelle SEPARATOR ', ') AS ingredient FROM recette 
        INNER JOIN plat ON plat.id_plat = recette.cle_plat
        INNER JOIN specialite on plat.specialite = specialite.id_specialite 
        INNER JOIN ingredient ON ingredient.id_ingredient = recette.cle_ingredient 
        INNER JOIN type ON plat.type = type.id_type 
        WHERE specialite.nom_pays = '$specialite' GROUP BY id_plat");
        $speExist = $reqSpe -> rowCount();
        if ($speExist != 0){
            ?>
            <h1 class='text-center font-weight-bold'>Résultats de recherche: </h1>
            <div class="text-center text-danger"><?php echo $specialite?></div> <br/>
            <?php
            while ($data = $reqSpe -> fetch()) {
                ?>
<!-- 
//////////////////////////////////////////////////////////////////////// CODE HTML POUR AFFICHER RESULTAT RECHERCHE SPE ///////////////////////////////////////////////////////////////////// 
-->
<section class="result-win d-flex container mx-auto mb-5">  


<div class="d-flex align-items-start flex-column bd-highlight  p-2" style="height: 300px;">
    <div class="p-2  bd-highlight">

        <?php echo "<span = class='product-name'>" .  $data['Nom plat']. " - ". "<span = class='specialite'>". $data['specialite']."</span> </span>" ?> 
    </div>

    <div class="p-2  bd-highlight">
        <?php echo "<span = class='product-describe'>" .  $data['ingredient'] ."</span> " ?> 
    </div>

    <div class="p-2 mt-auto bd-highlight">
        <?php echo "<span = class='product-price'>" .  $data['prix'] ." €</span> " ?> 
    </div>
</div>


<div class="d-flex flex-column align-items-center product-detail">
   
    <div class="mb-auto p-2 bd-highlight">
        <span><?php echo "<img src ='". $data['image']."'></img>" ?></span> 
    </div>


    <div class="">
        <form method="POST" action="ajout_panier.php<?php echo "?id=". $_SESSION['id_client'] ;?>"  >

            <div class="mb-3 p-2 ml-5 bd-highlight">
                <input type="number" id="number" width="5%" step="1" name='quantity' />
            </div>

            <div>
                <input type="hidden" name="id_plat" value="<?php echo $data['id']; ?>">
            </div>

            <div class="mt-auto p-2 bd-highlight">
                <input type="submit" name="ajouter" value="Ajouter au panier" class="btn-ajouter" />
            </div>

        </form>

    </div>

</div>

</section>
        
<!--
///////////////////////////////////////////////////////////////////////////////// REPRISE DE L'ALGO REQ SPE /////////////////////////////////////////////////////////////////////////////// 
-->
        <?php
            }
        }else{  
            echo '<p class="text-center font-weight-bold text-danger">Aucun plat n\'a été trouver pour cette spécialité</p>';                
            }
        }
?>





<!-- 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////// CODE PHP POUR RECHERCHE PAR PRIX MINI ET PRIX MAX ///////////////////////////////////////////////////////////////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
NOTE URGENT:    
    !! PENSEZ A COMMENTER LES ETAPES DE L'ALGO !!
-->
<?php
    if (isset($_POST['prix_result'])){
        $prix_max_verif = intval($_POST['prix_max']);
        $prix_mini_verif = intval($_POST['prix_mini']);
            if (isset($prix_mini_verif) AND  isset($prix_max_verif))  {
                $reqPrix = $bdd -> query("SELECT plat.libelle AS `Nom plat`, type.type AS type, plat.prix AS prix, specialite.nom_pays AS specialite ,  plat.img AS `image`, plat.id_plat AS id,
                GROUP_CONCAT(ingredient.libelle SEPARATOR ', ') AS ingredient FROM recette 
                INNER JOIN plat ON plat.id_plat = recette.cle_plat INNER JOIN specialite on plat.specialite = specialite.id_specialite 
                INNER JOIN ingredient ON ingredient.id_ingredient = recette.cle_ingredient INNER JOIN type ON plat.type = type.id_type 
                WHERE plat.Prix BETWEEN '$prix_mini_verif' AND '$prix_max_verif' GROUP BY id_plat");
                $prixExist = $reqPrix -> rowCount();
                    if ($prixExist != 0){
                        ?>
                        <h1 class='text-center font-weight-bold'>Résultats de recherche:</h1>
                        <div class="text-center text-danger"><?php echo "entre ".$prix_mini_verif . " € et " . $prix_max_verif. " €"?></div> <br/>
            
                        <?php
                        while ($data = $reqPrix -> fetch()) {
?>

<!-- 
//////////////////////////////////////////////////////////////////////// CODE HTML POUR AFFICHER RESULTAT RECHERCHE PRIX ///////////////////////////////////////////////////////////////////// 
-->

<section class="result-win d-flex container mx-auto mb-5">  


<div class="d-flex align-items-start flex-column bd-highlight  p-2" style="height: 300px;">
    <div class="p-2  bd-highlight">

        <?php echo "<span = class='product-name'>" .  $data['Nom plat']. " - ". "<span = class='specialite'>". $data['specialite']."</span> </span>" ?> 
    </div>

    <div class="p-2  bd-highlight">
        <?php echo "<span = class='product-describe'>" .  $data['ingredient'] ."</span> " ?> 
    </div>

    <div class="p-2 mt-auto bd-highlight">
        <?php echo "<span = class='product-price'>" .  $data['prix'] ." €</span> " ?> 
    </div>
</div>


<div class="d-flex flex-column align-items-center product-detail">
   
    <div class="mb-auto p-2 bd-highlight">
        <span><?php echo "<img src ='". $data['image']."'></img>" ?></span> 
    </div>


    <div class="">
        <form method="POST" action="ajout_panier.php<?php echo "?id=". $_SESSION['id_client'] ;?>"  >

            <div class="mb-3 p-2 ml-5 bd-highlight">
                <input type="number" id="number" width="5%" step="1" name='quantity' />
            </div>

            <div>
                <input type="hidden" name="id_plat" value="<?php echo $data['id']; ?>">
            </div>

            <div class="mt-auto p-2 bd-highlight">
                <input type="submit" name="ajouter" value="Ajouter au panier" class="btn-ajouter" />
            </div>

        </form>

    </div>

</div>

</section>

<!--
///////////////////////////////////////////////////////////////////////////////// REPRISE DE L'ALGO REQ PRIX /////////////////////////////////////////////////////////////////////////////// 
-->
                            <?php
                        }
                    }else{
                            echo '<p class="text-center font-weight-bold text-danger">Aucun plat ne correspond a ces prix</p>';               
                    }   
            }
    }
                ?>

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
</body>
</html>