<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    
    <title>Ma Boutique</title>
  </head>
  <body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">

            <a class="navbar-brand" href="<?php echo RACINE_SITE . 'index.php'; ?>">Ma Boutique</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav">
                <?php
                    echo '<li><a href="'. RACINE_SITE .'index.php" class="nav-link">Boutique</a></li>';

                    if(estConnecte()) { // Si membre est connecté 
                        echo '<li><a href="'. RACINE_SITE .'profil.php" class="nav-link">Profil</a></li>';
                        echo '<li><a href="'. RACINE_SITE .'connexion.php?action=deconnexion" class="nav-link">Déconnexion</a></li>';
                    } else { // membre non connecté
                        echo '<li><a href="'. RACINE_SITE .'inscription.php" class="nav-link">Inscription</a></li>';
                        echo '<li><a href="'. RACINE_SITE .'connexion.php?action=connexion" class="nav-link">Connexion</a></li>';
                    }

                    echo '<li><a href="'. RACINE_SITE .'panier.php" class="nav-link">Panier</a></li>';

                    if(estAdmin()) { // Si membre est administrateur
                        echo '<li><a href="'. RACINE_SITE .'admin/gestion_boutique.php" class="nav-link">Gestion de la boutique</a></li>';
                        echo '<li><a href="'. RACINE_SITE .'admin/gestion_membre.php" class="nav-link">Gestion des membres</a></li>';
                    }
                ?>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container">
        <div class="row">
            <div class="col-12">
            <!-- Ici le contenu spécifique à la page-->