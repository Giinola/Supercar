<?php 
include 'menu.php'; 

include 'db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_kv'])) {
    foreach ($_POST as $champ => $valeur) {
        // On ne prend que nos clés attendues (évite d’update les boutons/inputs du 2e formulaire)
        if (!preg_match('/^(en_tete|nom_marque|(nom|image|descri|prix)_voiture\d+)$/', $champ)) continue;

        $ch = $bdd->real_escape_string($champ);
        $vl = $bdd->real_escape_string($valeur);

        $bdd->query("UPDATE `ford` SET valeur='$vl' WHERE nom_champ='$ch' LIMIT 1");
        if ($bdd->affected_rows === 0) {
            $bdd->query("INSERT INTO `ford` (nom_champ, valeur) VALUES ('$ch', '$vl')");
        }
    }
}
// --- SUPPRIMER ---
if (isset($_POST['supprimer'])) {
    $voitureId = $_POST['supprimer'];
    mysqli_query($bdd, "DELETE FROM ford WHERE nom_champ = 'nom_voiture$voitureId'");
}
    
// ---------- Chargement ----------
$contenu = [];
$resultats = $bdd->query("SELECT nom_champ, valeur FROM `ford`");
while ($ligne = $resultats->fetch_assoc()) {
    $contenu[$ligne['nom_champ']] = $ligne['valeur'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Administration - Ford</title>
<style>
    body { background:#121212; color:#fff; font-family:'Poppins',sans-serif; margin:0 }
    h1 { text-align:center; background:#000; color:#ffcc00; padding:20px; font-size:28px; margin-left:220px }
    .main-content { margin-left:220px; padding:30px }
    table { width:90%; margin:30px auto; border-collapse:collapse; background:#1e1e1e; border-radius:10px; overflow:hidden; box-shadow:0 0 10px rgba(255,204,0,.1) }
    th, td { padding:15px; border-bottom:1px solid #333; vertical-align:top }
    th { background:#ffcc00; color:#000; font-size:15px }
    input[type="text"], textarea { width:100%; background:#2a2a2a; color:#fff; border:1px solid #444; padding:10px; border-radius:5px; font-size:14px }
    textarea { resize:vertical; height:80px }
    img { max-width:100px; margin-top:10px; border-radius:4px; border:1px solid #444 }
    button { display:block; margin:30px auto; padding:12px 30px; background:#ffcc00; border:none; border-radius:25px; color:#000; font-size:16px; font-weight:700; cursor:pointer }
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

</style>
</head>
<body>

<h1>Administration - Ford</h1>

<div class="main-content">
  <!-- Formulaire des champs existants -->
  <form method="POST">
    <table>
      <tr><th>Champ</th><th>Valeur</th></tr>

      <tr>
        <td>Texte en-tête</td>
        <td><textarea name="en_tete"><?= htmlspecialchars($contenu['en_tete'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea></td>
      </tr>

      <tr>
        <td>Nom de la marque</td>
        <td><textarea name="nom_marque"><?= htmlspecialchars($contenu['nom_marque'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea></td>
      </tr>

     <?php for ($i = 1; !empty($contenu["nom_voiture$i"]); $i++): ?>
  <!-- affiche la voiture $i -->
  <tr>
    <td>Nom Voiture <?php echo $i; ?></td>
    <td><textarea name="nom_voiture<?php echo $i; ?>">
<?php echo htmlspecialchars($contenu["nom_voiture$i"]); ?>
    </textarea></td>
  </tr>
  <tr>
    <td>Image Voiture <?php echo $i; ?></td>
    <td>
      <input type="text" name="image_voiture<?php echo $i; ?>" value="<?php echo htmlspecialchars($contenu["image_voiture$i"] ?? ''); ?>">
      <?php if (!empty($contenu["image_voiture$i"])): ?>
        <br><img src="<?php echo htmlspecialchars($contenu["image_voiture$i"]); ?>" alt="">
      <?php endif; ?>
    </td>
  </tr>
  <tr>
    <td>Description Voiture <?php echo $i; ?></td>
    <td><textarea name="descri_voiture<?php echo $i; ?>"><?php echo htmlspecialchars($contenu["descri_voiture$i"] ?? ''); ?></textarea></td>
  </tr>
  <tr>
    <td>Prix Voiture <?php echo $i; ?></td>
    <td><textarea name="prix_voiture<?php echo $i; ?>"><?php echo htmlspecialchars($contenu["prix_voiture$i"] ?? ''); ?></textarea></td>
  </tr>
<?php endfor; ?>


    </table>
    <br><button type="submit" name="supprimer" value="<?= $i ?>">Supprimer</button>

    <button type="submit" name="save_kv" value="1">Enregistrer les modifications</button>

  </form>

  <!-- Formulaire d’ajout (centré, pas de position:fixed, donc pas de chevauchement) -->
  <?php 
    $table_name = 'ford'; 
    include 'ajout_voiture.php';  // <<< version centrée qu’on a faite précédemment
  ?>
</div>

</body>
</html>
