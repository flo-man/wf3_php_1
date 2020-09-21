<?php


// Connexion à la BdD : 
$pdo = new PDO('mysql:host=localhost;dbname=immobilier', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

// DEBUG
function debug($var) {
    echo '<pre>';
        print_r($var);
    echo '</pre>';
}

// Variable d'affichage :
$contenu = '';

// Affichage
$requete = $pdo->prepare("SELECT id_logement, titre, adresse, ville, cp, surface, prix, photo, type, description FROM logement");
$succes = $requete->execute();
$contenu .=  "Nombre de logement(s) : " . $requete->rowCount();

$contenu .=  '<table class="table table-striped">';
		// Affichage des entêtes :
		$contenu .=  '<tr>';
			$contenu .=  '<th> ID </th>';
			$contenu .=  '<th> Titre </th>';
			$contenu .=  '<th> Adresse </th>';
			$contenu .=  '<th> Ville </th>';
			$contenu .=  '<th> Code postal </th>';
			$contenu .=  '<th> Surface (m²)</th>';
			$contenu .=  '<th> Prix (€)</th>';
			$contenu .=  '<th> Photo </th>';
			$contenu .=  '<th> Type </th>';
			$contenu .=  '<th> Description </th>';
		$contenu .=  '</tr>';

        // Affichage des lignes :
		while ($logement = $requete->fetch(PDO::FETCH_ASSOC)) {
            $contenu .=  '<tr>';
        foreach ($logement as $indice => $infos) {
            $string = strip_tags($infos);
            if ($indice == 'photo') {
                $contenu .= '<td><img src="' . $infos . '" alt="photo_logement" style="width: 80px; object-fit: cover;"></td>';
            } elseif ($indice == 'titre') {
                $contenu .= '<td><a href="detail_logement.php?id_logement=' . $logement['id_logement'] . '">' . $infos . '</a></td>';
            } elseif (strlen($string) > 30) {
                $contenu .= '<td>' . substr($infos, 0, 30) . '...<a href="">lire la suite</a>';
            } else {
                $contenu .= '<td>' . $infos . '</td>';
            }
        }
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

    <title>Liste des logements</title>
  </head>
  <body>
    <div class="row">
      <div class="col-12 mt-4 text-center">
          <h1>Liste des logements</h1>
      </div>
    </div>
    <hr>
    <div class="mt-1 text-center">
        <button type="button" class="btn btn-primary" style="color: white" onclick="window.location.href='ajout_logement.php'">Ajout d'un nouveau logement</button>
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