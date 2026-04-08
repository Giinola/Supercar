<?php
session_start();
 
// Vérifier que l'admin est connecté
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
 
// Connexion à la base
$host = "mysql-ginola.alwaysdata.net";
$login = "ginola";
$pass = "AlwaysGinola1";
$dbname = "ginola_supercar";
 
$bdd = new mysqli($host, $login, $pass, $dbname);
if ($bdd->connect_error) {
    die("Connexion échouée: " . $bdd->connect_error);
}
$bdd->set_charset('utf8mb4');
 
// ✅ Dire à MySQL qui est l'admin connecté (pour les triggers)
$admin_nom = $_SESSION['admin'] ?? 'inconnu';
$admin_nom_safe = $bdd->real_escape_string($admin_nom);
$bdd->query("SET @admin_user = '$admin_nom_safe'");
 
// Soumission du formulaire
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['add_car'])
    && isset($_POST['table'])
    && !empty($_POST['table'])
) {
    $table_name = $_POST['table'];
 
    $nom_complet        = mysqli_real_escape_string($bdd, trim($_POST['nom_complet'] ?? ''));
    $classe             = mysqli_real_escape_string($bdd, trim($_POST['classe'] ?? ''));
    $carrosserie        = mysqli_real_escape_string($bdd, trim($_POST['carrosserie'] ?? ''));
    $description_courte = mysqli_real_escape_string($bdd, trim($_POST['description_courte'] ?? ''));
    $chemin_image       = mysqli_real_escape_string($bdd, trim($_POST['chemin_image'] ?? ''));
    $puissance_ch       = mysqli_real_escape_string($bdd, trim($_POST['puissance_ch'] ?? ''));
    $prix_estime        = mysqli_real_escape_string($bdd, trim($_POST['prix_estime'] ?? ''));
 
    if ($nom_complet === '') {
        $_SESSION['msg'] = "Le nom du modèle est obligatoire.";
        $_SESSION['msg_type'] = "error";
    } else {
        $sql = "INSERT INTO `$table_name` (nom_complet, classe, carrosserie, description_courte, chemin_image, puissance_ch, prix_estime)
                VALUES ('$nom_complet', '$classe', '$carrosserie', '$description_courte', '$chemin_image', '$puissance_ch', '$prix_estime')";
 
        $ok = mysqli_query($bdd, $sql);
 
        if ($ok) {
            $_SESSION['msg'] = "Voiture ajoutée avec succès.";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['msg'] = "Erreur : " . mysqli_error($bdd);
            $_SESSION['msg_type'] = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SuperCar — Ajouter une voiture</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
 
    :root {
      --bg: #0a0a0a;
      --bg-soft: #111111;
      --text: #f5f5f5;
      --text-muted: #8a8a8a;
      --accent: #c9a875;
      --line: rgba(255, 255, 255, 0.08);
      --error: #d97766;
      --success: #7fa88a;
    }
 
    html, body { min-height: 100%; }
 
    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      color: var(--text);
      font-weight: 300;
      letter-spacing: 0.3px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      position: relative;
    }
 
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background:
        radial-gradient(ellipse at top, rgba(201, 168, 117, 0.04), transparent 60%),
        radial-gradient(ellipse at bottom, rgba(255, 255, 255, 0.02), transparent 50%);
      pointer-events: none;
      z-index: 0;
    }
 
    .topbar {
      position: relative;
      padding: 32px 60px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 2;
      border-bottom: 1px solid var(--line);
    }
 
    .brand-mark {
      font-family: 'Cormorant Garamond', serif;
      font-size: 22px;
      font-weight: 500;
      letter-spacing: 4px;
      color: var(--text);
      text-decoration: none;
    }
 
    .brand-mark span { color: var(--accent); }
 
    .top-meta {
      font-size: 11px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--text-muted);
    }
 
    main {
      position: relative;
      z-index: 1;
      flex: 1;
      padding: 60px 24px 80px;
      display: flex;
      justify-content: center;
    }
 
    .form-card {
      width: 100%;
      max-width: 760px;
      padding: 56px 56px;
      background: rgba(17, 17, 17, 0.6);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid var(--line);
      animation: fadeUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) both;
    }
 
    .eyebrow {
      font-size: 11px;
      letter-spacing: 6px;
      text-transform: uppercase;
      color: var(--accent);
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      gap: 14px;
    }
 
    .eyebrow::before {
      content: '';
      width: 30px;
      height: 1px;
      background: var(--accent);
      opacity: 0.5;
    }
 
    h1 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 42px;
      font-weight: 400;
      line-height: 1.1;
      letter-spacing: 1px;
      margin-bottom: 12px;
    }
 
    h1 .accent {
      font-style: italic;
      color: var(--accent);
      font-weight: 500;
    }
 
    .subtitle {
      font-size: 13px;
      color: var(--text-muted);
      margin-bottom: 44px;
      letter-spacing: 0.5px;
    }
 
    .flash {
      padding: 14px 18px;
      margin-bottom: 32px;
      border-left: 2px solid var(--success);
      background: rgba(127, 168, 138, 0.06);
      color: var(--success);
      font-size: 12px;
      letter-spacing: 0.5px;
    }
 
    .flash.error {
      border-left-color: var(--error);
      background: rgba(217, 119, 102, 0.06);
      color: var(--error);
    }
 
    .row {
      display: flex;
      gap: 24px;
      flex-wrap: wrap;
    }
 
    .col { flex: 1; min-width: 220px; }
 
    .field { margin-bottom: 28px; }
 
    .field label {
      display: block;
      font-size: 10px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-bottom: 10px;
      font-weight: 400;
    }
 
    .field input,
    .field select,
    .field textarea {
      width: 100%;
      padding: 12px 0;
      background: transparent;
      border: none;
      border-bottom: 1px solid var(--line);
      color: var(--text);
      font-family: 'Inter', sans-serif;
      font-size: 15px;
      font-weight: 300;
      letter-spacing: 0.5px;
      outline: none;
      transition: border-color 0.4s ease;
    }
 
    .field textarea {
      min-height: 90px;
      resize: vertical;
    }
 
    .field select {
      cursor: pointer;
      appearance: none;
      background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%238a8a8a'%3e%3cpath d='M7 10l5 5 5-5z'/%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right center;
      padding-right: 30px;
    }
 
    .field select option {
      background: var(--bg-soft);
      color: var(--text);
    }
 
    .field input:focus,
    .field select:focus,
    .field textarea:focus { border-bottom-color: var(--accent); }
 
    .field input::placeholder,
    .field textarea::placeholder {
      color: #555;
      font-weight: 300;
    }
 
    .actions {
      margin-top: 16px;
      display: flex;
      gap: 14px;
      justify-content: flex-end;
      flex-wrap: wrap;
    }
 
    .btn {
      padding: 18px 42px;
      font-family: 'Inter', sans-serif;
      font-size: 11px;
      font-weight: 400;
      letter-spacing: 3px;
      text-transform: uppercase;
      cursor: pointer;
      transition: all 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
      background: var(--text);
      color: var(--bg);
      border: 1px solid var(--text);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      text-decoration: none;
    }
 
    .btn:hover {
      background: var(--accent);
      border-color: var(--accent);
      transform: translateY(-2px);
    }
 
    .btn.ghost {
      background: transparent;
      color: var(--text-muted);
      border-color: var(--line);
    }
 
    .btn.ghost:hover {
      background: transparent;
      border-color: var(--accent);
      color: var(--accent);
      transform: none;
    }
 
    .btn .arrow { transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1); }
    .btn:hover .arrow { transform: translateX(5px); }
 
    .bottombar {
      position: relative;
      padding: 28px 60px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 11px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--text-muted);
      z-index: 2;
      border-top: 1px solid var(--line);
    }
 
    .bottombar .line {
      flex: 1;
      height: 1px;
      background: var(--line);
      margin: 0 32px;
    }
 
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
 
    @media (max-width: 768px) {
      .topbar, .bottombar { padding: 24px 28px; }
      main { padding: 40px 20px; }
      .top-meta, .bottombar .line { display: none; }
      .bottombar { justify-content: center; text-align: center; }
      .form-card { padding: 40px 28px; }
      h1 { font-size: 34px; }
      .row { gap: 0; }
    }
  </style>
