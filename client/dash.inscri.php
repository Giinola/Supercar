<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Si l'utilisateur n'est pas connecté, rediriger vers la connexion
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription Reussi</title>
</head>
<body>

<div class="dashboard">
    <div class="card">
        <h1>Votre inscription est reussi
        </h1>
        <p>Ravi de vous voir parmis nous. Profitez pleinement de nos services.</p>
        
        <div class="buttons">
            <a class="btn primary" href="index.php">Accueil</a>
            <a class="btn secondary" href="logout.php">Déconnexion</a>
        </div>
    </div>
</div>
