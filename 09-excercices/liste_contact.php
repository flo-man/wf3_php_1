<?php
/*
	1- Afficher dans une table HTML la liste des contacts avec tous les champs.
	2- Le champ photo devra afficher la photo du contact en 80px de large.
	3- Ajouter une colonne "Voir" avec un lien sur chaque contact qui amène au détail du contact (detail_contact.php).

*/

$pdo = new PDO('mysql:host=localhost;dbname=repertoire', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

// DEBUG
function debug($var) {
  echo '<pre>';
      print_r($var);
  echo '</pre>';
}

$contenu = '';

// Fonction 'VOIR'
if(isset($_GET['action']) && $_GET['action'] == "voir" && isset($_GET['id_contact'])) {	
  $_GET['action'] = htmlspecialchars($_GET['action'], ENT_QUOTES);
  header('location:detail_contact.php?id_contact=' . $_GET['id_contact']);
}

// Fonction 'SUPPRIMER'
if(isset($_GET['action']) && $_GET['action'] == "supprimer" && isset($_GET['id_contact'])) {
  $_GET['action'] = htmlspecialchars($_GET['action'], ENT_QUOTES);
  $requete = $pdo->prepare("DELETE FROM contact WHERE id_contact=:id_contact");
  $succes = $requete->execute(array(':id_contact' => $_GET['id_contact']));
  $contenu .= '<div class="row justify-content-center text-center"><div class="alert alert-success col-sm-3 mt-3">Le contact a bien été supprimé.</div></div>';
}

// Affichage
$requete = $pdo->prepare("SELECT id_contact, nom, prenom, telephone, email, type_contact, photo FROM contact");
$succes = $requete->execute();
$contenu .=  "Nombre de contact(s) : " . $requete->rowCount();

$contenu .=  '<table class="table table-striped">';
		// Affichage des entêtes :
		$contenu .=  '<tr>';
			$contenu .=  '<th> ID </th>';
			$contenu .=  '<th> Nom </th>';
			$contenu .=  '<th> Prénom </th>';
			$contenu .=  '<th> Téléphone </th>';
			$contenu .=  '<th> Email </th>';
			$contenu .=  '<th> Type </th>';
			$contenu .=  '<th> Photo </th>';
			$contenu .=  '<th></th>';
		$contenu .=  '</tr>';

		// Affichage des lignes :
		while ($contact = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$contenu .=  '<tr>';
      foreach ($contact as $indice => $infos) {
        if ($indice == 'photo') {
            $contenu .= '<td><img src="' . $infos . '" alt="" style="width: 80px; max-height: 80px; object-fit: cover;"></td>';
        } else {
            $contenu .= '<td>' . $infos . '</td>';
        }
    }
        $contenu .=  '<td>';
					$contenu .=  '<div><a href="?action=voir&id_contact=' . $contact['id_contact'] . '"> Voir </a></div>';

          $contenu .=  '<div><a href="ajout_contact.php?id_contact='. $contact['id_contact'] .'"> Modifier </a></div>';
          
          $contenu .=  '<div><a href="?action=supprimer&id_contact=' . $contact['id_contact'] . '" style="color: red" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer ce membre?\'));"> Supprimer </a></div>';
				$contenu .=  '</td>';
			$contenu .=  '</tr>';
		}
$contenu .=  '</table>';

?>


<!doctype html>
<html lang="fr">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Mon répertoire</title>
  </head>
  <body>
    <div class="row">
      <div class="col-12 mt-4 text-center">
          <h1>Mon répertoire</h1>
      </div>
    </div>
    <hr>
    <div class="mt-1 text-center">
        <button type="button" class="btn btn-primary" style="color: white" onclick="window.location.href='ajout_contact.php'">Ajout d'un nouveau contact</button>
    </div>
    <div class="row justify-content-center">
		  <div class="col-sm-10">
        <?php echo $contenu; ?>
      </div>
    </div>






    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>