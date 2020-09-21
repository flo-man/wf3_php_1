<?php
require_once '../inc/init.php';

//***************************************** TRAITEMENT PHP *****************************************//
// 1) restrictions d'accès aux admins

if(!estAdmin()) { // Si membre non-admin ou non connecté, on le renvoie vers connexion
    header('location:../connexion.php');
    exit();
}

// 7) Suppression du produit
// On se positionne avant l'affichage du tableau pour que celui-ci soit à jour sans le produit supprimé
if (isset($_GET['id_produit'])) { // si id_produit existe dans l'URL c'est qu'on a demandé sa suppression
    $resultat = executeRequete("DELETE FROM produit WHERE id_produit = :id_produit", array('id_produit' => $_GET['id_produit'])); // L'identifiant du produit à supprimer vient de l'URL

    if ($resultat) { // Si le 'DELETE' retourne un objet PDOStatement (= true) c'est que la requête a marché
        $contenu .= '<div class="alert alert-success">Le produit a bien été supprimé.</div>';
    } else { // Dans le cas contraire on a reçu false
        $contenu .= '<div class="alert alert-danger">Erreur lors de la suppression.</div>';
    }
}
// 6) Affichage des produits en back-office

$resultat = executeRequete("SELECT * FROM produit");
$contenu .= '<p class="mt-3" style="text-align: center">Nombre de produits dans la boutique : ' . $resultat->rowCount() . '</p>';

$contenu .= '<table class="table">';

    $contenu .= '<tr>';

    $contenu .= '<th>ID</th>';
    $contenu .= '<th>Référence</th>';
    $contenu .= '<th>Catégorie</th>';
    $contenu .= '<th>Titre</th>';
    $contenu .= '<th>Description</th>';
    $contenu .= '<th>Couleur</th>';
    $contenu .= '<th>Taille</th>';
    $contenu .= '<th>Photo</th>';
    $contenu .= '<th>Public</th>';
    $contenu .= '<th>Prix</th>';
    $contenu .= '<th>Stock</th>';
    $contenu .= '<th>Action</th>'; // Colonne pour les liens "modifier/supprimer"

    $contenu .= '</tr>';
    
    // 6) Excercice : afficher un produit par ligne avec dans la colonne 'photo', la photo du produit (90px width)
    while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)) { 
        $contenu .= '<tr>';
        foreach ($produit as $indice => $infos) { // Cette boucle parcourt les informations du tableau 'produit'
            if ($indice == 'photo') { // Si dans la colonne 'photo' alors balise IMG
                $contenu .= '<td><img src="../' . $infos . '" alt="" style="width: 90px"></td>';
            } else {
                $contenu .= '<td>' . $infos . '</td>';
            }
        }
        $contenu .= '<td>
                            <a href="formulaire_produit.php?id_produit='. $produit['id_produit'] .'">modifier</a>
                            <a href="?id_produit='. $produit['id_produit'] .'" onclick="return confirm(\'Êtes-vous certain de vouloir suprrimer ce produit ?\')">supprimer</a>';
        $contenu .= '</td>'; // Nous ajoutons des liens "modifier/supprimer" sur chaque ligne de produits (nous sommes à l'intérieur du tr). Nous passons dans l'URL, l'identifiant du produit contenu dans la variable $produit['id_produit']




        $contenu .= '</tr>';
        /*
        $contenu .= '<tr>';
        $contenu .= '<td>' . $produit['id_produit'] . '</td>';
        $contenu .= '<td>' . $produit['reference'] . '</td>';
        $contenu .= '<td>' . $produit['categorie'] . '</td>';
        $contenu .= '<td>' . $produit['titre'] . '</td>';
        $contenu .= '<td>' . $produit['description'] . '</td>';
        $contenu .= '<td>' . $produit['couleur'] . '</td>';
        $contenu .= '<td>' . $produit['taille'] . '</td>';
        $contenu .= '<td><img src="../' . $produit['photo'] . '" alt="" style="width: 90px"></td>';
        $contenu .= '<td>' . $produit['public'] . '</td>';
        $contenu .= '<td>' . $produit['prix'] . '</td>';
        $contenu .= '<td>' . $produit['stock'] . '</td>';
        $contenu .= '</tr>'; 
        */
    }
$contenu .= '</table>';






//***************************************** AFFICHAGE *****************************************//
require_once '../inc/header.php';

// 2) liens de navigation
?>
<h1 class="mt-4">Gestion Boutique</h1>

<ul class="nav nav-tabs">
    <li><a href="gestion_boutique.php" class="nav-link active">Affichage des produits</a></li>
    <li><a href="formulaire_produit.php" class="nav-link">Formulaire produit</a></li>
</ul>



<?php
echo $contenu;
require_once '../inc/footer.php';