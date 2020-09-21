<?php

//----------------------------------------—–
// Cas pratique : formulaire pour poster des commentaires
//----------------------------------------—–

// Objectif : protéger la requête SQL dont les données viennent de l'internaute

/*
Création de la BdD :
Nom de la BdD : dialogue
Nom de la table : commentaire
Colonnes (champs) : id_commentaire INT PK AI
                    pseudo VARCHAR(50)
                    message TEXT
                    date_enregistrement DATETIME
*/

// 2) Connexion à la BdD et Traitement de $_POST :
$pdo = new PDO('mysql:host=localhost;dbname=dialogue', 
               'root',
               'root',
               array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
               ));

if (!empty($_POST)) { // Si le formulaire a été envoyé

    // 5) Traitement contre les failles XSS (JavaScript) et les failles CSS : on parle d'Échapper les données
    // Pour l'exemple on injecte ce css : <style>body{display: none};</style>
    // Pour s'en prémunire nous faisons :
    $_POST['pseudo'] = htmlspecialchars($_POST['pseudo'], ENT_QUOTES);
    $_POST['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES); // Cette fonction prédéfinie convertie les charactères spéciaux ('<', '>', '&', '"') en entitée HTML (ex: le < devient $lt; le > devient $gt; les guillemets deviennent &quot; etc).


    // Nous insérons le message en BdD avec une requête qui n'est pas protégée contre les injections et qui n'accepte pas les apostrophes :

    // $resultat = $pdo->query("INSERT INTO commentaire (pseudo, date_enregistrement, message) VALUES ('$_POST[pseudo]', NOW(), '$_POST[message]')"); // Ici on insère directement dans la requête des données qui viennent d'un formulaire sans avoir pris de précautions.

    // 4) Nous faisons l'injection SQL suivante      '); DELETE FROM commentaire; #
    // Cette injection a pour effet de vider la table.

    // Pour s'en prémunire nous faisons la requête préparée suivante (en commentant la requête précédente) :
    $resultat = $pdo->prepare("INSERT INTO commentaire (pseudo, date_enregistrement, message) VALUES (:pseudo, NOW(), :message)");
    $resultat->execute(array(
        ':pseudo' => $_POST['pseudo'],
        ':message' => $_POST['message'],
    ));

    // Avec la requête préparée, on constate que l'injection SQL est neutralisée. Par ailleurs, on peut mettre des apostrophes dans le formulaire.
    // Comment ça marche ? le fait de mettre des marqueurs dans la requête évite que les instructions SQL d'origine et injectées se concatènent. Ces instructions ne s'exéctuent donc plus ensemble. En liant les marqueurs vides à leur valeur dans execute(), les instruction SQL sont neutralisées par cette méthode qui les rend inoffensives. La BdD ne les exécute donc pas.



} // FIN DU IF NOT EMPTY POST



// 1) Formulaire
// print_r($_POST);
?>

<h1>Votre Message</h1>

<form method="post">

    <div><label for="pseudo">Pseudo</label></div>
    <div><input type="text" name="pseudo" id="pseudo" value="<?php echo $_POST['pseudo'] ?? ''; ?>"></div>

    <div><label for="message">Message</label></div>
    <div><textarea name="message" id="message"><?php echo $_POST['message'] ?? ''; ?></textarea></div>

    <div><input type="Submit"></div>

</form>

<?php

// 3) Affichage des commentaires :

$resultat = $pdo->query("SELECT pseudo, message, DATE_FORMAT(date_enregistrement, '%d/%m/%Y') AS datefr, DATE_FORMAT(date_enregistrement, '%H-%i-%s') AS heurefr FROM commentaire ORDER BY date_enregistrement DESC");

echo '<h2>' . $resultat->rowCount() . ' commentaires</h2>';

while ($commentaire = $resultat->fetch(PDO::FETCH_ASSOC)) {

    // print_r($commentaire); // On retrouve les alias de la requête sous forme d'indices dans le tableau $commentaire

    echo '<div><i>Par ' . $commentaire['pseudo'] . ' le ' . $commentaire['datefr'] . ' à ' . $commentaire['heurefr'] . '</i></div>';
    echo '<div>' . $commentaire['message'] . '</div>';
    echo '<hr>';

}