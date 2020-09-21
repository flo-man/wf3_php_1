<?php
/* Le fichier init.php sera inclus dans tous les scripts (hors inclusion) pour initialiser :
    - la connexion à la BdD
    - la création ou l'ouvertur de session
    - la définition du chemin du site sur le serveur
    - l'inclusion du fichier functions.php



*/

// Connexion à la BdD
$pdo = new PDO('mysql:host=localhost;dbname=site_commerce', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

// Création ou ouverture de session
session_start();

// Chemin du site
define('RACINE_SITE', '/php/08-site/'); // On indique ici les dossiers dans lesquels se situe le site à partir de localhost. Cela permet de créer des chemins absolus à partir de localhost (caractérisés par le / au début). Ils sont utilisés notamment dans header.php qui peut être inclus dans des fichiers appartenant à des dossiers ou des sous-dossiers différents. Par conséquant les chemins relatifs vers les sources changeraient, alors que les chemins absolus sont les mêmes.

// Variable d'affichage :
$contenu = '';

// Inclusion des fonctions
require_once 'functions.php'; // Fait l'inclusion une seule fois du fichier spécifié

