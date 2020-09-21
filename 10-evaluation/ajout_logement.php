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
$alerte = '';

//-------------------------
// Validation du formulaire
//-------------------------

if(!empty($_POST)) {
	 
    if (!isset($_POST['titre']) || strlen($_POST['titre']) < 5 || strlen($_POST['titre']) > 100 ){
        $alerte .= '<div class="alert alert-danger">Le champ "Titre" doit contenir entre 5 et 50 caractères.</div>';
    }

    if (!isset($_POST['adresse']) || strlen($_POST['adresse']) < 5 || strlen($_POST['adresse']) > 150 ){
        $alerte .= '<div class="alert alert-danger">Le champ "Adresse" doit contenir entre 5 et 150 caractères.</div>';
    }

    if (!isset($_POST['ville']) || strlen($_POST['ville']) < 3 || strlen($_POST['ville']) > 50 ){
        $alerte .= '<div class="alert alert-danger">Le champ "Ville" doit contenir entre 3 et 50 caractères.</div>';
    }

    if (!isset($_POST['cp']) || !preg_match('#^[0-9]{5}$#', $_POST['cp']) ){
        $alerte .= '<div class="alert alert-danger">Le champs "Code postal" doit contenir 5 chiffres.</div>';
    }

    if (!isset($_POST['surface']) || !filter_var($_POST['surface'], FILTER_VALIDATE_INT) || strlen($_POST['surface']) > 6) {
        $alerte .= '<div class="alert alert-danger">La surface n\'est pas valide.</div>';
    }

    if (!isset($_POST['prix']) || !filter_var($_POST['prix'], FILTER_VALIDATE_INT) || strlen($_POST['prix']) > 12) {
        $alerte .= '<div class="alert alert-danger">Le prix n\'est pas valide.</div>';
    }

    if (!isset($_POST['type']) || ($_POST['type'] != 'loc' && $_POST['type'] != 'vente' ) ) {
        $alerte .= '<div class="alert alert-danger">Le type de logement n\'est pas valide.</div>';
	}
    
    if(isset($_FILES['photo'])) {

        $maxsize = 2097152;
        $permis = array('gif', 'png', 'jpg', 'jpeg');
        $nomfichier = $_FILES['photo']['name'];
        $ext = pathinfo($nomfichier, PATHINFO_EXTENSION);
        
        if(($_FILES['photo']['size'] >= $maxsize) || ($_FILES['photo']['size'] == 0)) {
            $alerte .= '<div class="alert alert-danger">Le poids de la photo ne doit pas excédé 2 Mo</div>';
        }

        if (!in_array($ext, $permis)) {
            $alerte .= '<div class="alert alert-danger">L\'extension du fichier photo n\'est pas valide</div>';
        }
    }
	//---------------
    // Enregistrement
	//---------------
	if (empty($alerte)) {

		//-------------------
		// Upload de la photo
		//-------------------
		$photo_bdd = ''; // Par défaut la photo en bdd est vide

		if (!empty($_FILES['photo']['name'])) { // Si un fichier est en cours d'upload

            // Créer un dossier s'il n'en existe pas déjà un
            if(!is_dir("photos/"."/")) {
                mkdir("photos/"."/");
            }

            $extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
            $name = "logement_".date('d-m-Y_H:i:s').".".$extension;
            move_uploaded_file($_FILES["photo"]["tmp_name"], "photos/".$name.".".$extension);
            $photo_bdd = "photos/".$name.".".$extension;

		}

		// Echappement des caractères spéciaux
		foreach ($_POST as $indice => $valeur) {
			$_POST[$indice] = htmlspecialchars($valeur);
		}

		$requete = $pdo->prepare("INSERT INTO logement (titre, adresse, ville, cp, surface, prix, photo, type, description) VALUES (:titre, :adresse, :ville, :cp, :surface, :prix, :photo, :type, :description)");

		$succes = $requete->execute(array(':titre'        	=> $_POST['titre'],
							   			  ':adresse'     	=> $_POST['adresse'],
							   			  ':ville'		    => $_POST['ville'],
							   			  ':cp'      	    => $_POST['cp'],
                                          ':surface'  	    => $_POST['surface'],
                                          ':prix'  	        => $_POST['prix'],
                                          ':photo'         	=> $photo_bdd,
							   			  ':type'  	        => $_POST['type'],
		                                  ':description'  	=> $_POST['description'],));
        
        if ($succes) {
        $alerte .= '<div class="alert alert-success">Le logement a été enregistré.</div>';
    	} else {
        $alerte .= '<div class="alert alert-danger">Erreur lors de l\'enregistrement.</div>';
    	}
    } // fin de if empty $alerte
} // fin de if !empty POST


?>

<!doctype html>
<html lang="fr">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <style>.custom-file {overflow: hidden;}</style>
    <title>Ajout d'un logement</title>
  </head>
  <body>
    <div class="row">
        <div class="col-12 mt-4 text-center">
            <h1>Ajout d'un logement</h1>
        </div>
    </div>
    <hr>
	<div class="row justify-content-center">
		<div class="col-sm-6">
			<?php echo $alerte; ?>
			<form method="post" enctype="multipart/form-data">
				<input type="hidden" name="id_logement" id="id_logement">

				<div class="form-group">
					<label for="titre">Titre</label>
					<input type="text" class="form-control" name="titre" id="titre">
				</div>
				<div class="form-group">
					<label for="adresse">Adresse</label>
					<input type="text" class="form-control" name="adresse" id="adresse">
				</div>
				<div class="form-group">
					<label for="ville">Ville</label>
					<input type="text" class="form-control" name="ville" id="ville">
				</div>
				<div class="form-group">
					<label for="cp">Code postal</label>
					<input type="text" class="form-control" name="cp" id="cp">
				</div>
				<div class="form-group">
					<label for="surface">Surface (m²)</label>
					<input type="text" class="form-control" name="surface" id="surface">
				</div>
                <div class="form-group">
					<label for="prix">Prix (€)</label>
					<input type="text" class="form-control" name="prix" id="prix">
				</div>
				<div class="form-group">
					<label for="photo">Choisiez une photo</label>
					<div class="custom-file">
						<div><input type="file" name="photo" id="photo"></div>
					</div>
				</div>
                <div class="form-group">
                    <div><label for="type">Type de logement</label></div>
                    <div>
                        <input type="radio" name="type" value="loc" checked> Location 
                        <input type="radio" name="type" value="vente"> Vente 
				    </div>
                </div>
                <div class="form-group">
					<label for="description">Description</label>
					<textarea name="description" class="form-control" id="description" rows="5"></textarea>
				</div>
				<div><input type="submit" value="Enregistrer" class="btn btn-primary mt-4"></div>
			</form>

			<button type="button" class="btn btn-danger mt-4 mb-4" onclick="window.location.href='liste_logement.php'">Retour</button>
		</div>
	</div>





    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>