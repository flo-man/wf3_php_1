<style>
    h2 {
        border-top: 1px solid navy;
        border-bottom: 1px solid navy;
        color: navy;
    }

    table {
        border: 1px solid;
    }
    
    td {
        border: 1px solid;
    }
</style>

<?php 

//-----------------------------------
echo '<h2> Les Balises PHP </h2>';
//-----------------------------------

?>

<?php
// Pour ouvrir un passage PHP on utilise la balise précédente (ligne 17)
// Pour fermer un passage en PHP on utilise la balise suivante :
?>

<p>Ici je suis en HTML</p> <!-- En dehors des balises d'ouverture et de fermeture PHP, nous pouvons écrire du HTML quand on est dans un fichier ayant l'extension PHP -->

<?php 
// On n'est pas obligé de fermer un passage PHP en fin de script.

// pour faire 1 ligne de commentaire
# pour faire 1 ligne de commentaire

/*
pour faire plusieurs
lignes de commentaire
*/

//-----------------------------------
echo '<h2> Affichage </h2>';
//-----------------------------------

echo 'Bonjour !<br>'; // echo permet d'effectuer un affichage dans le navigateur, nous pouvons y mettre des balises HTML sous forme de string. Notez que toutes les instructions se terminent par un ';'.

print 'Nous sommes jeudi <br>'; // autre instruction d'affichage dans le navigateur.

// Autres instructions d'affichage que nous verrons plus loin :
print_r('code');
echo '<br>';
var_dump('code');

//-----------------------------------
echo '<h2> Variable </h2>';
//-----------------------------------

// Une variable est un espace mémoire qui porte un nom et qui permet de conserver une valeur.
// Dans PHP on représente une variable avec le signe '$'.

$a = 127; // On déclare la variable 'a' et lui affecte la valeur 127.
echo gettype($a); // gettype est une fonction prédéfinie qui permet de voir le type d'une variable. Ici il s'agit d'un INTEGER (ce qui signifie ENTIER)
echo '<br>';

$a = 1.5;
echo gettype($a); // Ici nous avons un DOUBLE (=FLOAT) : un nombre à virgule.
echo '<br>';

$a = 'une chaine de caractères';
echo gettype($a); // Ici nous avons un STRING
echo '<br>';
$a = '127';
echo gettype($a); // Un nombre écrit entre quotes ou guillemets est interprété comme un STRING
echo '<br>';

$a = true; // ou false
echo gettype($a); // Ici nous avons un BOOLEAN (booléen)
echo '<br>';

// Par convention, un nom de variable commence par une minuscule, puis on met une majuscule à chaque mot (camelCase). Il peut contenir des chiffres (jamais au début!) ou un tiret du bas '_' (pas au début ni à la fin!). Exemple $maVariable1

//-----------------------------------
echo '<h2> Guillemets et quotes </h2>';
//-----------------------------------

$message = "aujourd'hui"; // ou bien :
$message = 'aujourd\'hui'; // on échappe l'apostrophe dans les quotes simples

$prenom = "John";
echo ("Bonjour $prenom <br>"); // Quand on écrit une variable dans des guillemet elle est évaluée: son contenu est affiché (ici John)
echo ('Bonjour $prenom <br>'); // Dans des quotes simples, tout est du texte brut: c'est le nom de la variable qui est affiché

//-----------------------------------
echo '<h2> Concaténation </h2>';
//-----------------------------------

// En PHP on concatène les éléments avec le point '.'
$x = 'Bonjour ';
$y = 'tout le monde';
echo $x . $y . ' ! <br>'; // Concaténation de variables et d'un string. On peut traduire le point de concaténation par "suivi de ..."

//-----
// Concaténation lors de l'affectation avec l'opérateur .=
$message = '<p>Erreur dans le champ email</p>';
$message .= '<p>Erreur dans le champ téléphone</p>'; // Avec l'opérateur combiné .= on ajoute la nouvelle valeur SANS remplacer la valeur précédente dans la variable $message.
echo $message; // On affiche donc les 2 messages.

//-----------------------------------
echo '<h2> Constante </h2>';
//-----------------------------------

