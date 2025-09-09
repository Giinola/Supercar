<?php
$bdd = new mysqli("localhost", "root", "", "supercar");
$bdd->set_charset("utf8");

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

    .sidebar {
        height: 100vh;
        width: 220px;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #2a2a2a;
        padding-top: 20px;
        box-shadow: 2px 0 5px rgba(252, 191, 73, 0.3);
        display: flex;
        flex-direction: column;
        z-index: 10;
    }

    .sidebar h4 {
        color: #fcbf49;
        text-align: center;
        margin-bottom: 15px;
        font-size: 16px;
        font-weight: 600;
    }

    .sidebar a {
        padding: 12px 20px;
        text-decoration: none;
        color: #eaeaea;
        display: block;
        font-size: 15px;
        font-weight: 500;
    }

    .sidebar a:hover {
        background-color: #fcbf49;
        color: #000;
    }

    .topbar {
        margin-left: 220px;
        background-color: #000;
        padding: 20px;
        font-size: 24px;
        font-weight: bold;
        color: #fcbf49;
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

<div class="sidebar">
    <h4>Visualisation</h4>
    <a href="Acceuil.php">Tableau de bord</a>
    <a href="Demande_essai.php">Demandes d'essai</a>
    <a href="Utilisateurs.php">Utilisateurs</a>
    <a href="Contact.php">Contact</a>

    <div class="secondary-menu">
        <h4>Modification</h4>
        <a href="admin_acceuil.php">Accueil</a>
            <a href="admin_voitures.php">Voiture</a>
            <a href="admin_essai.php">Demandes essai</a>
            <a href="admin_services.php">Services</a>
            <a href="Admin_contact.php">Contact</a>
    </div>
</div>
<div class="menu-marques">
  <a class="bouton-marque" href="merco.php">Mercedes</a>
  <a class="bouton-marque" href="Ford.php">Ford</a>
  <a class="bouton-marque" href="nissan.php">Nissan</a>
  <a class="bouton-marque" href="toyota.php">Toyota</a>
</div>

<div class="topbar"> Administration - Page Voitures</div>

<div class="main-content">
<form method="POST">
  <table>
    <tr><th>Champ</th><th>Valeur</th></tr>

    <tr><td>Titre de page</td><td><input type="text" name="titre_page" value="<?= isset($contenu['titre_page']) ? $contenu['titre_page'] : '' ?>"></td></tr>
    <tr><td>Description</td><td><textarea name="description_page"><?= isset($contenu['description_page']) ? $contenu['description_page'] : '' ?></textarea></td></tr>

    <?php
    $marques = ['ford', 'nissan', 'mercedes', 'toyota'];
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
