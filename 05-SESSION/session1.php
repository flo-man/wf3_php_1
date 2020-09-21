<?php

//--------------------------------------
// La superglobale $_SESSION
//--------------------------------------

// Principe des sessions : Fichiers temporaires appelés "session" et créés sur le serveur avec un identifiant unique. Cette session est liée à un internaute car dans le même temps, un cookie est déposé dans son navigateur avec l'identifiant (dans localhost: PHPSESSID). Ce cookie se détruit lorsqu'on quitte le navigateur.

// La session peut contenir toute sorte d'informations, y compris sensibles, car elle n'est pas accessible par l'internaute, donc pas modifiable par celui-ci. On y stocke des données de login, les paniers d'achats, etc.

// Tous les sites qui fonctionnent sur le principe de connexion (site bancaire par ex) ou qui ont besoin de suivre un internaute de page en page (avec son panier par ex) utilisent des SESSIONs.

// Les données de fichier de SESSION sont accessibles et manipulables à partir de la superglobale $_SESSION

// Création d'une session :
session_start(); // permet de créer un fichier de session OU de l'ouvrir s'il existe déjà

// Remplissage du fichier de session :
$_SESSION['pseudo'] = 'tintin';
$_SESSION['mdp'] = 'milou'; // $_SESSION étant superglobale est un array. On accède donc à ses valeurs en passant par les indices écrits entre []

echo '1 - La session après remplissage : ';
print_r($_SESSION);
// Les sessions se trouvent dans le dossier "mamp/tmp(/php)"

// Vider une partie de la session :
unset($_SESSION['mdp']); // Nous supprimons le mot de passe avec unset()
echo '<br>' . '2 - La session après suppression du mdp : ';
print_r($_SESSION);

// Suppression de toute la session :
// session_destroy(); // Suppression de la session (fichier) mais il faut savoir que le session_destroy() est d'abord lu par l'interpréteur qui ne l'exécute qu'à la fin du script

echo '<br>' . '3 - La session après suppression : ';
print_r($_SESSION); // Nous avons fait un session_destroy() mais il ne sera exécuté qu'à la fin de ce script, c'est la raison pour laquelle nous avons encore accès aux informations ici.

// Les sessions ont l'avantage d'être disponible partout sur le site : voir session2.php
echo '<p><a href="session2.php">Aller Page 2</a></p>';
