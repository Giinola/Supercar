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
 

// Enregistrement des modifications
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $champ => $valeur) {
        $bdd->query("UPDATE essai SET valeur = '$valeur' WHERE nom_champ = '$champ'");
    }
}

// Chargement des données
$contenu = [];
$result = $bdd->query("SELECT * FROM essai");
while ($row = $result->fetch_assoc()) {
    $contenu[$row['nom_champ']] = $row['valeur'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Admin – Demande d'essai</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #121212;
        color: #fff;
        margin: 0;
        padding: 0;
    }

    .main-content {
        margin-left: 240px;
        padding: 20px;
    }

    h1 {
        text-align: center;
        background-color: #000;
        color: #ffcc00;
        padding: 20px;
        font-size: 28px;
        margin-bottom: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #1e1e1e;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(255, 204, 0, 0.2);
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
    }

    th {
        background-color: #ffcc00;
        color: #000;
    }

    input[type="text"], textarea {
        width: 100%;
        padding: 8px;
        background-color: #2a2a2a;
        color: #fff;
        border: 1px solid #444;
        border-radius: 5px;
    }

    img {
        margin-top: 10px;
        max-width: 150px;
        border: 1px solid #333;
        border-radius: 5px;
    }

    button[type="submit"] {
        margin: 30px auto;
        display: block;
        background-color: #ffcc00;
        color: #000;
        font-weight: bold;
        border: none;
        border-radius: 25px;
        padding: 12px 25px;
        cursor: pointer;
    }
  </style>
</head>
<body>

<div class="main-content">
  <h1> Administration – Page Demande d'essai</h1>
  <form method="POST">
    <table>
      <tr><th>Champ</th><th>Valeur</th></tr>
      <tr><td>Titre du formulaire</td><td><input type="text" name="titre_formulaire" value="<?= $contenu['titre_formulaire'] ?? '' ?>"></td></tr>
      <tr><td>Message de succès</td><td><input type="text" name="message_succes" value="<?= $contenu['message_succes'] ?? '' ?>"></td></tr>
      <tr><td>Texte du bouton</td><td><input type="text" name="texte_bouton" value="<?= $contenu['texte_bouton'] ?? '' ?>"></td></tr>
      <tr>
          <td>Image de fond</td>
          <td>
              <input type="text" name="image_fond" value="<?= $contenu['image_fond'] ?? '' ?>">
              <br><img src="<?= $contenu['image_fond'] ?? '' ?>" alt="Image de fond">
          </td>
      </tr>
      <tr><td>Label Mercedes</td><td><input type="text" name="label_mercedes" value="<?= $contenu['label_mercedes'] ?? '' ?>"></td></tr>
      <tr><td>Label Ford</td><td><input type="text" name="label_ford" value="<?= $contenu['label_ford'] ?? '' ?>"></td></tr>
      <tr><td>Label Toyota</td><td><input type="text" name="label_toyota" value="<?= $contenu['label_toyota'] ?? '' ?>"></td></tr>
      <tr><td>Label Nissan</td><td><input type="text" name="label_nissan" value="<?= $contenu['label_nissan'] ?? '' ?>"></td></tr>
      <tr><td>Options Mercedes</td><td><textarea name="car_option_merco"><?= $contenu['car_option_merco'] ?? '' ?></textarea></td></tr>
      <tr><td>Options Ford</td><td><textarea name="car_option_ford"><?= $contenu['car_option_ford'] ?? '' ?></textarea></td></tr>
      <tr><td>Options Toyota</td><td><textarea name="car_option_toyota"><?= $contenu['car_option_toyota'] ?? '' ?></textarea></td></tr>
      <tr><td>Options Nissan</td><td><textarea name="car_option_nissan"><?= $contenu['car_option_nissan'] ?? '' ?></textarea></td></tr>
    </table>
    <button type="submit"> Enregistrer les modifications</button>
  </form>
</div>

</body>
</html>
