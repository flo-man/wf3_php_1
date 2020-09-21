<?php

//---------------------------------------
// La superglobale $_COOKIE
//---------------------------------------

// Un cookie est un petit fichier (4ko max) déposé par le serveur du site dans le navigateur de l'internaute et qui peut contenir des informations. Les cookies sont automatiquement renvoyés au serveur web par le navigateur quand l'internaute navigue dans les pages concernées par le cookie. PHP permet de récupérer très facilement les données contenues dans un cookie : ses information sont stockées dans la superglobale $_COOKIE.

// Précautions à prendre avec les cookies :
// Etant sauvegardé dans le poste de l'internaute, le cookie peut être volé ou modifié. On n'y met donc pas d'informations sensibles (prix de panier, carte bancaise, mdp, ...) mais des préférences ou des traces de visite

// Application :
// Nous allons stocker la langue séléctionnée par l'internaute dans un cookie

// 2 - On détermine la langue d'affichage de l'internaute :
if (isset($_GET['langue'])) { // si on a cliqué sur 1 langue, l'indice langue est passée dans l'URL et donc se trouve dans $_GET
    $langue = $_GET['langue']; // On affecte alors la valeur de la langue à la variable $langue ("fr" ou "es" etc)
} elseif (isset($_COOKIE['langue'])) { // sinon si on a reçu un cookie appelé "langue"
    $langue = $_COOKIE['langue']; // affecte la valeur stockée dans le cookie
} else {
    $langue = 'fr'; // par défaut, si on a pas cliqué et qu'aucun cookie n'existe, la langue sera "fr".
}

// 3 - On envoie le cookie :
$un_an = time() + 365*24*60*60; // time() retourne le timestamp de l'instant présent auquel on ajoute 1 an exprimé en secondes


setcookie('langue', $langue, $un_an); // On envoie un cookie appelé 'langue', avec comme valeur celle qui est dans $langue, et pour date d'expiration $un_an

// 4 - On affiche la langue :
echo "<h2>Langue du site : $langue</h2>";

// setcookie() permet de créer un cookie, cependant il n'y a pas de fonction prédéfinie permettant de le supprimer. Pour cela, on le met à jour avec une date périmée (dépassée) ou à 0 ou encore en mettant juste le nom du cookie sans les autres arguments

// 1 - Le HTML
?>

<h1>Langue</h1>

<ul>
    <li><a href="?langue=fr">Français</a></li>
    <li><a href="?langue=es">Español</a></li>
    <li><a href="?langue=en">English</a></li>
    <li><a href="?langue=it">Italien</a></li>
</ul>