// Une constante permet de conserver une valeur sauf que celle-ci ne peut pas changer. C'est-à-dire qu'on ne pourra pas la modifier durant l'exécution du script. Utile pour conserver par exemple les paramètres de connexion à la BdD.

define('CAPITALE_FRANCE', 'Paris'); // Définit la constante appelée CAPITALE_FRANCE à laquelle on donne la valeur Paris. Par convention le nom des constantes est toujours en majuscule.
echo CAPITALE_FRANCE . '<br>'; // affiche 'Paris'

// Autre façon :
const TAUX_CONVERSION = 6.55957; // Définit la constante de conversion.
echo TAUX_CONVERSION . '<br>'; // Affiche '6.55957'

// Quelques constantes magiques :
echo __DIR__ . '<br>'; // Contient le chemin complet vers notre dossier
echo __FILE__ . '<br>'; // Contient le chemin complet vers notre fichier

//-------
// Excercice : afficher Bleu-Blanc-Rouge en mettant le texte de chaque couleur dans une variable.

$b = 'Bleu';
$w = 'Blanc';
$r = 'Rouge';
echo $b . '-' . $w . '-' . $r . '<br>'; // Option 1
echo "$b-$w-$r <br>"; // Option 2

$couleurs = 'Bleu-';
$couleurs .= 'Blanc-';
$couleurs .= 'Rouge';
echo $couleurs; // Option 3

//-----------------------------------
echo '<h2> Les Opérateurs Arithmétiques </h2>';
//-----------------------------------

$a = 10;
$b = 2;
echo $a + $b . '<br>'; // Affiche 12
echo $a - $b . '<br>'; // Affiche 8
echo $a * $b . '<br>'; // Affiche 20
echo $a / $b . '<br>'; // Affiche 5
echo $a % $b . '<br>'; // modulo = reste de la division entière. Exemple : 3%2 = 1, car si on a 3 billes, on les répartit sur 2 joueurs, il nous en reste 1. Ici, affiche 0.

//----------------
// Les Opérateurs Arithmétiques Combinés
$a += $b; // équivaut à $a = $a + $b
echo $a . '<br>';

$a -= $b; // équivaut à $a = $a - $b, soit $a = 12 - 2. $a vaut donc à la fin 10.
$a *= $b; // équivaut à $a = $a * $b, soit $a = 10 * 2. $a vaut donc à la fin 20.
$a /= $b; // équivaut à $a = $a / $b, soit $a = 20 / 2. $a vaut donc à la fin 10.
$a %= $b; // équivaut à $a = $a % $b, soit $a = 10 % 2. $a vaut donc à la fin 0.

// On utilisera le += et le -= dans les paniers d'achat.

//----------------
// Incrémenter et Décrémenter
$i = 0;

$i++; // Incrémentation de $i par ajout de 1 : $i vaut donc à la fin 1
$i--; // Décrémentation de $i par soustraction de 1 : $i vaut donc à la fin 0 ici.

//-----------------------------------
echo '<h2> Les Structures Conditionnelles </h2>';
//-----------------------------------

$a = 10;
$b = 5;
$c = 2;

// if ..... else :
if ($a > $b) { // Si la condition est vraie, c'est-à-dire $a est bien supérieur à $b alors on entre dans les 1ères accolades.
    echo '$a est supérieur à $b <br>';
} else { // Sinon on exécute le else.
    echo 'Non, c\'est $b qui est supérieur ou égal à $a <br>';
}

// L'opérateur AND qui s'écrit && :
if ($a > $b && $b > $c) { // Si $a est supérieur à $b et dans le même temps $b est supérieur à $c, alors on entre dans les accolades.
    echo 'Vrai pour les 2 conditions <br>';
}

// TRUE && TRUE => TRUE
// FALSE && FALSE => FALSE
// TRUE && FALSE => FALSE

// L'opérateur hors s'écrit || :
if ($a == 9 || $b > $c) {
    echo 'Vrai pour au moins 1 des 2 conditions <br>';
} else {
    echo 'Les 2 conditions sont fausses <br>';
}

// TRUE || TRUE => TRUE
// FALSE || FALSE => FALSE
// TRUE || FALSE => TRUE

