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

    <link rel="stylesheet" href="style\main_style.css" />

</head>


<body>
    <div class=backgroud-body>
        <div class="container-fluid">
            <header class="row align-items-center">
                <h1 class="col-auto m-0 p-0 logo">EAT <span class="word-color">MyPhp</span> FOOD</a></h1>
                <nav class="col-auto ml-auto">
                    <ul class="row  justify-content-between my-0">
                        <li class="col-auto cool-link"><a href="#">Ma commande</a></li>
                        <li class="col-auto cool-link"><a href="#">Deconnexion</a></li>
                    </ul>
                </nav>
            </header>
        </div>



        <div style="height: 100vh;" class="row container-fluid d-flex align-items-center justify-content-start">
        
            <div class="window">
                <h1 class="welcome"><span class="word-color">Bienvenue </span><?php echo $userInfo['pseudo']; ?> !</h1>

                <h1 class="annonce">Commander vos plats préféres <br> en un clic</h1>

                <section class="search-win p-4">
                    <form class="search" method="post" action="research.php">
                        <p>Rechercher parmi nos menu, vos plats préférés</p>
                        <input type="text" name="search" placeholder="Recherche un plat" name="search">
                        <button type="submit" name="result_search"><i class="fa fa-search"></i></button>
                    </form>


                    <br><br>

                    <form class="list" method="post" action="research.php">
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
                            <button type="submit" name="list_ing"><i class="fa fa-search"></i></button>
                        </p>
                    </form>

                    <br><br>

                    <form class="list" action="research.php" method='post'>
                        <p>Spécialité: </p>
                        <select name="specialite" id="list_ing">
                            <option value="Italien">Italien</option>
                            <option value="Oriental">Oriental</option>
                            <option value="Americain">Americain</option>
                            <option value="Japonais">Japonais</option>
                        </select>
                        <button type="submit" name="origine"><i class="fa fa-search"></i></button>
                    </form>

                    <br><br>


                    <form class="price" method="post" action="research.php">
                        <p>Par fourchette de prix:</p>
                        <input type="text" name="prix_mini" placeholder="Prix mini" id="prix_mini" />
                        <input type="text" name="prix_max" placeholder="Prix max" id="prix_max" />
                        <button type="submit" name="prix_result"><i class="fa fa-search"></i></button>
                    </form>

                    <br><br>


                    <div class="cursor d-flex justify-content-center">
                        <a style="font-size:1em;cursor:pointer " onclick="openNav()">
                            <input type="submit" name="Visualiser" value="Visualiser votre panier" class="btn-commande" /></a></div>
                    <!-- SettingSlide Menu contact-->
                    <div id="mySidenav" class="sidenav ">
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                        <div class="container_contact">
                            <div class=commande>Votre commande — </div>
                        </div>
                    </div>
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