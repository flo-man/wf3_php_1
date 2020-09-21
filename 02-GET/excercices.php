<?php
// Excercice :
/*
    1 - Vous affichez dans ce script : un titre "Mon Profil", un nom et un pérnom.
    2 - Vous y ajoutez un lien en $_GET pour "modifier mon profil". Ce lien passe dans l'URL à la page excercice.php que l'action demandée est modification.
    3 - Si vous recevez cette information depuis l'URL vous affichez "Vous avez demandé la modification de votre profil".
*/
if (isset($_GET['action']) && $_GET['action'] == 'modifier') {
    print_r($_GET);
    echo '<p>Vous avez demandé la modification de votre profil <a href="excercices.php">Recommencer</a></p>';
} elseif (isset($_GET['action']) && $_GET['action'] == 'supprimer') {
    print_r($_GET);
    echo '<p>Vous avez demandé la suppression de votre profil <a href="excercices.php">Recommencer</a></p>';
}
?>

<h1>Mon Profil</h1>

<p>Nom : Matrix</p>
<p>Prénom : John</p>

<a href="excercices.php?action=modifier">Modifier mon Profil</a>
<a href="excercices.php?action=supprimer">Supprimer mon Profil</a>