//-----------------------

// if ... elseif ... else :

if ($a == 8) {
    echo 'Réponse 1 : $a est égal à 8 <br>';
} elseif ($a != 10) {
    echo 'Réponse 2 : $a est différent de 10 <br>';
} else {
    echo 'Réponse 3 : $a est égal à 10 <br>';
}

// Note : le else n'est pas obligatoire. Else n'est jamais suivi d'une condition.

//---------------------
// L'opérateur XOR pour OU exclusif :

$question1 = 'mineur';
$question2 = 'je vote'; // exemple d'un questionnaire

// Les réponses internaute n'étant pas cohérentes, on lui met un message :
if ($question1 == 'mineur' XOR $question2 == 'je vote') { // XOR = ou exclusif. Seulement une des deux conditions doit être valide pour entrer dans le if. Si nous avons TRUE XOR TRUE cela FALSE.
    echo 'Vos réponses sont cohérentes <br>';
} else {
    echo 'Vos réponses ne sont pas cohérentes <br>';
}

// TRUE XOR TRUE => FALSE
// FALSE XOR FALSE => TRUE
// TRUE XOR FALSE => FALSE

//----------------------
// Frome dite ternaire de la condition (autre syntaxe du if) :
$a = 10;
echo ($a == 10) ? '$a est égal à 10 <br>' : '$a est différent de 10 <br>'; // le "?" remplace le if, et le ":" remplace else. On affiche le premier string si la condition est vraie, sinon le second.

//--------------------
// Comparaison == ou ===
$varA = 1;  // INTEGER
$varB = '1';// STRING
if ($varA == $varB) { // Double ==
    echo '$varA est égal à $varB en valeur <br>';
}

if ($varA === $varB) { // Triple ===
    echo '$varA est égal à $varB en valeur ET en type <br>';
} else {
    echo 'Les deux variables sont différentes en valeur OU en type <br>';
}

// le simple = est un symbole d'affection

//------------------
// isset() et empty() :
// empty() : vérifie si la variable est vide, c'est-à-dire 0, '', NULL, false ou non définie.

// isset() : vérifie si la variable existe et a une valeur non NULL.

$var1 = 0;
$var2 = '';

if (empty($var1)) echo '$var1 contient 0, un string vide, NULL, false ou n\'est pas définie <br>'; // Vrai car la variable contient 0.

if (isset($var2)) echo 'La variable existe et est non NULL <br>'; // Vrai car la variable existe bien et ne contient pas NULL.

// Contexte d'utilisation :
// empty() pour vérifier des champs formulaire.
// isset() pour vérifier l'existence d'un indice dans un tableau.

//----------------
// L'opérateur NOT qui s'écrit '!'
$var3 = 'quelque chose';
if (!empty($var3)) { // le ! correspond à une négation : il intervertit le sens du booléen : !true devient false et !false devient true. Ici cela signifie "$var3 n'est pas nul".
    echo 'La variable n\'est pas vide <br>';
}

//-----------------
// L'opérateur ?? appelé "NULL coalescent" (PHP 7) :
$variable_inconnue = 'test';
echo $variable_inconnue ?? 'valeur par défaut';

//-----------------------------------
echo '<h2> Switch </h2>';
//-----------------------------------

// La condition SWITCH est une autre syntaxe pour écrire if ... elseif ... else quand on veut comparer une variable à une multitude de valeurs.

$langue = 'chinois';
switch ($langue) {
    case 'français' : // On compare $langue à la valeur 'case' et exécute le code qui suit si elle correspond.
        echo 'Bonjour !';
    break; // Obligatoire pour quitter le SWITCH un fois un 'case' exécuté.
    case 'italien' :
        echo 'Ciao !';
    break;
    case 'espagnol' :
        echo 'Hola !';
    break;
    default : // Le cas par défaut qui est exécuté si on ne rentre pas dans l'un des 'case'.
        echo 'Hello ! <br>';
    break;
}

// Excercice : Réécrivez ce switch sous forme de conditions if ... pour obtenir exactement le même résultat.

