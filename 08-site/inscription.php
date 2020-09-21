<?php
require_once 'inc/init.php';
$affiche_formulaire = true; // Pour afficher le formulaire tant que le membre n'est pas inscrit

//---------------------------------- TRAITEMENT PHP -------------------------------------//
// debug($_POST);

if (!empty($_POST)) { // Si $_POST n'est pas vide, c'est que le formulaire a été envoyé

    //-------------------------
    // Validation du formulaire
    //-------------------------
    if (!isset($_POST['pseudo']) || strlen($_POST['pseudo']) < 4 || strlen($_POST['pseudo']) > 20 ){ // Si le pseudo n'existe pas dans $_POST ou si sa valeur est inférieur à 4 ou si elle est supérieur à 20, on met un message à l'internaute
        $contenu .= '<div class="alert alert-danger">Le pseudo doit contenir entre 4 et 20 caractères.</div>';
    }

    if (!isset($_POST['mdp']) || strlen($_POST['mdp']) < 4 || strlen($_POST['mdp']) > 20 ){ // Si le pseudo n'existe pas dans $_POST ou si sa valeur est inférieur à 4 ou si elle est supérieur à 20, on met un message à l'internaute
        $contenu .= '<div class="alert alert-danger">Le mot de passe doit contenir entre 4 et 20 caractères.</div>';
    }

    if (!isset($_POST['nom']) || strlen($_POST['nom']) < 1 || strlen($_POST['nom']) > 20 ){ // Si le pseudo n'existe pas dans $_POST ou si sa valeur est inférieur à 4 ou si elle est supérieur à 20, on met un message à l'internaute
        $contenu .= '<div class="alert alert-danger">Le pseudo doit contenir entre 1 et 20 caractères.</div>';
    }

    if (!isset($_POST['prenom']) || strlen($_POST['prenom']) < 1 || strlen($_POST['prenom']) > 20 ){ // Si le pseudo n'existe pas dans $_POST ou si sa valeur est inférieur à 4 ou si elle est supérieur à 20, on met un message à l'internaute
        $contenu .= '<div class="alert alert-danger">Le prénom doit contenir entre 1 et 20 caractères.</div>';
    }

    if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || strlen($_POST['email']) > 50) { // La fonction prédéfinie filter_var() avec l'argument FILTER_VALIDATE_EMAIL vérifie que le string fourni est bien un email
        $contenu .= '<div class="alert alert-danger">L\'e-mail n\'est pas valide.</div>';
    }

    if (!isset($_POST['ville']) || strlen($_POST['ville']) < 1 || strlen($_POST['ville']) > 20 ){ // Si le pseudo n'existe pas dans $_POST ou si sa valeur est inférieur à 4 ou si elle est supérieur à 20, on met un message à l'internaute
        $contenu .= '<div class="alert alert-danger">La ville doit contenir entre 1 et 20 caractères.</div>';
    }

    if (!isset($_POST['adresse']) || strlen($_POST['adresse']) < 4 || strlen($_POST['adresse']) > 50 ){ // Si le pseudo n'existe pas dans $_POST ou si sa valeur est inférieur à 4 ou si elle est supérieur à 20, on met un message à l'internaute
        $contenu .= '<div class="alert alert-danger">L\'adresse doit contenir entre 4 et 50 caractères.</div>';
    }

    if (!isset($_POST['civilite']) || ($_POST['civilite'] != 'm' && $_POST['civilite'] != 'f') ) {
        $contenu .= '<div class="alert alert-danger">La civilité n\'est pas valide.</div>';
    }

    if (!isset($_POST['cp']) || !preg_match('#^[0-9]{5}$#', $_POST['cp']) ) {
        $contenu .= '<div class="alert alert-danger">Le code postal n\'est pas valide.</div>';
    }

    //-------------------------
    // S'il n'y a plus d'erreur dans le formulaire, on vérifie si le pseudo existe ou pas avant d'inscrire l'internaute en BdD
    //-------------------------
    if (empty($contenu)) { // si la variable est vide (et qu'il n'y a pas de message d'erreur)
        // On vérifie le pseudo en BdD :
        $resultat = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo", array(':pseudo' => $_POST['pseudo']));

        if ($resultat->rowCount() > 0) { // si la requête retourne une ou plusieurs ligne, c'est que le pseudo est déjà en BdD
            $contenu .= '<div class="alert alert-danger">Le pseudo est indisponible, veuillez en choisir un autre.</div>';
        } else {
            // Inscription en BdD
            $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); // Nous hashons le mot de passe avec l'algorithme bcrypt par défaut qui nous retourne une clé de hashage. Nous allons l'insérer en BdD.
            // debug($mdp);
            $succes = executeRequete(
                "INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, cp, adresse, statut) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite, :ville, :cp, :adresse, :statut)",
                array(':pseudo'     => $_POST['pseudo'],
                      ':mdp'        => $mdp, // On prend le mdp hashé
                      ':nom'        => $_POST['nom'],
                      ':prenom'     => $_POST['prenom'],
                      ':email'      => $_POST['email'],
                      ':civilite'   => $_POST['civilite'],
                      ':ville'      => $_POST['ville'],
                      ':cp'         => $_POST['cp'],
                      ':adresse'    => $_POST['adresse'],
                      ':statut'     => 0, // 0 pour un membre non-admin
            ));

        $contenu .= '<div class="alert alert-success">Vous êtes inscrit. <a href="connexion.php">Cliquez ici pour vous connecter</a></div>';
        $affiche_formulaire = false; // Pour ne plus afficher le formulaire
        }
    } // fin de if (empty($contenu))
} // fin de if (!empty($_POST))





