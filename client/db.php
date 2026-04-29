<?php

$host    = "mysql-ginola.alwaysdata.net";
$dbname  = "ginola_supercar";
$login   = "ginola";
$pass    = "AlwaysGinola1";
$charset = "utf8mb4";


$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";


$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        
    PDO::ATTR_EMULATE_PREPARES   => false,                   
];

try {
    $pdo = new PDO($dsn, $login, $pass, $options);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données.");
}
