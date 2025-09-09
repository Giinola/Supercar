<?php
$host = "localhost";
$login = "root";
$pass = "";
$dbname = "test bdd"; 

// Création de la connexion
$bdd = new mysqli($host, $login, $pass, $dbname);

// Vérification de la connexion
if ($bdd->connect_error) {
    die("Connexion échouée: " . $bdd->connect_error);
}

// Changer le jeu de caractères en utf8
$bdd->set_charset("utf8");
?>