//---------------------------------- Affichage -------------------------------------//
require_once 'inc/header.php';
?>
<h1 class="mt-4">Inscription</h1>
<?php
echo $contenu; // Pour les messages à l'internaute
if ($affiche_formulaire) : // Syntaxe en if () : .... endif; . Si le membre n'est pas inscrit on lui affiche le formulaire
?>
    <form action="" method="post">

        <div><label for="pseudo">Pseudo</label></div>
        <div><input type="text" name="pseudo" id="pseudo" value="<?php echo $_POST['pseudo'] ?? ''; ?>"></div>

        <div><label for="mdp">Mot de passe</label></div>
        <div><input type="password" name="mdp" id="mdp"></div>

        <div><label for="nom">Nom</label></div>
        <div><input type="text" name="nom" id="nom" value="<?php echo $_POST['nom'] ?? ''; ?>"></div>

        <div><label for="prenom">Prénom</label></div>
        <div><input type="text" name="prenom" id="prenom" value="<?php echo $_POST['prenom'] ?? ''; ?>"></div>

        <div><label for="email">E-mail</label></div>
        <div><input type="text" name="email" id="email" value="<?php echo $_POST['email'] ?? ''; ?>"></div>

        <div><label>Civilité</label></div>
        <div>
            <input type="radio" name="civilite" value="m" checked>Monsieur
            <input type="radio" name="civilite" value="f" <?php if(isset($_POST['civilite']) && $_POST['civilite'] == 'f') echo 'checked';?>>Madame
        </div>

        <div><label for="ville">Ville</label></div>
        <div><input type="text" name="ville" id="ville" value="<?php echo $_POST['ville'] ?? ''; ?>"></div>

        <div><label for="cp">Code postal</label></div>
        <div><input type="text" name="cp" id="cp" value="<?php echo $_POST['cp'] ?? ''; ?>"></div>

        <div><label for="adresse">Adresse</label></div>
        <div><textarea name="adresse" id="adresse" cols="30" rows="5"><?php echo $_POST['adresse'] ?? ''; ?></textarea></div>

        <div><input type="submit" value="S'inscrire" class="btn btn-info mt-2"></div>

    </form>



<?php
endif;
require_once 'inc/footer.php';