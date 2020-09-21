<?php
require_once 'inc/init.php';
//***************************************** TRAITEMENT PHP *****************************************//
// debug($_POST);
// 1) Ajout du produit au panier
if (!empty($_POST)) { // Si formulaire d'ajout a été envoyé 
    // On séléctionne en BdD le prix, la référence et le titre du produit ajouté
    $resultat = executeRequete("SELECT prix, reference, titre FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_POST['id_produit']));
    $produit = $resultat->fetch(PDO::FETCH_ASSOC);
    

    // On remplit la session avec les infos du produit ajouté au panier (on les met dans la session pour que le panier soit accessible dans toutes les pages du site)
    $_SESSION['panier']['id_produit'][] = $_POST['id_produit']; // Les crochets vides [] permettent d'ajouter un élément à la fin du tableau (avec des indices numériques)
    $_SESSION['panier']['reference'][] = $produit['reference']; // La référence elle, vient de la BdD
    $_SESSION['panier']['titre'][] = $produit['titre'];
    $_SESSION['panier']['quantite'][] = $_POST['quantite'];
    $_SESSION['panier']['prix'][] = $produit['prix'];
    // debug($_SESSION);

    // 3) Redirection vers la fiche produit une fois l'article ajouté au panier
    header('location:fiche_produit.php?id_produit=' . $_POST['id_produit'] . ''); // Passage d'id_produit dans l'URL pour réafficher la fiche de produit après l'ajout au panier

} // fin du if not empty $_POST

// 4) Vider le panier :
if (isset($_GET['action']) && $_GET['action'] == 'vider') {
    unset($_SESSION['panier']); // On supprime le panier de la session, sans supprimer la session elle-même, pour ne pas déconnecter le membre
}


//***************************************** AFFICHAGE *****************************************//
require_once 'inc/header.php';
// 2) Affichage du panier
echo '<h1 class="mt-4">Votre Panier</h1>';
if (empty($_SESSION['panier']['id_produit'])) { // S'il n'y a pas d'id_produit, le panier est vide
    echo '<p>Votre panier est vide.</p>';
} else {
    echo '<table class="table table-striped">';
    // Ligne des en-têtes
    echo '<tr class="info">
            <th>Références</th>
            <th>Titre</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>
          </tr>';
    
    // Lignes de chaque produit
    // Boucle for pour parcourir les indices numériques
    for ($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++) {
        echo '<tr>';
            echo '<td>' . $_SESSION['panier']['reference'][$i] . '</td>';
            echo '<td>' . $_SESSION['panier']['titre'][$i] . '</td>';
            echo '<td>' . $_SESSION['panier']['quantite'][$i] . '</td>';
            echo '<td>' . number_format($_SESSION['panier']['prix'][$i], 2, ',', '') . ' €</td>';
        
        
        echo '</tr>';
    }
    // Ligne du total
    echo '<tr>
          <th colspan="3">Total</th>
          <th colspan="1">'.number_format(montantTotal(), 2, ',', '').' €</th>
          </tr>';

    //Ligne "vider" le panier
    echo '<tr class="text-right">
          <td colspan="4">
            <a href="?action=vider">Vider le panier</a>
          </td>
          </tr>';


    echo '</table>';


} // fin du else 'panier'





require_once 'inc/footer.php';