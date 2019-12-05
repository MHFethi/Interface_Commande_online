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

      <link rel="stylesheet" href="style\style.css" />

</head>


<body>

<section class=''>
<h1 class="Welcome">Bienvenue <?php echo $userInfo['pseudo']; ?> </h1>
    <div class="container">
        <div class="commande">
            <h2>De quoi avez-vous envie de manger ? </h2>
                <form method="post" action="">
                    <p> 
                        <input type="text" name="search" id="list_plat" placeholder="Recherche un plat"/> 
                        <input type="submit" name="go" value ="Go" id="go"/>
                    </p> 

                    <p>Liste des plats contenant les ingrédient suivant :
                        <select name="choix_ingredient" id="list_ing">
                            <option value="choix1">Boeuf</option>
                            <option value="choix2">Poulet Roti</option>
                            <option value="choix3">Merguez</option>
                            <option value="choix4">Crevette</option>
                            <option value="choix4">Légumes</option>
                            <option value="choix4">Salade</option>
                            <option value="choix4">Tomate</option>
                            <option value="choix4">Nouilles de blé</option>
                            <option value="choix4">Grains de couscous</option>
                            <option value="choix4">Citron confits</option>
                            <option value="choix4">Olives</option>
                            <option value="choix4">Raisins secs</option>
                            <option value="choix4">Cornichons</option>
                            <option value="choix4">Emmental</option>
                            <option value="choix4">Mozzarella</option>
                            <option value="choix4">Cheddar</option>
                            <option value="choix4">Sauce au poivre</option>
                            <option value="choix4">Sauce Teriyaki</option>
                            <option value="choix4">Sauce Barbecue</option>
                            <option value="choix4">Sauce Tomate</option>
                        </select>
                        <input type="submit" name="list" value ="Go" id="go"/>
                    </p> 
                    
                
                    <p>
                        <input type="text" name="List_prix_mini" placeholder="Prix mini" id="prix_mini"/> 
                        <input type="text" name="List_prix_max" placeholder="Prix max"id="prix_max"/>
                        <input type="submit" name="prix" value ="Go" id="go"/>
                    </p>
                
                        
                    <p>Spécialité: 
                        <select name="choix_origine" id="list_ing">
                            <option value="choix2">Italien</option>
                            <option value="choix3">Oriental</option>
                            <option value="choix4">Americain</option>
                            <option value="choix4">Japonais</option>
                        </select>
                        <input type="submit" name="origine" value ="Go" id="go"/>
                    </p> 
                            
                    <p><input type="submit" name="Visualiser" value ="Visualiser commande" id="subscribe"/></p>
            </form>   
    </div>
</div>


</section>



<section class="mt-5">
<h1 class='text-center'>Votre recherche:</h1>
<?php
if (isset ($_POST['search'])) {
    $searchVerif = htmlspecialchars($_POST['search']);
        if (!empty($searchVerif)) {
            $reqPlat = $bdd -> query("SELECT plat.libelle AS `Nom plat`, type.type AS type, plat.prix AS prix, specialite.nom_pays AS specialite , 
            GROUP_CONCAT(ingredient.libelle SEPARATOR ', ') AS ingredient FROM recette 
            INNER JOIN plat ON plat.id_plat = recette.cle_plat INNER JOIN specialite on plat.specialite = specialite.id_specialite 
            INNER JOIN ingredient ON ingredient.id_ingredient = recette.cle_ingredient INNER JOIN type ON plat.type = type.id_type WHERE plat.libelle 
            LIKE '%" . $searchVerif . "%' GROUP BY id_plat");
            $platExist = $reqPlat -> rowCount();
            if ($platExist == 0){
                echo '<p class="text-center font-weight-bold text-danger">Plat inexistant</p>';                
            }
            else{
                while ($data = $reqPlat -> fetch()) {


                        ?>


                        <div class="container mb-4 rounded ">
                            <div class="p-3 contentConnexion text-left">
                                
                                <p>
                                    <span class='font-weight-bold'>Nom: </span>
                                    <span><?php echo $data['Nom plat']?></span> 
                                </p>
                                <p>
                                    <span class='font-weight-bold'>Prix:</span>
                                    <span><?php echo $data['prix']?></span> 
                                </p>
                                <p>
                                    <span class='font-weight-bold'>Specialité:</span
                                    ><span><?php echo $data['specialite']?></span> 
                                </p>
                                <p>
                                    <span class='font-weight-bold'>Ingredient:</span>
                                    <span><?php echo $data['ingredient']?></span> 
                                </p>
                                <p>
                                    <span class='font-weight-bold'>Type</span>
                                    <span><?php echo $data['type']?></span> 
                                </p>  
                            </div>
                        </div>




                        <?php
                } 
            }
        }    
        else{
            echo '<p class="text-center font-weight-bold text-danger">Tout les doivent etre remplis</p>';                }
          }
        
    
    
     
?>


</section>

</body>

</html>