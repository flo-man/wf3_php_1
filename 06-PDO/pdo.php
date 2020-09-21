<?php
//------------------------------------—
// PDO - (PHP DATA OBJECT)
//------------------------------------—

// L'extension PDO, pour PHP Data Object, définit l'interface pour accéder à une BdD depuis PHP, et permet d'exéuter des requêtes SQL

function debug($var) {
    echo '<pre>';
        print_r($var);
    echo '</pre>';
}

//------------------------------------—
echo '<h2> Connexion à la BdD </h2>';
//------------------------------------—

$pdo = new PDO('mysql:host=localhost;dbname=entreprise', // driver mysql, serveur de la BdD (host), nom de la BdD (dbname) à changer
               'root', // pseudo de la BdD
               'root', // mdp de la BdD // (MAMP) (pour XAMP: '')
               array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // option 1 : on affiche les erreurs SQL
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' // option 2 : on définit le jeu de caractères des échanges avec la BdD
               )
);
// $pdo est un objet qui provient de al classe prédéfinie PDO et qui représente la connexion à la base de données

//------------------------------------—
echo '<h2> Requêtes avec exec() </h2>';
//------------------------------------—

// Nous insérons un employé :
$resultat = $pdo->exec("INSERT INTO employes (prenom, nom, sexe, service, date_embauche, salaire) VALUES ('test', 'test', 'm', 'test', '2020-08-26', 2000)");

/*
exec() est utilisé pour la formulation de requêtes ne retournant pas de résultat : INSERT, UPDATE, DELETE.
Valeur de retour :
    - Succès : renvoie le nombre de lignes affectées
    - Échec : false
*/

echo "Nombre d'enregistrments affectés par l'INSERT : $resultat <br>";
echo "Dernier ID généré en BdD : " . $pdo->lastInsertId() . '<br>';

//-----------------
$resultat = $pdo->exec("DELETE FROM employes WHERE prenom = 'test'");
echo "Nombre d'enregistrments affectés par le DELETE : $resultat <br>";

//------------------------------------—
echo '<h2> Requêtes avec query() et fetch() pour un seul résultat </h2>';
//------------------------------------—

$resultat = $pdo->query("SELECT * FROM employes WHERE prenom = 'Daniel'");

/*
Au contraire de exec(), query() est utilisé pour la formulation de requêtes qui retournent un ou plusieurs résultats : SELECT.

Valeur de retour :
    - Succès : query() retourne un objet qui provient de la classe PDOstatement
    - Échec : false
*/

debug($resultat); // $resultat est le résultat de la requête de séléction sous forme inexploitable directement. Effectivement, nous ne voyons pas d'autres informations que "Daniel". Pour accéder à ces informations, il nous faut utiliser la méthode fetch().

$employe = $resultat->fetch(PDO::FETCH_ASSOC); // la méthode fecth() avec le paramètre PDO::FETCH_ASSOC retourne un tableau associatif exploitable dont les indices correspondent aux noms des champs de la requête. Ce tableau contient les données de Daniel.

debug($employe);
echo 'Je suis ' . $employe['prenom'] . ' ' . $employe['nom'] . ' du service ' . $employe['service'] . '<br>';

// On peut aussi utiliser les méthodes suivantes :
// 1
$resultat = $pdo->query("SELECT * FROM employes WHERE prenom = 'Daniel'");
$employe = $resultat->fetch(PDO::FETCH_NUM); // Pour obtenir un tableau indexé numériquement
debug($employe);
echo 'Je suis ' . $employe['1'] . ' ' . $employe['2'] . ' du service ' . $employe['4'] . '<br>';

// 2
$resultat = $pdo->query("SELECT * FROM employes WHERE prenom = 'Daniel'");
$employe = $resultat->fetch(); // Pour obtenir un mélange de tableau associatif et numérique
debug($employe);
echo 'Je suis ' . $employe['1'] . ' ' . $employe['2'] . ' du service ' . $employe['4'] . '<br>';

// 3
$resultat = $pdo->query("SELECT * FROM employes WHERE prenom = 'Daniel'");
$employe = $resultat->fetch(PDO::FETCH_OBJ); // Retourne un objet avec le nom des champs comme propriétés publiques
debug($employe);
echo 'Je suis ' . $employe->prenom . ' ' . $employe->nom . ' du service ' . $employe->service . '<br>';

