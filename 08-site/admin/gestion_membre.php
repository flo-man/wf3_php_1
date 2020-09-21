<?php
// Excercice : 
// 1 - Seul l'admin doit avoir accès à cette page. Les autres sont redirigés vers connexion.php
// 2 - Afficher tous les membres inscrits dans une table HTML avec toutes les infos du membres, sauf MDP. Ajouter une colonne ACTION
// 3 - Afficher le nombe de membres inscrits
// 4 - Dans ACTION, mettre un lien supprimer pour supprimer le membre inscrit, SAUF vous-même qui etes connecté
// 5 - BONUS : dans ACTION, ajouter un lien pour pouvoir modifier le statut des membres, pour en faire un admin ou un membre (SAUF vous-même)

require_once '../inc/init.php';
//***************************************** TRAITEMENT PHP *****************************************//

// Excercice 1)
if(!estAdmin()) { // Si membre non-admin ou non connecté, on le renvoie vers connexion
    header('location:../connexion.php');
    exit();
}

// Excercice 4) Suppression du membre
if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && $_GET['id_membre']) {
    $resultat = executeRequete("DELETE FROM membre WHERE id_membre = :id_membre", array('id_membre' => $_GET['id_membre']));

    if ($resultat) {
        $contenu .= '<div class="alert alert-success">Le membre a bien été supprimé.</div>';
    } else {
        $contenu .= '<div class="alert alert-danger">Erreur lors de la suppression.</div>';
    }
}

// Excercice 5) modification du membre
// SI DEPUIS MEMBRE
if (isset($_GET['action']) && $_GET['action'] == 'modifiermembre' && $_GET['id_membre']) {

    $resultat = executeRequete("UPDATE membre SET statut = 1 WHERE id_membre = :id_membre", array('id_membre' => $_GET['id_membre']));

    if ($resultat) {
        $contenu .= '<div class="alert alert-success">Le statut du membre a bien été modifié.</div>';
    } else {
        $contenu .= '<div class="alert alert-danger">Erreur lors de la modification.</div>';
    }
}
// SI DEPUIS ADMIN
if (isset($_GET['action']) && $_GET['action'] == 'modifieradmin' && $_GET['id_membre']) {

    $resultat = executeRequete("UPDATE membre SET statut = 0 WHERE id_membre = :id_membre", array('id_membre' => $_GET['id_membre']));

    if ($resultat) {
        $contenu .= '<div class="alert alert-success">Le statut du membre a bien été modifié.</div>';
    } else {
        $contenu .= '<div class="alert alert-danger">Erreur lors de la modification.</div>';
    }
}

// Excercice 2)
$resultat = executeRequete("SELECT * FROM membre");
// Excercice 3)
$contenu .= '<p class="mt-3" style="text-align: center">Nombre de membres inscrits : ' . $resultat->rowCount() . '</p>';

$contenu .= '<table class="table">';

    $contenu .= '<tr>';

    $contenu .= '<th>ID</th>';
    $contenu .= '<th>Pseudo</th>';
    $contenu .= '<th>Nom</th>';
    $contenu .= '<th>Prénom</th>';
    $contenu .= '<th>E-mail</th>';
    $contenu .= '<th>Civilité</th>';
    $contenu .= '<th>Ville</th>';
    $contenu .= '<th>Code postal</th>';
    $contenu .= '<th>Adresse</th>';
    $contenu .= '<th>Statut</th>';
    $contenu .= '<th>Action</th>'; // Colonne pour les liens "modifier/supprimer"

    $contenu .= '</tr>';
    // CONDITION : CACHER LE MOT DE PASSE
    while ($membre = $resultat->fetch(PDO::FETCH_ASSOC)) { 
        $contenu .= '<tr>';
        foreach ($membre as $indice => $infos) {
            if ($indice == 'mdp') {
                $contenu .= '';
            } else {
                $contenu .= '<td>' . $infos . '</td>';
            }
        }
        // CONDTION : ACTION, SAUF SUR ADMIN PRINCIPAL
        $contenu .= '<td>';
            if ($membre['pseudo'] == 'lejugeti') {
                $contenu .= '';
            // CONDITION : MODIFIER ADMIN OU MEMBRE
            } elseif ($membre['statut'] == 1) {
                $contenu .= '<div><a href="?action=modifieradmin&id_membre='.$membre['id_membre'].'" onclick="return confirm(\'Êtes-vous certain de vouloir modifier le statut de ce membre ?\')">modifier</a></div>';
                $contenu .= '<div><a href="?action=supprimer&id_membre='.$membre['id_membre'].'" onclick="return confirm(\'Êtes-vous certain de vouloir suprrimer ce membre ?\')">supprimer</a></div>';
            } else {
                $contenu .= '<div><a href="?action=modifiermembre&id_membre='.$membre['id_membre'].'" onclick="return confirm(\'Êtes-vous certain de vouloir modifier le statut de ce membre ?\')">modifier</a></div>';
                $contenu .= '<div><a href="?action=supprimer&id_membre='.$membre['id_membre'].'" onclick="return confirm(\'Êtes-vous certain de vouloir suprrimer ce membre ?\')">supprimer</a></div>';
            }
        $contenu .= '</td>';

        $contenu .= '</tr>';
    }

$contenu .= '</table>';

//***************************************** AFFICHAGE *****************************************//
require_once '../inc/header.php';
?>
<h1 class="mt-4">Gestion Boutique</h1>

<?php
echo $contenu;
require_once '../inc/footer.php';