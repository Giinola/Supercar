<?php
$host = "mysql-ginola.alwaysdata.net";
$login = "ginola";
$pass = "AlwaysGinola1";
$dbname = "ginola_supercar"; 

$bdd = new mysqli($host, $login, $pass, $dbname);


if ($bdd->connect_error) {
    die("Connexion échouée: " . $bdd->connect_error);
}


$bdd->set_charset("utf8");
?>
