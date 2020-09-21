<h1>Les commerciaux et leurs salaires</h1>

<?php
// Excercice :
// 1 - Affichez dans une liste ul li le prénom, le nom et le salaire des commerciaux (1 commercial par li). Pour cela, vous faites une requête préparée.

// 2 - Affichez le nombre de commerciaux 

function debug($var) {
    echo '<pre>';
        print_r($var);
    echo '</pre>';
}

$pdo = new PDO('mysql:host=localhost;dbname=entreprise',
               'root',
               'root',
               array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
               )
);

// $resultat = $pdo->query("SELECT DISTINCT service FROM employes");

// $services = $resultat->fetchAll(PDO::FETCH_ASSOC);

// debug($services);

$service = 'commercial';

// 1)
$resultat = $pdo->prepare("SELECT * FROM employes WHERE service = :service ");

// 2)

$resultat->bindParam(':service', $service);
// debug($service);

// 3)
$resultat->execute();
// debug($resultat);

echo '1) Le salaire des employés du service commercial';
echo '<ul>';
while ($employe = $resultat->fetch(PDO::FETCH_ASSOC)) { 

    echo '<li>' . $employe['prenom'] . ' ' . $employe['nom'] . ' | ' . $employe['salaire'] . ' €</li>';

}
echo '</ul>';

echo '2) Nombre d\'employés du service commercial : ' . $resultat->rowCount() . '<br>';