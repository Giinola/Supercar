<?php

$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SuperCar — Administration</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<style>
    :root {
        --bg: #0a0a0a;
        --bg-soft: #111111;
        --bg-card: rgba(17, 17, 17, 0.6);
        --text: #f5f5f5;
        --text-muted: #8a8a8a;
        --accent: #c9a875;
        --line: rgba(255, 255, 255, 0.08);
        --sidebar-w: 240px;
    }
 
    /* ===== Sidebar ===== */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: var(--sidebar-w);
        height: 100vh;
        background: var(--bg-soft);
        border-right: 1px solid var(--line);
        padding: 40px 0;
        overflow-y: auto;
        z-index: 50;
        font-family: 'Inter', sans-serif;
    }
 
    .sidebar-brand {
        font-family: 'Cormorant Garamond', serif;
        font-size: 22px;
        font-weight: 500;
        letter-spacing: 4px;
        color: var(--text);
        text-align: center;
        padding: 0 24px 32px;
        border-bottom: 1px solid var(--line);
        margin-bottom: 28px;
    }
 
    .sidebar-brand span {
        color: var(--accent);
    }
 
    .sidebar-section {
        padding: 0 24px;
        margin-bottom: 24px;
    }
 
    .sidebar-title {
        font-size: 10px;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 400;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
 
    .sidebar-title::before {
        content: '';
        width: 18px;
        height: 1px;
        background: var(--accent);
        opacity: 0.6;
    }
 
    .sidebar a {
        display: block;
        padding: 11px 14px;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 13px;
        font-weight: 300;
        letter-spacing: 0.5px;
        border-left: 1px solid transparent;
        transition: all 0.3s ease;
        margin-bottom: 2px;
    }
 
    .sidebar a:hover {
        color: var(--text);
        border-left-color: var(--line);
        padding-left: 18px;
    }
 
    .sidebar a.active {
        color: var(--accent);
        border-left-color: var(--accent);
        padding-left: 18px;
    }
 
    /* ===== Topbar ===== */
    .topbar {
        position: sticky;
        top: 0;
        z-index: 40;
        margin-left: var(--sidebar-w);
        padding: 22px 60px;
        background: rgba(10, 10, 10, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid var(--line);
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-family: 'Inter', sans-serif;
    }
 
    .topbar-meta {
        font-size: 11px;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--text-muted);
    }
 
    .topbar-logout {
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--text-muted);
        text-decoration: none;
        transition: color 0.3s ease;
    }
 
    .topbar-logout:hover {
        color: var(--accent);
    }
 
    /* ===== Responsive ===== */
    @media (max-width: 1024px) {
        .topbar { padding: 22px 32px; }
    }
 
    @media (max-width: 768px) {
        :root { --sidebar-w: 0px; }
        .sidebar {
            position: relative;
            width: 100%;
            height: auto;
            padding: 24px 0;
        }
        .topbar { padding: 18px 22px; margin-left: 0; }
        .topbar-meta { display: none; }
    }
 
    /* Scrollbar discrète */
    .sidebar::-webkit-scrollbar { width: 4px; }
    .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); }
</style>
</head>
<body>
 
<aside class="sidebar">
    <div class="sidebar-brand">SUPER<span>CAR</span></div>
 
    <div class="sidebar-section">
        <div class="sidebar-title">Visualisation</div>
        <a href="index.php" class="<?= $current === 'index.php' ? 'active' : '' ?>">Tableau de bord</a>
        <a href="Demande_essai.php" class="<?= $current === 'Demande_essai.php' ? 'active' : '' ?>">Demandes d'essai</a>
        <a href="Utilisateurs.php" class="<?= $current === 'Utilisateurs.php' ? 'active' : '' ?>">Utilisateurs</a>
        <a href="Contacts.php" class="<?= $current === 'Contacts.php' ? 'active' : '' ?>">Messages</a>
    </div>
 
    <div class="sidebar-section">
        <div class="sidebar-title">Modification</div>
        <a href="admin_acceuil.php" class="<?= $current === 'admin_acceuil.php' ? 'active' : '' ?>">Page d'accueil</a>
        <a href="admin_voitures.php" class="<?= $current === 'admin_voitures.php' ? 'active' : '' ?>">Voitures</a>
        <a href="admin_essai.php" class="<?= $current === 'admin_essai.php' ? 'active' : '' ?>">Demandes d'essai</a>
        <a href="admin_services.php" class="<?= $current === 'admin_services.php' ? 'active' : '' ?>">Services</a>
        <a href="Admin_contact.php" class="<?= $current === 'Admin_contact.php' ? 'active' : '' ?>">Contact</a>
    </div>
</aside>
 
<div class="topbar">
    <div class="topbar-meta">Espace Administration</div>
    <a href="logout.php" class="topbar-logout">Déconnexion →</a>
</div>
</body>
</html>