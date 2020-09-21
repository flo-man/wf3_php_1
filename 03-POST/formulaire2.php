<?php
// Excercice : 
// - Créer un formulaire avec les champs : "Ville", "CP" et une zone de texte "adresse" dans cette page formulaire2.php.
// - Afficher les données saisies par l'internaute dans la page formulaire2-traitement.php



?>

<h1>Formulaire</h1>

<form action="formulaire2-traitement.php" method="post">

    <div><label for="ville">Ville</label></div>
    <div><input type="text" name="ville" id="ville"></div>

    <div><label for="CP">Code postal</label></div>
    <div><input type="text" name="CP" id="CP"></div>

    <div><label for="adresse">Adresse</label></div>
    <div><textarea name="adresse" id="adresse"></textarea></div>

    <div><input type="submit" value="envoyer"></div>

</form>