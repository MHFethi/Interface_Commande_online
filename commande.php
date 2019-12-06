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
    <title>Commandez votre plat</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

      <link rel="stylesheet" href="style\commande_style.css" />

</head>


<body>
<div class="container-fluid">
<header class="row align-items-center">
                    <h1 class="col-auto m-0 p-0"><a href="#">Food-PHP</a></h1>
                    <nav class="col-auto ml-auto">
                        <ul class="row  justify-content-between my-0">
                            <li class="col-auto cool-link"><a href="connexion_membres.php">Connexion</a></li>
                            <li class="col-auto cool-link"><a href="#"">Commande</a></li>
                            <li class="col-auto cool-link"><a href="#">Mon panier</a></li>
                        </ul>
                    </nav>
                </header>

<h1 class='text-center'>Bienvenue <?php echo $userInfo['pseudo']; ?> </h1> <br/>    
        <div class="fenetre ">
            <section class="d-flex justify-content-center" >
                <form method="post" action="">
                    <p> 
                        <input type="text" name="search" id="list_plat" placeholder="Recherche un plat"/> 
                        <input type="submit" name="result_search" value ="Go" class="btn btn-primary btn-sm"/>
                    </p> 
                </form>
            </section>


            <section class="d-flex justify-content-center">
                <form method="post" action="">
                <p>Liste des plats contenant les ingrédient suivant :
                    <select name="ingredient" id="list_ing">
                        <option value="Boeuf">Boeuf</option>
                        <option value="Poulet">Poulet Roti</option>
                        <option value="Merguez">Merguez</option>
                        <option value="Crevette">Crevette</option>
                        <option value="Legumes">Légumes</option>
                        <option value="Salade">Salade</option>
                        <option value="Tomate">Tomate</option>
                        <option value="Nouille">Nouilles de blé</option>
                        <option value="Couscous">Grains de couscous</option>
                        <option value="Citron">Citron confits</option>
                        <option value="Olives">Olives</option>
                        <option value="Raisins">Raisins secs</option>
                        <option value="Cornichons">Cornichons</option>
                        <option value="Emmental">Emmental</option>
                        <option value="Mozzarella">Mozzarella</option>
                        <option value="Cheddar">Cheddar</option>
                        <option value="Sauce_Poivre">Sauce au poivre</option>
                        <option value="Sauce_Teri">Sauce Teriyaki</option>
                        <option value="Sauce_Barbec">Sauce Barbecue</option>
                        <option value="Sauce_Tomate">Sauce Tomate</option>
                    </select>
                    <input type="submit" name="list_ing" value ="Go" class="btn btn-primary btn-sm"/>
                </p> 
                </form>
            </section>


            <section class="d-flex justify-content-center">
                <form method="post" action="">
                    <p>
                        <input type="text" name="prix_mini" placeholder="Prix mini" id="prix_mini"/> 
                        <input type="text" name="prix_max" placeholder="Prix max"id="prix_max"/>
                        <input type="submit" name="prix_result" value ="recherche" class="btn btn-primary btn-sm"/>
                </p>
                </form>
            </section>


        
            <section class="d-flex justify-content-center">
                <form action="" method='post'>
                    <p>Spécialité: 
                            <select name="specialite" id="list_ing">
                                <option value="Italien">Italien</option>
                                <option value="Oriental">Oriental</option>
                                <option value="Americain">Americain</option>
                                <option value="Japonais">Japonais</option>
                            </select>
                        <input type="submit" name="origine" value ="Go" class="btn btn-primary btn-sm"/>
                    </p> 
                </form>
            </section>     

            <br>
                                   
            <p class="d-flex justify-content-center"><input type="submit" name="Visualiser" value ="Visualiser commande" class="btn btn-primary btn-sm"/></p>
        </div>
    </div>






