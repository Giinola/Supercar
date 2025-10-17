<?php
include 'menu.php'; 
include 'db.php';
$contenu = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_kv'])) {
    foreach ($_POST as $champ => $valeur) {
    
        if (!preg_match('/^(en_tete|nom_marque|(nom|image|descri|prix)_voiture\d+)$/', $champ)) continue;

        $ch = $bdd->real_escape_string($champ);
        $vl = $bdd->real_escape_string($valeur);

        $bdd->query("UPDATE `ford` SET valeur='$vl' WHERE nom_champ='$ch' LIMIT 1");
        if ($bdd->affected_rows === 0) {
            $bdd->query("INSERT INTO `ford` (nom_champ, valeur) VALUES ('$ch', '$vl')");
        }
    }
}
    if (isset($_POST['supprimer'])) {
        $voitureId = $_POST['supprimer'];
        mysqli_query($bdd, "DELETE FROM mercedes WHERE nom_champ = 'nom_voiture$voitureId'");
    }
}

$resultats = mysqli_query($bdd, "SELECT * FROM mercedes");
if (mysqli_num_rows($resultats) > 0) {
    while ($ligne = mysqli_fetch_assoc($resultats)) {
        $contenu[$ligne['nom_champ']] = $ligne['valeur'];
    }
} else {
    $contenu = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Administration - Mercedes</title>
    <style>
        body {
            background-color: #121212;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            background-color: #000;
            color: #ffcc00;
            padding: 20px;
            font-size: 28px;
            margin-left: 220px;
        }
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: #1e1e1e;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.1);
        }
        th, td {
            padding: 15px;
            border-bottom: 1px solid #333;
        }
        th {
            background-color: #ffcc00;
            color: #000;
            font-size: 15px;
        }
        input[type="text"], textarea {
            width: 100%;
            background-color: #2a2a2a;
            color: #fff;
            border: 1px solid #444;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
            height: 80px;
        }
        img {
            max-width: 100px;
            margin-top: 10px;
            border-radius: 4px;
            border: 1px solid #444;
        }
        button {
            display: block;
            margin: 30px auto;
            padding: 12px 30px;
            background-color: #ffcc00;
            border: none;
            border-radius: 25px;
            color: #000;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        .main-content {
            margin-left: 220px;
            padding: 30px;
        }
    </style>
</head>
<body>
    <h1>Administration - Mercedes</h1>

    <div class="main-content">
    <form method="POST" enctype="multipart/form-data">
        <table>
            <tr><th>Champ</th><th>Valeur</th></tr>
            <tr><td>Texte en-tête</td><td><textarea name="en_tete"><?php echo htmlspecialchars($contenu['en_tete']) ? $contenu['en_tete'] : ''; ?></textarea></td></tr>
            <tr><td>Nom de la marque</td><td><textarea name="nom_marque"><?php echo htmlspecialchars($contenu['nom_marque']) ? $contenu['nom_marque'] : ''; ?></textarea></td></tr>
<?php for ($i = 1; !empty($contenu["nom_voiture$i"]); $i++): 
  $nom  = htmlspecialchars($contenu["nom_voiture$i"], ENT_QUOTES, 'UTF-8');
  $img  = htmlspecialchars($contenu["image_voiture$i"] ?? '', ENT_QUOTES, 'UTF-8');
  $desc = htmlspecialchars($contenu["descri_voiture$i"] ?? '', ENT_QUOTES, 'UTF-8');
  $prix = htmlspecialchars($contenu["prix_voiture$i"]  ?? '', ENT_QUOTES, 'UTF-8');
?>
  <tr>
    <td>Nom Voiture <?= $i ?></td>
    <td><textarea name="nom_voiture<?= $i ?>"><?= $nom ?></textarea></td>
  </tr>
  <tr>
    <td>Image Voiture <?= $i ?></td>
    <td>
      <input type="text" name="image_voiture<?= $i ?>" value="<?= $img ?>">
      <?php if ($img): ?><br><img src="<?= $img ?>" alt="Image voiture" style="max-width:120px;border:1px solid #444;border-radius:4px;margin-top:6px;"><?php endif; ?>
      <br><button type="submit" name="supprimer" value="<?= $i ?>">Supprimer</button>
    </td>
  </tr>
  <tr>
    <td>Description Voiture <?= $i ?></td>
    <td><textarea name="descri_voiture<?= $i ?>"><?= $desc ?></textarea></td>
  </tr>
  <tr>
    <td>Prix Voiture <?= $i ?></td>
    <td><textarea name="prix_voiture<?= $i ?>"><?= $prix ?></textarea></td>
  </tr>
<?php endfor; ?>
<?php 
$table_name = 'mercedes';
include 'ajout_voiture.php';
 ?>

        <button type="submit">Enregistrer les modifications</button> 
    </form>
    </div>
    
</body>
</html>
