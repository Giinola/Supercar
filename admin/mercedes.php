<?php

$bdd = new mysqli("localhost", "root", "", "supercar");
$bdd->set_charset("utf8");


$contenu = array();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $champ => $valeur) {
        mysqli_query($bdd, "UPDATE mercedes SET valeur = '$valeur' WHERE nom_champ = '$champ'");
    }
}


$resultat = mysqli_query($bdd, "SELECT * FROM mercedes");
while ($ligne = mysqli_fetch_assoc($resultat)) {
    $contenu[$ligne['nom_champ']] = $ligne['valeur'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Mercedes - Simple</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: white;
            padding: 20px;
        }
        h1 {
            color: #ffcc00;
            text-align: center;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px;
            background-color: #1e1e1e;
            color: white;
            border: 1px solid #333;
        }
        img {
            max-width: 200px;
            margin-bottom: 20px;
        }
        button {
            background-color: #ffcc00;
            color: black;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            display: block;
            margin: 20px auto;
        }
    </style>
</head>
<body>
<h1> Administration Mercedes </h1>

<form method="POST">
    <label>Nom Voiture 1</label>
    <input type="text" name="nom_voiture1" value="<?php echo $contenu['nom_voiture1'] ?? ''; ?>">

    <label>Image Voiture 1</label>
    <input type="text" name="image_voiture1" value="<?php echo $contenu['image_voiture1'] ?? ''; ?>">
    <br><img src="<?php echo $contenu['image_voiture1'] ?? ''; ?>">

    <label>Description Voiture 1</label>
    <textarea name="descri_voiture1"><?php echo $contenu['descri_voiture1'] ?? ''; ?></textarea>

    <label>Prix Voiture 1</label>
    <input type="text" name="prix_voiture1" value="<?php echo $contenu['prix_voiture1'] ?? ''; ?>">

    <hr>

    <label>Nom Voiture 2</label>
    <input type="text" name="nom_voiture2" value="<?php echo $contenu['nom_voiture2'] ?? ''; ?>">

    <label>Image Voiture 2</label>
    <input type="text" name="image_voiture2" value="<?php echo $contenu['image_voiture2'] ?? ''; ?>">
    <br><img src="<?php echo $contenu['image_voiture2'] ?? ''; ?>">

    <label>Description Voiture 2</label>
    <textarea name="descri_voiture2"><?php echo $contenu['descri_voiture2'] ?? ''; ?></textarea>

    <label>Prix Voiture 2</label>
    <input type="text" name="prix_voiture2" value="<?php echo $contenu['prix_voiture2'] ?? ''; ?>">

    <hr>

    <label>Nom Voiture 3</label>
    <input type="text" name="nom_voiture3" value="<?php echo $contenu['nom_voiture3'] ?? ''; ?>">

    <label>Image Voiture 3</label>
    <input type="text" name="image_voiture3" value="<?php echo $contenu['image_voiture3'] ?? ''; ?>">
    <br><img src="<?php echo $contenu['image_voiture3'] ?? ''; ?>">

    <label>Description Voiture 3</label>
    <textarea name="descri_voiture3"><?php echo $contenu['descri_voiture3'] ?? ''; ?></textarea>

    <label>Prix Voiture 3</label>
    <input type="text" name="prix_voiture3" value="<?php echo $contenu['prix_voiture3'] ?? ''; ?>">

    <button type="submit"> Enregistrer</button>
</form>

</body>
</html>
