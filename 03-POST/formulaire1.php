<?php

//-------------------------------------------
// La superglobale $_POST
//-------------------------------------------

// $_POST est une superglobale qui permet de récupérer les données saisies dans un formulaire.

// $_POST étant une superglobale est donc un array et est disponible dans tous les contextes du script, y compris au sein des fonctions sans y faire "global $_POST".

// Les données saisies dans le formulaire son réceptionnées dans $_POST de la manière suivante : $_POST = array('name1' => 'valeur input1', 'nameN' => 'valeur inputN');

echo '<pre>';
print_r($_POST); // Pour vérifier que le formulaire envoie bien des données
echo '</pre>';

if (!empty($_POST)) { // Si n'est pas vide $_POST c'est que l'on a reçu des données du formulaire. On peut donc en afficher le contenu :
    echo '<p>Prénom : ' . $_POST['prenom'] . '</p>';
    echo '<p>Description : ' . $_POST['description'] . '</p>';
}

// Remarque :
// - Cliquer dans l'URL et faire "entrer" permet de réinitialiser le formulaire comme si nous venions pour la première fois
// - Faire F5 ou CTRL+R permet de rafraichir la page et de renvoyer les dernieres données saisies dans le formulaire

?>
<h1>Formulaire</h1>

<form method="post" action=""> <!-- Un formulaire doit toujours être dans une balise FORM pour fonctionner. L'attribut METHOD définit comment les données vont circuler entre le navigateur et le serveur. L'attribut ACTION définit l'URL de destination des donnée saisies.-->

    <div><label for="prenom">Prénom</label></div>
    <div><input type="text" name="prenom" id="prenom"></div> <!-- Il ne faut pas oublier les "name" dans les formulaires. Ils constituent les indices du tableau $_POST qui réceptionne les données-->

    <div><label for="description">Description</label></div> <!-- L'attribut FOR n'est pas indispensable mais il permet de relier le label à l'input qui porte l'id de même valeur, ainsi quand on clique sur l'étiquette, le curseur se positionne dans l'input-->
    <div><textarea name="description" id="description"></textarea></div>

    <div><input type="submit" value="envoyer"></div>

</form>