$langue = 'chinois';
if ($langue == 'français') {
    echo 'Bonjour !';
} elseif ($langue == 'italien') {
    echo 'Ciao !';
} elseif ($langue == 'espagnol') {
    echo '¡Hola!';
} else {
    echo 'Hello ! <br>';
}

//-----------------------------------
echo '<h2> Fonctions </h2>';
//-----------------------------------

function separation() {
    echo '<hr>';
}

separation();

//--------------------------
// Fonction avec paramètre et return

function bonjour($prenom, $nom) { // $prenom et $nom = paramètres de la fonction

    return 'Bonjour ' . $prenom . ' ' . $nom . ' ! <br>';

}

$prenom = 'Pierre';
$nom = 'Quiroule';
echo bonjour($prenom, $nom); // Echo pas dans la fonction, donc ici en même temps que l'appel de la fonction.

//------
// Excercice : écrivez la fonction factureEssence() qui calcule le coût total de votre facture en fonction du nombre de litre d'essence que vous indiquez lors de l'appel de la fonction. 'Votre facture est de X euros pour Y litres d'essence'.
// Pour cela on vous donne une fonction prixLitre() qui vous retourne le prix du litre d'essence. Vous l'utilisez donc pour calculer le total de la facture.

function prixLitre() {
    return rand(100, 200)/100;
}

function nombreLitre() {
    return rand(50, 80);
}

$prixLitre = prixLitre();
$nombreLitre = nombreLitre();

function factureEssence($prixTotal, $nombreLitre) {
    global $prixLitre;
    global $nombreLitre;
    return 'Votre facture est de ' . $prixLitre * $nombreLitre . '€ pour ' . $nombreLitre . ' litres d\'essence. <br>';
}

echo factureEssence($prixLitre * $nombreLitre, $nombreLitre);

//-----------------
// En PHP7 on peut préciser le type des valeurs entrantes dans une fonction:

function identite(string $nom, int $age) { // array, bool, float, int, string
    echo gettype($nom) . '<br>';
    echo gettype($age) . '<br>';
    echo $nom . ' a ' . $age . ' ans <br>';
}
identite('Astérix', 60); // les types sont respectés, pas d'erreur

identite('Astérix', '60'); // le string '60' a été casté en integer (en mode strict il y aurait une erreur)

// identite('Obélix', 'soixante'); // Fatal error

// PHP7 on peut aussi préciser la valeur de retour que doit sortir la fonction :

function adulte(int $age) : bool { // array, booléen, float, int, string
    if($age > 18) {
        return true;
    } else {
        return false;
    }
}

var_dump(adulte(7)); // la fonction retourne bien un booléen, il n'y a donc pas d'erreur. Nous faisons un var_dump car il permet d'afficher le false que retourne la fonction, 'echo false' n'affichant rien.
 echo '<br>';
//-------------
// Variable locale et variable globale :

// De l'espace local vers global :

function jourSemaine() {
    $jour = 'Vendredi <br>'; // Variable locale
    return $jour;
}

// echo $jour; // Notice: Undefined variable: jour in /Applications/MAMP/htdocs/PHP/01-bases/bases.php on line 394
echo jourSemaine();

// De l'espace global vers local :

$pays = 'France'; // Variable globale

function affichePays() {
    global $pays; // permet de récupérer une variable globale au sein de l'espace local de la fonction.
    echo $pays;
}

affichePays();

//-----------------------------------
echo '<h2> Structures Itératives : Boucles </h2>';
//-----------------------------------
// Les boucles sont destinées à répéter des lignes de code de façon automatique

//---------------------
// Boucle while :
$i = 0; // On initialise à 0 une variable qui sert de compteur.

while ($i < 3) { // Tant que $i  est inférieur à 3, nous entrons dans la boucle.
    echo $i . '<br>';
    $i++; // On incrémente à chaque tour de boucle afin de ne pas avoir une boucle infinie (à 3 la condition étant fausse, on quitte la boucle)
}

// Excercie : à l'aide d'une boucle while, afficher un sélécteur des années depuis 1920 jusqu'a 2020.
echo '<select>';
echo '<option>Valeur 1</option>';
echo '</select>';

echo '<br>';

