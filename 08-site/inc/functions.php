<?php
// Fonctions du site

// DEBUG
function debug($var) {
    echo '<pre>';
        print_r($var);
    echo '</pre>';
}

//-------------------
// Fonction qui indique si l'internaute est connecté

function estConnecte() {

    if(isset($_SESSION['membre'])) { // si "membre" existe dans la session, c'est que l'internaute est passé par la page de connexion avec les bons pseudo / mdp
        return true; // Il est connecté
    } else {
        return false; // Il n'est pas connecté
    }

}

//-------------------------
// Fonction qui indique si le membre connecté est administrateur

function estAdmin() { 
    if(estConnecte() && $_SESSION['membre']['statut'] == 1)  { // Si le membre est connecté alors on regarde son statut dans la session. S'il vaut '1' alors il est bien admin.
        return true; // Le membre est admin connecté
    } else {
        return false; // Il ne l'est pas
    }
}

//-------------------------
// Fonction qui exécute les requêtes

function executeRequete($requete, $param = array()) { // Le paramète $requete reçoit une requête SQL. Le paramète $param reçoit un tableau avec les marqueurs associés à leur valeur. Dans le cas où le tableau n'est pas fourni, $param prend un array() vide par défaut
    
    // Echappement des données avec htmlspecialchars() :
    foreach ($param as $indice => $valeur) {
        $param[$indice] = htmlspecialchars($valeur); // On prend la valeur de $param que l'on passe dans htmlspecialchars() pour transformer les chevrons en entitées html qui neutralisent les balises <style> et <script> éventuellement injectée dans le formulaire. Evite les risques XSS et CSS. Puis on range cette valeur échappée dans son emplacement d'origine qui est $param[$indice].
    }

    global $pdo; // permet d'accéder à la variable $pdo qui est déclarée dans le init.php, autrement dit dans l'espace global, or nous sommes ici dans un espace local (function).

    $resultat = $pdo->prepare($requete); // On prépare la requête reçue dans $requete
    $succes = $resultat->execute($param); // Puis on l'exécute en lui donnant le tableau qui associe les marqeurs à leurs valeurs

    // var_dump($succes); // execute() renvoie toujours un booléen quand la requête a marché, sinon false.

    if ($succes) { // Si $succes contient true (la requête a marché) je retourne alors $resultat qui contient le jeu de résultats du SELECT (objet PDOStatement).
        return $resultat;
    } else { // Sinon, si erreur dans la requête, on retourne false
        return false;
    }

}

//-------------------------
// Fonction qui calcul le total des prix du panier
function montantTotal() {
    $total = 0;
    for ($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++) {
        $total += $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i]; // += permet de ne pas écraser la dernière valeur
    }
    return($total);
}