// Note : vous ne pouvez pas faire plusieurs fetch() sur le même résultat, ce pourquoi nous répétons ici la requête

// Excercice : Affichez le service de l'employé dont l'id_employe est 417
$resultat = $pdo->query("SELECT * FROM employes WHERE id_employes = 417");
$employe = $resultat->fetch(PDO::FETCH_OBJ);
echo 'L\'employé portant l\'identifiant ' . $employe->id_employes . ' travail au service ' . $employe->service;

//------------------------------------—
echo '<h2> Requêtes avec query() et fetch() pour plusieurs résultats </h2>';
//------------------------------------—

$resultat = $pdo->query("SELECT * FROM employes");
echo 'Nombre d\'employés ' . $resultat->rowCount() . '<br>'; // Compte le nombre de lignes dans l'objet $resultat (contexte : nombre de produits dans une boutique).

debug($resultat);

while ($employe = $resultat->fetch(PDO::FETCH_ASSOC)) { // fetch() va chercher la ligne "suivante" du jeu de résultats qu'il retourne en tableau associatif. La boucle while () permet de faire avancer le curseur dans la table et s'arrête quand le curseur est à la fin des résultats (quand fetch() retourne false)

    debug($employe); // $employe est un tableau associatif qui contient les données de 1 employé par tour de boucle.

    echo '<div>';
        echo '<div>' . $employe['prenom'] . '</div>';
        echo '<div>' . $employe['nom'] . '</div>';
        echo '<div>' . $employe['service'] . '</div>';
        echo '<div>' . $employe['salaire'] . ' €</div>';
    echo '</div><hr>';

}

//------------------------------------—
echo '<h2> La méthode fetchAll() </h2>';
//------------------------------------—

$resultat = $pdo->query("SELECT * FROM employes");

$donnees = $resultat->fetchAll(PDO::FETCH_ASSOC); // fetchAll() retourne toutes les lignes de $resultat dans un tableau multidimensionnel : on a 1 tableau associatif par employé rangé à chaque indice numérique. Pour info on peut aussi faire FETCH_NUM pour un sous-tableau numérique ou un fetchAll() sans paramètre pour un sous-tableau numérique et associatif.

debug($donnees); // Il s'agît d'un tableau multidimensionnel

echo '<hr>';

// On parcourt le tableau $donnees avec une boucle foreach pour en afficher le contenu :

foreach ($donnees as $employe) { // $employe est lui même un tableau. On accède donc à ses valeurs par les indices entre [].

    // debug($donnees);
    echo '<div>';
        echo '<div>' . $employe['prenom'] . '</div>';
        echo '<div>' . $employe['nom'] . '</div>';
        echo '<div>' . $employe['service'] . '</div>';
        echo '<div>' . $employe['salaire'] . ' €</div>';
    echo '</div><hr>';

}

//------------------------------------—
echo '<h2> Excercice </h2>';
//------------------------------------—

// Afficher la liste des DIFFERENTS services dans une seule liste <ul> et avec un service par <li>

$resultat = $pdo->query("SELECT DISTINCT service FROM employes");

$services = $resultat->fetchAll(PDO::FETCH_ASSOC);

echo '<hr>';

echo '<ul>';
foreach ($services as $employe) { 

    echo '<li>' . $employe['service'] . '</li>';

}
echo '</ul>';

echo '<hr>';

$resultat = $pdo->query("SELECT service FROM employes GROUP BY service"); // /!\ ne pas oublier de refaire la requête avant un nouveau fetch, sinon on est déjà en dehors du jeu de résultats et donc il n'y a plus rien à récupèrer. /!\

echo '<ul>';
while ($employe = $resultat->fetch(PDO::FETCH_ASSOC)) { 

    echo '<li>' . $employe['service'] . '</li>';

}
echo '</ul>';

//------------------------------------—
echo '<h2> Table HTML </h2>';
//------------------------------------—

// On veut afficher dynamiquement le jeu de résultats sous forme de table HTML.
$resultat = $pdo->query("SELECT * FROM employes");
?>
<style>
    table, tr, th, td {
        border: 1px solid;
        text-align: center;
    }
    table {
        border-collapse: collapse;
    }
    tr:nth-child(even) {
        background-color: lightgrey;
    }