$i = 1920;
echo "<select>";
while ($i <= 2020) { // Pour date en cours: ($i <= date('Y'))
    echo "<option>$i</option>";
    $i++;
}
echo "</select> <br>";

//---------------------
// Boucle do while :

// La boucle do while à la particularité de s'exécuter au moins une fois, puis tant que la condition de fin est vraie.

$j = 0;

do {
    echo '<br>je fais 1 tour <br>';
    $j++;
} while ($j > 10); // la condition est false, pourtant la boucle a tourné 1 fois

echo '<br>';

//---------------------
// Boucle for :
for ($i = 0; $i < 3; $i++) { // Nous trouvon dans les () de for : la valeur de départ; la condition d'entrée dans la boucle; la variation de $i.
    echo $i . '<br>';
}

echo '<br>';

for ($i = 0; $i < 10; $i+=2) { // Nous trouvon dans les () de for : la valeur de départ; la condition d'entrée dans la boucle; la variation de $i.
    echo $i . '<br>';
}

echo '<br>';

//---------------------
// Excercice : afficher les mois 1 à 12 dans un sélécteur à l'aide d'une boucle for

echo "<select>";
for ($i = 1; $i <= 12; $i++) {
    echo "<option>$i</option>";
}
echo "</select> <br>";

//---------------------
// Il existe aussi la boucle foreach que nous verrons un peu plus loin. Elle sert à parcourir les tableaux ou les objets.

//---------------------
// Excercice : faites une boucle qui affiche les chiffres 0 à 9 dans une table HTML sur une seule ligne. Vous faites du CSS dans la balise <style> au début pour mettre une bordure sur ce tableau.

echo '<table><tr>';
for ($i = 0; $i <= 9; $i++) {
        echo '<td>' . $i . '</td>';
}
echo '</tr></table>';

echo '<br>';

//---------------------
// Excercice : faites une boucle qui affiche de 0 à 9 sur la même ligne. Cette ligne se répétant 10 fois, le tout dans une table HTML

// Principe de la boucle imbriquée

echo '<table>';
    for ($i = 0; $i <= 9; $i++) {
        echo '<tr>';
        for ($j = 0; $j <= 9; $j++) {
            echo '<td>' . $j . '</td>';
        }
        echo '</tr>';
    }
echo '</table>';

//-----------------------------------
echo '<h2> Quelques fonctions pré-définies </h2>';
//-----------------------------------

// Une fonction prédéfinie permet de réaliser un traitement spécifique prédéterminé dans le langage PHP

// strlen
$phrase = 'mettez une phrase ici';
echo strlen($phrase); // compte le nombre d'octet (1 octet pour chaque caractère, sauf les caractère accentué qui comptenet pour 2)

echo '<br>';

// substr
$texte = 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Itaque fuga, amet ipsa dolores exercitationem, corporis, magnam rem nam consequuntur provident consectetur quas ullam ipsam odio architecto labore illum laudantium eum?';
echo substr($texte, 0, 18) . '...<a href="">lire la suite</a>'; // coupe le texte de la position 0 et sur 18 caractère

echo '<br>';

// strtolower, strtoupper, trim
$message = '    Hello World !   ';
echo strtolower($message) . '<br>'; // Tout en minuscule

echo strtoupper($message) . '<br>'; // Tout en majuscule

echo strlen($message) . '<br>'; // On compte la longueur (incluant les espaces)
echo strlen(trim($message)) . '<br>'; // trim() supprime les espaces au début et à la fin de la chaîne de caractère. Puis ici on compte le résultat sans les espaces.

// La documentation PHP en ligne :
http://www.php.net/manual/fr

//-----------------------------------
echo '<h2> Tableaux (arrays) </h2>';
//-----------------------------------

// Type de variable amélioré. Commence à l'indice 0.

// Utilisation: souvent quand on récupère des informations de la BdD, nous les retrouvons sous forme de tableau.

// Déclarer un tableau (méthode 1)

$liste = array('Grégoire', 'Nathalie', 'Emilie', 'François', 'Georges');
echo gettype($liste) . '<br>'; // type array

// echo $liste; // ERREUR de type array to string conversion car on ne peut pas afficher directement un tableau

