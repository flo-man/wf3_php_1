<?php
require_once 'inc/init.php';
//***************************************** TRAITEMENT PHP *****************************************//
$contenu_categories = '';
$contenu_produits = '';

// 1 - Affichage des catégories :
$resultat = executeRequete("SELECT DISTINCT categorie FROM produit", array()); // DISTINCT pour dédoublonner

$contenu_categories .= '<div class="list-group mb-4">';
$contenu_categories .= '<a href="?categorie=tous" class="list-group-item">Tous les produits</a>'; // On passe dans l'URL via href que categorie=tous
while ($cat = $resultat->fetch(PDO::FETCH_ASSOC)) {
    // debug($cat); // $cat contient à chaque tour une des catégories.
    $contenu_categories .= '<a href="?categorie='.$cat['categorie'].'" class="list-group-item">'.$cat['categorie'].'</a>';
}


$contenu_categories .= '</div>';

// 1 - Affichage des produits suivant la catégorie choisie :
if (isset($_GET['categorie']) && $_GET['categorie'] != 'tous') { // Si "categorie" est dans l'URL et que sa valeur est différente de "tous" alors on séléctionne la catégorie demandée
    $resultat = executeRequete("SELECT id_produit, reference, titre, photo, prix, description FROM produit WHERE categorie = :categorie", array(':categorie' => $_GET['categorie']));
    
    
    
} else {
    $resultat = executeRequete("SELECT * FROM produit"); // Sinon on séléctionne tous les produits (les cas où on arrive pour la première fois sur la page ou si on a cliqué sur la catégorie 'tous')
}

while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)) {

    $contenu_produits .= '<div class="col-sm-4 mb-4">';
        $contenu_produits .= '<div class="card">';
            // Image cliquable
            $contenu_produits .= '<a href="fiche_produit.php?id_produit='.$produit['id_produit'].'">
                                    <img class="card-img-top" src="'.$produit['photo'].'" alt="'.$produit['titre'].'">
                                  </a>';
            // Infos du produit
            $contenu_produits .= '<div class="card-body">';
                $contenu_produits .= '<h4>' . $produit['titre'] . '</h4>';
                $contenu_produits .= '<h5>' . number_format($produit['prix'], 2, ',', '') . ' €</h5>'; // Formate l'affichage des prix avec : 2 décimales, une virgule pour séparateur des décimales et un string vide pour séparateur des milliers.
                $contenu_produits .= '<p>' . $produit['description'] . '</p>';
            $contenu_produits .= '</div>';

        $contenu_produits .= '</div>'; // .card
    $contenu_produits .= '</div>'; // .col-sm-4
}


//***************************************** AFFICHAGE *****************************************//
require_once 'inc/header.php';
?>
    <h1 class="mt-4">Boutique</h1>
    <hr>

    <div class="row">
    
        <div class="col-md-3">
            <h2>Catégories</h2>
            <?php echo $contenu_categories; // Pour afficher les catégories
            ?>
        </div>



        <div class="col-md-9">
            <h2>Produits</h2>
            <div class="row">
                <?php echo $contenu_produits; // Pour afficher les produits
                ?>
            </div>
        </div>

    </div><!-- .row -->




<?php
require_once 'inc/footer.php';