<section class="mt-5">
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
                $reqPlat = $bdd -> query("SELECT plat.libelle AS `Nom plat`, type.type AS type, plat.prix AS prix, specialite.nom_pays AS specialite , 
                GROUP_CONCAT(ingredient.libelle SEPARATOR ', ') AS ingredient FROM recette 
                INNER JOIN plat ON plat.id_plat = recette.cle_plat INNER JOIN specialite on plat.specialite = specialite.id_specialite 
                INNER JOIN ingredient ON ingredient.id_ingredient = recette.cle_ingredient INNER JOIN type ON plat.type = type.id_type WHERE plat.libelle 
                LIKE '%" . $searchVerif . "%' GROUP BY id_plat");
    // On declare une variale qui va excuter une req SQL qui va consister a compter le npmbre du resultat de la requete 
                $platExist = $reqPlat -> rowCount();
    // Si le resultat de la requete est egale a 0 alors on affiche "Plat inexistant" sinon on affiche le resultat de la recherche grace a une boucle while 
    // qui nous permettra d'afficher plusieurs donnée d'une requete de recherche et dans laquelle on declare une variable qui aura pour valeur le resultat de la requete 
                if ($platExist == 0){
                    echo '<p class="text-center font-weight-bold text-danger">Plat inexistant</p>';                
                }
                else{

                    ?>

                    <h1 class='text-center'>Votre recherche:</h1>
                    <div class="text-center text-danger"><?php echo $searchVerif ?></div> 
        
        
                    <?php
                    while ($data = $reqPlat -> fetch()) {

?>

<!-- 
////////////////////////////////////////////////////////////////////////// CODE HTML POUR AFFICHER RESULTAT RECHERCHE MOT CLES ///////////////////////////////////////////////////////////////////// 
-->
                        <div class="container mb-4 rounded ">
                            <div class="p-3 contentConnexion text-left">
                                
                                <p>
                                    <span class='font-weight-bold'>Nom: </span>
                                    <span><?php echo $data['Nom plat']?></span> 
                                </p>
                                <p>
                                    <span class='font-weight-bold'>Prix:</span>
                                    <span><?php echo $data['prix']?> euros</span> 
                                </p>
                                <p>
                                    <span class='font-weight-bold'>Specialité: </span
                                    ><span><?php echo $data['specialite']?></span> 
                                </p>
                                <p>
                                    <span class='font-weight-bold'>Ingredient: </span>
                                    <span><?php echo $data['ingredient']?></span> 
                                </p>
                                <p>
                                    <span class='font-weight-bold'>Type: </span>
                                    <span><?php echo $data['type']?></span> 
                                </p>  
                            </div>
                        </div>

<!-- 
/////////////////////////////////////////////////////////////////////////////////////// REPRISE DE L'ALGO REQ MOT CLES  /////////////////////////////////////////////////////////////////////////////// 
-->

<?php
                } 
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
        $reqIng = $bdd -> query("SELECT plat.libelle AS `Nom plat`, type.type AS type, plat.prix AS prix, specialite.nom_pays AS specialite , 
        GROUP_CONCAT(ingredient.libelle SEPARATOR ', ') AS ingredient FROM recette 
        INNER JOIN plat ON plat.id_plat = recette.cle_plat
        INNER JOIN specialite on plat.specialite = specialite.id_specialite 
        INNER JOIN ingredient ON ingredient.id_ingredient = recette.cle_ingredient 
        INNER JOIN type ON plat.type = type.id_type 
        GROUP BY id_plat HAVING GROUP_CONCAT(ingredient.libelle SEPARATOR ', ') LIKE '%" . $ingredient . "%'");
        $ingExist = $reqIng -> rowCount();
        if ($ingExist != 0){
            ?>

            <h1 class='text-center'>Votre recherche:</h1>
            <div class="text-center text-danger"><?php echo $ingredient?></div> <br/>


            <?php
            while ($data = $reqIng -> fetch()) {
                ?>
                <!-- 
//////////////////////////////////////////////////////////////////////// CODE HTML POUR AFFICHER RESULTAT RECHERCHE ING ///////////////////////////////////////////////////////////////////// 
-->


        <div class="container mb-4 rounded ">
                <div class="p-3 contentConnexion text-left">

                    <p>
                        <span class='font-weight-bold'>Nom: </span>
                        <span><?php echo $data['Nom plat']?></span> 
                    </p>

                    <p>
                        <span class='font-weight-bold'>Prix:</span>
                        <span><?php echo $data['ingredient']?></span> 
                    </p>
                </div>
        </div>
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
                $reqPrix = $bdd -> query("SELECT plat.libelle AS `Nom plat`, type.type AS type, plat.prix AS prix, specialite.nom_pays AS specialite , 
                GROUP_CONCAT(ingredient.libelle SEPARATOR ', ') AS ingredient FROM recette 
                INNER JOIN plat ON plat.id_plat = recette.cle_plat INNER JOIN specialite on plat.specialite = specialite.id_specialite 
                INNER JOIN ingredient ON ingredient.id_ingredient = recette.cle_ingredient INNER JOIN type ON plat.type = type.id_type 
                WHERE plat.Prix BETWEEN '$prix_mini_verif' AND '$prix_max_verif' GROUP BY id_plat");
                $prixExist = $reqPrix -> rowCount();
                    if ($prixExist != 0){
                        ?>

                        <h1 class='text-center'>Votre recherche: </h1>
                        <div class="text-center text-danger"><?php echo "entre ".$prix_mini_verif . " euros et " . $prix_max_verif. "euros"?></div> <br/>

            
                        <?php
                        while ($data = $reqPrix -> fetch()) {
?>
                            <div class="container mb-4 rounded ">
                                <div class="p-3 contentConnexion text-left">
                                    <p>
                                        <span class='font-weight-bold'>Nom: </span>
                                        <span><?php echo $data['Nom plat']?></span> 
                                    </p>

                                    <p>
                                        <span class='font-weight-bold'>Prix:</span>
                                        <span><?php echo $data['prix']?> euros</span> 
                                    </p>
                                </div>
                            </div>
                            <?php
                        }

                    }else{
                            echo '<p class="text-center font-weight-bold text-danger">Aucun plat ne correspond a ces prix</p>';               
                    }   
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
        $reqSpe = $bdd -> query("SELECT plat.libelle AS `Nom plat`, type.type AS type, plat.prix AS prix, specialite.nom_pays AS specialite , 
        GROUP_CONCAT(ingredient.libelle SEPARATOR ', ') AS ingredient FROM recette 
        INNER JOIN plat ON plat.id_plat = recette.cle_plat
        INNER JOIN specialite on plat.specialite = specialite.id_specialite 
        INNER JOIN ingredient ON ingredient.id_ingredient = recette.cle_ingredient 
        INNER JOIN type ON plat.type = type.id_type 
        WHERE specialite.nom_pays = '$specialite' GROUP BY id_plat");
        $speExist = $reqSpe -> rowCount();
        if ($speExist != 0){
            ?>

            <h1 class='text-center'>Votre recherche: </h1>
            <div class="text-center text-danger"><?php echo $specialite?></div> <br/>


            <?php
            while ($data = $reqSpe -> fetch()) {
                ?>
<!-- 
//////////////////////////////////////////////////////////////////////// CODE HTML POUR AFFICHER RESULTAT RECHERCHE SPE ///////////////////////////////////////////////////////////////////// 
-->

        <div class="container mb-4 rounded ">
                <div class="p-3 contentConnexion text-left">
                    <p>
                        <span class='font-weight-bold'>Nom: </span>
                        <span><?php echo $data['Nom plat']?></span> 
                    </p>

                    <p>
                        <span class='font-weight-bold'>Prix:</span>
                        <span><?php echo $data['specialite']?></span> 
                    </p>
                </div>
        </div>
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


</section>

</body>

</html>