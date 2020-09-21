<?php
// Exercice
/*
   1- Seul l'administrateur doit avoir accès à cette page. Les autres sont redirigés vers la page de connexion.
   2- Afficher tous les membres inscrits dans une table HTML, avec toutes les infos du membre SAUF son mot de passe. Vous ajoutez une colonne "action".
   3- Afficher le nombre de membres inscrits.
   4- Dans la colonne "action", ajoutez un lien "supprimer" pour supprimer un membre inscrit, SAUF vous même qui êtes connecté.
   5- Bonus : dans la colonne "action", ajoutez un lien pour pouvoir modifier le statut des membres pour en faire un admin ou un membre, sauf vous même qui êtes connecté.
*/


require_once("../inc/init.php");

// 1- Vérification si Admin :
if(!EstAdmin())
{
	header("location:../connexion.php");
	exit();
}

// 3- Suppression d'un membre :
if(isset($_GET['action']) && $_GET['action'] == "supprimer_membre" && isset($_GET['id_membre']))
{	// on ne peut pas supprimer son propre profil :
	if ($_GET['id_membre'] != $_SESSION['membre']['id_membre']) {
		executeRequete("DELETE FROM membre WHERE id_membre=:id_membre", array(':id_membre' => $_GET['id_membre']));
	} else {
		$contenu .= '<div class="alert alert-danger">Vous ne pouvez pas supprimer votre propre profil ! </div>';
	}
	
}

// 4- Modification statut membre :
if(isset($_GET['action']) && $_GET['action'] == "modifier_statut" && isset($_GET['id_membre']) && isset($_GET['statut']))
{  // on ne peut pas modifier son propre profil :
	if ($_GET['id_membre'] != $_SESSION['membre']['id_membre']) {
		$statut = ($_GET['statut'] == 0) ? 1 : 0;	// si statut = 0 alors il devient 1 sinon devient 0
		executeRequete("UPDATE membre SET statut = '$statut' WHERE id_membre=:id_membre", array(':id_membre' => $_GET['id_membre']));
	} else {
		$contenu .= '<div class="alert alert-danger">Vous ne pouvez pas modifier votre propre profil ! </div>';	
	}
}


// 2- Préparation de l'affichage :
$resultat = executeRequete("SELECT id_membre,pseudo, nom, prenom, email, civilite, ville, cp, adresse, statut FROM membre"); // tous les champs SAUF le mdp que l'on ne veut pas afficher !
$contenu .= '<h1 class="mt-4"> Membres </h1>';
$contenu .=  "Nombre de membre(s) : " . $resultat->rowCount();

$contenu .=  '<table class="table">';
		// Affichage des entêtes :
		$contenu .=  '<tr>';
			$contenu .=  '<th> id_membre </th>';
			$contenu .=  '<th> pseudo </th>';
			$contenu .=  '<th> nom </th>';
			$contenu .=  '<th> prénom </th>';
			$contenu .=  '<th> email </th>';
			$contenu .=  '<th> civilité </th>';
			$contenu .=  '<th> ville </th>';
			$contenu .=  '<th> cp </th>';
			$contenu .=  '<th> adresse </th>';
			$contenu .=  '<th> statut </th>';
			$contenu .=  '<th> action </th>';
		$contenu .=  '</tr>';

		// Affichage des lignes :
		while ($membre = $resultat->fetch(PDO::FETCH_ASSOC))
		{
			$contenu .=  '<tr>';
				foreach ($membre as $indice => $information)
				{
					$contenu .=  '<td>' . $information . '</td>';
				}
				$contenu .=  '<td>';
					$contenu .=  '<div><a href="?action=supprimer_membre&id_membre=' . $membre['id_membre'] . '" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer ce membre?\'));"> supprimer </a></div>';

					$contenu .=  '<div><a href="?action=modifier_statut&id_membre=' . $membre['id_membre'] . '&statut='. $membre['statut'] .'"> modifier </a></div>';
				$contenu .=  '</td>';

			$contenu .=  '</tr>';
		}
$contenu .=  '</table>';


//-------------------------------------------------- Affichage ---------------------------------------------------------//
require_once("../inc/header.php");
echo $contenu;
require_once("../inc/footer.php");