</style>
<?php
echo '<table>';
// Affichage de la ligne d'en tête
    echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Prénom</th>';
        echo '<th>Nom</th>';
        echo '<th>Sexe</th>';
        echo '<th>Service</th>';
        echo '<th>Date d\'embauche</th>';
        echo '<th>Salaire</th>';
    echo '</tr>';
    // Affichage des lignes
    while ($employe = $resultat->fetch(PDO::FETCH_ASSOC)) { // À chaque tour de boucle while(), le fetch() va chercher la ligne suivante qui correspond à 1 employé et retourne ses informations sous forme de tableau associatif. Comme il s'agît d'un tableau, nous faison ensuite une boucle foreach() pour le parcourir:

        echo '<tr>';

        foreach ($employe as $data) { // foreach() parcourt les données de chaque tableau employé et les affiche en colonne.
            echo '<td>' . $data . '</td>';
        }
        
        echo '</tr>';
    }

echo '</table>';

//------------------------------------—
echo '<h2> Requêtes préparées </h2>';
//------------------------------------—

//Les requêtes préparées sont préconisées si vous exécutez plusieurs fois la même requête et ainsi éviter de répéter le cycle complet (analye / interpretation / exécution) réalisé par le SGBD"mysql" (gain de performance). Les requêtes préparées sont aussi utilisées pour assainir les données (se prémunir des injections sql => chapitre ultérieur).

$nom = 'Sennard';

// Une requête préparée se réalise en 3 étapes :
// 1) On prépare la requête :
$resultat = $pdo->prepare("SELECT * FROM employes WHERE nom = :nom "); // prepare() permet de préparer la requête mais ne l'exécute pas. :nom est un marqueur nominatif qui est vide et attend une valeur.

// 2) On lie le marqueur à sa valeur :
$resultat->bindParam(':nom', $nom); // bindParam() lie le marqueur :nom à la variable $nom. Remarque : cette méthode reçoit exclusivement une variabe en second argument. On ne peut pas y mettre une valeur directement.

$resultat->bindValue(':nom', 'Sennard'); // bindValue() lie le marqueur :nom à la valeur 'Sennard'. Contrairement à bindParam(), bindValue() reçoit au choix un valeur ou une variable.

// 3) On exécute la requête :
$resultat->execute(); // execute() permet d'exécuter une requête préparée avec prepare()
debug($resultat);

$employe = $resultat->fetch(PDO::FETCH_ASSOC);
echo $employe['prenom'] . ' ' . $employe['nom'] . ' du service ' . $employe['service'] . '<br>';

/*

    valeurs de retour :
        prepare() retourne toujours un PDOStatement
        execute() :
                Succès : true
                Échec : false
*/

//------------------------------------—
echo '<h2> Requêtes préparées: points complémentaires </h2>';
//------------------------------------—

echo '<h3>Le marqueur sous forme de "?"</h3>';

$resultat = $pdo->prepare("SELECT * FROM employes WHERE nom = ? AND prenom = ?"); // On prépare la requête avec les parties variables représentées avec des marqueurs sous forme de "?"

$resultat->bindValue(1, 'Durand'); // 1 représente le premier "?"
$resultat->bindValue(2, 'Damien'); // 2 représente le second "?"
$resultat->execute();

// OU encore directement dans le execute()
$resultat->execute(array('Durand', 'Damien'));

/*
    la flèche caractèrise les objets : $objet->methode();

    les crochets caractèrisent les tableaux : $tableau['indice'];
*/
debug($resultat);
$employe = $resultat->fetch(PDO::FETCH_ASSOC);
debug($employe);
echo 'Le service est ' . $employe['service'];

echo '<h3>Lier les marqueurs nominatifs à leur valeur directement dans execute ()</h3>';

$resultat = $pdo->prepare("SELECT * FROM employes WHERE nom = :nom AND prenom = :prenom");

$resultat->execute(array(':nom' => 'Chevel', ':prenom' => 'Daniel')); // On associe chaque marqueur à sa valeur directement dans un tableau. Note : nous ne sommes pas obligés de remettre les ":" devant les marqueurs dans ce tableau.

$employe = $resultat->fetch(PDO::FETCH_ASSOC);
echo 'Le service est ' . $employe['service'] . '<br>';

//******************************************** FIN ***********************************/