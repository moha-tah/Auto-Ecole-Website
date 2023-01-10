<?php

// cette fonction permet d'avoir le formalisme français des jours/mois.
// grâce à cette commande, Monday devient Lundi et January devient Janvier (par exemple).
setlocale(LC_TIME, 'fr_FR.utf8','fra');

// les dates sont maintenant synchronisés à l'heure de Paris.
date_default_timezone_set('Europe/Paris');

// stocke la date du jour sous format pratique pour la comparaison (YYYY-MM-JJ)
$date = date("Y\-m\-d");

// dateAffichee permet d'afficher la date du jour en format JJ/MM/YYYY, utilisé en France.
$dateAffichee = date("d/m/Y");

// on initialise la connexion à la base de données.
$dbhost = "tuxa.sme.utc";
$dbuser = "nf92a081";
$dbpass = "Kj6JxYKj";
$dbname = "nf92a081";

// on se connecte à la base de données.
$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');

// on informe $connect que nos requêtes SQL seront écrites en UTF-8.
mysqli_set_charset($connect, 'utf8');

// cette fonction permet de cacher les erreurs PHP de la page web s'il y a des erreurs.
error_reporting(0);

// cette fonction permet d'ajouter la date de naissance après le nom de l'utilisateur en cas de doublons dans la BDD.
function doublons($connect, $nom, $prenom, $dateNaiss) {
    // on récupère le nombre d'élèves ayant le même nom et prénom fourni en arguments de la fonction.
    $requeteNbDoublons = "SELECT COUNT(ideleve) FROM eleves WHERE nom='".$nom."' AND prenom='".$prenom."'";
    $resultatNbDoublons = mysqli_query($connect, $requeteNbDoublons);
    $nbDoublons = mysqli_fetch_row($resultatNbDoublons);
    $nbDoublons = $nbDoublons[0];

    // s'il n'y a pas de doublons, on ne précise pas la date de naissance dans la chaîne de caractères.
    if ($nbDoublons == 1) {
      return "";
    } else { // sinon on renvoie la date de naissance dans un formalisme français.
      return " (".date("d/m/Y", strtotime($dateNaiss)).")";
    };

};

 ?>
