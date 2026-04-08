<?php
session_start();
 
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
 
require_once 'db.php';
 
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}
 
$success = false;
$error = '';
$success_msg = '';
 
// =====================================================
//  Mise à jour du statut d'une demande
// =====================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['new_status'])) {
 
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Erreur de sécurité.";
    } else {
        // Liste blanche des statuts autorisés
        $statuts_autorises = ['approuve', 'refuse', 'en_attente'];
        $new_status = $_POST['new_status'];
 
        if (!in_array($new_status, $statuts_autorises, true)) {
            $error = "Statut invalide.";
        } else {
            try {
                $stmt = $pdo->prepare("UPDATE demandes_essai SET status = :status WHERE id = :id");
                $stmt->execute([
                    ':status' => $new_status,
                    ':id'     => (int) $_POST['id'],
                ]);
                $success = true;
                $success_msg = "Statut mis à jour avec succès";
            } catch (PDOException $e) {
                $error = "Erreur lors de la mise à jour.";
            }
        }
    }
}
 
// =====================================================
//  Récupération des demandes
// =====================================================
$demandes = [];
try {
    $stmt = $pdo->query("
        SELECT id, nom, email, voiture, date_essai,
               COALESCE(heure, Heure) AS heure,
               IFNULL(status, 'en_attente') AS status
        FROM demandes_essai
        ORDER BY date_essai DESC, id DESC
    ");
    $demandes = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Impossible de charger les demandes.";
}
 
// Statistiques
$nb_attente  = 0;
$nb_approuve = 0;
$nb_refuse   = 0;
foreach ($demandes as $d) {
    if ($d['status'] === 'approuve') $nb_approuve++;
    elseif ($d['status'] === 'refuse') $nb_refuse++;
    else $nb_attente++;
}
 
include 'menu.php';
 
function h($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SuperCar — Demandes d'essai</title>
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
        --success: #7ec998;
        --error: #d97766;
        --warning: #d4b35e;
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
        margin-bottom: 48px;
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
 
    /* Stats */
    .stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 40px;
        animation: fadeUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) 0.2s both;
    }
 
    .stat {
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--line);
        padding: 24px 28px;
    }
 
    .stat-label {
        font-size: 10px;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 8px;
    }
 
    .stat-value {
        font-family: 'Cormorant Garamond', serif;
        font-size: 36px;
        font-weight: 500;
    }
 
    .stat-value.attente  { color: var(--warning); }
    .stat-value.approuve { color: var(--success); }
    .stat-value.refuse   { color: var(--error); }
 
    /* Toast */
    .toast {
        position: fixed;
        top: 100px;
        right: 32px;
        z-index: 100;
        padding: 18px 26px;
        background: rgba(17, 17, 17, 0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--line);
        color: var(--text);
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 14px;
        animation: toastIn 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) both,
                   toastOut 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) 3.5s forwards;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }
 
    .toast.success { border-left: 2px solid var(--success); }
    .toast.error   { border-left: 2px solid var(--error); }
 
    .toast-icon {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        color: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
    }
 
    .toast.success .toast-icon { background: var(--success); }
    .toast.error   .toast-icon { background: var(--error); }
 
    .toast-text strong { display: block; font-weight: 500; margin-bottom: 2px; }
    .toast-text small { color: var(--text-muted); font-size: 11px; }
 
    /* Demande card */
    .demande-card {
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--line);
        padding: 28px 36px;
        margin-bottom: 16px;
        animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) both;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 24px;
        align-items: center;
    }
 
    .demande-info {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }
 
    .info-block {
        min-width: 0;
    }
 
    .info-label {
        font-size: 9px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 6px;
    }
 
    .info-value {
        font-size: 14px;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
 
    .info-value.serif {
        font-family: 'Cormorant Garamond', serif;
        font-size: 17px;
        font-style: italic;
        color: var(--accent);
    }
 
    .demande-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 12px;
    }
 
    .badge {
        display: inline-block;
        padding: 6px 14px;
        font-size: 9px;
        letter-spacing: 2px;
        text-transform: uppercase;
        border: 1px solid;
    }
 
    .badge.en_attente { color: var(--warning); border-color: var(--warning); }
    .badge.approuve   { color: var(--success); border-color: var(--success); }
    .badge.refuse     { color: var(--error);   border-color: var(--error); }
 
    .actions-buttons {
        display: flex;
        gap: 8px;
    }
 
    .btn-action {
        padding: 8px 16px;
        font-family: 'Inter', sans-serif;
        font-size: 9px;
        font-weight: 400;
        letter-spacing: 2px;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s ease;
        background: transparent;
        color: var(--text-muted);
        border: 1px solid var(--line);
    }
 
    .btn-action:hover:not(:disabled) {
        color: var(--text);
        border-color: var(--text-muted);
    }
 
    .btn-action.approve:hover:not(:disabled) {
        color: var(--success);
        border-color: var(--success);
    }
 
    .btn-action.refuse:hover:not(:disabled) {
        color: var(--error);
        border-color: var(--error);
    }
 
    .btn-action:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }
 
    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: var(--bg-card);
        border: 1px solid var(--line);
    }
 
    .empty-state h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 24px;
        font-weight: 400;
        font-style: italic;
        color: var(--accent);
        margin-bottom: 8px;
    }
 
    .empty-state p {
        font-size: 12px;
        color: var(--text-muted);
    }
 
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
 
    @keyframes toastIn {
        from { opacity: 0; transform: translateX(40px); }
        to   { opacity: 1; transform: translateX(0); }
    }
 
    @keyframes toastOut {
        from { opacity: 1; transform: translateX(0); }
        to   { opacity: 0; transform: translateX(40px); visibility: hidden; }
    }
 
    @media (max-width: 1280px) {
        .demande-card { grid-template-columns: 1fr; }
        .demande-actions { align-items: flex-start; }
    }
 
    @media (max-width: 1024px) {
        .main-content { padding: 40px 32px 60px; }
        .demande-info { grid-template-columns: 1fr 1fr; }
    }
 
    @media (max-width: 768px) {
        .main-content { margin-left: 0; padding: 32px 22px 60px; }
        h1 { font-size: 36px; }
        .stats { grid-template-columns: 1fr; }
        .demande-card { padding: 22px; }
        .demande-info { grid-template-columns: 1fr; gap: 16px; }
        .toast { top: 90px; right: 16px; left: 16px; }
    }
