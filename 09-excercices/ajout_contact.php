<?php
/* 1- Créer une base de données "repertoire" avec une table "contact" :
	  id_contact PK AI INT
	  nom VARCHAR(50)
	  prenom VARCHAR(50)
	  telephone VARCHAR(10)
	  email VARCHAR(255)
	  type_contact ENUM('ami', 'famille', 'professionnel', 'autre')
	  photo VARCHAR(255)

	2- Créer un formulaire HTML (avec doctype...) afin d'ajouter un contact dans la bdd. 
	   Le champ type_contact doit être géré via un "select option".
	   On doit pouvoir uploader une photo par le formulaire. 
	
	3- Effectuer les vérifications nécessaires :
	   Les champs nom et prénom contiennent 2 caractères minimum, le téléphone 10 chiffres
	   Le type de contact doit être conforme à la liste des types de contacts
	   L'email doit être valide
	   En cas d'erreur de saisie, afficher des messages d'erreurs au-dessus du formulaire

	4- Ajouter les infos du contact dans la BDD et afficher un message en cas de succès ou en cas d'échec.
	5- Si une photo est uploadée, ajouter la photo du contact en BDD et uploader le fichier sur le serveur de votre site.

*/

// Connexion à la BdD : 
$pdo = new PDO('mysql:host=localhost;dbname=repertoire', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

// Variable d'affichage :
$contenu = '';

// DEBUG
function debug($var) {
    echo '<pre>';
        print_r($var);
    echo '</pre>';
}

//-------------------------
// Validation du formulaire
//-------------------------
if(!empty($_POST)) {
	 
    if (!isset($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 50 ){
        $contenu .= '<div class="alert alert-danger">Le champ Nom doit contenir entre 2 et 50 caractères.</div>';
    }

    if (!isset($_POST['prenom']) || strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 50 ){
        $contenu .= '<div class="alert alert-danger">Le champ Prénom doit contenir entre 2 et 50 caractères.</div>';
    }

    if (!isset($_POST['telephone']) || !preg_match('#^[0-9]{10}$#', $_POST['telephone']) ){
        $contenu .= '<div class="alert alert-danger">Le téléphone doit contenir 10 chiffres.</div>';
    }

    if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || strlen($_POST['email']) > 255) {
        $contenu .= '<div class="alert alert-danger">L\'e-mail n\'est pas valide.</div>';
    }

    if (!isset($_POST['type_contact']) || ($_POST['type_contact'] != 'ami' && $_POST['type_contact'] != 'famille' && $_POST['type_contact'] != 'professionnel' && $_POST['type_contact'] != 'autre' ) ) {
        $contenu .= '<div class="alert alert-danger">Le type de contact n\'est pas valide.</div>';
	}

	//-------------------------
    // Enregistrement
	//-------------------------
	if (empty($contenu)) {

		//-------------------------
		// Upload de la photo
		//-------------------------
		$photo_bdd = ''; // Par défaut la photo en bdd est vide

		if (isset($_POST['photo_actuelle'])) {
			$photo_bdd = $_POST['photo_actuelle'];
		}

		if (!empty($_FILES['photo']['name'])) { // Si un fichier est en cours d'upload

			$fichier_photo = $_FILES['photo']['name']; // Nom de la photo
			$photo_bdd = 'photo/' . $fichier_photo; // Chemin relatif de la photo qui est enregistré en BdD et qui nous servira pour l'attribut src des balises image
			copy($_FILES['photo']['tmp_name'], $photo_bdd); // Cette fonction prédéfinie enregistre le fichier qui est temporaitement à l'adresse "tmp_name" vers l'adresse dont le chemin est "../photo/fichier_photo.jpg"
		}

		// Echappement des caractères spéciaux
		foreach ($_POST as $indice => $valeur) {
			$_POST[$indice] = htmlspecialchars($valeur);
		}

		$requete = $pdo->prepare("REPLACE INTO contact (id_contact, nom, prenom, telephone, email, type_contact, photo) VALUES (:id_contact, :nom, :prenom, :telephone, :email,:type_contact, :photo)");

		$succes = $requete->execute(array(':id_contact'     => $_POST['id_contact'],
										  ':nom'        	=> $_POST['nom'],
							   			  ':prenom'     	=> $_POST['prenom'],
							   			  ':telephone'		=> $_POST['telephone'],
							   			  ':email'      	=> $_POST['email'],
							   			  ':type_contact'  	=> $_POST['type_contact'],
							   			  ':photo'         	=> $photo_bdd,));
        
        if ($succes) {
        $contenu .= '<div class="alert alert-success">Le contact a été enregistré.</div>';
    	} else {
        $contenu .= '<div class="alert alert-danger">Erreur lors de l\'enregistrement.</div>';
    	}
    } // fin de if empty $contenu
} // fin de if !empty POST

// Fonction 'MODIFIER'
if (isset($_GET['id_contact'])) {
	$requete = $pdo->prepare("SELECT * FROM contact WHERE id_contact = :id_contact");
	$succes = $requete->execute(array(':id_contact' => $_GET['id_contact']));
    $contact = $requete->fetch(PDO::FETCH_ASSOC);
}

?>

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<style>.custom-file {overflow: hidden;}</style>
    <title>Ajout d'un contact</title>
  </head>
  <body>
  	<div class="row">
		<div class="col-12 mt-4 text-center">
			<?php if(isset($_GET['id_contact'])) {
				echo '<h1>Modification d\'un contact</h1>';
			} else {
				echo '<h1>Ajout d\'un nouveau contact</h1>';
			}?>
		</div>
	</div>
	<hr>
	<div class="row justify-content-center">
		<div class="col-sm-4">
			<?php echo $contenu; ?>
			<form method="post" enctype="multipart/form-data">
				<input type="hidden" name="id_contact" value="<?php echo $contact['id_contact'] ?? 0; ?>">

				<div class="form-group">
					<label for="nom">Nom</label>
					<input type="text" class="form-control" name="nom" id="nom" value="<?php echo $contact['nom'] ?? ''; ?>">
				</div>
				<div class="form-group">
					<label for="prenom">Prénom</label>
					<input type="text" class="form-control" name="prenom" id="prenom" value="<?php echo $contact['prenom'] ?? ''; ?>">
				</div>
				<div class="form-group">
					<label for="telephone">Téléphone</label>
					<input type="text" class="form-control" name="telephone" id="telephone" value="<?php echo $contact['telephone'] ?? ''; ?>">
				</div>
				<div class="form-group">
					<label for="email">E-mail</label>
					<input type="text" class="form-control" name="email" id="email" value="<?php echo $contact['email'] ?? ''; ?>">
				</div>
				<div class="form-group">
					<label for="type_contact">Type de contact</label>
					<div>
					<select name="type_contact" id="type_contact">
						<option value="ami" <?php if (isset($contact['type_contact']) && $contact['type_contact'] == 'ami') echo 'selected'; ?>>Ami</option>
            			<option value="famille" <?php if (isset($contact['type_contact']) && $contact['type_contact'] == 'famille') echo 'selected'; ?>>Famille</option>
            			<option value="professionnel" <?php if (isset($contact['type_contact']) && $contact['type_contact'] == 'professionnel') echo 'selected'; ?>>Professionnel</option>
            			<option value="autre" <?php if (isset($contact['type_contact']) && $contact['type_contact'] == 'autre') echo 'selected'; ?>>Autre</option>
					</select>
					</div>
				</div>
				<div class="form-group">
					<label for="photo">Photo</label>
					<div class="custom-file">
						<input type="file" class="custom-file-input" name="photo" id="photo">
						<label class="custom-file-label" for="customFile">Choisiez une photo</label>
					</div>
					<!-- Fonction 'MODIFIER' -->
					<?php
					if (isset($contact['photo'])) {
						echo '<p class="mt-2">Photo actuelle du contact :</p>';
						echo '<img src="'.$contact['photo'].'" style="width: 90px">';
						echo '<input type="hidden" name="photo_actuelle" value="'.$contact['photo'].'">';
					}
					?>
					<!-- Fin de la fonction 'MODIFIER' -->
				</div>
				<div><input type="submit" value="Enregistrer" class="btn btn-primary mt-4"></div>
				</form>
				<button type="button" class="btn btn-danger mt-4" onclick="window.location.href='liste_contact.php'">Retour</button>
		</div>
	</div>

	<script src=https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js></script>
	<script>
		bsCustomFileInput.init()

		var btn = document.getElementById('photo')
		var form = document.querySelector('form')
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>