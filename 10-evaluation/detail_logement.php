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

// Contrôle de l'existence du contact

if (isset($_GET['id_logement'])) {

    // Echappement des caractères spéciaux

	$_GET['id_logement'] = htmlspecialchars($_GET['id_logement'], ENT_QUOTES);


   $requete = $pdo->prepare("SELECT id_logement, titre, adresse, ville, cp, surface, prix, photo, type, description FROM logement WHERE id_logement = :id_logement");
   $succes = $requete->execute(array(':id_logement' => $_GET['id_logement']));

   
   

   // Affichage et mise en forme
      $logement = $requete->fetch(PDO::FETCH_ASSOC);
      extract($logement);
}
?>

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Détails du logement</title>
  </head>
  <body>
  <div class="row">
      <div class="col-12 mt-4 text-center">
         <h1>Détails du logement</h1>
      </div>
    </div>
    <hr>
    <div class="row justify-content-center text-center">
    <div class="col-12 mt-2 mb-5">
        <h2><?php echo $titre; ?></h2>
    </div>

    <div class="col-12">
        <img src="<?php echo $photo; ?>" width="300px">
    </div>

    <div class="col-6 mt-5">
        <h3>Détails</h3>
        <ul style="list-style-type: none" class="list-group list-group-flush">
            <li><b> Adresse : </b><?php echo $adresse; ?></li>
            <li><b> Code postal : </b><?php echo $cp; ?></li>
            <li><b> Surface : </b><?php echo $surface; ?> m²</li>
            <li><b> Prix : </b><?php echo $prix; ?> €</li>
            <li><b> Type : </b><?php echo $type; ?></li>
            <li><b> Description : </b><?php echo $description; ?></li>
        </ul>
        <div class="mt-4">
        <button type="button" class="btn btn-primary" style="color: white" onclick="window.location.href='liste_logement.php'">Retour à la liste des logements</button>
        </div>
    </div>


</div> <!-- .row -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>