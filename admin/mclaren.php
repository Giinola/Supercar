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

// --- Supprimer une voiture ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer'])) {
    $voitureId = (int)$_POST['supprimer'];
    $bdd->query("DELETE FROM mclaren WHERE id = $voitureId");
    $_SESSION['msg'] = "✅ Suppression réussie.";
}

// --- Mise à jour des données ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_update_voitures'])) {
    if (is_array($_POST['nom_complet'])) {
        foreach ($_POST['nom_complet'] as $id => $nom_complet) {
            $id = (int)$id;
            $nom_complet = mysqli_real_escape_string($bdd, $nom_complet);
            $classe = mysqli_real_escape_string($bdd, $_POST['classe'][$id]);
            $carrosserie = mysqli_real_escape_string($bdd, $_POST['carrosserie'][$id]);
            $description_courte = mysqli_real_escape_string($bdd, $_POST['description_courte'][$id]);
            $chemin_image = mysqli_real_escape_string($bdd, $_POST['chemin_image'][$id]);
            $puissance_ch = mysqli_real_escape_string($bdd, $_POST['puissance_ch'][$id]);
            $prix_estime = mysqli_real_escape_string($bdd, $_POST['prix_estime'][$id]);

            // UPDATE à l'intérieur de la boucle
            $bdd->query("
                UPDATE mclaren SET 
                    nom_complet = '$nom_complet', 
                    classe = '$classe', 
                    carrosserie = '$carrosserie',
                    description_courte = '$description_courte', 
                    chemin_image = '$chemin_image',
                    puissance_ch = '$puissance_ch',
                    prix_estime = '$prix_estime'
                WHERE id = $id
            ");
        }
        $_SESSION['msg'] = "✅ Modifications enregistrées.";
    }
}

// --- Récupérer les voitures pour affichage ---
$voitures = [];
$resultats = $bdd->query("SELECT * FROM mclaren ORDER BY id ASC");
while ($ligne = $resultats->fetch_assoc()) {
    $voitures[] = $ligne;
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Administration - Mc Laren</title>
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

        th,
        td {
            padding: 15px;
            border-bottom: 1px solid #333;
        }

        th {
            background-color: #ffcc00;
            color: #000;
            font-size: 15px;
        }

        input[type="text"],
        textarea {
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
    <h1>Administration - Mc Laren</h1>
    <div class="main-content">

        <form method="POST" enctype="multipart/form-data">
            <table>
                <?php

                if (!empty($voitures)) {
                    foreach ($voitures as $voiture) {
                        $id = (int)$voiture['id'];
                ?>
                        <tr>
                            <td colspan="2" style="background:#222; color:#fff; font-weight:bold; padding:8px 10px;">Voiture ID: <?= $id ?></td>
                        </tr>

                        <tr>
                            <td>Nom Complet</td>
                            <td>
                                <textarea name="nom_complet[<?= $id ?>]"><?= htmlspecialchars($voiture['nom_complet'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>Classe</td>
                            <td><input type="text" name="classe[<?= $id ?>]" value="<?= htmlspecialchars($voiture['classe'] ?? '', ENT_QUOTES, 'UTF-8') ?>"></td>
                        </tr>

                        <tr>
                            <td>Carrosserie</td>
                            <td><input type="text" name="carrosserie[<?= $id ?>]" value="<?= htmlspecialchars($voiture['carrosserie'] ?? '', ENT_QUOTES, 'UTF-8') ?>"></td>
                        </tr>

                        <tr>
                            <td>Description Courte</td>
                            <td>
                                <textarea name="description_courte[<?= $id ?>]"><?= htmlspecialchars($voiture['description_courte'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>Chemin Image</td>
                            <td>
                                <input type="text" name="chemin_image[<?= $id ?>]" value="<?= htmlspecialchars($voiture['chemin_image'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                <?php if (!empty($voiture['chemin_image'])): ?>
                                    <br><img src="<?= htmlspecialchars($voiture['chemin_image']) ?>" alt="Image voiture" style="max-width:120px;border:1px solid #444;border-radius:4px;margin-top:6px;">
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                        <tr>
                            <td>Puissance (ch)</td>
                            <td><textarea name="puissance_ch[<?= $id ?>]"><?= htmlspecialchars($voiture['puissance_ch'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>Prix Estimé</td>
                            <td><textarea name="prix_estime[<?= $id ?>]"><?= htmlspecialchars($voiture['prix_estime'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea> €</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="submit" name="supprimer" value="<?= $id ?>" onclick="return confirm('Voulez-vous vraiment supprimer cette voiture ?')">Supprimer cette Voiture</button>
                            </td>
                        </tr>

                <?php
                    }
                } else {

                    echo '<tr><td colspan="2">Aucune voiture n\'est actuellement enregistrée.</td></tr>';
                }
                ?>

                <tr>
                    <td colspan="2" style="padding-top:20px;">
                        <button type="submit" name="action_update_voitures" value="1">Enregistrer les Modifications des Voitures</button>
                    </td>
                </tr>

            </table>
        </form>

    </div>
    </form>
    </div>
    <?php
    $table_name = 'mclaren';
    include 'ajout_voiture.php';
    ?>

</body>

</html>