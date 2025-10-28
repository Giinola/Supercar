<?php
include 'menu.php';
$host = "mysql-ginola.alwaysdata.net";  
$login = "ginola";                  
$pass = "AlwaysGinola1";            
$dbname = "ginola_supercar";        
 
 
$bdd = new mysqli($host, $login, $pass, $dbname);
 
 
if ($bdd->connect_error) {
    die("Connexion échouée: " . $bdd->connect_error);  
}
 


$contenu = [];

// Mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $champ => $valeur) {
        mysqli_query($bdd, "UPDATE voitures SET valeur = '$valeur' WHERE nom_champ = '$champ'");
    }
}

// Récupération des données
$resultats = mysqli_query($bdd, "SELECT * FROM voitures");
while ($ligne = mysqli_fetch_assoc($resultats)) {
    $contenu[$ligne['nom_champ']] = $ligne['valeur'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Admin Voitures</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
        background-color: #121212;
        color: #fff;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }

    
    .main-content {
        margin-left: 220px;
        padding: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #1e1e1e;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(255, 204, 0, 0.2);
    }

    th, td {
        padding: 15px 20px;
        text-align: left;
    }

    th {
        background-color: #ffcc00;
        color: #000;
        font-size: 16px;
    }

    tr:nth-child(even) {
        background-color: #1a1a1a;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 10px;
        background-color: #2a2a2a;
        color: #fff;
        border: 1px solid #444;
        border-radius: 5px;
    }

    img {
        max-width: 150px;
        margin-top: 10px;
        border-radius: 4px;
    }

    button[type="submit"] {
        display: block;
        margin: 30px auto;
        padding: 12px 30px;
        background-color: #ffcc00;
        border: none;
        border-radius: 30px;
        font-size: 16px;
        font-weight: bold;
        color: #000;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #e6b800;
    }
    .menu-marques {
  margin-top: 40px;
  padding-bottom: 40px;
  display: flex;
  justify-content: center;
  gap: 20px;
}

.menu-marques a {
  background-color: yellow;
  color: black;
  padding: 12px 25px;
  text-decoration: none;
  font-weight: bold;
  font-size: 16px;
  border-radius: 6px;
  transition: background-color 0.2s;
}

.menu-marques a:hover {
  background-color: #ffd700;
}

  </style>
</head>
<body>
<div class="menu-marques">
  <a class="bouton-marque" href="Merco.php">Mercedes</a>
  <a class="bouton-marque" href="range rove.php">Range Rover</a>
  <a class="bouton-marque" href="mclaren.php">Mc Laren</a>
  <a class="bouton-marque" href="ferrari.php">Ferrari</a>
</div>

<div class="topbar"> Administration - Page Voitures</div>

<div class="main-content">
<form method="POST">
  <table>
    <tr><th>Champ</th><th>Valeur</th></tr>

    <tr><td>Titre de page</td><td><input type="text" name="titre_page" value="<?= isset($contenu['titre_page']) ? $contenu['titre_page'] : '' ?>"></td></tr>
    <tr><td>Description</td><td><textarea name="description_page"><?= isset($contenu['description_page']) ? $contenu['description_page'] : '' ?></textarea></td></tr>

    <?php
    $marques = ['Range Rover', 'ferrari', 'mercedes', 'mclaren'];
    foreach ($marques as $marque) {
        echo "<tr><td>Nom " . ucfirst($marque) . "</td><td><input type='text' name='{$marque}_nom' value='" . (isset($contenu["{$marque}_nom"]) ? $contenu["{$marque}_nom"] : '') . "'></td></tr>";
        echo "<tr><td>Image " . ucfirst($marque) . "</td><td><input type='text' name='{$marque}_image' value='" . (isset($contenu["{$marque}_image"]) ? $contenu["{$marque}_image"] : '') . "'><br><img src='" . (isset($contenu["{$marque}_image"]) ? $contenu["{$marque}_image"] : '') . "' alt=''></td></tr>";
        echo "<tr><td>Lien " . ucfirst($marque) . "</td><td><input type='text' name='{$marque}_lien' value='" . (isset($contenu["{$marque}_lien"]) ? $contenu["{$marque}_lien"] : '') . "'></td></tr>";
    }
    ?>
  </table>

  <button type="submit">Enregistrer les modifications</button>
</form>
</div>

</body>
</html>
