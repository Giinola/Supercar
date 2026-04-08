<?php
session_start();
require_once 'db.php';
 
// Vérifier que l'admin est connecté
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
 
$message = "";
 
// Nettoyage des vieux logs (utilise la procédure stockée)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nettoyer'])) {
    $jours = (int) $_POST['jours'];
    if ($jours > 0) {
        try {
            $stmt = $pdo->prepare("CALL sp_nettoyer_vieux_logs(:j, @nb)");
            $stmt->execute([':j' => $jours]);
            $stmt->closeCursor();
            $nb = $pdo->query("SELECT @nb AS nb")->fetch()['nb'];
            $message = "$nb log(s) supprimé(s).";
        } catch (PDOException $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}
 
// Récupérer les statistiques (procédure stockée)
$stats = [];
try {
    $stmt = $pdo->query("CALL sp_statistiques_admin()");
    $stats = $stmt->fetchAll();
    $stmt->closeCursor();
} catch (PDOException $e) {
    $stats = [];
}
 
// Filtre par type d'action
$filtre = $_GET['filtre'] ?? '';
$where = '';
$params = [];
if ($filtre !== '') {
    $where = "WHERE action_type = :f";
    $params[':f'] = $filtre;
}
 
// Récupérer les 100 derniers logs
$stmt = $pdo->prepare("SELECT * FROM logs_admin $where ORDER BY date_action DESC LIMIT 100");
$stmt->execute($params);
$logs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SuperCar — Journal des actions</title>
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
      --info: #7a9bb8;
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
      padding: 60px 60px 80px;
      max-width: 1400px;
      margin: 0 auto;
      width: 100%;
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
      font-size: 48px;
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
      margin-bottom: 50px;
      letter-spacing: 0.5px;
    }
 
    .message {
      padding: 14px 18px;
      margin-bottom: 32px;
      border-left: 2px solid var(--accent);
      background: rgba(201, 168, 117, 0.06);
      color: var(--accent);
      font-size: 12px;
      letter-spacing: 0.5px;
    }
 
    /* Statistiques */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 20px;
      margin-bottom: 50px;
    }
 
    .stat-card {
      padding: 28px 24px;
      background: rgba(17, 17, 17, 0.6);
      backdrop-filter: blur(20px);
      border: 1px solid var(--line);
      transition: border-color 0.4s ease;
    }
 
    .stat-card:hover { border-color: var(--accent); }
 
    .stat-label {
      font-size: 10px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-bottom: 12px;
    }
 
    .stat-value {
      font-family: 'Cormorant Garamond', serif;
      font-size: 38px;
      font-weight: 500;
      color: var(--accent);
    }
 
    /* Barre d'outils */
    .toolbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 24px;
      margin-bottom: 30px;
      padding-bottom: 24px;
      border-bottom: 1px solid var(--line);
    }
 
    .filters {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
    }
 
    .filter-btn {
      padding: 10px 18px;
      background: transparent;
      border: 1px solid var(--line);
      color: var(--text-muted);
      font-family: 'Inter', sans-serif;
      font-size: 10px;
      letter-spacing: 2px;
      text-transform: uppercase;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.3s ease;
    }
 
    .filter-btn:hover, .filter-btn.active {
      border-color: var(--accent);
      color: var(--accent);
    }
 
    .cleanup-form {
      display: flex;
      align-items: center;
      gap: 12px;
    }
 
    .cleanup-form label {
      font-size: 10px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--text-muted);
    }
 
    .cleanup-form input {
      width: 70px;
      padding: 10px;
      background: transparent;
      border: 1px solid var(--line);
      color: var(--text);
      font-family: 'Inter', sans-serif;
      font-size: 13px;
      text-align: center;
      outline: none;
      transition: border-color 0.3s ease;
    }
 
    .cleanup-form input:focus { border-color: var(--accent); }
 
    .cleanup-form button {
      padding: 10px 20px;
      background: transparent;
      border: 1px solid var(--text);
      color: var(--text);
      font-family: 'Inter', sans-serif;
      font-size: 10px;
      letter-spacing: 2px;
      text-transform: uppercase;
      cursor: pointer;
      transition: all 0.3s ease;
    }
 
    .cleanup-form button:hover {
      background: var(--accent);
      border-color: var(--accent);
      color: var(--bg);
    }
 
    /* Tableau des logs */
    .logs-table {
      width: 100%;
      border-collapse: collapse;
      background: rgba(17, 17, 17, 0.4);
      backdrop-filter: blur(20px);
      border: 1px solid var(--line);
    }
 
    .logs-table thead th {
      padding: 18px 20px;
      text-align: left;
      font-size: 10px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--text-muted);
      font-weight: 400;
      border-bottom: 1px solid var(--line);
    }
 
    .logs-table tbody td {
      padding: 18px 20px;
      font-size: 13px;
      color: var(--text);
      border-bottom: 1px solid var(--line);
    }
 
    .logs-table tbody tr {
      transition: background 0.3s ease;
    }
 
    .logs-table tbody tr:hover {
      background: rgba(201, 168, 117, 0.04);
    }
 
    .logs-table tbody tr:last-child td { border-bottom: none; }
 
    .badge {
      display: inline-block;
      padding: 4px 12px;
      font-size: 9px;
      letter-spacing: 2px;
      text-transform: uppercase;
      border: 1px solid;
    }
 
    .badge.INSERT          { color: var(--success); border-color: var(--success); }
    .badge.UPDATE          { color: var(--accent);  border-color: var(--accent); }
    .badge.DELETE          { color: var(--error);   border-color: var(--error); }
    .badge.CONNEXION       { color: var(--info);    border-color: var(--info); }
    .badge.CONNEXION_ECHEC { color: var(--error);   border-color: var(--error); }
 
    .empty {
      text-align: center;
      padding: 60px 20px;
      color: var(--text-muted);
      font-size: 13px;
      letter-spacing: 0.5px;
    }
 
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
 
    @media (max-width: 768px) {
      .topbar, .bottombar { padding: 24px 28px; }
      main { padding: 40px 28px; }
      .top-meta, .bottombar .line { display: none; }
      .bottombar { justify-content: center; text-align: center; }
      h1 { font-size: 36px; }
      .toolbar { flex-direction: column; align-items: flex-start; }
      .logs-table { font-size: 11px; }
      .logs-table thead th, .logs-table tbody td { padding: 12px 10px; }
    }
  </style>
