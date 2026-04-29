<?php
session_start();
 
// Vérifier que l'admin est connecté
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
 
require_once 'db.php';
 
// Statistiques (avec gestion d'erreur si une table n'existe pas)
function safe_count($pdo, $table) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
        return (int) $stmt->fetchColumn();
    } catch (PDOException $e) {
        return 0;
    }
}
 
$total_users    = safe_count($pdo, 'utilisateur');
$total_essais   = safe_count($pdo, 'essai');
$total_messages = safe_count($pdo, 'contacts');
$total_ferrari  = safe_count($pdo, 'ferrari');
$total_mclaren  = safe_count($pdo, 'mclaren');
$total_merco    = safe_count($pdo, 'mercedes');
$total_rr       = safe_count($pdo, 'range_rover');
$total_voitures = $total_ferrari + $total_mclaren + $total_merco + $total_rr;
 
include 'menu.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SuperCar — Tableau de bord</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
 
    :root {
        --bg: #0a0a0a;
        --bg-soft: #111111;
        --bg-card: rgba(17, 17, 17, 0.6);
        --text: #f5f5f5;
        --text-muted: #8a8a8a;
        --accent: #c9a875;
        --line: rgba(255, 255, 255, 0.08);
    }
 
    html, body {
        background: var(--bg);
        color: var(--text);
        font-family: 'Inter', sans-serif;
        font-weight: 300;
        letter-spacing: 0.3px;
        min-height: 100vh;
    }
 
    body::before {
        content: '';
        position: fixed;
        inset: 0;
        background:
            radial-gradient(ellipse at top right, rgba(201, 168, 117, 0.04), transparent 60%),
            radial-gradient(ellipse at bottom left, rgba(255, 255, 255, 0.02), transparent 50%);
        pointer-events: none;
        z-index: 0;
    }
 
    .main-content {
        margin-left: 240px;
        padding: 56px 60px 80px;
        position: relative;
        z-index: 1;
    }
 
    .page-header {
        margin-bottom: 56px;
        animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) both;
    }
 
    .eyebrow {
        font-size: 11px;
        letter-spacing: 6px;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 14px;
    }
 
    .eyebrow::before {
        content: '';
        width: 30px;
        height: 1px;
        background: var(--accent);
        opacity: 0.6;
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
 
    .page-subtitle {
        font-size: 14px;
        color: var(--text-muted);
        max-width: 600px;
        line-height: 1.6;
    }
 
    /* ===== Stats Grid ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 48px;
        animation: fadeUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) 0.2s both;
    }
 
    .stat-card {
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--line);
        padding: 36px 32px;
        transition: all 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
 
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 2px;
        height: 0;
        background: var(--accent);
        transition: height 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
    }
 
    .stat-card:hover {
        border-color: rgba(201, 168, 117, 0.3);
        transform: translateY(-4px);
    }
 
    .stat-card:hover::before {
        height: 100%;
    }
 
    .stat-label {
        font-size: 10px;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 16px;
        font-weight: 400;
    }
 
    .stat-value {
        font-family: 'Cormorant Garamond', serif;
        font-size: 56px;
        font-weight: 500;
        color: var(--text);
        line-height: 1;
        margin-bottom: 8px;
    }
 
    .stat-value .accent {
        color: var(--accent);
        font-style: italic;
    }
 
    .stat-desc {
        font-size: 11px;
        color: var(--text-muted);
        letter-spacing: 0.5px;
    }
 
    /* ===== Quick Actions ===== */
    .actions-section {
        animation: fadeUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) 0.4s both;
    }
 
    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 28px;
        font-weight: 500;
        color: var(--text);
        letter-spacing: 0.5px;
        margin-bottom: 28px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--line);
    }
 
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 20px;
    }
 
    .action-card {
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--line);
        padding: 28px 32px;
        text-decoration: none;
        color: var(--text);
        transition: all 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
    }
 
    .action-card:hover {
        border-color: rgba(201, 168, 117, 0.3);
        transform: translateY(-2px);
    }
 
    .action-card-text {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
 
    .action-card-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 20px;
        font-weight: 500;
        color: var(--text);
    }
 
    .action-card-desc {
        font-size: 11px;
        color: var(--text-muted);
        letter-spacing: 0.5px;
    }
 
    .action-card-arrow {
        font-size: 18px;
        color: var(--accent);
        transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
    }
 
    .action-card:hover .action-card-arrow {
        transform: translateX(6px);
    }
 
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
 
    @media (max-width: 1024px) {
        .main-content { padding: 40px 32px 60px; }
    }
 
    @media (max-width: 768px) {
        .main-content { margin-left: 0; padding: 32px 22px 60px; }
        h1 { font-size: 36px; }
        .stat-value { font-size: 44px; }
    }
