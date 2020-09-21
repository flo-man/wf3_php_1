<?php
require_once 'inc/init.php';
//***************************************** TRAITEMENT PHP *****************************************//

$panier = ''; // Pour afficher le formulaire d'ajout au panier
$suggestion = ''; // Pour la suggestion de produits


// 1) Contrôle de l'existence du produit demandé
// debug($_GET);

if (isset($_GET['id_produit'])) { // si id_produit est présent dans l'URL
    $resultat = executeRequete("SELECT * FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));
    if ($resultat->rowCount() == 0) { // Il n'y a pas de produit en BdD avec cet id_produit (on redirige)
        header('location:index.php');
        exit();
    }

    // 2) Affichage et mise en forme des informations du produit :
        $produit = $resultat->fetch(PDO::FETCH_ASSOC);
        // debug($produit);
        extract($produit); // Crée des variables, nommées comme les indices du tableau associatif, et qui prennent les valeurs.

        // 3) Formulaire d'ajout au panier si le stock est supérieur à 0 :
        if ($stock > 0) {
            // Pour panier.php il nous faut l'id_produit et la quantité ajoutée au panier
            $panier .= '<form method="post" action="panier.php">';
            $panier .= '<input type="hidden" name="id_produit" value="'.$id_produit.'">'; // Ajout (caché) de l'id_produit à $_POST
            // sélécteur de quantité
            $panier .= '<select name="quantite" class="custom-select col-3">';
                for ($i = 1; $i <= $stock && $i <=10; $i++) {
                    $panier .= "<option>$i</option>"; // l'attribut value='' permet si besoin de choisir une valeur par défaut qui représente son nom en BdD (<option value='m'>masculin</option>)
                }
            $panier .= '</select>';
            // Bouton d'ajout au panier
            $panier .= '<input type="submit" name="ajout_panier" value="Ajouter au panier" class="btn btn-info col-6 offset-1">';
            $panier .= '</form>';
        } else {
            $panier .= '<p>Produit indisponible</p>';
        }

} else {  // si id_produit n'est pas dans l'URL (on redirige)
    header('location:index.php');
    exit();
}

// Excercice : Afficher 2 produits (photo et titre) aléatoirement appartenant à la même catégorie que celle du produit affiché au dessus. Ces 2 produits doivent être différents du produit consulté. La photo est cliquable et mène à la fiche détaillée du produit. Utilisez la variable $suggestion pour afficher le contenu

$resultat = executeRequete("SELECT id_produit, titre, photo FROM produit WHERE id_produit != :id_produit AND categorie = :categorie ORDER BY RAND() LIMIT 2" , array(':categorie' => $produit['categorie'], ':id_produit' => $produit['id_produit']));


while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)) {
    $suggestion .= '<div class="col-sm-2 mb-4">';
        $suggestion .= '<div class="card">';
            // Image cliquable
            $suggestion .= '<a href="fiche_produit.php?id_produit='.$produit['id_produit'].'">
                                    <img class="card-img-top" src="'.$produit['photo'].'" alt="'.$produit['titre'].'" style="max-width: 170px">
                                  </a>';
            // Infos du produit
            $suggestion .= '<div class="card-body">';
                $suggestion .= '<h5>' . $produit['titre'] . '</h5>';
            $suggestion .= '</div>';

        $suggestion .= '</div>'; // .card
    $suggestion .= '</div>'; // .col-sm-2
}
//***************************************** AFFICHAGE *****************************************//
require_once 'inc/header.php';
?>
<div class="row">
    <div class="col-12 mt-4">
        <h1><?php echo $titre; ?></h1>
    </div>

    <div class="col-md-8">
        <img src="<?php echo $photo; ?>" alt="<?php echo $titre; ?>" class="img-fluid">
    </div>

    <div class="col-md-4">
        <h2>Description</h2>
        <p><?php echo $description; ?></p>
        <h2>Détails</h2>
        <ul>
            <li>Catégorie : <?php echo $categorie; ?></li>
            <li>Couleur : <?php echo $couleur; ?></li>
            <li>Taille : <?php echo $taille; ?></li>
        </ul>
        <h3><?php echo number_format($prix, 2, ',', ''); ?> € TTC</h3>

        <?php echo $panier; // Formulaire d'ajout au panier ?>

    </div>


</div> <!-- .row -->

<hr>

<div class="row">
    <div class="col-12">
        <h2>Suggestion de produits</h2>
    </div>
    <?php echo $suggestion; ?>
</div>

<?php
require_once 'inc/footer.php';