</head>
<body>
 
  <header class="topbar">
    <a href="admin_acceuil.php" class="brand-mark">SUPER<span>CAR</span></a>
    <div class="top-meta">Administration — <?= htmlspecialchars($_SESSION['admin']) ?></div>
  </header>
 
  <main>
    <div class="form-card">
      <div class="eyebrow">Nouveau modèle</div>
      <h1><span class="accent">Ajouter</span> une voiture</h1>
      <p class="subtitle">Renseignez les informations du modèle à ajouter au catalogue</p>
 
      <?php if (isset($_SESSION['msg'])): ?>
        <div class="flash <?= ($_SESSION['msg_type'] ?? '') === 'error' ? 'error' : '' ?>">
          <?= htmlspecialchars($_SESSION['msg']) ?>
        </div>
        <?php unset($_SESSION['msg'], $_SESSION['msg_type']); ?>
      <?php endif; ?>
 
      <form method="post" action="" enctype="multipart/form-data">
 
        <div class="field">
          <label for="table">Marque</label>
          <select id="table" name="table" required>
            <option value="Mercedes">Mercedes</option>
            <option value="ferrari">Ferrari</option>
            <option value="range_rover">Range Rover</option>
            <option value="mclaren">McLaren</option>
          </select>
        </div>
 
        <div class="row">
          <div class="col field">
            <label for="nom_complet">Nom complet *</label>
            <input type="text" id="nom_complet" name="nom_complet" placeholder="Ex : 488 Pista" required>
          </div>
          <div class="col field">
            <label for="classe">Classe</label>
            <input type="text" id="classe" name="classe" placeholder="Ex : Supercar">
          </div>
        </div>
 
        <div class="row">
          <div class="col field">
            <label for="chemin_image">Chemin de l'image</label>
            <input type="text" id="chemin_image" name="chemin_image" placeholder="images/voiture.jpg">
          </div>
          <div class="col field">
            <label for="prix_estime">Prix estimé</label>
            <input type="text" id="prix_estime" name="prix_estime" placeholder="Ex : 350000">
          </div>
        </div>
 
        <div class="row">
          <div class="col field">
            <label for="carrosserie">Carrosserie</label>
            <input type="text" id="carrosserie" name="carrosserie" placeholder="Ex : Coupé">
          </div>
          <div class="col field">
            <label for="puissance_ch">Puissance (ch)</label>
            <input type="text" id="puissance_ch" name="puissance_ch" placeholder="Ex : 720">
          </div>
        </div>
 
        <div class="field">
          <label for="description_courte">Description courte</label>
          <textarea id="description_courte" name="description_courte" placeholder="Une brève présentation du modèle..."></textarea>
        </div>
 
        <div class="actions">
          <a href="admin_acceuil.php" class="btn ghost">Annuler</a>
          <button type="submit" name="add_car" value="1" class="btn">
            Ajouter
            <span class="arrow">→</span>
          </button>
        </div>
      </form>
    </div>
  </main>
 
  <footer class="bottombar">
    <span>© 2025 SuperCar</span>
    <div class="line"></div>
    <span>Luxury · Performance · Heritage</span>
  </footer>
 
</body>
</html>