</style>
</head>
<body>
 
<div class="main-content">
 
    <header class="page-header">
        <div class="eyebrow">Bienvenue, <?= htmlspecialchars($_SESSION['admin']) ?></div>
        <h1>Tableau <span class="accent">de bord</span></h1>
        <p class="page-subtitle">
            Vue d'ensemble de l'activité du site SuperCar et accès rapide aux différentes sections d'administration.
        </p>
    </header>
 
    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">— I · Utilisateurs</div>
            <div class="stat-value"><?= $total_users ?></div>
            <div class="stat-desc">Comptes inscrits sur le site</div>
        </div>
 
        <div class="stat-card">
            <div class="stat-label">— II · Demandes d'essai</div>
            <div class="stat-value"><?= $total_essais ?></div>
            <div class="stat-desc">Demandes reçues à ce jour</div>
        </div>
 
        <div class="stat-card">
            <div class="stat-label">— III · Messages</div>
            <div class="stat-value"><?= $total_messages ?></div>
            <div class="stat-desc">Messages de contact reçus</div>
        </div>
 
        <div class="stat-card">
            <div class="stat-label">— IV · Véhicules</div>
            <div class="stat-value"><?= $total_voitures ?></div>
            <div class="stat-desc">Voitures dans le catalogue</div>
        </div>
    </div>
 
    <!-- Actions rapides -->
    <section class="actions-section">
        <h2 class="section-title">Accès rapide</h2>
 
        <div class="actions-grid">
            <a href="admin_acceuil.php" class="action-card">
                <div class="action-card-text">
                    <span class="action-card-title">Page d'accueil</span>
                    <span class="action-card-desc">Modifier les contenus du site</span>
                </div>
                <span class="action-card-arrow">→</span>
            </a>
 
            <a href="admin_voitures.php" class="action-card">
                <div class="action-card-text">
                    <span class="action-card-title">Voitures</span>
                    <span class="action-card-desc">Gérer le catalogue de véhicules</span>
                </div>
                <span class="action-card-arrow">→</span>
            </a>
 
            <a href="admin_essai.php" class="action-card">
                <div class="action-card-text">
                    <span class="action-card-title">Demandes d'essai</span>
                    <span class="action-card-desc">Consulter les demandes reçues</span>
                </div>
                <span class="action-card-arrow">→</span>
            </a>
 
            <a href="Admin_contact.php" class="action-card">
                <div class="action-card-text">
                    <span class="action-card-title">Messages</span>
                    <span class="action-card-desc">Lire les messages des visiteurs</span>
                </div>
                <span class="action-card-arrow">→</span>
            </a>
 
            <a href="Utilisateurs.php" class="action-card">
                <div class="action-card-text">
                    <span class="action-card-title">Utilisateurs</span>
                    <span class="action-card-desc">Gérer les comptes inscrits</span>
                </div>
                <span class="action-card-arrow">→</span>
            </a>
 
            <a href="admin_services.php" class="action-card">
                <div class="action-card-text">
                    <span class="action-card-title">Services</span>
                    <span class="action-card-desc">Modifier les services proposés</span>
                </div>
                <span class="action-card-arrow">→</span>
            </a>
        </div>
    </section>
 
</div>
 
</body>
</html>