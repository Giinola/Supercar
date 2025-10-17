<?php


if (!isset($table_name) || $table_name === '') { die("Définis \$table_name"); }

include 'db.php';
$msg = '';

// Soumission (ajout d'une nouvelle voiture)
if (!empty($_POST['add_car']) && ($_POST['table'] ?? '') === $table_name) {
  $nom   = mysqli_real_escape_string($conn, trim($_POST['nom'] ?? ''));
  $image = mysqli_real_escape_string($conn, trim($_POST['image'] ?? ''));
  $desc  = mysqli_real_escape_string($conn, trim($_POST['description'] ?? ''));
  $prix  = mysqli_real_escape_string($conn, trim($_POST['prix'] ?? ''));
  $annee = mysqli_real_escape_string($conn, trim($_POST['annee'] ?? ''));

  if ($nom === '') {
    $msg = "Le nom du modèle est obligatoire.";
  } else {
    // N = MAX(nom_voitureN) + 1  (SQL direct, simple)
    $q = "SELECT MAX(CAST(SUBSTRING(nom_champ,12) AS UNSIGNED)) AS m
          FROM `$table_name` WHERE nom_champ LIKE 'nom_voiture%'";
    $r = mysqli_query($conn, $q);
    $row = $r ? mysqli_fetch_assoc($r) : ['m'=>0];
    $N = (int)($row['m'] ?? 0) + 1;

    // Insérer les paires (on évite les entrées vides, sauf nom)
    $ok = mysqli_query($conn, "INSERT INTO `$table_name` (nom_champ, valeur) VALUES ('nom_voiture$N', '$nom')");
    if ($ok && $image !== '') $ok = mysqli_query($conn, "INSERT INTO `$table_name` (nom_champ, valeur) VALUES ('image_voiture$N', '$image')");
    if ($ok && $desc  !== '') $ok = mysqli_query($conn, "INSERT INTO `$table_name` (nom_champ, valeur) VALUES ('descri_voiture$N', '$desc')");
    if ($ok && $prix  !== '') $ok = mysqli_query($conn, "INSERT INTO `$table_name` (nom_champ, valeur) VALUES ('prix_voiture$N',  '$prix')");
    if ($ok && $annee !== '') $ok = mysqli_query($conn, "INSERT INTO `$table_name` (nom_champ, valeur) VALUES ('annee_voiture$N', '$annee')");

    $msg = $ok ? "Voiture #$N ajoutée." : ("Erreur: ".mysqli_error($conn));
    if ($ok) $_POST = []; // vider le formulaire après succès
  }
}
?>

<style>
/* -- Formulaire centré, dans le flux (pas fixed), sans chevauchement -- */
.addcar { width:100%; box-sizing:border-box; padding: 0 16px; }
.addcar-card{
  max-width: 860px;
  margin: 24px auto 120px; /* le 120px évite d’être collé au bas s’il y a une barre de nav */
  background: #1e1e1e;
  border: 1px solid #444;
  border-radius: 12px;
  padding: 16px;
  color: #fff;
  font-family: Poppins, Arial, sans-serif;
  box-shadow: 0 8px 22px rgba(0,0,0,.35);
}
.addcar h2{ margin:0 0 12px; font-size:20px; color:#ffcc00; }
.addcar .row{ display:flex; gap:12px; flex-wrap:wrap; }
.addcar .col{ flex:1; min-width:220px; }
.addcar label{ display:block; font-weight:600; color:#cfd3da; margin-bottom:6px; }
.addcar input[type="text"], .addcar textarea{
  width:100%; background:#2a2a2a; color:#fff; border:1px solid #444;
  border-radius:8px; padding:10px; font-size:14px;
}
.addcar textarea{ min-height:90px; resize:vertical; }
.addcar .actions{ margin-top:12px; display:flex; gap:10px; justify-content:flex-end; }
.addcar button{
  background:#ffcc00; color:#111; border:0; border-radius:999px;
  padding:10px 16px; font-weight:800; cursor:pointer;
}
.addcar .flash{
  background:#333; color:#ffcc00; padding:8px 10px; border-radius:8px;
  margin-bottom:10px; display:inline-block;
}

/* Responsive: si ta page n’a pas déjà de marge pour la sidebar, rien n’est chevauché
   et si elle en a (ex: .main-content{margin-left:220px}), on n’ajoute rien ici. */
@media (max-width: 992px){
  .addcar-card{ margin:16px auto 100px; }
}
</style>

<div class="addcar">
  <div class="addcar-card">
    <h2>Ajouter une nouvelle voiture</h2>

    <?php if (!empty($msg)): ?>
      <div class="flash"><?php echo htmlspecialchars($msg); ?></div>
    <?php endif; ?>

    <form method="post">
      <input type="hidden" name="table" value="<?php echo htmlspecialchars($table_name); ?>">

      <div class="row">
        <div class="col">
          <label>Nom du modèle *</label>
          <input type="text" name="nom" required
                 value="<?php echo isset($_POST['nom'])?htmlspecialchars($_POST['nom']):''; ?>">
        </div>
        <div class="col">
          <label>Année (optionnel)</label>
          <input type="text" name="annee"
                 value="<?php echo isset($_POST['annee'])?htmlspecialchars($_POST['annee']):''; ?>">
        </div>
      </div>

      <div class="row">
        <div class="col">
          <label>URL de l'image</label>
          <input type="text" name="image"
                 value="<?php echo isset($_POST['image'])?htmlspecialchars($_POST['image']):''; ?>">
        </div>
        <div class="col">
          <label>Prix (texte)</label>
          <input type="text" name="prix"
                 value="<?php echo isset($_POST['prix'])?htmlspecialchars($_POST['prix']):''; ?>">
        </div>
      </div>

      <div class="row">
        <div class="col" style="min-width:100%;">
          <label>Description</label>
          <textarea name="description"><?php
            echo isset($_POST['description'])?htmlspecialchars($_POST['description']):''; ?></textarea>
        </div>
      </div>

      <div class="actions">
        <button type="submit" name="add_car" value="1">Ajouter</button>
      </div>
    </form>
  </div>
</div>
