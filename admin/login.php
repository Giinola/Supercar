<?php
session_start();
require_once 'db.php';
 
// Token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}
 
$error = "";
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Vérification CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Erreur de sécurité. Veuillez recharger la page.";
    } else {
        $nom_utilisateur = trim($_POST['nom_utilisateur'] ?? '');
        $mot_de_passe    = $_POST['mot_de_passe'] ?? '';
 
        if ($nom_utilisateur === '' || $mot_de_passe === '') {
            $error = "Veuillez remplir tous les champs.";
        } else {
            // Requête préparée PDO
            $stmt = $pdo->prepare("SELECT * FROM admin WHERE nom = :nom AND mot_de_passe = :mdp");
            $stmt->execute([
                ':nom' => $nom_utilisateur,
                ':mdp' => $mot_de_passe,
            ]);
            $admin = $stmt->fetch();
 
            if ($admin) {
                // Régénération de l'ID de session (anti-fixation)
                session_regenerate_id(true);
                $_SESSION['admin'] = $nom_utilisateur;
 
                // ✅ AJOUT : log de la connexion réussie
                $logStmt = $pdo->prepare("INSERT INTO logs_admin (admin_nom, action_type, details) VALUES (:nom, 'CONNEXION', 'Connexion admin réussie')");
                $logStmt->execute([':nom' => $nom_utilisateur]);
 
                header("Location: admin_acceuil.php");
                exit();
            } else {
                // ✅ AJOUT : log de la tentative échouée
                $logStmt = $pdo->prepare("INSERT INTO logs_admin (admin_nom, action_type, details) VALUES (:nom, 'CONNEXION_ECHEC', 'Mauvais identifiants')");
                $logStmt->execute([':nom' => $nom_utilisateur]);
 
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SuperCar — Administration</title>
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
    }
 
    html, body { height: 100%; }
 
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
      overflow-x: hidden;
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
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 24px;
    }
 
    .login-card {
      width: 100%;
      max-width: 440px;
      padding: 56px 48px;
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
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 14px;
      justify-content: center;
    }
 
    .eyebrow::before, .eyebrow::after {
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
      text-align: center;
      margin-bottom: 14px;
    }
 
    h1 .accent {
      font-style: italic;
      color: var(--accent);
      font-weight: 500;
    }
 
    .subtitle {
      font-size: 13px;
      color: var(--text-muted);
      text-align: center;
      margin-bottom: 44px;
      letter-spacing: 0.5px;
    }
 
    .error-message {
      padding: 14px 16px;
      margin-bottom: 28px;
      border-left: 2px solid var(--error);
      background: rgba(217, 119, 102, 0.06);
      color: var(--error);
      font-size: 12px;
      letter-spacing: 0.5px;
    }
 
    .field {
      margin-bottom: 28px;
    }
 
    .field label {
      display: block;
      font-size: 10px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-bottom: 10px;
      font-weight: 400;
    }
 
    .field input {
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
 
    .field input:focus { border-bottom-color: var(--accent); }
 
    .field input::placeholder {
      color: #555;
      font-weight: 300;
    }
 
    .btn {
      width: 100%;
      margin-top: 16px;
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
    }
 
    .btn:hover {
      background: var(--accent);
      border-color: var(--accent);
      transform: translateY(-2px);
    }
 
    .btn .arrow { transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1); }
    .btn:hover .arrow { transform: translateX(5px); }
 
    .back-link {
      display: block;
      text-align: center;
      margin-top: 32px;
      font-size: 11px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--text-muted);
      text-decoration: none;
      transition: color 0.3s ease;
    }
 
    .back-link:hover { color: var(--accent); }
 
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
      .top-meta, .bottombar .line { display: none; }
      .bottombar { justify-content: center; text-align: center; }
      .login-card { padding: 44px 32px; }
      h1 { font-size: 36px; }
    }
  </style>
</head>
<body>
 
  <header class="topbar">
    <a href="../index.html" class="brand-mark">SUPER<span>CAR</span></a>
    <div class="top-meta">Administration — Accès privé</div>
  </header>
 
  <main>
    <div class="login-card">
      <div class="eyebrow">Espace privé</div>
 
      <h1><span class="accent">Connexion</span></h1>
      <p class="subtitle">Accès réservé à l'équipe d'administration</p>
 
      <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
      <?php endif; ?>
 
      <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
 
        <div class="field">
          <label for="nom_utilisateur">Identifiant</label>
          <input type="text" id="nom_utilisateur" name="nom_utilisateur" placeholder="Votre nom d'utilisateur" required>
        </div>
 
        <div class="field">
          <label for="mot_de_passe">Mot de passe</label>
          <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="••••••••" required>
        </div>
 
        <button type="submit" class="btn">
          Se connecter
          <span class="arrow">→</span>
        </button>
      </form>
 
      <a href="../index.html" class="back-link">← Retour à l'accueil</a>
    </div>
  </main>
 
  <footer class="bottombar">
    <span>© 2025 SuperCar</span>
    <div class="line"></div>
    <span>Luxury · Performance · Heritage</span>
  </footer>
 
</body>
</html>