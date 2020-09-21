<?php
// Ouverture de la session
session_start(); // Lorsque je fais un session_start() ici, la session n'est pas recréée car elle existe déjà grâce au session_start() situé dans le fichier session1.php

echo 'Le fichier de session reste accessible dans tous les scripts du site comme ici : ';
print_r($_SESSION);

// Ce fichier session2.php n'a pas de lien avec le précédent, il n'y a pas d'inclusion, il pourrait être dans n'importe quel dossier, s'appeler n'importe comment, les données contenues restent accessibles grâce à la session.
echo '<p><a href="session1.php">Aller Page 1</a></p>';