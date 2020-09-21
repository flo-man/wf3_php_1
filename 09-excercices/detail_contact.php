<?php
/*
   1- Vous affichez le détail complet du contact demandé, y compris la photo. Si le contact n'existe pas, vous laissez un message. 

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

// 1) Contrôle de l'existence du contact

if (isset($_GET['id_contact'])) { // si id_produit est présent dans l'URL

    // Echappement des caractères spéciaux

	$_GET['id_contact'] = htmlspecialchars($_GET['id_contact'], ENT_QUOTES);


   $requete = $pdo->prepare("SELECT id_contact, nom, prenom, telephone, email, type_contact, photo FROM contact WHERE id_contact = :id_contact");
   $succes = $requete->execute(array(':id_contact' => $_GET['id_contact']));

   
   if ($requete->rowCount() == 0) { // Il n'y a pas de produit en BdD avec cet id_contact (on redirige)
        header('location:liste_contact.php');
   } else {

   // 2) Affichage et mise en forme
      $contact = $requete->fetch(PDO::FETCH_ASSOC);
      extract($contact);
   }
} else {
    header('location:liste_contact.php');
}
?>

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Fiche contact</title>
  </head>
  <body>
  <div class="row">
      <div class="col-12 mt-4 text-center">
         <h1>Fiche contact</h1>
      </div>
    </div>
    <hr>
    <div class="row justify-content-center text-center">
    <div class="col-12 mt-2 mb-5">
        <h2><?php echo $nom . ', ' . $prenom; ?></h2>
    </div>

    <div class="col-12">
        <img src="<?php echo $photo; ?>" alt="<?php echo $nom . $prenom; ?>" width="300px">
    </div>

    <div class="col-12 mt-5">
        <h3>Informations</h3>
        <ul class="list-group list-group-flush">
            <li><b> Téléphone : </b><?php echo $telephone; ?></li>
            <li><b> E-mail : </b><?php echo $email; ?></li>
            <li><b> Type : </b><?php echo $type_contact; ?></li>
        </ul>
        <?php echo '<div class="mt-4"><a href="ajout_contact.php?id_contact='. $contact['id_contact'] .'"> Modifier </a></div>'; ?>
        <?php echo '<div class="mt-4"><a href="liste_contact.php?action=supprimer&id_contact=' . $contact['id_contact'] . '" style="color: red" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer ce membre?\'));"> Supprimer </a></div>';?>
        <div class="mt-4">
        <button type="button" class="btn btn-primary" style="color: white" onclick="window.location.href='liste_contact.php'">Retour à la liste des contacts</button>
        </div>
    </div>


</div> <!-- .row -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>