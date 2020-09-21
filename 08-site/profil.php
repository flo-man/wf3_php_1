<?php
require_once 'inc/init.php';

/* EXCERCICES : 
1 - Si le visiteur accède à cette page et qu'il n'est pas connecté, vous le redirigez vers la page de connexion

2 - Dans cette page, affichez toutes les informations de son profil. Par ailleurs, ajoutez un message de bienvenue juste après le h1 : 'Bonjour [prenom] [nom] !'

3 - Ajoutez un lien "supprimer mon compte" qui lorsqu'on le clique supprime le membre de la BdD après avoir demandé la confirmation de la suppresion en JS. Une fois le profil supprimé, vous détruisez la session et redirigez en page inscription.php

*/

// Excecrice 1)
if(!isset($_SESSION['membre'])) { // if (!estConnecte) { }
    header('location:connexion.php');
    exit();
}


// Excecrice 3) partie PHP SUPPRESSION DU COMPTE
if (isset($_GET['action']) && $_GET['action'] == 'supprimer') { // Le isset() est nécessaire car si "action" n'existe pas dans l'URL, donc dans $_GET, la condition s'arrête immédiatement sans regarder si "action" contient "supprimer". Dans le cas contraire (si on ne met pas isset()) nous aurions une erreur 'undefined index'
  $id_membre = $_SESSION['membre']['id_membre']; // je vais chercher mon id_membre dans la $_SESSION car je suis connecté.

  $supprimer = executeRequete("DELETE FROM membre WHERE id_membre = $id_membre");

  session_destroy(); // On déconnecte le membre en supprimant sa session

  header("location:inscription.php");
}




require_once 'inc/header.php';
?>
<h1 class="mt-4">Profil</h1>

<!-- Excecrice 2) -->

<h3>Bonjour <?php echo $_SESSION['membre']['prenom'] . ' ' . $_SESSION['membre']['nom'];  ?> !</h3>

<?php
if (estAdmin()) {
  echo '<p>Vous êtes administrateur.</p>';
}

?>
<hr>
<h4>Vos coordonnées :</h4>
<ul>
    <li>Pseudo : <?php echo $_SESSION['membre']['pseudo'];  ?></li>
    <li>Nom : <?php echo $_SESSION['membre']['nom'];  ?></li>
    <li>Prénom : <?php echo $_SESSION['membre']['prenom'];  ?></li>
    <li>E-mail : <?php echo $_SESSION['membre']['email'];  ?></li>
    <li>Civilité : <?php echo $_SESSION['membre']['civilite'];  ?></li>
    <li>Ville : <?php echo $_SESSION['membre']['ville'];  ?></li>
    <li>Code Postal : <?php echo $_SESSION['membre']['cp'];  ?></li>
    <li>Adresse : <?php echo $_SESSION['membre']['adresse'];  ?></li>
</ul>

<!-- Excecrice 3) Partie HTML-->

<hr>
<p><a href="profil.php?action=supprimer" onclick="return (confirm('Etes-vous sur de vouloir supprimer votre compte ?'))">Supprimer mon compte</a></p> <!-- 'confirm' retourne true lorsqu'on valide, puis return true déclence le lien. En revanche quand on annule, 'confirm' retourne false puis return false bloque le lien (équivaut à e.preventDefault) -->















<button type="button" class="btn btn-info mt-2" data-toggle="modal" data-target="#exampleModal">
  Supprimer mon compte
</button>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Suppression du compte</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Êtes-vous sûr de vouloir définitivement supprimer votre compte, ainsi que toutes les informations de votre profil ?
      </div>
      <div class="modal-footer">

            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            <button type="button" class="btn btn-info mt-2"><a href="profil.php?action=supprimer">Supprimer</a></button>

      </div>
    </div>
  </div>
</div>




<?php
require_once 'inc/footer.php';