</style>
</head>
<body>
 
<?php if ($success): ?>
    <div class="toast success">
        <div class="toast-icon">✓</div>
        <div class="toast-text">
            <strong><?= h($success_msg) ?></strong>
            <small>Le statut a été modifié</small>
        </div>
    </div>
<?php elseif ($error): ?>
    <div class="toast error">
        <div class="toast-icon">!</div>
        <div class="toast-text">
            <strong>Erreur</strong>
            <small><?= h($error) ?></small>
        </div>
    </div>
<?php endif; ?>
 
<div class="main-content">
 
    <header class="page-header">
        <div class="eyebrow">Service · Demandes</div>
        <h1>Demandes <span class="accent">d'essai</span></h1>
        <p class="page-subtitle">Consultez et traitez les demandes d'essai soumises par les visiteurs du site.</p>
    </header>
 
    <!-- Statistiques -->
    <div class="stats">
        <div class="stat">
            <div class="stat-label">— En attente</div>
            <div class="stat-value attente"><?= $nb_attente ?></div>
        </div>
        <div class="stat">
            <div class="stat-label">— Approuvées</div>
            <div class="stat-value approuve"><?= $nb_approuve ?></div>
        </div>
        <div class="stat">
            <div class="stat-label">— Refusées</div>
            <div class="stat-value refuse"><?= $nb_refuse ?></div>
        </div>
    </div>
 
    <?php if (empty($demandes)): ?>
        <div class="empty-state">
            <h3>Aucune demande pour le moment</h3>
            <p>Les nouvelles demandes d'essai apparaîtront ici dès leur soumission.</p>
        </div>
    <?php else: ?>
        <?php foreach ($demandes as $d):
            $id    = (int) $d['id'];
            $stat  = $d['status'] ?? 'en_attente';
            $date  = !empty($d['date_essai']) ? date('d/m/Y', strtotime($d['date_essai'])) : '—';
            $heure = $d['heure'] ?? '—';
        ?>
            <div class="demande-card">
                <div class="demande-info">
                    <div class="info-block">
                        <div class="info-label">Client</div>
                        <div class="info-value serif"><?= h($d['nom']) ?></div>
                    </div>
                    <div class="info-block">
                        <div class="info-label">Email</div>
                        <div class="info-value"><?= h($d['email']) ?></div>
                    </div>
                    <div class="info-block">
                        <div class="info-label">Modèle souhaité</div>
                        <div class="info-value"><?= h($d['voiture']) ?></div>
                    </div>
                    <div class="info-block">
                        <div class="info-label">Date · Heure</div>
                        <div class="info-value"><?= h($date) ?> · <?= h($heure) ?></div>
                    </div>
                </div>
 
                <div class="demande-actions">
                    <span class="badge <?= h($stat) ?>"><?= h(str_replace('_', ' ', $stat)) ?></span>
 
                    <form method="POST" class="actions-buttons">
                        <input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <button type="submit" name="new_status" value="approuve"
                                class="btn-action approve"
                                <?= $stat === 'approuve' ? 'disabled' : '' ?>>
                            Approuver
                        </button>
                        <button type="submit" name="new_status" value="refuse"
                                class="btn-action refuse"
                                <?= $stat === 'refuse' ? 'disabled' : '' ?>>
                            Refuser
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
 
</div>
 
</body>
</html>