echo 'var_dump et print_r <br>';

echo '<pre>';
var_dump($liste); // Affiche contenu avec le type des valeur
echo '</pre>';

echo '<pre>';
print_r($liste); // Affiche contenu sans le type
echo '</pre>'; // Permet de formatter l'affichage

// Déclaration de notre fonction d'affichage :

function debug($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

debug($liste);

// Autre méthode pour déclarer un tableau (méthode 2) :

$tab = ['France', 'Italie', 'Espagne', 'Portugal'];

debug($tab);

echo $tab[1] . '<br>'; // Pour afficher Italie, on écit le nom du tableau suivi de son indice écrit entre crochet

//--------------------
// Ajouter une valeur à la fin du tableau : 
$tab[] = 'Suisse';  // Les [] vides premettent d'ahouter une valeur à la fin d'un tableau
debug($tab);

//--------------------
// Tableau associatif :
// Dans un tableau associatif, on peut choisir les indices :
$couleur = array(
    'j' => 'jaune',
    'b' => 'bleu',
    'v' => 'vert'
);
debug($couleur);

// Pour afficher un élément du tableau associatif :
    echo 'la seconde couleur de notre tableau est le ' . $couleur['b'] . '<br>';

    echo "la seconde couleur est le $couleur[b] <br>";

// Un tableau associatif écrit dans des guillemets pert les quotes autour de son indice.

//--------------------------
// Mesurer le nombr d'éléments dans un tableau :
echo 'taille du tableau : ' . count($couleur) . '<br>'; // compte le nombre d'élément dans le tableau $couleur

echo 'taille du tableau : ' . sizeof($couleur) . '<br>'; // sizeof() fait la même chose que count() dont il est un alias

//-----------------------------------
echo '<h2> Boucle foreach </h2>';
//-----------------------------------

// foreach est un moyen simple de parcourir un tableau de façon automatique. Cette boucle fonctionne uniquement sur les tableaux et les objets. Elle retroune une erreure si vous l'utilisez sur une variable d'un autre type ou non initialisée.

debug($tab);

foreach ($tab as $pays) { // la variable $pays vient parcourir la colonne des valeurs elle prend chaque valeur successivement à chaque tour de boucle. Le mot as est obligatoire et faire partie de la syntaxe.
    echo $pays . '<br>'; // affiche successivement les valeurs du tableau
};

foreach ($tab as $indice => $pays) { // Quand il y a deux variables, celle qui est à gauche parcourt la colonne les indices, cette qui est à droite parcourt la colonne des valeurs
    echo $indice . ' correspond à ' . $pays . '<br>';
};

// Excercices :
// 1) - Ecrivez un tableau associatif avec les indices prenom, nom, email et telephone, auxquels vous associez des valeurs pour 1 contact
// 2) - puis avec une boucle foreach, affichez les valeurs dans des <p>, sauf le prénom qui doit être dans un <h3>.

$contact = array(
    'prenom'    => 'John',
    'nom'       => 'Doe',
    'email'     => 'john.doe@gmail.com',
    'telephone' => '0623456789'
);

debug($contact);

foreach ($contact as $champ => $infos) {
    if ($champ == 'prenom') {
        echo "<h3> Bonjour $infos !</h3>";
    } else {
        echo '<p>' . $infos . '</p>';
    }
};

//-----------------------------------
echo '<h2> Tableau Multidimensionnel </h2>';
//-----------------------------------

// Nous parlons de tableaux multidimensionnels lorsqu'un tableau est contenu dans un autre tableau. Chaque tableau représente une dimension.

// Déclaration d'un tableau multidimensionnel :

$table_multi = array(
    array(
        'prenom'    => 'Julien',
        'nom'       => 'Dupont',
        'telephone' => '0612345678'
    ),
    array(
        'prenom'    => 'Nicolas',
        'nom'       => 'Durand',
        'telephone' => '0698765432'
    ),
    array(
        'prenom'    => 'Pierre',
        'nom'       => 'Dulac'
    )
);

// Il est possible de choisir l'indice d'un tableau multidimensionnel

debug($table_multi);

// Afficher la valeur "Julien" :
echo strtoupper($table_multi[0]['prenom']) . '<hr>'; // pour afficher "Julien" nous entrons d'abord dans le tableau $table_multi, puis nous allons à son indice [0], dans lequel nous allons à l'indice ['prenom']

// Parcourir le tableau multidimensionnel avec une boucle for
for ($i = 0; $i < sizeof($table_multi); $i++) {
    echo $table_multi[$i]['prenom'] . '<br>';
}

echo '<hr>';

// Excercice : afficher les trois prénoms avec une boucle foreach

foreach ($table_multi as $indice => $contact) {
    
    echo $table_multi[$indice]['prenom'] . '<br>';

}

foreach ($table_multi as $contact) {
    // debug($contact); // On voit que $contact est un array qui contient l'indice 'prenom'. On accède donc à 'prenom' en mettant l'indice dans des crochets.
    echo $contact['prenom'] . '<br>';
}

echo '<hr>';

// Excercice (optionnel) : Vous déclarez un tableau contenant 'taille' s-m-l-xl. Puis vous les affichez dans un menu déroulant (select/option) à l'aide d'une boucle foreach

// Correction :
$taille = array(
    'S',
    'M',
    'L',
    'XL'
);

echo '<select>';
for ($i = 0; $i < sizeof($taille); $i++) {
    echo "<option>$taille[$i]</option>";
}
echo '</select>';

//-----------------------------------
echo '<h2> Les inclusions de fichiers </h2>';
//-----------------------------------

echo "Première inclusion : ";
include 'exemple.inc.php'; // le fichier est inclus, c'est à dire que son code s'exécute ici. En cas d'erreur lors de l'inclusion, include génère une erreur de type "warning" et continue l'exécution du script.

echo "<br> Seconde inclusion : ";
include_once 'exemple.inc.php'; // le "once" est là pour vérifier si le fichier a déjà été inclus, auquel cas il ne ré-inclut pas.

echo "<br> Troisième inclusion : ";
require 'exemple.inc.php'; // le fichier est requis et donc obligatoire : en cas d'erreur lors de l'inclusion, require génère un message d'erreur "fatal error" qui stoppe l'exécution du code.

echo "<br> Quatrième inclusion : ";
require_once 'exemple.inc.php'; // le "once" est là pour vérifier si le fichier a déjà été inclus, auquel cas il ne ré-inclut pas.

echo '<hr>' . $inclusion; // Comme le fichier exemple.inc.php est déjà inclus, on accord aux éléments qui sont déclarés à l'intérieur de celui-ci, comme les variables, les fonctions, ...

// la mention inc précise qu'il s'agit d'un fichier d'inclusion (et non pas d'une page à part entière)

//-----------------------------------
echo '<h2> Introduction aux objets </h2>';
//-----------------------------------

// Un objet est un autre type de données (object en anglais). Il représente un objet réel (par exemple voiture, membre, panier d'achat, produit, etc) auquel on peut associer des variables, appelées "PROPRIETES" et des fonctions, appelées "METHODE".

// Pour créer des objets il nous faut un "plan de construction" : c'est le role de la classe.

// Nous créons ici une classe pour créer des objets "meubles" :
class Meuble { // Avec une majuscule (par convention)

    public $marque = 'ikea'; // $marque est une propriété. "public" précise qu'elle sera accessible partout 

    public function prix() { // Ceci est une méthode
        return rand(50, 200) . ' €';
    }

}

//----------
$table = new Meuble(); // new est un mot clé qui permet d'instancier la classe pour en faire un objet. L'interet est que notre $table bénéficie de la propriété "ikea" et de la méthode prix() définis dans la classe.

debug($table); // Nous observons le type "object", le nom de sa classe "Meuble" et sa propriété "marque"

echo 'Marque du meuble ' . $table->marque . '<br>'; // Pour accéder à la propriété d'un objet, on écrit cet objet suivi de la flèche -> puis du nom de la propriété sans le $.

echo 'Prix du meuble ' . $table->prix(); // Pour accéder à la methode d'un objet, on l'écrit après la flèche -> à laquelle on ajoute une paire de ()

//******************************************** FIN ***********************************/