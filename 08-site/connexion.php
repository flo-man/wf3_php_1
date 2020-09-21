<?php
require_once 'inc/init.php';
//---------------------------------- TRAITEMENT PHP -------------------------------------//
$message = ''; // Pour afficher le message de déconnexion

// 2) Déconnexion de l'internaute :

// debug($_GET);
if (isset($_GET['action']) && $_GET['action'] == 'deconnexion') { // Si le membre a cliqué sur "déconnexion"
    // debug($_SESSION);
    unset($_SESSION['membre']); // On ne fait pas un session_destroy qui supprimerait toute la session, car on veut pouvoir conserver le panier de l'internaute.
    $message = '<div class="alert alert-info">Vous êtes déconnecté</div>';
}

// 3) Le membre déjà connecté est redirigé vers son profil :

if(estConnecte()) {
    header('location:profil.php'); // Nous affichons le formulaire de connexion qu'aux membre non-connectés, les autres sont redirigés vers le profil.
    exit(); // Pour quitter le script
}

// 1) Traitement du formulaire
// debug($_POST);

if (!empty($_POST)) { // Si le formulaire a été envoyé

    // Controle du formulaire
    if (empty($_POST['pseudo']) || empty($_POST['mdp'])) { // Si les champs pseudo ou mdp sont vide ou non définis
        $contenu .='<div class="alert alert-danger">Les identifiants sont obligatoires</div>';
    }

    // S'il n'y a pas de message d'erreur à l'internaute, on cherche le pseudo en BdD :
    if (empty($contenu)) { // Si c'est vide c'est qu'il n'y a pas d'erreur

        $resultat = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo", array(':pseudo' => $_POST['pseudo']));

        if ($resultat->rowCount() == 1) { // S'il y a une ligne $resultat alors le pseudo existe. On peut vérifier le mdp
            
            $membre = $resultat->fetch(PDO::FETCH_ASSOC); // on "fetch" l'objet $resultat pour en extraire les données du membre (pas de boucle car le pseudo est unique)
            // debug($membre);

            // On vérifie le mdp
            if (password_verify($_POST['mdp'], $membre['mdp'])) { // Si le mdp du formulaire correspond au hash du mdp en BdD alors cette fonction retourne true.
                // On conntecte le membre
                $_SESSION['membre'] = $membre; // Nous remplaçons la session (ouverte avec le session_start() de init.php) avec les infos du membre qui proviennent de la BdD

                // Puis on redirige vers la page du profil :
                header('location:profil.php');

                exit(); // On quite le script

            } else {
                $contenu .='<div class="alert alert-danger">Erreur sur le mot de passe</div>';
            }




        } else { // s'il n'y a pas de ligne dans $resultat c'est que le pseudo n'existe pas dans la BdD
            $contenu .='<div class="alert alert-danger">Erreur sur le pseudo</div>';
        }

    } // Fin if empty contenu

} // Fin if !empty POST



//---------------------------------- Affichage -------------------------------------//
require_once 'inc/header.php';
?>

<h1 class="mt-4">Connexion</h1>
<?php
echo $message; // Pour le message de déconnexion
echo $contenu; // Pour les messages de connexion
?>
<form action="" method="post">

    <div><label for="pseudo">Pseudo</label></div>
    <div><input type="text" name="pseudo" id="pseudo"></div>

    <div><label for="mdp">Mot de passe</label></div>
    <div><input type="password" name="mdp" id="mdp"></div>

    <div class="mt-4"><input type="submit" value="Se connecter" class="btn btn-info"></div>

</form>



<?php
require_once 'inc/footer.php';