</head>
<body>
 
  <header class="topbar">
    <a href="admin_acceuil.php" class="brand-mark">SUPER<span>CAR</span></a>
    <div class="top-meta">Journal — <?= htmlspecialchars($_SESSION['admin']) ?></div>
  </header>
 
  <main>
    <div class="eyebrow">Administration</div>
    <h1><span class="accent">Journal</span> des actions</h1>
    <p class="subtitle">Historique complet des opérations effectuées sur l'espace d'administration</p>
 
    <?php if ($message): ?>
      <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
 
    <!-- Statistiques -->
    <div class="stats-grid">
      <?php if (empty($stats)): ?>
        <div class="stat-card">
          <div class="stat-label">Aucune donnée</div>
          <div class="stat-value">—</div>
        </div>
      <?php else: ?>
        <?php foreach ($stats as $s): ?>
          <div class="stat-card">
            <div class="stat-label"><?= htmlspecialchars($s['action_type']) ?></div>
            <div class="stat-value"><?= (int) $s['total'] ?></div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
 
    <!-- Barre d'outils -->
    <div class="toolbar">
      <div class="filters">
        <a href="?" class="filter-btn <?= $filtre === '' ? 'active' : '' ?>">Tous</a>
        <a href="?filtre=INSERT"          class="filter-btn <?= $filtre === 'INSERT' ? 'active' : '' ?>">Ajouts</a>
        <a href="?filtre=UPDATE"          class="filter-btn <?= $filtre === 'UPDATE' ? 'active' : '' ?>">Modifs</a>
        <a href="?filtre=DELETE"          class="filter-btn <?= $filtre === 'DELETE' ? 'active' : '' ?>">Suppressions</a>
        <a href="?filtre=CONNEXION"       class="filter-btn <?= $filtre === 'CONNEXION' ? 'active' : '' ?>">Connexions</a>
        <a href="?filtre=CONNEXION_ECHEC" class="filter-btn <?= $filtre === 'CONNEXION_ECHEC' ? 'active' : '' ?>">Échecs</a>
      </div>
 
      <form method="POST" class="cleanup-form">
        <label>Nettoyer logs &gt;</label>
        <input type="number" name="jours" value="30" min="1">
        <label>jours</label>
        <button type="submit" name="nettoyer">Nettoyer</button>
      </form>
    </div>
 
    <!-- Tableau des logs -->
    <table class="logs-table">
      <thead>
        <tr>
          <th>Date</th>
          <th>Admin</th>
          <th>Action</th>
          <th>Table</th>
          <th>ID</th>
          <th>Détails</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($logs)): ?>
          <tr><td colspan="6" class="empty">Aucun log à afficher</td></tr>
        <?php else: ?>
          <?php foreach ($logs as $log): ?>
            <tr>
              <td><?= htmlspecialchars($log['date_action']) ?></td>
              <td><?= htmlspecialchars($log['admin_nom'] ?? '—') ?></td>
              <td><span class="badge <?= htmlspecialchars($log['action_type']) ?>"><?= htmlspecialchars($log['action_type']) ?></span></td>
              <td><?= htmlspecialchars($log['table_cible'] ?? '—') ?></td>
              <td><?= $log['id_cible'] !== null ? (int) $log['id_cible'] : '—' ?></td>
              <td><?= htmlspecialchars($log['details'] ?? '') ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </main>
 
  <footer class="bottombar">
    <span>© 2025 SuperCar</span>
    <div class="line"></div>
    <span>Luxury · Performance · Heritage</span>
  </footer>
 
</body>
</html>